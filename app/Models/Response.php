<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_id',
        'user_id',
        'status',
    ];

    protected static function booted()
    {
        static::created(function ($response) {

            $response->forum->updateResponseCount();
        });

        static::deleted(function ($response) {

            $response->forum->updateResponseCount();
        });
    }
    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
