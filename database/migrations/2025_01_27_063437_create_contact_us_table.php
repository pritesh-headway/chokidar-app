<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/{timestamp}_create_contact_us_table.php

    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->string('society_name'); // Name of the society, apartment, or villa
            $table->string('country'); // Country
            $table->string('city'); // City
            $table->string('full_name'); // Full name of the person contacting
            $table->string('email'); // Email address
            $table->string('phone_number', 10); // Phone number (10-digit fixed length)
            $table->text('comments'); // Comments or questions
            $table->timestamps(); // To store created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_us');
    }
};
