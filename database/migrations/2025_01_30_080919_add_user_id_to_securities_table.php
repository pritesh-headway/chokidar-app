<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToSecuritiesTable extends Migration
{
    public function up()
    {
        Schema::table('securities', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); // Add user_id column (nullable initially)
        });
    }

    public function down()
    {
        Schema::table('securities', function (Blueprint $table) {
            $table->dropColumn('user_id'); // Rollback the column if migration is reversed
        });
    }
}
