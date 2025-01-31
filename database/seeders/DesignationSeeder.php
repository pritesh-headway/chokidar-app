<?php

namespace Database\Seeders;

// use App\Models\Role;
use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    public function run()
    {
        // Create 4 predefined roles
        Designation::create([
            'role_name' => 'Chairman',
            'status' => 'active',
        ]);

        Designation::create([
            'role_name' => 'Accountant',
            'status' => 'active',
        ]);

        Designation::create([
            'role_name' => 'Representative',
            'status' => 'active',
        ]);

        Designation::create([
            'role_name' => 'Committee Member',
            'status' => 'active',
        ]);

        // Optionally, use factory to generate random roles
        // \App\Models\Designation::factory()->count(10)->create(); // Create 10 random roles
    }
}
