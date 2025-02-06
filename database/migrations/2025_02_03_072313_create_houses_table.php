<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('house_no'); // House number (e.g., "A-101")
            $table->string('block'); // Block name or number (e.g., "Block A")
            $table->integer('floor'); // Floor number (e.g., 1, 2, 3)
            $table->unsignedBigInteger('society_id'); // Foreign key for society
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key for user (optional)
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status with default
            $table->timestamps(); // created_at and updated_at columns

            // Foreign key constraints
            $table->foreign('society_id')->references('id')->on('societies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houses');
    }
}
