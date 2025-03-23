<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AboutCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'sort',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort' => 'integer',
        'parent_id' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'parent_name',
        'has_children',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(AboutCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(AboutCategory::class, 'parent_id');
    }

    public function abouts(): HasMany
    {
        return $this->hasMany(About::class, 'category_id');
    }

    public function getParentNameAttribute(): string
    {
        return $this->parent?->name ?? '';
    }

    public function getHasChildrenAttribute(): bool
    {
        return $this->children()->count() > 0;
    }

    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('sort', 'asc');
        });
    }
} 