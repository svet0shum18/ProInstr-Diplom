<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'country',
    ];


    /**
     * Связь с товарами
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Полный URL логотипа
     */
    public function getLogoUrlAttribute()
    {
        return asset('assets/img/brands/' . $this->image);
    }

}
