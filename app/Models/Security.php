<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    use HasFactory;

    protected $fillable = [
        'guard_name',
        'mobile',
        'address',
        'gate_no',
        'details',
        'guard_image',
        'documents',
        'status',
        'society_id',
        'user_id'
    ];

    public function gateDetails()
    {
        return $this->hasMany(GateDetail::class, 'security_id');
    }

    public function security()
    {
        return $this->hasOne(Security::class, 'user_id');
    }
}
