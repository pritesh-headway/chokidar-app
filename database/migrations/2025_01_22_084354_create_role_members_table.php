<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleMembersTable extends Migration
{
    public function up()
    {
        Schema::create('role_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Foreign key for roles table
            $table->string('role_name'); // Role name, taken from roles table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key for users table
            $table->string('profile_image')->nullable();
            $table->string('mobile')->nullable();
            $table->string('block_number')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_members');
    }
}
