<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Candidate;
use App\Models\Voter;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -----------------------------
        // Faculties
        // -----------------------------
        $faculties = [
            ['name' => 'Faculty of Business & Management', 'code' => 'FBM', 'description' => 'Covers business, management, and accounting disciplines.'],
            ['name' => 'Faculty of Science & Technology', 'code' => 'FST', 'description' => 'Focuses on computer science, IT, and innovation.'],
            ['name' => 'Faculty of Engineering', 'code' => 'FE', 'description' => 'Handles civil, mechanical, and electrical engineering.'],
            ['name' => 'Faculty of Education', 'code' => 'FED', 'description' => 'Responsible for teacher education and pedagogy.'],
            ['name' => 'Faculty of Law', 'code' => 'FL', 'description' => 'Specializes in legal studies and governance.'],
        ];

        foreach ($faculties as $faculty) {
            DB::table('faculties')->updateOrInsert(
                ['name' => $faculty['name']],
                $faculty
            );
        }

        // -----------------------------
        // Sectors
        // -----------------------------
        $sectors = [
            ['sector_name' => 'Guild President', 'sector_code' => 'IUEA-GP', 'description' => 'Represents the student body at the university level.', 'max_candidates' => 10],
            ['sector_name' => 'Vice President', 'sector_code' => 'IUEA-VP', 'description' => 'Assists the guild president.', 'max_candidates' => 10],
            ['sector_name' => 'General Secretary', 'sector_code' => 'IUEA-GS', 'description' => 'Handles guild records and communication.', 'max_candidates' => 10],
            ['sector_name' => 'Finance Minister', 'sector_code' => 'IUEA-FM', 'description' => 'Manages guild funds.', 'max_candidates' => 10],
            ['sector_name' => 'Sports Minister', 'sector_code' => 'IUEA-SM', 'description' => 'Oversees student sports activities.', 'max_candidates' => 10],
        ];

        foreach ($sectors as $sector) {
            DB::table('sectors')->updateOrInsert(
                ['sector_name' => $sector['sector_name']],
                $sector
            );
        }

        // -----------------------------
        // Voters
        // -----------------------------
        $facultyPrograms = [
            'Business & Management' => ['Business Administration', 'Accounting & Finance', 'Marketing'],
            'Science & Technology' => ['Computer Science', 'Information Technology', 'Data Science'],
            'Law' => ['Law'],
            'Health' => ['Nursing', 'Public Health', 'Pharmacy'],
            'Engineering' => ['Civil Engineering', 'Mechanical Engineering', 'Electrical Engineering'],
        ];

        $facultyCodes = [
            'Business & Management' => 'FBM',
            'Science & Technology' => 'FST',
            'Law' => 'FLAW',
            'Health' => 'FHS',
            'Engineering' => 'FENG',
        ];

        for ($i = 1; $i <= 240; $i++) {
            $firstName = fake()->firstName();
            $lastName = fake()->lastName();

            $faculty = fake()->randomElement(array_keys($facultyPrograms));
            $program = fake()->randomElement($facultyPrograms[$faculty]);
            $facultyCode = $facultyCodes[$faculty];

            Voter::firstOrCreate(
                ['voter_id' => 'V' . str_pad($i, 3, '0', STR_PAD_LEFT)],
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'faculty' => $faculty,
                    'faculty_code' => $facultyCode,
                    'program' => $program,
                    'year_of_study' => fake()->numberBetween(1, 4),
                    'registered_at' => fake()->dateTimeBetween('-2 years', 'now'),
                    'has_voted' => fake()->boolean(50),
                    'fingerprint_template_id' => null,
                ]
            );
        }

        // -----------------------------
        // Candidates
        // -----------------------------
        $photosPath = 'candidate-photos/';

        $candidates = [
            [
                'first_name' => 'John',
                'last_name' => 'Akena',
                'display_name' => 'John Akena',
                'faculty' => 'Business & Management',
                'faculty_code' => 'FBM',
                'program' => 'Business Administration',
                'year_of_study' => '3',
                'sector' => 'Guild',
                'sector_code' => 'G01',
                'manifesto' => 'I believe in inclusive leadership and transparent governance.',
                'bio' => 'A final-year student passionate about financial reform and leadership.',
                'contact_email' => 'john.aketa@iuea.ac.ug',
            ],
            [
                'first_name' => 'Grace',
                'last_name' => 'Nansubuga',
                'display_name' => 'Grace Nansubuga',
                'faculty' => 'Business & Management',
                'faculty_code' => 'FBM',
                'program' => 'Accounting & Finance',
                'year_of_study' => '3',
                'sector' => 'Guild',
                'sector_code' => 'G02',
                'manifesto' => 'Empowering students and enhancing campus welfare.',
                'bio' => 'Driven and result-oriented finance major advocating for equity and student growth.',
                'contact_email' => 'grace.nansubuga@iuea.ac.ug',
            ],
            [
                'first_name' => 'Samuel',
                'last_name' => 'Oketcho',
                'display_name' => 'Samuel Oketcho',
                'faculty' => 'Science & Technology',
                'faculty_code' => 'FST',
                'program' => 'Computer Science',
                'year_of_study' => '2',
                'sector' => 'IT Sector',
                'sector_code' => 'IT01',
                'manifesto' => 'Digitize student services and improve access to tech opportunities.',
                'bio' => 'Tech-savvy candidate aiming to bridge students with digital innovation.',
                'contact_email' => 'samuel.oketcho@iuea.ac.ug',
            ],
            [
                'first_name' => 'Mary',
                'last_name' => 'Atim',
                'display_name' => 'Mary Atim',
                'faculty' => 'Arts & Social Sciences',
                'faculty_code' => 'FASS',
                'program' => 'Social Work',
                'year_of_study' => '2',
                'sector' => 'Guild',
                'sector_code' => 'G03',
                'manifesto' => 'Foster inclusion, promote student welfare, and empower female leadership.',
                'bio' => 'Passionate about social welfare and gender equality in student communities.',
                'contact_email' => 'mary.atim@iuea.ac.ug',
            ],
        ];

        foreach ($candidates as $index => $data) {
            Candidate::updateOrCreate(
                ['contact_email' => $data['contact_email']],
                [
                    'candidate_id' => Str::uuid(),
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'display_name' => $data['display_name'],
                    'photo_filename' => $photosPath . 'candidate' . ($index + 1) . '.png',
                    'faculty' => $data['faculty'],
                    'faculty_code' => $data['faculty_code'],
                    'program' => $data['program'],
                    'year_of_study' => $data['year_of_study'],
                    'sector' => $data['sector'],
                    'sector_code' => $data['sector_code'],
                    'candidate_number' => 'CAND-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'manifesto' => $data['manifesto'],
                    'bio' => $data['bio'],
                    'contact_email' => $data['contact_email'],
                    'status' => 'active',
                    'registered_at' => Carbon::now(),
                ]
            );
        }
    }
}
