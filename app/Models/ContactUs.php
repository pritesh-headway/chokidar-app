<?php
// app/Models/ContactUs.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'society_name',
        'country',
        'city',
        'full_name',
        'email',
        'phone_number',
        'comments',
    ];
}
