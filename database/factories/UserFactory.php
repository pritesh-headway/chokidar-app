<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $block_number = strtoupper($this->faker->randomLetter()) . '-' . $this->faker->numberBetween(100, 999); // Format: A-123
        return [

            'block_number' => $block_number,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => $this->faker->randomElement(['owner', 'admin', 'coowner', 'committee']),
            //'mobile' => $this->faker->unique()->numerify('##########'), // Generate a  unique 10-digit mobile number
            'mobile' => $this->faker->unique(true)->numerify('##########'), // Ensures unique mobile number
            'block' =>  explode('-', $block_number)[0],
            'profile_photo' => env('APP_URL') . 'profile_photos/avatar.png', // You can adjust this to generate random image URLs if needed
            'status' => $this->faker->randomElement(['active', 'inactive']),

        ];
    }
}
