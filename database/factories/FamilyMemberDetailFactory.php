<?php


namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\FamilyMemberDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class FamilyMemberDetailFactory extends Factory
{
    protected $model = FamilyMemberDetail::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();
        return [
            // 'block_number' => $this->faker->regexify('[A-Z]-[0-9]{3}'),
            'block_number' => $user->block_number,
            'member_name' => $this->faker->name,
            'user_id' => $user->id, // This will create a new user if not provided
            'mobile' => $this->faker->numerify('##########'),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
