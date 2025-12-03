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
    public $fingerprint = null;

    protected $listeners = ['setFingerprint'];

    public function mount($record)
    {
        $this->voter = Voter::findOrFail($record);
        $this->hasVoted = $this->voter->has_voted;

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

        if ($this->hasVoted) {
            $previous = Vote::where('voter_id', $this->voter->id)->get();

            foreach ($previous as $vote) {
                $this->selectedVotes[$vote->sector] = $vote->candidate_id;
            }
        }
    }

    public function submitVote()
    {
        if ($this->hasVoted) {
            session()->flash('warning', 'This voter has already voted.');
            return;
        }

        // Temporary fallback since fingerprint not enabled yet
        if (!$this->fingerprint) {
            $this->fingerprint = 'offline-fingerprint-placeholder';
        }

        foreach ($this->selectedVotes as $sector => $candidateId) {
            Vote::updateOrCreate(
                ['voter_id' => $this->voter->id, 'sector' => $sector],
                ['candidate_id' => $candidateId]
            );
        }

        $this->voter->has_voted = true;
        $this->voter->save();
        $this->hasVoted = true;

        session()->flash('success', 'Vote submitted successfully!');

        return redirect()->route('filament.resources.voters.index');
    }

    public function setFingerprint($template)
    {
        $this->fingerprint = $template;
    }
}
