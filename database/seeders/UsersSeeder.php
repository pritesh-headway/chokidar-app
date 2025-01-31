<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User; // Ensure this points to your Users model
use Spatie\Permission\Models\Role;

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

        // User::create([
        //     'block_number' => 'B-109', // You can adjust the block number or use default
        //     'first_name' => 'Admin',
        //     'last_name' => 'User',
        //     'role' => 'admin', // Set the role to admin
        //     'mobile' => '0000000000', // You can change this if needed
        //     'block' => 'B', // Adjust this based on your system
        //     'profile_photo' => 'profile_photos/avatar.png', // If no photo is set
        //     'status' => 'active', // Active status
        //     'email' => 'root@root.com',
        //     'password' => bcrypt('root1234'), // bcrypt the password
        //     'otp' => '0096', // OTP as specified
        // ]);

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // User::create([
        //     'role' => 'super-admin',
        //     'block_number' => 'A-999', // Adjust as needed
        //     'first_name' => 'Super',
        //     'last_name' => 'Admin',
        //     'mobile' => '8347400096',
        //     'block' => 'A',
        //     'profile_photo' => "profile_photos/super-admin.png", // or your default photo
        //     'status' => 'active',
        //     'email' => 'admin@headway.org.in',
        //     'password' => bcrypt('123456'),
        //     'otp' => '0096',
        //     'email_verified_at' => now(),
        //     // 'remember_token' => Str::random(10),
        //     // 'created_at' => now(),
        //     // 'updated_at' => now(),
        //     'society_id' => 0 // Adjust as needed
        // ]);
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');



        // // Creating roles
        // Role::create(['name' => 'super-admin']);
        // Role::create(['name' => 'admin']);
        // Role::create(['name' => 'owner']);
        // Role::create(['name' => 'tenant']);

        // // Assigning role to user
        // $user = User::find(247); // Super Admin user ID
        // $user->assignRole('super-admin');


        // User::factory()->count(10)->create();
    }
}
// eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTkyLjE2OC4xLjE2OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzM3MDA4MDI1LCJleHAiOjE3MzcwMTE2MjUsIm5iZiI6MTczNzAwODAyNSwianRpIjoiWGtBWnhrWlJmZFQ3aEkzdiIsInN1YiI6IjkiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.v2WsD-ypwVsntOK9eyKKTPkmyq0ZGU7iTSpo9JXFCus