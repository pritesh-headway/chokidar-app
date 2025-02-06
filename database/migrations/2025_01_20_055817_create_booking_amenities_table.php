<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingAmenitiesTable extends Migration
{
    public function up()
    {
        Schema::create('booking_amenities', function (Blueprint $table) {
            $table->id();
            $table->string('block_name', 50);
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->time('from');
            $table->time('to');
            $table->date('day');
            $table->unsignedBigInteger('amenity_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mobile', 10);
            $table->enum('booking_status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();
            $table->foreign('amenity_id')->references('id')->on('amenities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_amenities');
    }
}
