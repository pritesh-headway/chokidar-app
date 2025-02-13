<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    public function run()
    {
        SubscriptionPlan::create([
            'name' => 'Basic',
            'price' => 500,
            'duration' => 1,
            'status' => 'active'
        ]);

        SubscriptionPlan::create([
            'name' => 'Standard',
            'price' => 2500,
            'duration' => 6,
            'status' => 'active'
        ]);

        SubscriptionPlan::create([
            'name' => 'Premium',
            'price' => 5000,
            'duration' => 12,
            'status' => 'active'
        ]);
    }
}
