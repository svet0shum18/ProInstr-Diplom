<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

      protected $fillable = [
        'product_id',
        'user_id', // Добавляем это поле
        'rating',
        'comment',
        'photos',
        'is_approved'
    ];
    protected $casts = [

        'photos' => 'array',
        'is_approved' => 'boolean'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
