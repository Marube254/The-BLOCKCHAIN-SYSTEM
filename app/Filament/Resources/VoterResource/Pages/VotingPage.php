<?php

namespace App\Filament\Resources\VoterResource\Pages;

use App\Filament\Resources\VoterResource;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Voter;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;

class VotingPage extends Page
{
    protected static string $resource = VoterResource::class;
    protected static string $view = 'filament.resources.voter-resource.pages.voting-page';

    public Voter $voter;
    public array $candidatesBySector = [];
    public array $selectedVotes = [];
    public bool $hasVoted = false;
    public ?string $fingerprint = null;
    
    // Fingerprint properties
    public ?string $fingerprint_template = null;
    public ?int $fingerprint_quality = null;
    public bool $fingerprint_verified = false;
    public bool $fingerprint_required = true;

    protected $listeners = ['setFingerprint', 'fingerprintVerified'];

    public function mount($record)
    {
        $this->voter = Voter::findOrFail($record);
        $this->hasVoted = $this->voter->has_voted;
        
        // Check if fingerprint is already registered
        $this->fingerprint_required = !$this->voter->fingerprint_hash;

        // Debug logging
        \Log::info('VotingPage mounted', [
            'voter_id' => $this->voter->id,
            'has_voted' => $this->hasVoted,
            'fingerprint_required' => $this->fingerprint_required,
            'fingerprint_hash_exists' => !empty($this->voter->fingerprint_hash)
        ]);

        // Load candidates grouped by sector
        $this->candidatesBySector = Candidate::where('status', 'active')
            ->get()
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
    }

    public function registerFingerprint()
    {
        if (!$this->fingerprint_template) {
            $this->dispatch('notify', 'Please capture fingerprint first');
            return;
        }
        
        // Store fingerprint template
        $this->voter->fingerprint_template = $this->fingerprint_template;
        $this->voter->fingerprint_hash = hash('sha256', $this->fingerprint_template);
        $this->voter->fingerprint_registered_at = now();
        $this->voter->save();
        
        $this->fingerprint_required = false;
        $this->fingerprint_verified = true;
        
        $this->dispatch('notify', 'Fingerprint registered successfully!');
    }

    public function verifyFingerprint()
    {
        if (!$this->fingerprint_template) {
            $this->dispatch('notify', 'Please capture fingerprint for verification');
            return;
        }
        
        $storedHash = hash('sha256', $this->fingerprint_template);
        
        if ($storedHash === $this->voter->fingerprint_hash) {
            $this->fingerprint_verified = true;
            $this->voter->fingerprint_verified_at = now();
            $this->voter->save();
            $this->dispatch('notify', 'Fingerprint verified successfully!');
        } else {
            $this->fingerprint_verified = false;
            $this->dispatch('notify', 'Fingerprint does not match records!', 'error');
        }
    }

    public function submitVote()
    {
        // Check fingerprint verification if required
        if ($this->fingerprint_required && !$this->fingerprint_verified) {
            session()->flash('warning', 'Please verify fingerprint before voting');
            return;
        }

        if ($this->hasVoted) {
            session()->flash('warning', 'This voter has already voted.');
            return;
        }

        // Fingerprint fallback (for now)
        if (!$this->fingerprint) {
            $this->fingerprint = $this->fingerprint_template ?? 'offline-fingerprint-placeholder';
        }

        DB::beginTransaction();

        try {
            // Save each sector vote
            foreach ($this->selectedVotes as $sector => $candidateId) {
                Vote::updateOrCreate(
                    [
                        'voter_id' => $this->voter->id,
                        'sector' => $sector,
                    ],
                    [
                        'candidate_id' => $candidateId,
                        'confirmed_at' => now()
                    ]
                );
            }

            // Mark voter as done
            $this->voter->has_voted = true;
            $this->voter->voted_at = now();
            $this->voter->save();
            $this->hasVoted = true;

            DB::commit();

            session()->flash('success', 'Vote submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to submit vote: ' . $e->getMessage());
        }
    }

    public function setFingerprint($template)
    {
        $this->fingerprint = $template;
        $this->fingerprint_template = $template;
    }

    public function fingerprintVerified()
    {
        $this->fingerprint_verified = true;
    }
}
