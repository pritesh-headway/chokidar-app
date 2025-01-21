<?php


namespace Database\Factories;

use App\Models\Response;
use App\Models\Forum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseFactory extends Factory
{
    protected $model = Response::class;

    public function definition()
    {
        return [
            'forum_id' => Forum::factory(), // Automatically associate with a forum
            'user_name' => $this->faker->name,
            'comment' => $this->faker->text,
        ];
    }
}
