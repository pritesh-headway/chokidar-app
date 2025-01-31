<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $table = 'designations'; // This tells Laravel to use the designations table

    protected $fillable = [
        'role_name', // you might want to rename 'role_name' to something like 'designation_name' if needed
        'status',
        'society_id',
    ];
}
