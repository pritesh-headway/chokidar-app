<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocietyIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('society_id')->nullable(); // Add the society_id column
            $table->foreign('society_id')->references('id')->on('societies')->onDelete('set null'); // Foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['society_id']); // Drop the foreign key constraint
            $table->dropColumn('society_id'); // Drop the society_id column
        });
    }
}
