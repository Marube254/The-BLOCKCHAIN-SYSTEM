<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            if (!Schema::hasColumn('voters', 'fingerprint_credential_id')) {
                $table->string('fingerprint_credential_id')->nullable()->unique();
            }
            if (!Schema::hasColumn('voters', 'fingerprint_enrolled_at')) {
                $table->timestamp('fingerprint_enrolled_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->dropColumn('fingerprint_credential_id');
            $table->dropColumn('fingerprint_enrolled_at');
        });
    }
};
