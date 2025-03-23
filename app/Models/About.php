<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'subtitle',
        'content',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'category_name',
        'main_category_name',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AboutCategory::class);
    }

    public function getCategoryNameAttribute(): string
    {
        return $this->category?->name ?? '';
    }

    public function getMainCategoryNameAttribute(): string
    {
        return $this->category?->parent?->name ?? '';
    }
} 