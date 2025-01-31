<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoleColumnInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Step 1: Drop the existing 'role' column
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            // Step 2: Add the new 'role' column with updated ENUM values
            $table->enum('role', ['owner', 'admin', 'super-admin', 'tenant'])
                ->default('owner');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Step 1: Drop the updated 'role' column
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            // Step 2: Add the old 'role' column with previous ENUM values
            $table->enum('role', ['owner', 'admin', 'coowner', 'committee'])
                ->default('owner');
        });
    }
}
