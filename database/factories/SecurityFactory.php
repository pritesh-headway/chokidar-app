<?php

namespace Database\Factories;

use App\Models\Security;
use Illuminate\Database\Eloquent\Factories\Factory;

class SecurityFactory extends Factory
{
    protected $model = Security::class;

    public function definition()
    {
        return [
            'guard_name' => $this->faker->name,
            'mobile' => $this->faker->numerify('##########'),  // Generate a 10-digit numeric value
            'address' => $this->faker->address,
            'gate_no' => $this->faker->numberBetween(1, 20),  // Gate number between 1 and 20
            'details' => $this->faker->text,
            'guard_image' => 'guard_images/guard.webp',  // Set a fixed image path
            'documents' => json_encode(['guard_documents/guard_document1.pdf']),  // Set a fixed document path
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
