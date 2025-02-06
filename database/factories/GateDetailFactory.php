<?php

namespace Database\Factories;

use App\Models\GateDetail;
use App\Models\Security;
use Illuminate\Database\Eloquent\Factories\Factory;

class GateDetailFactory extends Factory
{
    protected $model = GateDetail::class;

    public function definition()
    {

        $security = Security::inRandomOrder()->first();

        return [
            'gate_no' => $this->faker->unique()->numberBetween(1, 10),
            'security_id' => $security->id,
            'gate_mobile' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
