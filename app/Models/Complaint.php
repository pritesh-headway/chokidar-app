<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'block_number',
        'complaint_by',
        'complaint_title',
        'user_id',
        'complaint_desc',
        'date',
        'complaint_status',
        'photos',
        'status',
        'image',
        'reason',
    ];
    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }
}
