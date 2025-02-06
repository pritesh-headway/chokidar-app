<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_no',
        'block',
        'floor',
        'society_id',
        'user_id',
        'status'
    ];

    // Define the relationship with society
    public function society()
    {
        return $this->belongsTo(Society::class);
    }

    // Define the relationship with user (optional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
