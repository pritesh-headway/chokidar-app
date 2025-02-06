<?php

namespace Database\Factories;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseFactory extends Factory
{
    protected $model = \App\Models\Response::class;

    public function definition()
    {
        return [
            'forum_id' => Forum::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
