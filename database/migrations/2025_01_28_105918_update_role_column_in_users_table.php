<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoleColumnInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {

            $table->enum('role', ['owner', 'admin', 'super-admin', 'tenant'])
                ->default('owner');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {

            $table->enum('role', ['owner', 'admin', 'coowner', 'committee'])
                ->default('owner');
        });
    }
}
