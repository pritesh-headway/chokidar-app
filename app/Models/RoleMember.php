<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'role_name',
        'user_id',
        'profile_image',
        'mobile',
        'block_number',
        'first_name',
        'last_name',
        'status',
    ];

    // Define relationships
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
