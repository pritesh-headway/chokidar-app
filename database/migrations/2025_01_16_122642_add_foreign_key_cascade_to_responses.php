<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop the existing foreign key
        Schema::table('responses', function (Blueprint $table) {
            $table->dropForeign(['forum_id']);
        });

        // Recreate the foreign key with 'cascade' on delete
        Schema::table('responses', function (Blueprint $table) {
            $table->foreign('forum_id')->references('id')->on('forums')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Drop the foreign key and remove cascading delete
        Schema::table('responses', function (Blueprint $table) {
            $table->dropForeign(['forum_id']);
        });
    }
};
