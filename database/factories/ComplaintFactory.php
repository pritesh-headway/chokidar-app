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

        // Generate a date in the format 'dd-mm-yyyy' and then convert it to 'Y-m-d'
        $date = $this->faker->date('d-m-Y');
        $formattedDate = \DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');

        return [
            'block_number' => $user->block_number,
            'complaint_by' => $user->first_name . ' ' . $user->last_name,
            'complaint_title' => $this->faker->sentence,
            'user_id' => $user->id,
            'complaint_desc' => $this->faker->paragraph,
            'date' => $formattedDate, // Store the date in 'Y-m-d' format
            'complaint_status' => 'pending',
            'photos' => json_encode($randomImages),  // Store the array of random images as JSON
            'image' => $randomImage,  // Store the image path
            'status' => 'active',
        ];
    }
}
