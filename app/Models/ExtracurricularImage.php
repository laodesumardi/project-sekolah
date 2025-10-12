<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtracurricularImage extends Model
{
    protected $fillable = [
        'extracurricular_id',
        'image',
        'thumbnail',
        'medium',
        'large',
        'caption',
        'sort_order',
    ];

    /**
     * Get the extracurricular that owns the image.
     */
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/placeholder-image.jpg');
    }

    /**
     * Get the thumbnail URL.
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return $this->image_url;
    }

    /**
     * Get the medium size URL.
     */
    public function getMediumUrlAttribute()
    {
        if ($this->medium) {
            return asset('storage/' . $this->medium);
        }
        return $this->image_url;
    }

    /**
     * Get the large size URL.
     */
    public function getLargeUrlAttribute()
    {
        if ($this->large) {
            return asset('storage/' . $this->large);
        }
        return $this->image_url;
    }

    /**
     * Get responsive image URLs.
     */
    public function getResponsiveUrlsAttribute()
    {
        return [
            'thumbnail' => $this->thumbnail_url,
            'medium' => $this->medium_url,
            'large' => $this->large_url,
            'original' => $this->image_url,
        ];
    }
}