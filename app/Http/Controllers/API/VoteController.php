<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Sector;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    public function getCandidates()
    {
        $candidates = Candidate::where('status', 'active')
            ->select('id', 'display_name', 'sector', 'photo_filename', 'photo_path', 'bio', 'manifesto')
            ->get()
            ->groupBy('sector');
        
        $formatted = [];
        foreach ($candidates as $sector => $candidateList) {
            $formatted[$sector] = $candidateList->map(function($candidate) {
                $photoUrl = null;
                if ($candidate->photo_filename) {
                    $photoUrl = asset('storage/' . $candidate->photo_filename);
                } elseif ($candidate->photo_path) {
                    $photoUrl = Storage::url($candidate->photo_path);
                }
                
                return [
                    'id' => $candidate->id,
                    'display_name' => $candidate->display_name,
                    'sector' => $candidate->sector,
                    'photo_url' => $photoUrl,
                    'bio' => $candidate->bio,
                    'manifesto' => $candidate->manifesto
                ];
            });
        }
        
        return response()->json($formatted);
    }

    public function getSectors()
    {
        return response()->json(Sector::all());
    }

    public function register(Request $request)
    {
        try {
            \Log::info('Register attempt', $request->all());
            
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'voter_id' => 'required|string|unique:voters,voter_id',
                'email' => 'required|email|unique:voters,email',
                'password' => 'required|min:6|confirmed'
            ]);

            $voter = Voter::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'voter_id' => $request->voter_id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'has_voted' => false
            ]);

            return response()->json([
                'message' => 'Registration successful!',
                'voter' => [
                    'id' => $voter->id,
                    'full_name' => $voter->first_name . ' ' . $voter->last_name,
                    'voter_id' => $voter->voter_id,
                    'email' => $voter->email,
                    'has_voted' => $voter->has_voted
                ]
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'voter_id' => 'required|string',
            'password' => 'required|string'
        ]);

        $voter = Voter::where('voter_id', $request->voter_id)->first();

        if (!$voter || !Hash::check($request->password, $voter->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $voter->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful!',
            'token' => $token,
            'voter' => [
                'id' => $voter->id,
                'full_name' => $voter->first_name . ' ' . $voter->last_name,
                'voter_id' => $voter->voter_id,
                'email' => $voter->email,
                'has_voted' => $voter->has_voted
            ]
        ]);
    }

    public function getUser(Request $request)
    {
        return response()->json($request->user());
    }

    public function getVoterFingerprint(Request $request)
    {
        $voter = $request->user();
        return response()->json([
            'credential_id' => $voter->fingerprint_credential_id,
            'enrolled_at' => $voter->fingerprint_enrolled_at
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function enrollFingerprint(Request $request)
    {
        try {
            $voter = $request->user();

            $request->validate([
                'credential_id' => 'required|string'
            ]);

            $voter->fingerprint_credential_id = $request->credential_id;
            $voter->fingerprint_enrolled_at = now();
            $voter->save();

            return response()->json([
                'success' => true,
                'message' => 'Fingerprint enrolled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function castVote(Request $request)
    {
        try {
            $voter = $request->user();

            DB::beginTransaction();

            foreach ($request->votes as $vote) {
                $previousVote = Vote::latest()->first();
                $previousHash = $previousVote ? $previousVote->blockchain_hash : str_repeat('0', 64);
                
                $blockchainHash = hash('sha256', json_encode([
                    'voter_id' => $voter->id,
                    'candidate_id' => $vote['candidate_id'],
                    'sector' => $vote['sector'],
                    'timestamp' => now()->timestamp,
                    'previous_hash' => $previousHash
                ]));

                Vote::create([
                    'voter_id' => $voter->id,
                    'candidate_id' => $vote['candidate_id'],
                    'sector' => $vote['sector'],
                    'blockchain_hash' => $blockchainHash,
                    'previous_hash' => $previousHash,
                    'confirmed_at' => now(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'voted_at' => now()
                ]);
            }

            // Update voter status
            $voter->has_voted = true;
            
            // Only set voted_at if column exists
            if (Schema::hasColumn('voters', 'voted_at')) {
                $voter->voted_at = now();
            }
            
            $voter->save();

            DB::commit();

            return response()->json(['message' => 'Vote cast successfully!'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Vote error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $voter = Voter::where('email', $request->email)->first();
        
        if (!$voter) {
            return response()->json(['message' => 'Email not found'], 404);
        }
        
        $token = Str::random(60);
        
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $voter->email],
            ['token' => $token, 'created_at' => now()]
        );
        
        $resetLink = url("/reset-password.html?token={$token}&email={$voter->email}");
        
        return response()->json([
            'message' => 'Reset link sent',
            'reset_link' => $resetLink
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);
        
        $reset = \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();
        
        if (!$reset) {
            return response()->json(['message' => 'Invalid token'], 400);
        }
        
        $voter = Voter::where('email', $request->email)->first();
        $voter->password = Hash::make($request->password);
        $voter->save();
        
        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        
        return response()->json(['message' => 'Password reset successful']);
    }

    public function getResults()
    {
        $results = Vote::select('sector', 'candidate_id', \DB::raw('count(*) as votes'))
            ->groupBy('sector', 'candidate_id')
            ->with('candidate')
            ->get()
            ->groupBy('sector');
        
        return response()->json($results);
    }

    public function getMyVote(Request $request)
    {
        $votes = Vote::where('voter_id', $request->user()->id)->with('candidate')->get();
        return response()->json($votes);
    }

    public function verifyVote($hash)
    {
        $vote = Vote::where('blockchain_hash', $hash)->first();
        
        if (!$vote) {
            return response()->json(['verified' => false], 404);
        }
        
        return response()->json(['verified' => true, 'vote' => $vote]);
    }
}