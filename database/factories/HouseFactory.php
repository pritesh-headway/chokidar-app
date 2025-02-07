<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'house_no'   => $this->faker->buildingNumber,
            'block'      => strtoupper($this->faker->randomLetter),
            'floor'      => $this->faker->numberBetween(1, 10),
            'society_id' => 2,
            'status'     => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Configure the factory.
     */
    public function configure()
    {
        return $this->afterCreating(function ($house) {
            // Pick a random user whose society_id is 2 and role_id is 3 or 4.
            $user = User::where('society_id', 2)
                ->whereIn('role_id', [3, 4])
                ->inRandomOrder()
                ->first();

            if ($user) {
                $user->update(['house_id' => $house->id]);
            }
        });
    }
}
