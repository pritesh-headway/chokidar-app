<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitorFactory extends Factory
{
    protected $model = Visitor::class;

    public function definition()
    {
        // Randomly pick a user from the users table
        $user = User::inRandomOrder()->first();

        return [
            'block_number' => $user ? $user->block_number : 'Unknown',  // Use the user's block_number
            'visitor_name' => $this->faker->name(),
            // 'mobile' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->numerify('9#########'), // Generates a phone number like '9XXXXXXXXX'
            'date' => $this->faker->date(),
            'reason' => $this->faker->sentence(),
            'visitor_status' => $this->faker->randomElement(['Pending', 'Active', 'Decline']),
            'prof_image' => $this->faker->imageUrl(256, 256),  // Profile image URL
            'user_id' => $user->id,  // Foreign key to the user
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
