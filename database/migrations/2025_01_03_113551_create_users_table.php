<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('block_number', 50)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->enum('role', ['owner', 'admin', 'coowner', 'committee']);
            $table->string('mobile', 10)->unique();
            $table->string('block', 50);
            $table->string('profile_photo', 256)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
