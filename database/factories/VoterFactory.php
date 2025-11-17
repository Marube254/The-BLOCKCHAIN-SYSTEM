<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Faculty;

class VoterFactory extends Factory
{
    protected $model = \App\Models\Voter::class;

    public function definition(): array
    {
        $faculty = Faculty::inRandomOrder()->first();

        $programs = [
            'Computer Science', 'Procurement', 'Electrical Engineering', 'Economics', 'Business Administration'
        ];

        return [
            'voter_id' => 'V' . $this->faker->unique()->numberBetween(1000, 9999),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'faculty' => $faculty ? $faculty->name : 'Science',
            'faculty_code' => $faculty ? $faculty->code : 'FST',
            'program' => $this->faker->randomElement($programs),
            'year_of_study' => $this->faker->numberBetween(1, 4),
            'registered_at' => now(),
            'has_voted' => $this->faker->boolean(30),
            'fingerprint_hash' => 'sample_fingerprint_hash', // fixed
'created_at' => now(),
'updated_at' => now(),
        ];  
    }
}
