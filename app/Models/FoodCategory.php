<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FoodCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function foods()
    {
        return $this->hasMany(Food::class);
    }
} 