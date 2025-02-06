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
        Schema::table('booking_amenities', function (Blueprint $table) {
            $table->text('reason')->nullable()->after('booking_status'); // Adding reason column as nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_amenities', function (Blueprint $table) {
            $table->dropColumn('reason'); // Rollback step
        });
    }
};
