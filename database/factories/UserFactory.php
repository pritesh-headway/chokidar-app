<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $block_number = strtoupper($this->faker->randomLetter()) . '-' . $this->faker->numberBetween(100, 999);
        return [

            'block_number' => $block_number,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => $this->faker->randomElement(['owner', 'admin', 'coowner', 'committee']),
            //'mobile' => $this->faker->unique()->numerify('##########'),
            'mobile' => $this->faker->unique(true)->numerify('##########'),
            'block' =>  explode('-', $block_number)[0],
            'profile_photo' => env('APP_URL') . 'profile_photos/avatar.png',
            'status' => $this->faker->randomElement(['active', 'inactive']),

        ];
    }
}
