<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocietySubscription extends Model
{
    use HasFactory;

    protected $fillable = ['society_id', 'plan_id', 'start_date', 'end_date', 'status'];

    public function society()
    {
        return $this->belongsTo(Society::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
