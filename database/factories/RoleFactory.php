<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'role_name' => $this->faker->randomElement(['Chairman', 'Accountant', 'Representative', 'Committee Member']),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
