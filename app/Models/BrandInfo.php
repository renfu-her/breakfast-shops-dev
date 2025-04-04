<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrandInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'is_active',
        'sort'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('sort', 'asc');
        });
    }
} 