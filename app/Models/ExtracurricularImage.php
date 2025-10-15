<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExtracurricularImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'extracurricular_id', 'image', 'thumbnail', 'title', 'image_type', 'sort_order'
    ];

    protected $appends = ['image_url', 'thumbnail_url'];

    // Relationships
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-image.jpg');
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return $this->image_url;
    }
}
