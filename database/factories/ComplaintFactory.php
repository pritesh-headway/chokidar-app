<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplaintFactory extends Factory
{
    protected $model = Complaint::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();

        // List of four images stored in the 'public/storage/complaint_images' folder
        $imageFiles = [
            'complaint_images/apartment-building-leak.jpg',
            'complaint_images/a-pipe-leak.jpeg',
            'complaint_images/paint.webp',
            'complaint_images/water.webp'
        ];
        $randomImage = $this->faker->randomElement($imageFiles);
        $randomImages = $this->faker->randomElements($imageFiles, $count = rand(2, 3)); // 2 or 3 images

        return [
            'block_number' => $user->block_number,
            'complaint_by' => $user->first_name . ' ' . $user->last_name,
            'complaint_title' => $this->faker->sentence,
            'user_id' => $user->id,
            'complaint_desc' => $this->faker->paragraph,
            'date' => $this->faker->date,
            'complaint_status' => 'pending',
            // 'photos' => $this->faker->text,
            'photos' => json_encode($randomImages),  // Store the array of random images as JSON
            // 'image' => $this->faker->randomElement($imageFiles),  // Randomly select an image
            'image' => $randomImage,  // Store the image path
            'status' => 'active',
        ];
    }
}
