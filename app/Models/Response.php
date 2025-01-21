<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Response extends Model
{

    use HasFactory;
    protected $fillable = ['forum_id', 'user_name', 'comment'];

    // Inverse of the relation, a response belongs to a forum
    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }
}
