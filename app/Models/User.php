<?php

namespace App\Models;

use App\Models\Vehicle;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject, FilamentUser
{
    use HasFactory;
    use Notifiable;
    protected $guard_name = 'api';
    protected $attributes = [
        'first_name' => 'Super',
        'last_name' => 'Admin',
        'mobile' => '8347400096',
        'status' => 'active',

    ];
    protected $table = 'users';

    protected $fillable = [
        'block_number',
        'first_name',
        'last_name',
        'role_id',
        'mobile',
        'block',
        'profile_photo',
        'status',
        'email',
        'password',
        'otp',
        'society_id',
        'deleted_at',
    ];

    protected $casts = [

        'mobile' => 'string',

        'status' => 'string',
    ];
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }
    public function setRole($role)
    {

        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        if ($role instanceof Role) {
            $this->role_id = $role->id;
            $this->save();
        } else {
            throw new \Exception("Role not found or invalid.");
        }
    }
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
        return $this->getKey();
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMemberDetail::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
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
        return [];
    }
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'member_id');
    }
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
    public function society()
    {
        return $this->belongsTo(Society::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Check if the user has access to Filament (Super Admin, Admin, etc.)
     */
    public function canAccessFilament(): bool
    {

        return in_array($this->role_id, [1, 2]);
    }

    /**
     * Implement the method from FilamentUser interface.
     * This checks if the user can access the Filament panel.
     */
    public function canAccessPanel(\Filament\Panel $panel): bool
    {

        return $this->canAccessFilament();
    }
}
