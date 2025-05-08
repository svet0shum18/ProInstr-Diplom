<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'full_name',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function getCartCountAttribute()
    {
        return $this->cartItems()->sum('quantity');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count(); // Получаем количество избранных товаров
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }


    public function lastDelivery()
    {
        return $this->hasOne(Delivery::class)->latestOfMany();
    }


    public function orders()
{
    return $this->hasMany(Order::class);
}


}
