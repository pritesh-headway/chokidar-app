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
        $imageFiles = [
            'complaint_images/apartment-building-leak.jpg',
            'complaint_images/a-pipe-leak.jpeg',
            'complaint_images/paint.webp',
            'complaint_images/water.webp'
        ];
        $randomImage = $this->faker->randomElement($imageFiles);
        $randomImages = $this->faker->randomElements($imageFiles, $count = rand(2, 3));
        $date = $this->faker->date('d-m-Y');
        $formattedDate = \DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');

        return [
            'block_number' => $user->block_number,
            'complaint_by' => $user->first_name . ' ' . $user->last_name,
            'complaint_title' => $this->faker->sentence,
            'user_id' => $user->id,
            'complaint_desc' => $this->faker->paragraph,
            'date' => $formattedDate,
            'complaint_status' => 'pending',
            'photos' => json_encode($randomImages),
            'image' => $randomImage,
            'status' => 'active',
        ];
    }
}
