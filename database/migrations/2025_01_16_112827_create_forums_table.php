<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumsTable extends Migration
{
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->string('block_number', 50);
            $table->unsignedBigInteger('user_id');
            $table->string('forum_by', 50);
            $table->string('title', 255);
            $table->text('description');
            $table->date('date');
            $table->string('profile_photo', 256);
            $table->integer('responses')->default(0);
            $table->text('photos')->nullable();
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('forums');
    }
}
