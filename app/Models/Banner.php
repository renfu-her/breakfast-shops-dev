<?php

namespace App\Models;

use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'is_active',
        'sort'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort' => 'integer',
        'image' => 'array',
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::addGlobalScope('order', function ($query) {
    //         $query->orderBy('sort', 'asc');
    //     });

    //     static::deleting(function ($banner) {
    //         if ($banner->image && isset($banner->image['webp'])) {
    //             $filename = basename($banner->image['webp']);
    //             app(ImageUploadService::class)
    //                 ->setDirectory('banners')
    //                 ->delete($filename);
    //         }
    //     });
    // }

    // public function setImageAttribute($value)
    // {
    //     if ($value instanceof \Illuminate\Http\UploadedFile) {
    //         $filename = $value->getClientOriginalName();
    //         $result = app(ImageUploadService::class)
    //             ->setDirectory('banners')
    //             ->upload($value, $filename);
    //         $this->attributes['image'] = $result;
    //     } else {
    //         $this->attributes['image'] = $value;
    //     }
    // }
} 