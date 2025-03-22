<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'is_active',
        'food_category_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(FoodCategory::class, 'food_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(FoodImage::class)->orderBy('sort');
    }
} 