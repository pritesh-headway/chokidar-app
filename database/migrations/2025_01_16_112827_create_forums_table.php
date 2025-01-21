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
            $table->string('block_number', 50); // Block number (varchar(50))
            $table->string('forum_by', 50); // Forum posted by (varchar(50))
            $table->string('title', 255); // Forum title
            $table->text('description'); // Description
            $table->date('date'); // Date (for the post)
            $table->string('profile_photo', 256); // Profile photo URL or path (varchar(256))
            $table->integer('responses')->default(0); // Number of responses (int)
            $table->text('photos')->nullable(); // Photos (multiple images, text to store URLs)
            $table->enum('status', ['active', 'deactive'])->default('active'); // Status (active or deactive)
            $table->timestamps(); // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('forums');
    }
}
