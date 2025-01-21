<?php

namespace Database\Factories;

use App\Models\Amenity;
use Illuminate\Database\Eloquent\Factories\Factory;

class AmenityFactory extends Factory
{
    protected $model = Amenity::class;

    public function definition()
    {
        $urls = [
            'amenity_images/play_area.jpg',
            'amenity_images/restaurant.jpg',
            'amenity_images/swiming_pool.jpg',
            'amenity_images/business.jpg',
        ];

        // Full base URL including /public/ path
        $baseUrl = env('APP_URL') . '/public/storage/';

        return [
            'title' => $this->faker->word,
            // Create full URL for the main amenity image with /storage/
            'amenity_image' => $baseUrl . $this->faker->randomElement($urls),
            // Create full URLs for the array of amenity images with /storage/
            'amenity_images' => json_encode(array_map(fn($url) => $baseUrl . $url, $this->faker->randomElements($urls, 3))),
            'status' => 'active',
        ];
    }
}
