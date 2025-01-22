<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition()
    {
        return [
            'service_name' => $this->faker->randomElement(['Security', 'Cleaner', 'Gardener', 'Electrician', 'Plumber', 'Maid', 'Iron Press', 'Milk man', 'Baby Caretaker']),
            'service_type' => $this->faker->randomElement(['society', 'owner', 'both']),
            'status' => $this->faker->randomElement(['active', 'deactive']),
            'service_image' => 'service_images/service1.png',
        ];
    }
}
