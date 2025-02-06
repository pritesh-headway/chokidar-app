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
            'mobile' => $this->faker->numerify('##########'),
            'address' => $this->faker->address,
            'gate_no' => $this->faker->numberBetween(1, 10),
            'details' => $this->faker->text,
            'guard_image' => 'guard_images/guard.webp',
            'documents' => json_encode(['guard_documents/guard_document1.pdf', 'guard_documents/guard_document2.pdf']),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
