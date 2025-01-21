<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Amenity::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Amenity::factory()->count(10)->create();
        // Amenity::truncate();
        // $urls = [
        //     url('public/storage/amenity_images/play_area.jpg'),
        //     url('public/storage/amenity_images/restaurant.jpg'),
        //     url('public/storage/amenity_images/swiming_pool.jpg'),
        //     url('public/storage/amenity_images/business.jpg'),
        // ];

        // Amenity::create([
        //     'title' => 'Sample Amenity',
        //     'amenity_image' => $urls[0], // Use the first image as the main image
        //     'amenity_images' => json_encode($urls), // Store all URLs as a JSON string
        //     'status' => 'active',
        // ]);
    }
}
