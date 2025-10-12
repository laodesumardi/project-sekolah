<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'thumbnail',
        'alt_text',
        'category',
        'sort_order',
        'is_active',
        'file_size',
        'dimensions',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include active galleries.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            $imagePath = storage_path('app/public/gallery/' . $this->image);
            if (file_exists($imagePath)) {
                $url = asset('storage/gallery/' . $this->image);
                \Log::info("Gallery image URL generated: {$url}");
                return $url;
            } else {
                \Log::warning("Gallery image file not found: {$imagePath}");
            }
        }
        
        \Log::warning("Gallery has no image field or image is null");
        // Return a simple placeholder if no image
        return 'data:image/svg+xml;base64,' . base64_encode('<svg width="400" height="300" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="300" fill="#F3F4F6"/><rect x="50" y="50" width="300" height="200" fill="#9CA3AF"/><rect x="100" y="100" width="200" height="100" fill="#E5E7EB"/><text x="200" y="150" text-anchor="middle" fill="#6B7280" font-family="Arial" font-size="16">Gallery Image</text></svg>');
    }

    /**
     * Get the thumbnail URL.
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            $thumbnailPath = storage_path('app/public/gallery/thumbnails/' . $this->thumbnail);
            if (file_exists($thumbnailPath)) {
                $url = asset('storage/gallery/thumbnails/' . $this->thumbnail);
                \Log::info("Gallery thumbnail URL generated: {$url}");
                return $url;
            } else {
                \Log::warning("Gallery thumbnail file not found: {$thumbnailPath}");
            }
        }
        
        \Log::warning("Gallery has no thumbnail field or thumbnail is null, falling back to image_url");
        // Fallback to image_url if thumbnail doesn't exist
        return $this->image_url;
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) {
            return null;
        }
        
        $bytes = (int) $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
