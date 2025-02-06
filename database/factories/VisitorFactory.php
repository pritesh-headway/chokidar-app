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

        $user = User::inRandomOrder()->first();

        return [
            'block_number' => $user ? $user->block_number : 'Unknown',
            'visitor_name' => $this->faker->name(),

            'mobile' => $this->faker->numerify('9#########'),
            'date' => $this->faker->date(),
            'reason' => $this->faker->sentence(),
            'visitor_status' => $this->faker->randomElement(['Pending', 'Active', 'Decline']),
            'prof_image' => $this->faker->imageUrl(256, 256),
            'user_id' => $user->id,
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
