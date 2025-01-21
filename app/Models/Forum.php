<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Forum extends Model
{
    use HasFactory;
    protected $fillable = [
        'block_number',
        'forum_by',
        'title',
        'description',
        'date',
        'profile_photo',
        'photos',
        'status'
    ];

    // Relationship: A forum has many responses
    public function responses()
    {
        return $this->hasMany(Response::class, 'forum_id');
    }

    // Accessor to get responses count
    public function getResponsesCountAttribute()
    {
        return $this->responses()->count();
    }

    /**
     * Delete the forum and automatically delete associated responses.
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($forum) {
            $forum->responses()->delete();  // Ensures responses are deleted when the forum is deleted
        });
    }
}
