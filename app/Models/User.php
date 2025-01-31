<?php

namespace App\Models;

use App\Models\Vehicle;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject; // Import the JWTSubject interface
use Illuminate\Foundation\Auth\User as Authenticatable; // Import Authenticatable

class User extends Authenticatable implements JWTSubject // Implement JWTSubject
{
    use HasFactory;
    // use HasRoles;

    protected $guard_name = 'api';

    protected $table = 'users'; // Specify the table associated with the model

    protected $fillable = [
        'block_number',
        'first_name',
        'last_name',
        'role_id',
        'mobile',
        'block',
        'profile_photo',
        'status',
        'email', // Add email here
        'password', // Add password here
        'otp',
        'society_id',
        'deleted_at',
    ];

    protected $casts = [
        // Cast mobile to string to preserve leading zeros
        'mobile' => 'string',
        // Cast status to string (optional)
        'status' => 'string',
    ];

    // Define the many-to-many relationship with roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    // Check if the user has a specific role
    public function hasRole($role)
    {
        return $this->roles()->where('role', $role)->exists();
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
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

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; // Return any custom claims if needed (empty for now)
    }

    // Relationship with ServiceRequest
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'member_id');
    }

    // Relationships
    public function sentConversations()
    {
        return $this->hasMany(Conversation::class, 'sender_id');
    }

    public function receivedConversations()
    {
        return $this->hasMany(Conversation::class, 'receiver_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function hello()
    {
        return "hello";
    }

    // Define the relationship: A user belongs to a society
    public function society()
    {
        return $this->belongsTo(Society::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}