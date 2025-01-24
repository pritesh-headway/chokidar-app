<?php


namespace Database\Factories;

use App\Models\Forum;
use App\Models\Response;  // Make sure to import the Response model
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumFactory extends Factory
{
    protected $model = Forum::class;

    public function definition()
    {
        // Get a random user from the users table
        $user = User::inRandomOrder()->first();

        // Create a new forum
        $forum = Forum::create([
            'block_number' => $user->block_number, // Taken from users table
            'user_id' => $user->id,
            'forum_by' => $user->first_name . ' ' . $user->last_name, // Combined first and last name
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'profile_photo' => $user->profile_photo, // Taken from users table
            'photos' => json_encode([ // Example photos
                'forum_images/forum1.jpg',
                'forum_images/forum2.jpg'
            ]),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ]);

        // Now get the count of responses for this forum_id
        $responsesCount = Response::where('forum_id', $forum->id)->count();

        // Update the forum with the response count
        $forum->responses = $responsesCount;
        $forum->save();

        return [
            'block_number' => $user->block_number, // Taken from users table
            'user_id' => $user->id,
            'forum_by' => $user->first_name . ' ' . $user->last_name, // Combined first and last name
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'profile_photo' => $user->profile_photo, // Taken from users table
            'responses' => $responsesCount, // Set the response count here
            'photos' => json_encode([ // Example photos
                'forum_images/forum1.jpg',
                'forum_images/forum2.jpg'
            ]),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
