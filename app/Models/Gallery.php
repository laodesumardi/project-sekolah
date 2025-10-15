<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'date',
        'location',
        'photographer',
        'is_published',
        'is_featured',
        'sort_order',
        'view_count',
        'total_photos',
        'cover_image',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'date' => 'date',
        'view_count' => 'integer',
        'total_photos' => 'integer'
    ];

    protected $appends = ['cover_image_url', 'formatted_date'];

    // Relationships
    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Accessors
    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/gallery/' . $this->cover_image);
        }
        
        // Return first image if no cover set
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return $firstImage->image_url;
        }
        
        return asset('images/placeholder-gallery.jpg');
    }

    public function getFormattedDateAttribute()
    {
        if (!$this->date) {
            return null;
        }
        
        return $this->date->format('d F Y');
    }

    public function getCategoryNameAttribute()
    {
        $categories = [
            'kegiatan' => 'Kegiatan',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'event' => 'Event',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
            'akademik' => 'Akademik',
            'lainnya' => 'Lainnya'
        ];
        
        return $categories[$this->category] ?? 'Lainnya';
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
    }

    // Methods
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function updateTotalPhotos()
    {
        $this->update(['total_photos' => $this->images()->count()]);
    }

    public function setCoverImage($imageId)
    {
        // Remove cover from all images in this gallery
        $this->images()->update(['is_cover' => false]);
        
        // Set new cover
        $image = $this->images()->find($imageId);
        if ($image) {
            $image->update(['is_cover' => true]);
            $this->update(['cover_image' => $image->image]);
        }
    }

    public function getCoverImage()
    {
        return $this->images()->where('is_cover', true)->first() 
            ?? $this->images()->first();
    }
}