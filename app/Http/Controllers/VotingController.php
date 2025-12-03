<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voter;
use App\Models\Candidate;
use App\Models\Vote;

class VotingController extends Controller
{
    // -------------------------------
    // 1. Show the voting screen
    // -------------------------------
    public function showVotingInterface()
    {
        return view('voting.vote');
    }

    // -------------------------------
    // 2. Identify voter by voter ID
    // -------------------------------
    public function identifyVoter(Request $request)
    {
        $request->validate([
            'voter_id' => 'required|string'
        ]);

        $voter = Voter::where('voter_id', $request->voter_id)->first();

        if (!$voter) {
            return response()->json(['error' => 'No voter found with this ID'], 404);
        }

        if ($voter->has_voted) {
            return response()->json(['error' => 'This voter has already voted'], 403);
        }

        // Store in session
        session(['current_voter' => $voter->id]);

        return response()->json(['success' => true, 'voter' => $voter]);
    }

    // -------------------------------
    // 3. Submit vote with fingerprint
    // -------------------------------
    public function submitVote(Request $request)
    {
        $request->validate([
            'fingerprint_data' => 'required|string',
            'votes' => 'required|array'
        ]);

        $voterId = session('current_voter');

        if (!$voterId) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        $voter = Voter::findOrFail($voterId);

        // FIRST TIME → save fingerprint
        if (!$voter->fingerprint_hash) {
            $voter->update([
                'fingerprint_hash' => $request->fingerprint_data
            ]);
        } else {
            // MATCH FINGERPRINT
            if ($voter->fingerprint_hash !== $request->fingerprint_data) {
                return response()->json([
                    'error' => 'Fingerprint does not match our records'
                ], 422);
            }
        }

        // Save votes
        foreach ($request->votes as $position => $candidateId) {
            Vote::create([
                'voter_id' => $voter->id,
                'candidate_id' => $candidateId,
                'position' => $position,
            ]);
        }

        // Mark voted
        $voter->update(['has_voted' => true]);

        session()->forget('current_voter');

        return response()->json(['success' => true]);
    }
}
