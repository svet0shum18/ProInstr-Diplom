<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    // Указываем, что данные в этих полях могут быть заполнены массово
    protected $fillable = [
        'name',
        'model',
        'image',
        'short_description',
        'full_description',
        'price',
        'power',
        'weight',
        'quantity',
        'tool_type_id',
        'brand_id',
        'category_id'
    ];

    // Для корректной работы с датами в базе данных
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Получить цену товара с учётом формата
     *
     * @return string
     */
    public function getPriceFormattedAttribute()
    {
        return number_format($this->price, 2, ',', ' ') . ' ₽';
    }

    /**
     * Получить полный путь к изображению товара
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return asset('assets/img/products/' . $this->image);
    }

    /**
     * Связь с типом инструмента
     */
    public function toolType()
    {
        return $this->belongsTo(ToolType::class);
    }

    /**
     * Связь с категорией
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь с брендом
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getUrlAttribute()
    {
        return \Str::slug($this->name);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function approvedReviews() {
        return $this->reviews()->where('is_approved', true);
    }
}
