<?php

namespace Database\Seeders;

use App\Models\Voter;
use Illuminate\Database\Seeder;

class ClearDemoVotersSeeder extends Seeder
{
    public function run(): void
    {
        // Keep only admin users, remove demo voters
        Voter::where('voter_id', 'NOT LIKE', 'ADMIN%')
            ->where('created_at', '>', now()->subDays(30))
            ->delete();
        
        $this->command->info('Demo voters cleared. Only real voters remain.');
    }
}