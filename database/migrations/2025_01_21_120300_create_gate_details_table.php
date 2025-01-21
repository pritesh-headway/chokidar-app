<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGateDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('gate_details', function (Blueprint $table) {
            $table->id();
            $table->integer('gate_no'); // Gate number
            $table->foreignId('security_id')->constrained('securities')->onDelete('cascade'); // Security ID (foreign key)
            $table->string('gate_mobile', 15); // Mobile number for the gate
            $table->enum('status', ['active', 'deactive'])->default('active'); // Status
            $table->timestamps(); // Created and updated timestamps

            // Remove the unique constraint from gate_no and gate_mobile combination
            $table->unique(['gate_no', 'gate_mobile'], 'unique_gate_mobile');
        });
    }


    public function down()
    {
        Schema::dropIfExists('gate_details');
    }
}
