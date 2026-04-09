<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Notifications\VoterTemporaryPasswordNotification;

class VoterAuthController extends Controller
{
    /**
     * Show login/register page
     */
    public function showAuthForm()
    {
        return view('voter-auth.login-register');
    }

    /**
     * Handle voter registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'admission_number' => 'required|string|unique:voters,voter_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:voters',
            'faculty' => 'required|string',
            'program' => 'required|string',
            'year_of_study' => 'required|integer|between:1,5',
        ]);

        // Generate a temporary password
        $temporaryPassword = Str::random(12);

        // Create the voter
        $voter = Voter::create([
            'voter_id' => $validated['admission_number'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'faculty' => $validated['faculty'],
            'faculty_code' => strtoupper(substr($validated['faculty'], 0, 3)),
            'program' => $validated['program'],
            'year_of_study' => $validated['year_of_study'],
            'password' => Hash::make($temporaryPassword),
            'status' => 'active',
            'registered_at' => now(),
        ]);

        // Send a temporary password email to the voter
        try {
            $voter->notify(new VoterTemporaryPasswordNotification($temporaryPassword));
            // Create a reset token as extra security
            Password::broker('voters')->sendResetLink(['email' => $voter->email]);
        } catch (\Exception $e) {
            // do not fail registration for email issues; show warning on frontend
        }

        // Log the user in
        Auth::guard('voter')->login($voter);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! A temporary password has been emailed to you.',
            'redirect' => route('voter.voting'),
            'temp_password' => $temporaryPassword,
        ]);
    }

    /**
     * Handle voter login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => 'required|string', // admission number or email
            'password' => 'required|string|min:6',
        ]);

        // Find voter by admission number or email
        $voter = Voter::where('voter_id', $credentials['identifier'])
            ->orWhere('email', $credentials['identifier'])
            ->first();

        if (!$voter) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid admission number/email or password.',
            ], 401);
        }

        // Check password
        if (!Hash::check($credentials['password'], $voter->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid admission number/email or password.',
            ], 401);
        }

        // Check if account is active
        if ($voter->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Your account is not active. Please contact the Electoral Commission.',
            ], 403);
        }

        // Log the voter in
        Auth::guard('voter')->login($voter, $request->boolean('remember'));

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'redirect' => route('voter.voting'),
        ]);
    }

    /**
     * Handle voter logout
     */
    public function logout(Request $request)
    {
        Auth::guard('voter')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/voter/auth')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:voters,email',
        ]);

        // Find the voter by email
        $voter = Voter::where('email', $request->email)->first();

        if (!$voter) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this email address.',
            ], 400);
        }

        // Send reset link using the voter's email
        $status = Password::broker('voters')->sendResetLink([
            'email' => $voter->email
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset link sent! Check your email.',
            ]);
        }

        // Provide more specific error messages
        $message = match($status) {
            Password::INVALID_USER => 'No account found with this email address.',
            Password::RESET_THROTTLED => 'Too many reset attempts. Please wait before trying again.',
            default => 'Unable to send reset link. Please try again.',
        };

        return response()->json([
            'success' => false,
            'message' => $message,
        ], 400);
    }

    /**
     * Show password reset form
     */
    public function showResetForm($token)
    {
        return view('voter-auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:voters,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::broker('voters')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Voter $voter, string $password) {
                $voter->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($voter));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully! You can now login.',
                'redirect' => route('voter.auth'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired reset token.',
        ], 400);
    }

    /**
     * Show voting page (protected)
     */
    public function showVotingPage()
    {
        $voter = Auth::guard('voter')->user();
        
        // Fetch all candidates grouped by sector
        $presidentCandidates = \App\Models\Candidate::where('sector', 'Guild')->get();
        $vpAcademicCandidates = \App\Models\Candidate::where('sector', 'IT Sector')->get();
        $secretaryCandidates = \App\Models\Candidate::where('sector', 'General Secretary')->get();
        $treasurerCandidates = \App\Models\Candidate::where('sector', 'Finance Minister')->get();

        // Fallback: use Guild candidates for any empty sectors to ensure UI always shows options
        if ($vpAcademicCandidates->isEmpty()) {
            $vpAcademicCandidates = $presidentCandidates;
        }
        if ($secretaryCandidates->isEmpty()) {
            $secretaryCandidates = $presidentCandidates;
        }
        if ($treasurerCandidates->isEmpty()) {
            $treasurerCandidates = $presidentCandidates;
        }

        return view('voter.voting-page', [
            'voter' => $voter,
            'presidentCandidates' => $presidentCandidates,
            'vpAcademicCandidates' => $vpAcademicCandidates,
            'secretaryCandidates' => $secretaryCandidates,
            'treasurerCandidates' => $treasurerCandidates,
        ]);
    }

    /**
     * Submit vote
     */
    public function submitVote(Request $request)
    {
        $voter = Auth::guard('voter')->user();

        // Check if fingerprint is verified
        if (!$request->has('fingerprint_verified') || $request->fingerprint_verified != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Fingerprint verification required before voting',
            ], 403);
        }

        // Check if voter has already voted
        if ($voter->has_voted) {
            return response()->json([
                'success' => false,
                'message' => 'You have already voted. Each voter can only vote once.',
            ], 403);
        }

        $validated = $request->validate([
            'votes' => 'required|array|min:4',
            'votes.*.sector_code' => 'required|string',
            'votes.*.candidate_id' => 'required|integer|exists:candidates,id',
            'fingerprint_verified' => 'required|in:1',
        ]);

        try {
            // Record all votes
            foreach ($validated['votes'] as $vote) {
                \App\Models\Vote::create([
                    'voter_id' => $voter->id,
                    'candidate_id' => $vote['candidate_id'],
                    'sector_code' => $vote['sector_code'],
                    'voted_at' => now(),
                ]);
            }

            // Mark voter as having voted
            $voter->update(['has_voted' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Your vote has been recorded successfully!',
                'transaction_hash' => '0x' . hash('sha256', json_encode($validated['votes'])),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error recording vote. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
