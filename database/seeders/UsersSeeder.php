<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // User::create([
        //     'first_name' => 'John',
        //     'last_name' => 'Doe',
        //     'mobile' => '1234567890',
        //     'profile_photo' => env('APP_URL') . 'profile_photos/avatar.png',
        //     'status' => 'active',
        //     'email' => 'john.doe@example.com',
        //     'password' => bcrypt('password'),
        //     'otp' => '123456',
        //     'email_verified_at' => now(),
        //     'remember_token' => \Str::random(10),
        //     'society_id' => 1,
        //     'role_id' => 3,
        //     'block' => 'A',
        //     'house_no' => 'A1',
        //     'house_id' => 1,
        // ]);

        User::factory()->count(10)->create();
    }
}
