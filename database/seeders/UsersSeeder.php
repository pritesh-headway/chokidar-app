<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User; // Ensure this points to your Users model

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the users table
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('users')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        // Enable foreign key checks
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Create 5 users using the factory

        User::create([
            'block_number' => 'B-109', // You can adjust the block number or use default
            'first_name' => 'Admin',
            'last_name' => 'User',
            'role' => 'admin', // Set the role to admin
            'mobile' => '0000000000', // You can change this if needed
            'block' => 'B', // Adjust this based on your system
            'profile_photo' => null, // If no photo is set
            'status' => 'active', // Active status
            'email' => 'root@root.com',
            'password' => bcrypt('root1234'), // bcrypt the password
            'otp' => '0096', // OTP as specified
        ]);

        User::factory()->count(10)->create();
    }
}
// eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTkyLjE2OC4xLjE2OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzM3MDA4MDI1LCJleHAiOjE3MzcwMTE2MjUsIm5iZiI6MTczNzAwODAyNSwianRpIjoiWGtBWnhrWlJmZFQ3aEkzdiIsInN1YiI6IjkiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.v2WsD-ypwVsntOK9eyKKTPkmyq0ZGU7iTSpo9JXFCus