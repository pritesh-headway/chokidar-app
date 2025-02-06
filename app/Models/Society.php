<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'society_name',
        'address',
        'city',
        'state',
        'postal_code',
        'contact_number',
        'type',
        'status',
    ];

    // // Define the relationship with the User model
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // Define the relationship: A society can have many users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function houses()
    {
        return $this->hasMany(House::class);
    }
}
