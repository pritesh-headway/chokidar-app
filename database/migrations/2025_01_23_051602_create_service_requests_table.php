<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('provider_id');
            $table->enum('request_status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('service_providers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_requests');
    }
}
