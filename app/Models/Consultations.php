<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultations extends Model
{
    use HasFactory;

    protected $table = 'consultations';

    protected $fillable = [
        'customer_id',
        'subject',
        'product_group',
        'category',
        // 'device_type',
        'brand_model',
        // 'serial_number',
        'description',
        'status',
        'notes', 
        'cs_id'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function messages()
{
    return $this->hasMany(Message::class, 'consultation_id');
}

}