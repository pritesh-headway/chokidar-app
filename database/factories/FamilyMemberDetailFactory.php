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

        $user = User::whereIn('role', ['owner', 'tenant'])->inRandomOrder()->first();
        return [

            'block_number' => $user->block_number,
            'member_name' => $this->faker->name,
            'user_id' => $user->id,
            'mobile' => $this->faker->numerify('##########'),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
