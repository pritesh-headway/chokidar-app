<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingAmenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'block_name',
        'first_name',
        'last_name',
        'from',
        'to',
        'day',
        'amenity_id',
        'user_id',
        'mobile',
        'booking_status',
        'status',
    ];

    protected $dates = ['day'];
    protected $casts = [
        'from' => 'datetime:H:i:s',
        'to' => 'datetime:H:i:s',
    ];

    public function amenity()
    {
        return $this->belongsTo(Amenity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
