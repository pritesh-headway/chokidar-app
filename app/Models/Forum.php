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
    public function updateResponseCount()
    {

        $responseCount = $this->responses()->count();
        $this->update(['responses' => $responseCount]);
    }
    public function responses()
    {
        return $this->hasMany(Response::class, 'forum_id');
    }
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
            $forum->responses()->delete();
        });
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
