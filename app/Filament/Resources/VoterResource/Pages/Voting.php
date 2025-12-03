<?php

namespace App\Filament\Resources\VoterResource\Pages;

use App\Filament\Resources\VoterResource;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Voter;
use Filament\Resources\Pages\Page;
use Illuminate\Http\Request;

class Voting extends Page
{
    protected static string $resource = VoterResource::class;
    protected static string $view = 'filament.resources.voter-resource.pages.voting';

    public Voter $voter;
    public array $candidatesBySector;
    public array $selectedVotes = [];
    public bool $hasVoted = false;

    public function mount($record)
    {
        $this->voter = Voter::findOrFail($record);
        $this->candidatesBySector = Candidate::all()->groupBy('sector')->toArray();
        $this->hasVoted = (bool) $this->voter->has_voted;

        if ($this->hasVoted) {
            $previousVotes = Vote::where('voter_id', $this->voter->id)->get();
            foreach ($previousVotes as $vote) {
                $this->selectedVotes[$vote->sector] = $vote->candidate_id;
            }
        }
    }

    public function submit(Request $request)
    {
        if ($this->hasVoted) {
            return redirect()->back()->with('warning', 'This voter has already voted.');
        }

        $data = $request->validate([
            'votes' => 'required|array',
            'fingerprint' => 'required|string',
        ]);

        // Fingerprint validation / first-time save
        $fingerprint = $data['fingerprint'];
        if (!$this->voter->fingerprint_hash) {
            $this->voter->fingerprint_hash = $fingerprint;
        } elseif ($this->voter->fingerprint_hash !== $fingerprint) {
            return redirect()->back()->with('warning', 'Fingerprint does not match our records.');
        }

        foreach ($data['votes'] as $sector => $candidateId) {
            Vote::updateOrCreate(
                ['voter_id' => $this->voter->id, 'sector' => $sector],
                ['candidate_id' => $candidateId]
            );
        }

        $this->voter->has_voted = true;
        $this->voter->save();

        return redirect()->back()->with('success', 'Vote submitted successfully.');
    }
}

