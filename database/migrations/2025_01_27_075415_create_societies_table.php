<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('societies', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Foreign key referring to 'users' table
            $table->string('society_name');  // Name of the society
            $table->text('address');  // Address of the society
            $table->string('city');  // City
            $table->string('state', 50);  // State
            $table->integer('postal_code');  // Postal Code (fixed length integer)
            $table->string('contact_number', 10);  // Contact number (10 digits)
            $table->enum('type', ['residential', 'commercial', 'mixed']);  // Type of society
            $table->enum('status', ['active', 'inactive'])->default('active');  // Status of the society
            $table->timestamps();  // created_at and updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societies');
    }
};
