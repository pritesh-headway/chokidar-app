<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMemberDetail extends Model
{
    use HasFactory;

    protected $fillable = ['block_number', 'member_name', 'user_id', 'mobile', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
