<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            if (!Schema::hasColumn('candidates', 'photo_filename')) {
                $table->string('photo_filename')->nullable()->after('display_name');
            }
            if (!Schema::hasColumn('candidates', 'photo_path')) {
                $table->string('photo_path')->nullable()->after('photo_filename');
            }
        });
    }

    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn(['photo_filename', 'photo_path']);
        });
    }
};
