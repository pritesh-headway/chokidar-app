<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notice extends Model
{
    use HasFactory;

    // Define the table name (optional if it follows convention)
    protected $table = 'notices';

    // Define the fillable fields to prevent mass assignment
    protected $fillable = [
        'notice_title',
        'notice_desc',
        'date',
        'time',
        'status'
    ];

    // Accessor for the 'date' field to return it in d-m-Y format
    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
