<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Facility extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'capacity',
        'location',
        'image',
        'thumbnail',
        'is_available',
        'floor',
        'facilities_spec',
        'sort_order',
        'view_count',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'view_count' => 'integer',
        'capacity' => 'integer',
        'sort_order' => 'integer'
    ];

    protected $appends = [
        'image_url',
        'thumbnail_url',
        'category_name'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($facility) {
            if (empty($facility->slug)) {
                $facility->slug = Str::slug($facility->name);
            }
        });

        static::updating(function ($facility) {
            if ($facility->isDirty('name') && empty($facility->slug)) {
                $facility->slug = Str::slug($facility->name);
            }
        });
    }

    /**
     * Get the user who created this facility.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this facility.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the full URL for the image.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/placeholder-facility.jpg');
    }

    /**
     * Get the full URL for the thumbnail.
     */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return $this->image_url;
    }

    /**
     * Get the category name in Indonesian.
     */
    public function getCategoryNameAttribute(): string
    {
        $categories = [
            'ruang_kelas' => 'Ruang Kelas',
            'laboratorium' => 'Laboratorium',
            'olahraga' => 'Olahraga',
            'perpustakaan' => 'Perpustakaan',
            'mushola' => 'Mushola',
            'kantin' => 'Kantin',
            'lainnya' => 'Lainnya'
        ];

        return $categories[$this->category] ?? 'Lainnya';
    }

    /**
     * Auto-generate slug from name.
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Scope for available facilities only.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope for filtering by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for search functionality.
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('location', 'like', "%{$keyword}%");
        });
    }

    /**
     * Scope for popular facilities (by view count).
     */
    public function scopePopular($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    /**
     * Increment the view count.
     */
    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    /**
     * Get formatted capacity with unit.
     */
    public function getFormattedCapacity(): string
    {
        if (!$this->capacity) {
            return 'N/A';
        }
        return $this->capacity . ' Orang';
    }

    /**
     * Get facilities specifications as array.
     */
    public function getSpecificationsArray(): array
    {
        if (!$this->facilities_spec) {
            return [];
        }
        
        return array_map('trim', explode(',', $this->facilities_spec));
    }
}