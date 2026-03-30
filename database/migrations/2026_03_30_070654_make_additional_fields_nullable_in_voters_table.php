<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('voters', function (Blueprint $table) {
            // Make all these fields nullable
            if (Schema::hasColumn('voters', 'faculty')) {
                $table->string('faculty')->nullable()->change();
            }
            if (Schema::hasColumn('voters', 'faculty_code')) {
                $table->string('faculty_code')->nullable()->change();
            }
            if (Schema::hasColumn('voters', 'program')) {
                $table->string('program')->nullable()->change();
            }
            if (Schema::hasColumn('voters', 'year_of_study')) {
                $table->string('year_of_study')->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('voters', function (Blueprint $table) {
            // Revert to not nullable (add default values)
            if (Schema::hasColumn('voters', 'faculty')) {
                $table->string('faculty')->nullable(false)->change();
            }
            if (Schema::hasColumn('voters', 'faculty_code')) {
                $table->string('faculty_code')->nullable(false)->change();
            }
            if (Schema::hasColumn('voters', 'program')) {
                $table->string('program')->nullable(false)->change();
            }
            if (Schema::hasColumn('voters', 'year_of_study')) {
                $table->string('year_of_study')->nullable(false)->change();
            }
        });
    }
};
