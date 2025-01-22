<?php

namespace Database\Factories;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumFactory extends Factory
{
    protected $model = Forum::class;

    public function definition()
    {
        // Get a random user from the users table
        $user = User::inRandomOrder()->first();

        return [
            'block_number' => $user->block_number, // Taken from users table
            'forum_by' => $user->first_name . ' ' . $user->last_name, // Combined first and last name
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'profile_photo' => $user->profile_photo, // Taken from users table
            'responses' => $this->faker->numberBetween(1, 100),
            'photos' => json_encode([
                'forum_images/forum1.jpg',
                'forum_images/forum2.jpg'
            ]), // Example photos
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
