<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'duration', 'status'];

    public function societySubscriptions()
    {
        return $this->hasMany(SocietySubscription::class, 'plan_id');
    }
}
