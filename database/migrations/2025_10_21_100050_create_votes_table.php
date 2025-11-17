<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voter_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('candidate_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('sector');
            $table->timestamp('confirmed_at')->nullable();
           // $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
