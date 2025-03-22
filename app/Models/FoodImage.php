<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class FoodImage extends Model
{
    use HasFactory;

    protected $table = 'food_images';

    protected $fillable = [
        'food_id',
        'image',
        'sort',
    ];

    protected $casts = [
        'sort' => 'integer',
    ];

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($foodImage) {
            if ($foodImage->image) {
                Storage::disk('public')->delete($foodImage->image);
            }
        });
    }
} 