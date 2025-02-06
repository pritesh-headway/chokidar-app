<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = \App\Models\Vehicle::class;

    public function definition()
    {
        $user = User::whereIn('role_id', [3, 4])
            ->inRandomOrder()
            ->first();
        return [
            'block_number' => $user ? $user->block_number : 'Unknown',
            'vehicle_number' => strtoupper($this->faker->regexify('GJ01[A-Z]{2}[0-9]{4}')),
            'vehicle_type' => $this->faker->randomElement(['2-wheeler', '4-wheeler']),
            'user_id' => $user->id,

            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
