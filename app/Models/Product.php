<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Указываем, что данные в этих полях могут быть заполнены массово
    protected $fillable = [
        'name',          // Название товара
        'description',   // Описание товара
        'price',         // Цена товара
        'image',         // Имя изображения товара
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
        return asset('assets/img/product/' . $this->image);
    }
}
