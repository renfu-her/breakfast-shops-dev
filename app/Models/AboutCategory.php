<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AboutCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort' => 'integer',
    ];

    public function abouts()
    {
        return $this->hasMany(About::class, 'category_id');
    }
} 