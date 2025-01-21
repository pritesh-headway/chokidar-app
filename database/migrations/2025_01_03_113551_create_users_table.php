<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('block_number', 50)->unique(); // Unique block number
            $table->string('first_name', 50); // First name
            $table->string('last_name', 50); // Last name
            $table->enum('role', ['owner', 'admin', 'coowner', 'committee']); // Role enumeration
            $table->string('mobile', 10)->unique(); // Mobile number with unique constraint
            $table->string('block', 50); // Block information
            $table->string('profile_photo', 256)->nullable(); // Profile photo, nullable
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status with default
            $table->string('email')->nullable()->unique(); // Email for admin login
            $table->string('password')->nullable(); // Password for admin login
            $table->string('otp')->nullable(); // OTP for mobile login
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp
            $table->rememberToken(); // Token for "remember me" functionality
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
