<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('block');
            $table->dropColumn('block_number');
            $table->string('block')->nullable();
            $table->string('house_no')->nullable();
            $table->unsignedBigInteger('house_id')->nullable();
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('block')->nullable();
            $table->string('block_number')->nullable();
            $table->dropColumn('block');
            $table->dropColumn('house_no');
            $table->dropForeign(['house_id']);
            $table->dropColumn('house_id');
        });
    }
};
