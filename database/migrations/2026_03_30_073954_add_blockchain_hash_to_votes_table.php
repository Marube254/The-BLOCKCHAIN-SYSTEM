<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->string('blockchain_hash', 64)->nullable()->after('sector');
            $table->string('previous_hash', 64)->nullable()->after('blockchain_hash');
            $table->integer('block_index')->nullable()->after('previous_hash');
            $table->string('ip_address')->nullable()->after('block_index');
            $table->string('user_agent')->nullable()->after('ip_address');
            $table->timestamp('voted_at')->nullable()->after('user_agent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropColumn(['blockchain_hash', 'previous_hash', 'block_index', 'ip_address', 'user_agent', 'voted_at']);
        });
    }
};
