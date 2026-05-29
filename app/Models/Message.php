<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'user_id', 
        'sender_type',
        'body',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultations::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
