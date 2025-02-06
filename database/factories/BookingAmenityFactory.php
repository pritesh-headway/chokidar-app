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
        $start_date = $this->faker->dateTimeBetween('+1 days', '+2 days');
        $end_time = Carbon::parse($start_date)->addHours(2);

        $user = User::inRandomOrder()->first();
        $amenity = Amenity::inRandomOrder()->first();
        $date = $start_date->format('Y-m-d');
        $start_time = $start_date->format('H:i:s');
        $end_time = $end_time->format('H:i:s');
        $day = $start_date->format('Y-m-d');

        return [
            'block_name' => $user->block_number,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'from' => $start_time,
            'to' => $end_time,
            'day' => $day,
            'amenity_id' => $amenity->id,
            'user_id' => $user->id,
            'mobile' => $user->mobile,
            'booking_status' => 'Pending',
            'status' => 'active',
        ];
    }
}
