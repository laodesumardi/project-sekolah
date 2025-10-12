<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Process and optimize uploaded image
     */
    public function processImage(UploadedFile $file, string $directory = 'images', array $sizes = null): array
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;
        
        // Default sizes if not provided
        if (!$sizes) {
            $sizes = [
                'thumbnail' => [300, 300],
                'medium' => [800, 600],
                'large' => [1200, 900]
            ];
        }

        $processedImages = [];

        // Process original image
        $image = $this->manager->read($file->getPathname());
        
        // Save original
        $originalPath = $directory . '/original/' . $filename;
        Storage::disk('public')->put($originalPath, $image->encode());
        $processedImages['original'] = $originalPath;

        // Create different sizes
        foreach ($sizes as $sizeName => $dimensions) {
            $resizedImage = clone $image;
            $resizedImage->resize($dimensions[0], $dimensions[1], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $sizePath = $directory . '/' . $sizeName . '/' . $filename;
            Storage::disk('public')->put($sizePath, $resizedImage->encode(quality: 85));
            $processedImages[$sizeName] = $sizePath;
        }

        return $processedImages;
    }

    /**
     * Process multiple images
     */
    public function processMultipleImages(array $files, string $directory = 'images', array $sizes = null): array
    {
        $processedImages = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $processedImages[] = $this->processImage($file, $directory, $sizes);
            }
        }

        return $processedImages;
    }

    /**
     * Create thumbnail from image
     */
    public function createThumbnail(string $imagePath, int $width = 300, int $height = 300): string
    {
        $image = $this->manager->read(Storage::disk('public')->path($imagePath));
        
        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $thumbnailPath = dirname($imagePath) . '/thumbnails/' . basename($imagePath);
        Storage::disk('public')->put($thumbnailPath, $image->encode(quality: 80));

        return $thumbnailPath;
    }

    /**
     * Resize image to specific dimensions
     */
    public function resizeImage(string $imagePath, int $width, int $height, bool $maintainAspectRatio = true): string
    {
        $image = $this->manager->read(Storage::disk('public')->path($imagePath));
        
        if ($maintainAspectRatio) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        } else {
            $image->resize($width, $height);
        }

        $resizedPath = dirname($imagePath) . '/resized/' . basename($imagePath);
        Storage::disk('public')->put($resizedPath, $image->encode(quality: 85));

        return $resizedPath;
    }

    /**
     * Compress image
     */
    public function compressImage(string $imagePath, int $quality = 80): string
    {
        $image = $this->manager->read(Storage::disk('public')->path($imagePath));
        
        $compressedPath = dirname($imagePath) . '/compressed/' . basename($imagePath);
        Storage::disk('public')->put($compressedPath, $image->encode(quality: $quality));

        return $compressedPath;
    }

    /**
     * Convert image to WebP format
     */
    public function convertToWebP(string $imagePath): string
    {
        $image = $this->manager->read(Storage::disk('public')->path($imagePath));
        
        $webpPath = dirname($imagePath) . '/webp/' . pathinfo($imagePath, PATHINFO_FILENAME) . '.webp';
        Storage::disk('public')->put($webpPath, $image->toWebp(quality: 85));

        return $webpPath;
    }

    /**
     * Add watermark to image
     */
    public function addWatermark(string $imagePath, string $watermarkPath, string $position = 'bottom-right'): string
    {
        $image = $this->manager->read(Storage::disk('public')->path($imagePath));
        $watermark = $this->manager->read(Storage::disk('public')->path($watermarkPath));
        
        // Resize watermark to 10% of image size
        $watermark->resize($image->width() * 0.1, $image->height() * 0.1, function ($constraint) {
            $constraint->aspectRatio();
        });

        // Position watermark
        switch ($position) {
            case 'top-left':
                $image->place($watermark, 'top-left', 10, 10);
                break;
            case 'top-right':
                $image->place($watermark, 'top-right', 10, 10);
                break;
            case 'bottom-left':
                $image->place($watermark, 'bottom-left', 10, 10);
                break;
            case 'bottom-right':
            default:
                $image->place($watermark, 'bottom-right', 10, 10);
                break;
        }

        $watermarkedPath = dirname($imagePath) . '/watermarked/' . basename($imagePath);
        Storage::disk('public')->put($watermarkedPath, $image->encode());

        return $watermarkedPath;
    }

    /**
     * Delete image and all its variants
     */
    public function deleteImage(string $imagePath): bool
    {
        $basePath = pathinfo($imagePath, PATHINFO_DIRNAME);
        $filename = pathinfo($imagePath, PATHINFO_FILENAME);
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);

        $variants = [
            $imagePath, // original
            $basePath . '/thumbnails/' . $filename . '.' . $extension,
            $basePath . '/medium/' . $filename . '.' . $extension,
            $basePath . '/large/' . $filename . '.' . $extension,
            $basePath . '/webp/' . $filename . '.webp',
            $basePath . '/compressed/' . $filename . '.' . $extension,
            $basePath . '/watermarked/' . $filename . '.' . $extension,
        ];

        $deleted = true;
        foreach ($variants as $variant) {
            if (Storage::disk('public')->exists($variant)) {
                $deleted = $deleted && Storage::disk('public')->delete($variant);
            }
        }

        return $deleted;
    }

    /**
     * Get image URL with size
     */
    public function getImageUrl(string $imagePath, string $size = 'original'): string
    {
        if ($size === 'original') {
            return Storage::disk('public')->url($imagePath);
        }

        $basePath = pathinfo($imagePath, PATHINFO_DIRNAME);
        $filename = basename($imagePath);
        $sizedPath = $basePath . '/' . $size . '/' . $filename;

        if (Storage::disk('public')->exists($sizedPath)) {
            return Storage::disk('public')->url($sizedPath);
        }

        return Storage::disk('public')->url($imagePath);
    }

    /**
     * Get responsive image URLs
     */
    public function getResponsiveImageUrls(string $imagePath): array
    {
        $basePath = pathinfo($imagePath, PATHINFO_DIRNAME);
        $filename = basename($imagePath);

        return [
            'thumbnail' => $this->getImageUrl($imagePath, 'thumbnail'),
            'medium' => $this->getImageUrl($imagePath, 'medium'),
            'large' => $this->getImageUrl($imagePath, 'large'),
            'original' => $this->getImageUrl($imagePath, 'original'),
        ];
    }
}

