<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        User::create([
            'name' => 'Super Admin',
            'email' => 'super@iuea.ac.ug',
            'password' => Hash::make('super123'),
            'role' => 'super_admin',
            'can_delete' => true,
            'can_manage_admins' => true,
        ]);

        User::create([
            'name' => 'Regular Admin',
            'email' => 'admin@iuea.ac.ug',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'can_delete' => false,
            'can_manage_admins' => false,
        ]);

        $this->command->info('Users created: ' . User::count());
    }
}
