<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenance';
    protected $fillable = [
        'block_number',
        'owner_name',
        'maintenance_status',
        'block',
        'photo',
        'user_id',
        'amount',
        'date',
        'description',
        'status'
    ];
    protected $casts = [
        'date' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
