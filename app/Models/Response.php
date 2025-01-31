<?php
// app/Models/Response.php
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
            // When a new response is added, update the response count in the corresponding forum
            $response->forum->updateResponseCount();
        });

        static::deleted(function ($response) {
            // When a response is deleted, update the response count in the corresponding forum
            $response->forum->updateResponseCount();
        });
    }

    // Relationship with Forum model
    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}