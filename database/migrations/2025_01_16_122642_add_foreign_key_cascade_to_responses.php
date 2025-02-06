<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::table('responses', function (Blueprint $table) {
            $table->dropForeign(['forum_id']);
        });
        Schema::table('responses', function (Blueprint $table) {
            $table->foreign('forum_id')->references('id')->on('forums')->onDelete('cascade');
        });
    }

    public function down()
    {

        Schema::table('responses', function (Blueprint $table) {
            $table->dropForeign(['forum_id']);
        });
    }
};
