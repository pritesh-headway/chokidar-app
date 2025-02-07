<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_no',
        'block',
        'floor',
        'society_id',
        'user_id',
        'status',
    ];

    public function society()
    {
        return $this->belongsTo(Society::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'house_id');
    }

    protected static function booted()
    {
        static::saved(function ($house) {
            if ($house->user_id && $house->user) {
                $house->syncUser();
            }
        });

        static::deleted(function ($house) {
            if ($house->user_id && $house->user) {
                $house->syncUser(true);
            }
        });
    }

    /**
     * Synchronize associated user.
     *
     * @param bool $reset If true, resets the house details on the user.
     */
    public function syncUser(bool $reset = false): void
    {
        $user = $this->user;
        $user->house_no = $reset ? null : $this->house_no;
        $user->block = $reset ? null : $this->block;
        $user->save();
    }
}
