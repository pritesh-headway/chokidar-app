<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueConstraintsFromUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropUnique(['block_number']);
            $table->dropUnique(['mobile']);
            $table->dropUnique(['email']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->unique('block_number');
            $table->unique('mobile');
            $table->unique('email');
        });
    }
}
