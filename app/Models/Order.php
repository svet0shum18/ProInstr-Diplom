<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    protected $fillable = ['user_id', 'type', 'total', 'status', 'delivery_date'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDeliveryTypeAttribute()
{
    return [
        'pickup' => 'Самовывоз',
        'courier' => 'Курьерская доставка'
      
    ][$this->type] ?? $this->type;
}
}
