<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sector;
use App\Models\Faculty;

class CandidateFactory extends Factory
{
    protected $model = \App\Models\Candidate::class;

    public function definition(): array
    {
        $sector = Sector::inRandomOrder()->first();
        $faculty = Faculty::inRandomOrder()->first();

        return [
            'candidate_id' => $this->faker->unique()->numberBetween(1, 100),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'display_name' => $this->faker->name(),
            'photo_filename' => null,
            'faculty' => $faculty ? $faculty->name : 'Science',
            'faculty_code' => $faculty ? $faculty->code : 'FST',
            'program' => $this->faker->word(),
            'year_of_study' => $this->faker->numberBetween(1, 4),
            'sector' => $sector ? $sector->sector_name : 'Guild President',
            'sector_code' => $sector ? $sector->sector_code : 'IUEA-G',
            'candidate_number' => $this->faker->unique()->numberBetween(1, 50),
            'manifesto' => $this->faker->paragraph(),
            'bio' => $this->faker->paragraph(),
            'contact_email' => $this->faker->safeEmail(),
            'status' => 'active',
            'registered_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
