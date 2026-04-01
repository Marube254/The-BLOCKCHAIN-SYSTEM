<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('admin')->after('password');
            }
            if (!Schema::hasColumn('users', 'can_delete')) {
                $table->boolean('can_delete')->default(false)->after('role');
            }
            if (!Schema::hasColumn('users', 'can_manage_admins')) {
                $table->boolean('can_manage_admins')->default(false)->after('can_delete');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'can_delete', 'can_manage_admins']);
        });
    }
};
