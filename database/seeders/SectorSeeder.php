<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Sector::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $sectors = [
            ['sector_name' => 'Guild President', 'sector_code' => 'IUEA-GP', 'description' => 'Represents the student body at the university level. Advocates for student rights and chairs the student council.', 'max_candidates' => 10],
            ['sector_name' => 'Vice President', 'sector_code' => 'IUEA-VP', 'description' => 'Assists the Guild President in all duties. Coordinates student welfare programs and takes over when President is unavailable.', 'max_candidates' => 10],
            ['sector_name' => 'General Secretary', 'sector_code' => 'IUEA-GS', 'description' => 'Handles guild records, meeting minutes, official correspondence, and maintains communication between council and students.', 'max_candidates' => 10],
            ['sector_name' => 'Finance Minister', 'sector_code' => 'IUEA-FM', 'description' => 'Manages guild funds, prepares budgets, oversees financial transactions, and ensures transparency in financial matters.', 'max_candidates' => 10],
            ['sector_name' => 'Sports Minister', 'sector_code' => 'IUEA-SM', 'description' => 'Oversees student sports activities, organizes tournaments, manages sports facilities, and promotes physical fitness.', 'max_candidates' => 10],
        ];

        foreach ($sectors as $sector) {
            Sector::create($sector);
        }

        $this->command->info('Sectors created: ' . Sector::count());
    }
}
