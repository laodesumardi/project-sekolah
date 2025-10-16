<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'gallery_id',
        'image',
        'thumbnail',
        'medium',
        'title',
        'caption',
        'alt_text',
        'file_size',
        'mime_type',
        'width',
        'height',
        'sort_order',
        'is_cover',
        'view_count'
    ];

    protected $casts = [
        'is_cover' => 'boolean',
        'view_count' => 'integer',
        'file_size' => 'integer',
        'width' => 'integer',
        'height' => 'integer'
    ];

    protected $appends = ['image_url', 'thumbnail_url', 'medium_url', 'formatted_size'];

    // Relationships
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/placeholder-gallery.jpg');
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return $this->image_url;
    }

    public function getMediumUrlAttribute()
    {
        if ($this->medium) {
            return asset('storage/' . $this->medium);
        }
        return $this->image_url;
    }

    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Methods
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function setAsCover()
    {
        // Remove cover from all images in this gallery
        $this->gallery->images()->update(['is_cover' => false]);
        
        // Set this image as cover
        $this->update(['is_cover' => true]);
        $this->gallery->update(['cover_image' => $this->image]);
    }
}