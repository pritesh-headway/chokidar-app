<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceTable extends Migration
{
    public function up()
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->string('block_number', 50);
            $table->string('owner_name', 50);
            $table->enum('maintenance_status', ['PENDING', 'COMPLETED'])->default('PENDING');
            $table->string('block', 50);
            $table->string('photo', 256)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->integer('amount');
            $table->date('date');
            $table->text('description');
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenance');
    }
}
