<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Voter;
use Illuminate\Support\Facades\Hash;

class VoterAuthController extends Controller
{
    /**
     * Show the voter login form
     */
    public function showLoginForm()
    {
        return view('voter.login'); // make sure this view exists
    }

    /**
     * Handle voter login via fingerprint or password
     */
    public function login(Request $request)
    {
        $request->validate([
            'voter_id' => 'required|string',
            'password' => 'nullable|string',
            'fingerprint_data' => 'nullable|string',
        ]);

        $voter = Voter::where('voter_id', $request->voter_id)->first();

        if (!$voter) {
            return back()->withErrors(['voter_id' => 'Voter not found'])->withInput();
        }

        // Fingerprint login
        if ($request->filled('fingerprint_data')) {
            if ($voter->fingerprint_data === $request->fingerprint_data) {
                Auth::guard('voter')->login($voter);
                return redirect()->intended(route('voting.index'));
            } else {
                return back()->withErrors(['fingerprint' => 'Fingerprint mismatch!'])->withInput();
            }
        }

        // Password login
        if ($request->filled('password')) {
            if (Auth::guard('voter')->attempt([
                'voter_id' => $request->voter_id,
                'password' => $request->password,
            ], $request->boolean('remember'))) {
                return redirect()->intended(route('voting.index'));
            } else {
                return back()->withErrors(['password' => 'Incorrect password'])->withInput();
            }
        }

        return back()->withErrors(['login' => 'Please provide a password or fingerprint'])->withInput();
    }

    /**
     * Logout voter
     */
    public function logout()
    {
        Auth::guard('voter')->logout();
        return redirect()->route('voter.login');
    }
}
