<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
public function up()
{
    Schema::table('voters', function (Blueprint $table) {
        $table->string('fingerprint_hash')->nullable();
    });
}

public function down()
{
    Schema::table('voters', function (Blueprint $table) {
        $table->dropColumn('fingerprint_hash');
    });
}

}
;
