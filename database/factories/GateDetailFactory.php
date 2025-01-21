<?php
namespace Database\Factories;

use App\Models\GateDetail;
use App\Models\Security;
use Illuminate\Database\Eloquent\Factories\Factory;

class GateDetailFactory extends Factory
{
protected $model = GateDetail::class;

public function definition()
{
// Fetch a random security guard from the securities table
$security = Security::inRandomOrder()->first();

return [
'gate_no' => $this->faker->unique()->numberBetween(1, 100), // Random gate number
'security_id' => $security->id, // Use the random security ID
'gate_mobile' => $this->faker->phoneNumber, // Mobile number for the gate
'status' => $this->faker->randomElement(['active', 'deactive']),
];
}
}