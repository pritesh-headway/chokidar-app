<?php

namespace Database\Factories;

use App\Models\SocietySubscription;
use App\Models\Society;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SocietySubscriptionFactory extends Factory
{
    protected $model = SocietySubscription::class;

    public function definition(): array
    {
        $startDate = Carbon::today();
        $duration = SubscriptionPlan::inRandomOrder()->first()->duration ?? 1;
        $endDate = $startDate->copy()->addMonths($duration);

        return [
            'society_id' => Society::factory(),
            'plan_id' => SubscriptionPlan::inRandomOrder()->first()->id ?? 1,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement(['active', 'expired', 'cancelled']),
        ];
    }
}
