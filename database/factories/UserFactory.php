<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        // $block = strtoupper($this->faker->randomLetter());
        // $house_no = $block . '-' . $this->faker->numberBetween(100, 999);
        $house = DB::table('houses')->inRandomOrder()->first();
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'mobile' => $this->faker->unique(true)->numerify('##########'),
            'profile_photo' => 'profile_photos/avatar.png',
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'otp' => $this->faker->numerify('######'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'society_id' => 5, // Assuming society_id 1 exists for simplicity
            'role_id' => 3, // Assuming role_id 3 exists for simplicity
            'house_id' => $house->id,
            'block'    => $house->block,
            'house_no' => $house->house_no,
        ];
    }
}
