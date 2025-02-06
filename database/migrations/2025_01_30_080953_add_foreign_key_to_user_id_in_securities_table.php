<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToUserIdInSecuritiesTable extends Migration
{
    public function up()
    {
        Schema::table('securities', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('securities', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
}
