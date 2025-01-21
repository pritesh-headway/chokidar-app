<?php


namespace Database\Factories;

use App\Models\Forum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumFactory extends Factory
{
    protected $model = Forum::class;

    public function definition()
    {
        return [
            'block_number' => strtoupper($this->faker->randomLetter) . '-' . $this->faker->numberBetween(100, 999), // Uppercase first letter
            'forum_by' => $this->faker->name(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'profile_photo' => $this->faker->imageUrl(256, 256),
            'responses' => $this->faker->numberBetween(1, 100),
            'photos' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()]), // Multiple photos as JSON
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
