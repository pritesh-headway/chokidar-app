<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
