<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    // Add a static property to keep track of the current index
    private static $index = 0;

    public function definition()
    {
        // List of unique services
        $services = ['Security', 'Cleaner', 'Gardener', 'Electrician', 'Plumber', 'Maid', 'Iron Press', 'Milk man', 'Baby Caretaker'];

        // Access the service by index
        $serviceName = $services[self::$index];

        // Increment the index after each use
        self::$index = (self::$index + 1) % count($services);  // Loop back to 0 after reaching the end of the array

        return [
            'service_name' => $serviceName,
            'service_type' => $this->faker->randomElement(['society', 'owner', 'both']),
            'status' => $this->faker->randomElement(['active', 'deactive']),
            'service_image' => 'service_images/service1.png',
        ];
    }
}
