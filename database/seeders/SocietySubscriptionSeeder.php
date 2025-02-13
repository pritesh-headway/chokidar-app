<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SocietySubscriptionSeeder extends Seeder
{
    public function run()
    {
        // Define subscription records manually
        $subscriptions = [
            [
                'society_id' => 2,
                'plan_id' => 1, // Assuming "Basic" plan
                'start_date' => '2024-02-01',
                'end_date' => '2024-03-01',
                'status' => 'expired',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'society_id' => 3,
                'plan_id' => 2, // Assuming "Standard" plan
                'start_date' => '2024-02-01',
                'end_date' => '2024-08-01',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'society_id' => 5,
                'plan_id' => 3, // Assuming "Premium" plan
                'start_date' => '2024-02-01',
                'end_date' => '2025-02-01',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Insert into the database
        DB::table('society_subscriptions')->insert($subscriptions);
    }
}
