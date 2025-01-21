<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();  // ID field
            $table->string('notice_title');  // Title of the notice
            $table->text('notice_desc');  // Description of the notice
            $table->date('date');  // Date of the notice
            $table->time('time');  // Time of the notice
            $table->enum('status', ['active', 'deactive'])->default('active');  // Status of the notice
            $table->timestamps();  // Created_at and Updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notices');
    }
}