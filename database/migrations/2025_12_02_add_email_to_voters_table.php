<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            // Add email field if it doesn't exist - nullable first to handle existing records
            if (!Schema::hasColumn('voters', 'email')) {
                $table->string('email')->nullable()->unique()->after('last_name');
            }
            
            // Add remember token for "remember me" functionality
            if (!Schema::hasColumn('voters', 'remember_token')) {
                $table->rememberToken()->nullable();
            }
            
            // Add status field for account status
            if (!Schema::hasColumn('voters', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    public function down(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->dropColumn(['email', 'remember_token', 'status']);
        });
    }
};
