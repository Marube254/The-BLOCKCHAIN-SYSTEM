<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voter;
use App\Models\Vote;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    // Show voting page
    public function index()
    {
        $voter = Auth::user(); // Fingerprint-logged-in voter
        $sectors = Candidate::select('sector')->distinct()->pluck('sector');

        // Group candidates by sector
        $candidates = Candidate::all()->groupBy('sector');

        return view('voting.index', compact('voter', 'sectors', 'candidates'));
    }

    // Submit votes
    public function submit(Request $request)
    {
        $request->validate([
            'votes' => 'required|array', // votes[sector] = candidate_id
            'fingerprint_data' => 'required|string',
        ]);

        $voter = Auth::user();

        // Verify fingerprint again
        if ($voter->fingerprint_data !== $request->fingerprint_data) {
            return back()->withErrors(['fingerprint' => 'Fingerprint does not match!']);
        }

        // Save votes
        foreach ($request->votes as $sector => $candidateId) {
            Vote::create([
                'voter_id' => $voter->id,
                'candidate_id' => $candidateId,
                'sector' => $sector,
            ]);
        }

        // Mark voter as voted
        $voter->has_voted = true;
        $voter->save();

        return redirect()->route('voting.thankyou');
    }

    // Thank you page after voting
    public function thankyou()
    {
        return view('voting.thankyou');
    }
}
