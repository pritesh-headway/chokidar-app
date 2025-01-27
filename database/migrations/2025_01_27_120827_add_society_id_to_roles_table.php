<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocietyIdToRolesTable extends Migration
{
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedBigInteger('society_id')->nullable(); // Add society_id as a nullable column
            $table->foreign('society_id')->references('id')->on('societies')->onDelete('cascade'); // Add foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['society_id']); // Drop the foreign key constraint
            $table->dropColumn('society_id'); // Drop the society_id column
        });
    }
}
