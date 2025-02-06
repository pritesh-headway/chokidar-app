<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $fillable = [
        'block_number',
        'vehicle_number',
        'vehicle_type',
        'user_id',
        // 'vehicle_image',
        'status',
        'vehicle_brand',
        'vehicle_model',
    ];

    /**
     * Get the user that owns the vehicle.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
