<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create 4 predefined roles
        Role::create([
            'role_name' => 'Chairman',
            'status' => 'active',
        ]);

        Role::create([
            'role_name' => 'Accountant',
            'status' => 'active',
        ]);

        Role::create([
            'role_name' => 'Representative',
            'status' => 'active',
        ]);

        Role::create([
            'role_name' => 'Committee Member',
            'status' => 'active',
        ]);

        // Optionally, use factory to generate random roles
        // \App\Models\Role::factory()->count(10)->create(); // Create 10 random roles
    }
}
