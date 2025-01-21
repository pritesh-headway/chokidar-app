<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        // // Seed vehicles for 10 random users
        // \App\Models\Vehicle::factory(30)->create();  // Creates 30 vehicles linked to 10 random users
        // Vehicle::truncate();
        // Create 5 vehicles with random users
        Vehicle::factory()->count(5)->create();
    }
}
