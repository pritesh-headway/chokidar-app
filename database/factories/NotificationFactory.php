<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = \App\Models\Notification::class;

    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'type' => $this->faker->word,
            'notifiable_type' => $this->faker->randomElement(['App\Models\User', 'App\Models\Admin']),
            'notifiable_id' => $this->faker->randomNumber(),
            'data' => $this->faker->text,
            'read_at' => $this->faker->optional()->dateTime,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
