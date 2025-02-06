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
        for ($i = 0; $i < 10; $i++) {

            $security = Security::inRandomOrder()->first();
            $gateMobile = preg_replace('/\D/', '', $faker->phoneNumber);
            $gateMobile = substr($gateMobile, 0, 10);
            GateDetail::create([

                'gate_no' => $faker->unique()->numberBetween(1, 1000),
                'security_id' => $security->id,
                'gate_mobile' => $gateMobile,
                'status' => $faker->randomElement(['active', 'deactive']),
            ]);
        }
    }
}
