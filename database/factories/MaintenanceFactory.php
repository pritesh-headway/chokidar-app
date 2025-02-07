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
        $user = User::whereNotNull('house_id') // Ensure user has a house
            ->where('society_id', 2)
            ->inRandomOrder()
            ->first();

        if (!$user || !$user->house_id) {
            // If no valid user-house combination is found, return dummy data or skip
            return [];
        }

        $house = $user->house;

        return [
            'block_number' => $house ? $house->block . '-' . $house->house_no : 'Unknown',
            'owner_name' => $user ? $user->first_name . ' ' . $user->last_name : 'Unknown',
            'maintenance_status' => $this->faker->randomElement(['PENDING', 'COMPLETED']),
            'block' => $house ? strtoupper(substr($house->block, 0, 1)) : 'X',
            'photo' => $user->profile_photo ?? 'default.jpg',
            'user_id' => $user->id,
            'amount' => $this->faker->numberBetween(1000, 10000),
            'date' => $this->faker->date(),
            'description' => $this->faker->text(),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
