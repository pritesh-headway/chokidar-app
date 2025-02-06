<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecuritiesTable extends Migration
{
    public function up()
    {
        Schema::create('securities', function (Blueprint $table) {
            $table->id();
            $table->string('guard_name', 50);
            $table->bigInteger('mobile');
            $table->string('address', 255);
            $table->integer('gate_no');
            $table->text('details');
            $table->string('guard_image', 256);
            $table->text('documents');
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('securities');
    }
}
