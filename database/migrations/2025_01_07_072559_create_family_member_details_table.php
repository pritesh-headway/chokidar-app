<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('family_member_details', function (Blueprint $table) {
            $table->id();
            $table->string('block_number', 50);
            $table->string('member_name', 50);
            $table->unsignedBigInteger('user_id');
            $table->string('mobile', 10);
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_member_details');
    }
};
