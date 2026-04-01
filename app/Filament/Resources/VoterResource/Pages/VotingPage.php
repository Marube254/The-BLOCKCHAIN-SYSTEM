<?php

namespace App\Filament\Resources\VoterResource\Pages;

use App\Filament\Resources\VoterResource;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Voter;
use Filament\Resources\Pages\Page;

class VotingPage extends Page
{
    protected static string $resource = VoterResource::class;
    protected static string $view = 'filament.resources.voter-resource.pages.voting-page';

    public Voter $voter;
    public array $candidatesBySector = [];
    public array $selectedVotes = [];
    public bool $hasVoted = false;
    public ?string $fingerprint = null;

    protected $listeners = ['setFingerprint'];

    public function mount($record)
    {
        $this->voter = Voter::findOrFail($record);
        $this->hasVoted = $this->voter->has_voted;

        // Load candidates grouped by sector
        $this->candidatesBySector = Candidate::all()
            ->groupBy('sector')
            ->map(fn ($group) =>
                $group->map(fn ($c) => [
                    'id' => $c->id,
                    'name' => $c->display_name,
                    'photo' => $c->photo_filename,
                ])->toArray()
            )
            ->toArray();

        // Pre-fill previously voted choices
        if ($this->hasVoted) {
            $previousVotes = Vote::where('voter_id', $this->voter->id)->get();

            foreach ($previousVotes as $vote) {
                $this->selectedVotes[$vote->sector] = $vote->candidate_id;
            }
        }

        // Redirect to voting dashboard (new SB Admin template)
        return redirect()->to('/voting-dashboard.html');
    }

    public function submitVote()
    {
        if ($this->hasVoted) {
            session()->flash('warning', 'This voter has already voted.');
            return;
        }

        // Fingerprint fallback (for now)
        if (!$this->fingerprint) {
            $this->fingerprint = 'offline-fingerprint-placeholder';
        }

        // Save each sector vote
        foreach ($this->selectedVotes as $sector => $candidateId) {
            Vote::updateOrCreate(
                [
                    'voter_id' => $this->voter->id,
                    'sector' => $sector,
                ],
                [
                    'candidate_id' => $candidateId,
                ]
            );
        }

        // Mark voter as done
        $this->voter->has_voted = true;
        $this->voter->save();
        $this->hasVoted = true;

        session()->flash('success', 'Vote submitted successfully!');

        // Redirect to voting dashboard
        return redirect()->to('/voting-dashboard.html');
    }

    public function setFingerprint($template)
    {
        $this->fingerprint = $template;
    }
}
