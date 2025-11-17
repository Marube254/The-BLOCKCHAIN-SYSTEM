<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();

            // Candidate personal info
            $table->string('candidate_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('display_name');
            $table->string('photo_filename')->nullable();

            // Academic info
            $table->string('faculty');
            $table->string('faculty_code');
           // $table->string('department');
            $table->string('program');
            $table->integer('year_of_study');

            // Sector info
            $table->string('sector');
            $table->string('sector_code');
            $table->string('candidate_number')->unique();


            // Candidate manifesto & bio
            $table->text('manifesto')->nullable();
            $table->text('bio')->nullable();

            // Contact & status
            $table->string('contact_email')->nullable();
            $table->enum('status', ['active', 'withdrawn', 'disqualified'])->default('active');

            // Registration timestamp
            $table->timestamp('registered_at')->nullable();

            // Metadata (JSON)
           // $table->json('metadata')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
