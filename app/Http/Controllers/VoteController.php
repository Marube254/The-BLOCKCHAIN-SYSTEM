<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VoteController extends Controller
{
    /**
     * Register a new voter
     */
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'admission' => 'required|string|unique:voters,voter_id',
            'email' => 'required|email|unique:voters,email',
            'password' => 'required|string|min:6',
        ]);

        $voter = Voter::create([
            'voter_id' => $request->admission,
            'first_name' => explode(' ', $request->full_name)[0],
            'last_name' => explode(' ', $request->full_name)[1] ?? '',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'faculty' => 'General', // Default, can be updated later
            'faculty_code' => 'GEN',
            'program' => 'General Program',
            'year_of_study' => 1,
            'registered_at' => now(),
            'has_voted' => false,
        ]);

        // Create Sanctum token
        $token = $voter->createToken('voting-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'token' => $token,
            'voter' => $voter
        ]);
    }

    /**
     * Login voter
     */
    public function login(Request $request)
    {
        $request->validate([
            'admission' => 'required|string',
            'password' => 'required|string',
        ]);

        $voter = Voter::where('voter_id', $request->admission)->first();

        if (!$voter || !Hash::check($request->password, $voter->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid admission number or password'
            ], 401);
        }

        // Create Sanctum token
        $token = $voter->createToken('voting-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'token' => $token,
            'voter' => $voter
        ]);
    }

    /**
     * Get all candidates grouped by sector
     */
    public function getCandidates()
    {
        $candidates = Candidate::where('status', 'active')
            ->orderBy('sector')
            ->orderBy('display_name')
            ->get()
            ->groupBy('sector')
            ->map(function ($sectorCandidates) {
                return $sectorCandidates->map(function ($candidate) {
                    return [
                        'id' => $candidate->id,
                        'name' => $candidate->display_name,
                        'program' => $candidate->program,
                        'slogan' => $candidate->manifesto ? Str::limit($candidate->manifesto, 50) : 'Committed to excellence',
                        'imgIcon' => 'fa-user-graduate', // Default icon
                        'photo' => $candidate->photo_filename ? asset('storage/' . $candidate->photo_filename) : null,
                    ];
                });
            });

        return response()->json([
            'success' => true,
            'candidates' => $candidates
        ]);
    }

    /**
     * Cast vote for authenticated voter
     */
    public function castVote(Request $request)
    {
        $voter = $request->user();

        if ($voter->has_voted) {
            return response()->json([
                'success' => false,
                'message' => 'You have already voted!'
            ], 403);
        }

        $request->validate([
            'votes' => 'required|array',
            'votes.president' => 'required|exists:candidates,id',
            'votes.vpAcademic' => 'required|exists:candidates,id',
            'votes.secretary' => 'required|exists:candidates,id',
            'votes.treasurer' => 'required|exists:candidates,id',
        ]);

        DB::beginTransaction();
        try {
            $votes = $request->votes;
            $transactionHash = '0x' . bin2hex(random_bytes(16));

            // Get the last vote for blockchain linking
            $lastVote = Vote::latest('id')->first();
            $previousHash = $lastVote ? $this->generateBlockHash($lastVote) : 'genesis';

            // Save votes
            foreach ($votes as $position => $candidateId) {
                $candidate = Candidate::find($candidateId);

                Vote::create([
                    'voter_id' => $voter->id,
                    'candidate_id' => $candidateId,
                    'sector' => $this->mapPositionToSector($position),
                    'confirmed_at' => now(),
                    'blockchain_hash' => $this->generateVoteHash($voter->id, $candidateId, $transactionHash),
                    'previous_hash' => $previousHash,
                    'block_index' => ($lastVote ? $lastVote->block_index : 0) + 1,
                    'blockchain_timestamp' => now(),
                ]);
            }

            // Mark voter as voted
            $voter->update(['has_voted' => true]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vote cast successfully!',
                'transaction_hash' => $transactionHash
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to cast vote. Please try again.'
            ], 500);
        }
    }

    /**
     * Forgot password - send reset email
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'admission' => 'required|string',
            'email' => 'required|email',
        ]);

        $voter = Voter::where('voter_id', $request->admission)
                     ->where('email', $request->email)
                     ->first();

        if (!$voter) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with these credentials'
            ], 404);
        }

        // Generate reset token
        $resetToken = Str::random(64);
        $voter->update([
            'reset_token' => Hash::make($resetToken),
            'reset_token_expires_at' => Carbon::now()->addHour(),
        ]);

        // Send reset email (you'll need to configure mail)
        try {
            Mail::to($voter->email)->send(new \App\Mail\PasswordReset($voter, $resetToken));
        } catch (\Exception $e) {
            // Log error but don't expose to user
        }

        return response()->json([
            'success' => true,
            'message' => 'Password reset link sent to your email'
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $voter = Voter::whereNotNull('reset_token_expires_at')
                     ->where('reset_token_expires_at', '>', Carbon::now())
                     ->get()
                     ->first(function ($v) use ($request) {
                         return Hash::check($request->token, $v->reset_token);
                     });

        if (!$voter) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired reset token'
            ], 400);
        }

        $voter->update([
            'password' => Hash::make($request->password),
            'reset_token' => null,
            'reset_token_expires_at' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully!'
        ]);
    }

    /**
     * Helper: Map position names to sector names
     */
    private function mapPositionToSector($position)
    {
        $mapping = [
            'president' => 'Guild President',
            'vpAcademic' => 'Vice President',
            'secretary' => 'General Secretary',
            'treasurer' => 'Finance Minister',
        ];

        return $mapping[$position] ?? $position;
    }

    /**
     * Helper: Generate blockchain hash for a vote
     */
    private function generateVoteHash($voterId, $candidateId, $transactionHash)
    {
        $data = $voterId . $candidateId . $transactionHash . time();
        return hash('sha256', $data);
    }

    /**
     * Helper: Generate block hash from previous vote
     */
    private function generateBlockHash($vote)
    {
        $data = $vote->id . $vote->voter_id . $vote->candidate_id . $vote->blockchain_timestamp;
        return hash('sha256', $data);
    }
}