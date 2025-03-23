<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function parent()
    {
        return $this->belongsTo(AboutCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(AboutCategory::class, 'parent_id');
    }

    public function abouts()
    {
        return $this->hasMany(About::class);
    }
} 