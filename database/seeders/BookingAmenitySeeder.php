<?php

namespace Database\Seeders;

use App\Models\BookingAmenity;
use Illuminate\Database\Seeder;

class BookingAmenitySeeder extends Seeder
{
    public function run()
    {
        BookingAmenity::factory()->count(10)->create(); // Creating 10 booking entries
        // BookingAmenity::truncate();
    }
}
