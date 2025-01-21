<?php

namespace Database\Factories;

use App\Models\BookingAmenity;
use App\Models\User;
use App\Models\Amenity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class BookingAmenityFactory extends Factory
{
    protected $model = BookingAmenity::class;

    public function definition()
    {
        $start_date = $this->faker->dateTimeBetween('+1 days', '+2 days'); // New date for the booking
        $end_time = Carbon::parse($start_date)->addHours(2); // 2 hours later for the end time

        $user = User::inRandomOrder()->first(); // Pick a random user
        $amenity = Amenity::inRandomOrder()->first(); // Pick a random amenity

        // Extract date and time components
        $date = $start_date->format('Y-m-d'); // Use only date for 'from'
        $start_time = $start_date->format('H:i:s'); // Start time (from)
        $end_time = $end_time->format('H:i:s'); // End time (to)

        // Create the 'day' column value as the date (same as from date)
        $day = $start_date->format('Y-m-d');

        return [
            'block_name' => $user->block_number,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'from' => $start_time,  // Renamed from 'start_date' to 'from' and storing only time
            'to' => $end_time,      // Renamed from 'end_date' to 'to' and storing only time
            'day' => $day,          // New column 'day' to store the date
            'amenity_id' => $amenity->id,
            'user_id' => $user->id,
            'mobile' => $user->mobile,
            'booking_status' => 'Pending',
            'status' => 'active',
        ];
    }
}
