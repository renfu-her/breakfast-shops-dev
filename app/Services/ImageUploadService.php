<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ImageUploadService
{
    protected $disk;
    protected $basePath;
    protected $directory;
    protected $sizes;

    public function __construct(string $disk = 'public', string $basePath = 'images', string $directory = '')
    {
        $this->disk = $disk;
        $this->basePath = $basePath;
        $this->directory = $directory;
        $this->sizes = [
            'original' => null,
            'large' => 1200,
            'medium' => 800,
            'small' => 400,
        ];
    }

    public function setDirectory(string $directory): self
    {
        $this->directory = $directory;
        return $this;
    }

    protected function getPath(string $path = ''): string
    {
        return trim($this->basePath . '/' . $this->directory . '/' . $path, '/');
    }

    protected function generateFilename(): string
    {
        return Str::uuid7() . '.webp';
    }

    public function upload(UploadedFile $file, ?string $filename = null): array
    {
        $filename = $filename ?? $this->generateFilename();
        $originalPath = $this->getPath('original/' . $filename);
        $webpPath = $this->getPath($filename);

        // 儲存原始圖片
        $originalImage = Image::make($file);
        Storage::disk($this->disk)->put($originalPath, $originalImage->encode());

        // 轉換為 WebP 並調整大小
        $webpImage = Image::make($file);
        $webpImage->encode('webp', 90);

        // 儲存 WebP 版本
        Storage::disk($this->disk)->put($webpPath, $webpImage->encode());

        // 生成不同尺寸的圖片
        $sizes = [];
        foreach ($this->sizes as $size => $width) {
            if ($width) {
                $resizedImage = Image::make($file)
                    ->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('webp', 90);

                $sizePath = $this->getPath($size . '/' . $filename);
                Storage::disk($this->disk)->put($sizePath, $resizedImage->encode());
                $sizes[$size] = Storage::disk($this->disk)->url($sizePath);
            }
        }

        return [
            'original' => Storage::disk($this->disk)->url($originalPath),
            'webp' => Storage::disk($this->disk)->url($webpPath),
            'sizes' => $sizes,
        ];
    }

    public function delete(string $filename): void
    {
        // 刪除原始圖片
        Storage::disk($this->disk)->delete($this->getPath('original/' . $filename));
        
        // 刪除 WebP 版本
        Storage::disk($this->disk)->delete($this->getPath($filename));
        
        // 刪除所有尺寸的圖片
        foreach ($this->sizes as $size => $width) {
            if ($width) {
                Storage::disk($this->disk)->delete($this->getPath($size . '/' . $filename));
            }
        }
    }
} 