<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GateDetail;
use App\Models\Security;
use Faker\Factory as Faker;

class GateDetailSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Adjust the number of rows you want to insert
        for ($i = 0; $i < 10; $i++) {
            // Select a random security guard
            $security = Security::inRandomOrder()->first();

            // Generate a clean 10-digit phone number without special characters
            $gateMobile = preg_replace('/\D/', '', $faker->phoneNumber); // Remove non-digit characters

            // Make sure it's exactly 10 digits
            $gateMobile = substr($gateMobile, 0, 10);

            // Create multiple gate details for a single gate number with different security IDs
            GateDetail::create([
                // Change gate_no to allow a larger range
                'gate_no' => $faker->unique()->numberBetween(1, 1000),  // Larger range for unique gate numbers
                'security_id' => $security->id,  // Random security guard's ID
                'gate_mobile' => $gateMobile,  // Clean 10-digit phone number
                'status' => $faker->randomElement(['active', 'deactive']),  // Random status
            ]);
        }
    }
}
