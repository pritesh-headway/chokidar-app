<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('gate_details', function (Blueprint $table) {
            // Drop the unique constraint on gate_mobile
            $table->dropUnique(['gate_mobile']);
        });
    }

    public function down()
    {
        Schema::table('gate_details', function (Blueprint $table) {
            // Restore the unique constraint on gate_mobile if needed
            $table->unique('gate_mobile');
        });
    }
};
