<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Candidate;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Candidate::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $items = [
            ['John Akena','President','Computer Science student, advocating for digital transformation'],
            ['Grace Nansubuga','President','Business student focused on financial transparency and student welfare'],
            ['David Mwangi','President','Law student committed to student rights and governance reform'],
            ['Samuel Oketcho','Vice President Academic','Software Engineering, passionate about academic excellence'],
            ['Mary Atim','Vice President Academic','Education student focused on curriculum improvement'],
            ['Peter Okello','Vice President Academic','Research enthusiast promoting innovation in learning'],
            ['Sarah Namutebi','Secretary General','Mass Communication student, voice of the students'],
            ['James Mwangi','Secretary General','Public Administration, experienced in student governance'],
            ['Patricia Nambi','Secretary General','Law student committed to transparency and accountability'],
            ['Esther Akinyi','Treasurer','Accounting student, financial integrity advocate'],
            ['Brian Ssemwanga','Treasurer','Finance student, budget transparency champion'],
            ['Rebecca Nantege','Treasurer','Economics student, resource allocation expert'],
        ];

        foreach ($items as $index => $i) {
            [$firstName, $lastName] = array_pad(explode(' ', $i[0], 2), 2, '');

            $sectorCode = str_replace(' ', '_', strtolower($i[1]));
            $candidateNumber = sprintf('CAND%03d', $index + 1);
            $contactEmail = strtolower(str_replace(' ', '.', $i[0])) . '@iuea.ac.ug';

            Candidate::create([
                'candidate_id' => sprintf('C%03d', $index + 1),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'display_name' => $i[0],
                'faculty' => 'General',
                'faculty_code' => 'GEN',
                'program' => 'General Studies',
                'year_of_study' => 1,
                'sector' => $i[1],
                'sector_code' => $sectorCode,
                'candidate_number' => $candidateNumber,
                'manifesto' => 'I will serve with integrity and transparency.',
                'bio' => $i[2],
                'contact_email' => $contactEmail,
                'registered_at' => now(),
                'status' => 'active',
            ]);
        }

        $this->command->info('Candidates seeded: ' . Candidate::count());
    }
}
