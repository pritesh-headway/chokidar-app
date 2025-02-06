<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    public function run()
    {

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
    }
}
