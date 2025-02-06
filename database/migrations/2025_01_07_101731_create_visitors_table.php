<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('block_number', 50);
            $table->string('visitor_name', 50);
            $table->string('mobile', 10);
            $table->date('date');
            $table->string('reason', 255);
            $table->enum('visitor_status', ['Pending', 'Active', 'Decline'])->default('Pending');
            $table->string('prof_image', 256);
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
