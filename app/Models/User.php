<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject; // Import the JWTSubject interface
use Illuminate\Foundation\Auth\User as Authenticatable; // Import Authenticatable

class User extends Authenticatable implements JWTSubject // Implement JWTSubject
{
    use HasFactory;


    protected $table = 'users'; // Specify the table associated with the model

    protected $fillable = [
        'block_number',
        'first_name',
        'last_name',
        'role',
        'mobile',
        'block',
        'profile_photo',
        'status',
        'email', // Add email here
        'password', // Add password here
        'otp',
    ];

    protected $casts = [
        // Cast mobile to string to preserve leading zeros
        'mobile' => 'string',
        // Cast status to string (optional)
        'status' => 'string',
    ];
    // Implement the two required methods from JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Return the primary key of the user
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMemberDetail::class); // Correct relationship
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class); // Correct relationship
    }
    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }


    public function getJWTCustomClaims()
    {
        return []; // Return any custom claims if needed (empty for now)
    }
}
