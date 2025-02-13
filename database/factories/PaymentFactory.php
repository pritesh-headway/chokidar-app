<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Society;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'society_id' => Society::inRandomOrder()->first()->id ?? Society::factory(),
            'amount' => $this->faker->randomFloat(2, 500, 5000),
            'transaction_id' => $this->faker->unique()->uuid(),
            'status' => $this->faker->randomElement(['pending', 'success', 'failed', 'refunded']),
            'payment_date' => now(),
        ];
    }
}
