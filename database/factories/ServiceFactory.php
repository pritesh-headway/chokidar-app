<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;
    private static $index = 0;

    public function definition()
    {

        $services = ['Security', 'Cleaner', 'Gardener', 'Electrician', 'Plumber', 'Maid', 'Iron Press', 'Milk man', 'Baby Caretaker'];
        $serviceName = $services[self::$index];
        self::$index = (self::$index + 1) % count($services);

        return [
            'service_name' => $serviceName,
            'service_type' => $this->faker->randomElement(['society', 'owner', 'both']),
            'status' => $this->faker->randomElement(['active', 'deactive']),
            'service_image' => 'service_images/service1.png',
        ];
    }
}
