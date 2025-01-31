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
                ->onDelete('cascade'); // If a user is deleted, the associated security guard record will also be deleted
        });
    }

    public function down()
    {
        Schema::table('securities', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
}
