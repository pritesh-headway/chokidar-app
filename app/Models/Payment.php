<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'society_id',
        'amount',
        'transaction_id',
        'status',
        'payment_date',
    ];

    public function society()
    {
        return $this->belongsTo(Society::class);
    }
}
