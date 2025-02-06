<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notice extends Model
{
    use HasFactory;
    protected $table = 'notices';
    protected $fillable = [
        'notice_title',
        'notice_desc',
        'date',
        'time',
        'status',
        'society_id',
        'documents'
    ];
    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
