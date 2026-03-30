<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('voters', function (Blueprint $table) {
            if (!Schema::hasColumn('voters', 'voted_at')) {
                $table->timestamp('voted_at')->nullable()->after('has_voted');
            }
        });
    }

    public function down()
    {
        Schema::table('voters', function (Blueprint $table) {
            if (Schema::hasColumn('voters', 'voted_at')) {
                $table->dropColumn('voted_at');
            }
        });
    }
};
