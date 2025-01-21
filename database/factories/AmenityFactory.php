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
            url('public/storage/amenity_images/play_area.jpg'),
            url('public/storage/amenity_images/restaurant.jpg'),
            url('public/storage/amenity_images/swiming_pool.jpg'),
            url('public/storage/amenity_images/business.jpg'),
        ];

        return [
            'title' => $this->faker->word,
            'amenity_image' => $this->faker->randomElement($urls),
            'amenity_images' => json_encode($this->faker->randomElements($urls, 3)),
            'status' => 'active',
        ];
    }
}
