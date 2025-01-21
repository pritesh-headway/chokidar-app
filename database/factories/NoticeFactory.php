<?php

namespace Database\Factories;

use App\Models\Notice;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticeFactory extends Factory
{
    protected $model = Notice::class;

    public function definition()
    {
        // Define the available documents
        $availableDocuments = [
            'notice1.jpg',
            'notice2.jpg',
            'notice3.webp',
        ];

        // Randomly select between 1 and 3 documents
        $documents = $this->faker->randomElements($availableDocuments, rand(1, 3));

        return [
            'notice_title' => $this->faker->sentence(),
            'notice_desc' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'status' => $this->faker->randomElement(['active', 'deactive']),
            // Generate document URLs based on the selected files
            'documents' => json_encode(array_map(function ($document) {
                return env('APP_URL') . '/public/storage/notice_documents/' . $document;  // Create full URL
            }, $documents)),
        ];
    }
}
