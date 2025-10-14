<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',
        'target_audience',
        'class_id',
        'author_id',
        'is_published',
        'published_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    /**
     * Get the class that owns the announcement.
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the author of the announcement.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope for published announcements.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope for active announcements (not expired).
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Scope for urgent announcements.
     */
    public function scopeUrgent($query)
    {
        return $query->where('type', 'urgent');
    }

    /**
     * Scope for school announcements.
     */
    public function scopeSchool($query)
    {
        return $query->where('type', 'school');
    }

    /**
     * Scope for class announcements.
     */
    public function scopeClass($query)
    {
        return $query->where('type', 'class');
    }

    /**
     * Scope for student audience.
     */
    public function scopeForStudents($query)
    {
        return $query->whereIn('target_audience', ['all', 'student']);
    }

    /**
     * Get the excerpt of the content.
     */
    public function getExcerptAttribute()
    {
        return \Str::limit(strip_tags($this->content), 150);
    }

    /**
     * Get the type badge color.
     */
    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'urgent' => 'red',
            'school' => 'blue',
            'class' => 'green',
            default => 'gray'
        };
    }

    /**
     * Check if announcement is expired.
     */
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if announcement is urgent.
     */
    public function isUrgent()
    {
        return $this->type === 'urgent';
    }
}

