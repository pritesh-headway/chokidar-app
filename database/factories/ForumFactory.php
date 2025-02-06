<?php

namespace Database\Factories;

use App\Models\Forum;
use App\Models\Response;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumFactory extends Factory
{
    protected $model = Forum::class;

    public function definition()
    {

        $user = User::inRandomOrder()->first();
        $forum = Forum::create([
            'block_number' => $user->block_number,
            'user_id' => $user->id,
            'forum_by' => $user->first_name . ' ' . $user->last_name,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'profile_photo' => $user->profile_photo,
            'photos' => json_encode([
                'forum_images/forum1.jpg',
                'forum_images/forum2.jpg'
            ]),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ]);
        $responsesCount = Response::where('forum_id', $forum->id)->count();
        $forum->responses = $responsesCount;
        $forum->save();

        return [
            'block_number' => $user->block_number,
            'user_id' => $user->id,
            'forum_by' => $user->first_name . ' ' . $user->last_name,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'profile_photo' => $user->profile_photo,
            'responses' => $responsesCount,
            'photos' => json_encode([
                'forum_images/forum1.jpg',
                'forum_images/forum2.jpg'
            ]),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
