<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    protected $appends = [
        'image_url'
    ];

    /**
     * Связь с типами инструментов
     */
    public function toolTypes()
    {
        return $this->hasMany(ToolType::class);
    }

    /**
     * Связь с товарами (если прямая связь нужна)
     */
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ToolType::class,
            'category_id',
            'tool_type_id'
        );
    }

    /**
     * URL изображения категории
     */
    public function getImageUrlAttribute()
    {
        return asset('assets/img/categories/' . $this->image);
    }

    public function getUrlAttribute()
{
    return \Str::slug($this->name);
}
}
