<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'category_id',
        'author_id',
        'views',
        'is_featured',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'allow_comments',
        'scheduled_at',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'published_at' => 'datetime',
            'scheduled_at' => 'datetime',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });

        static::updating(function ($news) {
            if ($news->isDirty('title') && empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the category that owns the news.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    /**
     * Get the author that owns the news.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the tags that belong to the news.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tags');
    }

    /**
     * Scope a query to only include published news.
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include featured news.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include recent news.
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->published()->orderBy('published_at', 'desc')->limit($limit);
    }

    /**
     * Scope a query to only include popular news.
     */
    public function scopePopular($query, $limit = 5)
    {
        return $query->published()->orderBy('views', 'desc')->limit($limit);
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            $imagePath = storage_path('app/public/news/' . $this->image);
            if (file_exists($imagePath)) {
                return asset('storage/news/' . $this->image);
            } else {
                \Log::warning("News image file not found: {$imagePath}");
            }
        }
        
        // Return a simple placeholder if no image
        return 'data:image/svg+xml;base64,' . base64_encode('<svg width="400" height="300" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="300" fill="#F3F4F6"/><rect x="50" y="50" width="300" height="200" fill="#9CA3AF"/><rect x="100" y="100" width="200" height="100" fill="#E5E7EB"/><text x="200" y="150" text-anchor="middle" fill="#6B7280" font-family="Arial" font-size="16">News Image</text></svg>');
    }

    /**
     * Get the excerpt or auto-generate from content.
     */
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        return Str::limit(strip_tags($this->content), 150);
    }

    /**
     * Get the time ago format.
     */
    public function getTimeAgoAttribute()
    {
        return $this->published_at->diffForHumans();
    }
}
