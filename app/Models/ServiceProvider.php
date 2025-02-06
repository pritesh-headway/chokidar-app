<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'service_id',
        'mobile',
        'address',
        'profile_image',
        'documents',
        'status'
    ];

    protected $casts = [
        'documents' => 'array',
    ];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'provider_id');
    }
}
