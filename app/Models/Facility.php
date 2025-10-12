<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'capacity',
        'is_available',
        'category_id',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include available facilities.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/facilities/' . $this->image);
        }
        return asset('images/placeholder-facility.jpg');
    }

    /**
     * Get the category that owns the facility.
     */
    public function category()
    {
        return $this->belongsTo(FacilityCategory::class);
    }
}
