<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'achievement_id',
        'image',
        'thumbnail',
        'title',
        'image_type',
        'sort_order'
    ];

    protected $appends = [
        'image_url',
        'thumbnail_url'
    ];

    // Relationships
    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/achievements/images/' . $this->image) : null;
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/achievements/thumbnails/' . $this->thumbnail) : null;
    }
}