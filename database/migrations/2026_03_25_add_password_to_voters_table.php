<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            if (!Schema::hasColumn('voters', 'password')) {
                $table->string('password')->nullable()->after('has_voted');
            }
        });
    }

    public function down(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            if (Schema::hasColumn('voters', 'password')) {
                $table->dropColumn('password');
            }
        });
    }
};
