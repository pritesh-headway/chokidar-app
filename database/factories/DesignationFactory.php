<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Designation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DesignationFactory extends Factory
{
    protected $model = Designation::class;

    public function definition()
    {
        return [
            'role_name' => $this->faker->randomElement(['Chairman', 'Accountant', 'Representative', 'Committee Member']),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
