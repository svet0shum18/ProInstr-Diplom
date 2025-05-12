<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'image'
    ];


    /**
     * Связь с категорией
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь с товарами
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * URL изображения типа инструмента
     */
    // public function getImageUrlAttribute()
    // {
    //     return asset('assets/img/toolType/' . $this->image);
    // }

    public function getUrlAttribute()
{
    return \Str::slug($this->name);
}
}