<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GateDetail extends Model
{
    use HasFactory;

    protected $fillable = ['gate_no', 'security_id', 'gate_mobile', 'status', 'society_id'];
    public function security()
    {
        return $this->belongsTo(Security::class, 'security_id');
    }
}
