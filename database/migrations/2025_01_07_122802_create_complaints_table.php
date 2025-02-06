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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('block_number', 50);
            $table->string('complaint_by', 50);
            $table->string('complaint_title', 255);

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('complaint_desc');
            $table->date('date');
            $table->enum('complaint_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('photos');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
