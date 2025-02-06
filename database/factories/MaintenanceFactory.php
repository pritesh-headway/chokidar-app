<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceFactory extends Factory
{
    protected $model = Maintenance::class;

    public function definition()
    {
        $user = User::where('society_id', 2)->inRandomOrder()->first();

        return [
            'block_number' => $user->block_number,
            'owner_name' => $user->first_name . ' ' . $user->last_name,
            'maintenance_status' => $this->faker->randomElement(['PENDING', 'COMPLETED']),
            'block' => strtoupper(substr($user->block_number, 0, 1)),
            'photo' => $user->profile_photo,
            'user_id' => $user->id,
            'amount' => $this->faker->numberBetween(1000, 10000),
            'date' => $this->faker->date(),
            'description' => $this->faker->text(),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
