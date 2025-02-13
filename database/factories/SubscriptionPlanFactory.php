<?php

namespace Database\Factories;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionPlanFactory extends Factory
{
    protected $model = SubscriptionPlan::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'duration' => $this->faker->numberBetween(1, 12),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
