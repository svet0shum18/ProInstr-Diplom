<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    protected $fillable = [
        'user_id',
        'city',
        'street',
        'house',
        'apartment',
        'full_name',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}