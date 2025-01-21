<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->string('block_number');  // Block number (to be the same as user's block_number)
            $table->string('vehicle_number')->unique();  // Vehicle number (with a unique constraint)
            $table->enum('vehicle_type', ['2-wheeler', '4-wheeler']);  // Vehicle type (either 2-wheeler or 4-wheeler)
            $table->unsignedBigInteger('user_id');  // Foreign key referencing the users table's id
            // $table->string('vehicle_image', 256)->nullable();  // Vehicle image URL or path
            $table->enum('status', ['active', 'deactive'])->default('active');  // Status of the vehicle
            $table->timestamps();

            // Add foreign key constraint for user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  // Ensures referential integrity
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
