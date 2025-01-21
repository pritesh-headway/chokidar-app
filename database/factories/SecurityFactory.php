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
            'gate_no' => $this->faker->randomNumber(),
            'details' => $this->faker->text,
            'guard_image' => $this->faker->imageUrl(),
            'documents' => json_encode([$this->faker->filePath()]),  // Storing file paths as a JSON array
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
