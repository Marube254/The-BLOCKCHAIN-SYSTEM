<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->id();

            // Basic voter info
            $table->string('voter_id')->unique(); // Example: V001, V002
            $table->string('first_name');
            $table->string('last_name');

            // Academic details
            $table->string('faculty');
            $table->string('faculty_code');
            $table->string('program');
            $table->unsignedTinyInteger('year_of_study'); // 1–5 range

            // Registration & voting details
            $table->timestamp('registered_at')->nullable();
            $table->boolean('has_voted')->default(false);

            // Authentication details
            $table->string('password')->nullable(); // nullable for fingerprint-only login
            $table->string('fingerprint_hash')->nullable(); // store fingerprint template/hash

            // Optional metadata
            //$table->json('metadata')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
