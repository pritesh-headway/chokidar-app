<?php


namespace Database\Factories;

use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceRequestFactory extends Factory
{
    protected $model = ServiceRequest::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $service = Service::inRandomOrder()->first();
        $provider = ServiceProvider::inRandomOrder()->first();
        return [
            'member_id' => $user->id,
            'service_id' => $service->id,
            'provider_id' => $provider->id,
            'request_status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
