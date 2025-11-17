<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Voter;
use App\Models\Candidate;
use App\Models\Sector;

class VoteFactory extends Factory
{
    protected $model = \App\Models\Vote::class;

    public function definition(): array
    {
        $voter = Voter::where('has_voted', 0)->inRandomOrder()->first();
        $candidate = $voter
            ? Candidate::where('faculty_code', $voter->faculty_code)
                        ->inRandomOrder()
                        ->first()
            : Candidate::inRandomOrder()->first();

        if ($voter) {
            $voter->update(['has_voted' => 1]);
        }

        return [
            'voter_id' => $voter ? $voter->id : 1,
            'candidate_id' => $candidate ? $candidate->id : 1,
            'sector' => $candidate ? $candidate->sector : 'Guild President',
            'confirmed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
