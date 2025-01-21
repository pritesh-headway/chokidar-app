<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'block_number',
        'visitor_name',
        'mobile',
        'date',
        'reason',
        'visitor_status',
        'prof_image',
        'user_id',
        'status',
    ];

    // A visitor belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
