<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    
    // 🧩 Kolom yang bisa diisi
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'branch_id',
        'profile_photo'
    ];

    // 🧩 Agar password otomatis di-hash saat diset
    public function setPwAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // 🧩 Override default Laravel auth fields (opsional)
    public function getAuthPassword()
    {
        return $this->pw;
    }
    public function branch()
{
    return $this->belongsTo(Branches::class);
}

}