<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'service_type',
        'status',
        'service_image',
    ];

    // Define the relationship with ServiceProvider
    public function serviceProviders()
    {
        return $this->hasMany(ServiceProvider::class);
    }
}
