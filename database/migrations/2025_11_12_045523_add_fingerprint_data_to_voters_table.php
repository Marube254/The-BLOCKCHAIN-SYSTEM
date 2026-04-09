<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            if (!Schema::hasColumn('voters', 'fingerprint_template')) {
                $table->text('fingerprint_template')->nullable()->after('password');
            }
            if (!Schema::hasColumn('voters', 'fingerprint_hash')) {
                $table->string('fingerprint_hash')->nullable()->after('fingerprint_template');
            }
            if (!Schema::hasColumn('voters', 'fingerprint_registered_at')) {
                $table->timestamp('fingerprint_registered_at')->nullable()->after('fingerprint_hash');
            }
            if (!Schema::hasColumn('voters', 'fingerprint_verified_at')) {
                $table->timestamp('fingerprint_verified_at')->nullable()->after('fingerprint_registered_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->dropColumn([
                'fingerprint_template',
                'fingerprint_hash',
                'fingerprint_registered_at',
                'fingerprint_verified_at'
            ]);
        });
    }
};
