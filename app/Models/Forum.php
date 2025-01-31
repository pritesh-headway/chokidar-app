<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'block_number',
        'user_id',
        'forum_by',
        'title',
        'description',
        'date',
        'profile_photo',
        'responses',
        'photos',
        'status',
    ];

    // Method to update the number of responses
    public function updateResponseCount()
    {
        // Count the number of responses for the current forum
        $responseCount = $this->responses()->count();

        // Update the forum's response count
        $this->update(['responses' => $responseCount]);
    }

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

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}