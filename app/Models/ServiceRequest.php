<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'service_id',
        'provider_id',
        'request_status',
        'status',
    ];
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function provider()
    {
        return $this->belongsTo(ServiceProvider::class, 'provider_id');
    }
}
