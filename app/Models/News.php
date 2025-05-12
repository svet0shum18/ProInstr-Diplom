<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    protected $fillable = ['title','img','description','category_id'];

    public function category(): BelongsTo {
        return $this->belongsTo(CategoryNews::class, 'category_id');
    }

      public function getImageUrlAttribute()
    {
        return asset('assets/img/news/' . $this->image);
    }
}
