<?php

namespace Database\Seeders;

use App\Models\Maintenance;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    public function run()
    {
        // Seed the maintenance table with 10 records
        // Maintenance::truncate();
        Maintenance::factory(10)->create();
    }
}

