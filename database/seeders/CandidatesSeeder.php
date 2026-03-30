<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidates = [
            [
                'candidate_id' => 'PRES001',
                'first_name' => 'John',
                'last_name' => 'Akena',
                'display_name' => 'John Akena',
                'faculty' => 'Engineering',
                'faculty_code' => 'ENG',
                'program' => 'Computer Science',
                'year_of_study' => 3,
                'sector' => 'President',
                'sector_code' => 'PRES',
                'candidate_number' => '001',
                'status' => 'active'
            ],
            [
                'candidate_id' => 'PRES002',
                'first_name' => 'Grace',
                'last_name' => 'Nansubuga',
                'display_name' => 'Grace Nansubuga',
                'faculty' => 'Engineering',
                'faculty_code' => 'ENG',
                'program' => 'Computer Science',
                'year_of_study' => 3,
                'sector' => 'President',
                'sector_code' => 'PRES',
                'candidate_number' => '002',
                'status' => 'active'
            ],
            [
                'candidate_id' => 'VPAC001',
                'first_name' => 'Samuel',
                'last_name' => 'Oketcho',
                'display_name' => 'Samuel Oketcho',
                'faculty' => 'Engineering',
                'faculty_code' => 'ENG',
                'program' => 'Computer Science',
                'year_of_study' => 3,
                'sector' => 'Vice President Academic',
                'sector_code' => 'VPAC',
                'candidate_number' => '003',
                'status' => 'active'
            ],
            [
                'candidate_id' => 'VPAC002',
                'first_name' => 'Mary',
                'last_name' => 'Atim',
                'display_name' => 'Mary Atim',
                'faculty' => 'Engineering',
                'faculty_code' => 'ENG',
                'program' => 'Computer Science',
                'year_of_study' => 3,
                'sector' => 'Vice President Academic',
                'sector_code' => 'VPAC',
                'candidate_number' => '004',
                'status' => 'active'
            ],
            [
                'candidate_id' => 'SEC001',
                'first_name' => 'Peter',
                'last_name' => 'Okello',
                'display_name' => 'Peter Okello',
                'faculty' => 'Engineering',
                'faculty_code' => 'ENG',
                'program' => 'Computer Science',
                'year_of_study' => 3,
                'sector' => 'Secretary General',
                'sector_code' => 'SEC',
                'candidate_number' => '005',
                'status' => 'active'
            ],
            [
                'candidate_id' => 'SEC002',
                'first_name' => 'Sarah',
                'last_name' => 'Namutebi',
                'display_name' => 'Sarah Namutebi',
                'faculty' => 'Engineering',
                'faculty_code' => 'ENG',
                'program' => 'Computer Science',
                'year_of_study' => 3,
                'sector' => 'Secretary General',
                'sector_code' => 'SEC',
                'candidate_number' => '006',
                'status' => 'active'
            ],
            [
                'candidate_id' => 'TRE001',
                'first_name' => 'James',
                'last_name' => 'Mwangi',
                'display_name' => 'James Mwangi',
                'faculty' => 'Engineering',
                'faculty_code' => 'ENG',
                'program' => 'Computer Science',
                'year_of_study' => 3,
                'sector' => 'Treasurer',
                'sector_code' => 'TRE',
                'candidate_number' => '007',
                'status' => 'active'
            ],
            [
                'candidate_id' => 'TRE002',
                'first_name' => 'Esther',
                'last_name' => 'Akinyi',
                'display_name' => 'Esther Akinyi',
                'faculty' => 'Engineering',
                'faculty_code' => 'ENG',
                'program' => 'Computer Science',
                'year_of_study' => 3,
                'sector' => 'Treasurer',
                'sector_code' => 'TRE',
                'candidate_number' => '008',
                'status' => 'active'
            ],
        ];

        foreach ($candidates as $candidate) {
            \App\Models\Candidate::create($candidate);
        }
    }
}
