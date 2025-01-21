<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAmenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'block_name',
        'first_name',
        'last_name',
        'from',           // Renamed from 'start_date' to 'from'
        'to',             // Renamed from 'end_date' to 'to'
        'day',            // New column 'day'
        'amenity_id',
        'user_id',
        'mobile',
        'booking_status',
        'status',
    ];

    protected $dates = ['day'];  // Ensure 'day' is treated as a date without time

    // Optional: Cast the 'from' and 'to' as time (if you need them to be treated as time)
    protected $casts = [
        'from' => 'datetime:H:i:s', // Treat as time
        'to' => 'datetime:H:i:s',   // Treat as time
    ];

    public function amenity()
    {
        return $this->belongsTo(Amenity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
