<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = \App\Models\Vehicle::class;

    public function definition()
    {
        // return [
        //     'block_number' => $this->faker->word(),  // Random block number
        //     'vehicle_number' => $this->faker->unique()->word(),  // Random vehicle number
        //     'vehicle_type' => $this->faker->randomElement(['2-wheeler', '4-wheeler']),  // Random vehicle type
        //     'user_id' => User::inRandomOrder()->first()->id,  // Randomly select an existing user
        //     'vehicle_image' => $this->faker->imageUrl(256, 256),  // Random vehicle image URL
        //     'status' => $this->faker->randomElement(['active', 'deactive']),  // Random status
        // ];

        // Randomly select a user from the users table
        // $user = User::inRandomOrder()->first();  // Get a random user
        $user = User::whereIn('role_id', [3, 4])  // Select users whose role_id is 3 or 4
            ->inRandomOrder()
            ->first();  // Get a random user from the filtered list


        return [
            'block_number' => $user ? $user->block_number : 'Unknown',  // Use the user's block_number
            'vehicle_number' => strtoupper($this->faker->regexify('GJ01[A-Z]{2}[0-9]{4}')),  // Vehicle number with the format GJ01AB9999
            'vehicle_type' => $this->faker->randomElement(['2-wheeler', '4-wheeler']),  // Randomly assign vehicle type
            'user_id' => $user->id,  // Set the user_id to the randomly selected user's ID
            // 'vehicle_image' => $this->faker->imageUrl(256, 256),  // Random image URL
            'status' => $this->faker->randomElement(['active', 'deactive']),  // Random status
        ];
    }

    // /**
    //  * Set the user ID and block number for the vehicle.
    //  *
    //  * @param  int  $userId
    //  * @return \Illuminate\Database\Eloquent\Factories\Factory
    //  */
    // public function forUser(int $userId)
    // {
    //     $user = User::find($userId);  // Get the user by user_id

    //     return $this->state(function (array $attributes) use ($user) {
    //         return [
    //             'user_id' => $user->id,
    //             'block_number' => $user->block_number,  // Set block_number to the user's block_number
    //         ];
    //     });
    // }
}
