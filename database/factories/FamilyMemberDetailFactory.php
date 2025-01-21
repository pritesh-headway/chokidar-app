<?php


namespace Database\Factories;

use App\Models\FamilyMemberDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FamilyMemberDetailFactory extends Factory
{
    protected $model = FamilyMemberDetail::class;

    public function definition()
    {
        return [
            'block_number' => $this->faker->regexify('[A-Z]-[0-9]{3}'),
            'member_name' => $this->faker->name,
            'user_id' => \App\Models\User::factory(), // This will create a new user if not provided
            'mobile' => $this->faker->numerify('##########'),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
