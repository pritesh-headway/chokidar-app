<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumsTable extends Migration
{
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('block_number', 50); // Block number
            $table->unsignedBigInteger('user_id'); // Foreign key referencing users table
            $table->string('forum_by', 50); // Concatenated first_name and last_name from users table
            $table->string('title', 255); // Forum title
            $table->text('description'); // Forum description
            $table->date('date'); // Forum date
            $table->string('profile_photo', 256); // Profile photo path
            $table->integer('responses')->default(0); // Number of responses
            $table->text('photos')->nullable(); // Photos (JSON or comma-separated links)
            $table->enum('status', ['active', 'deactive'])->default('active'); // Status
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('forums');
    }
}
