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
        // Randomly pick a user from the users table
        $user = User::inRandomOrder()->first();

        return [
            'block_number' => $user->block_number,  // Use the user's block_number
            'owner_name' => $user->first_name . ' ' . $user->last_name, // Concatenate first_name and last_name
            'maintenance_status' => $this->faker->randomElement(['PENDING', 'COMPLETED']),
            'block' => strtoupper(substr($user->block_number, 0, 1)), // Use the first letter of block_number
            'photo' => $user->profile_photo, // Use the user's profile photo
            'user_id' => $user->id,  // Foreign key to user table
            'amount' => $this->faker->numberBetween(1000, 10000),  // Random amount
            'date' => $this->faker->date(),
            'description' => $this->faker->text(),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
