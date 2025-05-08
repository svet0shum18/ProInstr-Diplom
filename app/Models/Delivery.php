<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'city',
        'street',
        'house',
        'apartment',
        'full_name',
        'phone',
        'delivery_date',
        'time_interval',
        'comment',
        'is_saved' // флаг сохранения для будущих заказов
    ];

    protected $dates = ['delivery_date'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
