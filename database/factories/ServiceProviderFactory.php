<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\ServiceProvider;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceProviderFactory extends Factory
{
    protected $model = ServiceProvider::class;

    public function definition()
    {

        $service = Service::inRandomOrder()->first();
        return [
            'full_name' => $this->faker->name,
            'service_id' => $service->id,
            'mobile' => $this->faker->unique()->numerify('##########'),
            'address' => $this->faker->address,
            'profile_image' => $this->faker->randomElement(['service_provider_images/provider1.jpg', 'service_provider_images/provider2.jpg', 'service_provider_images/provider3.webp']),
            'documents' => json_encode(['document1.pdf']),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
