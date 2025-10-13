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
        
        // Return a simple placeholder if no image (same as News)
        return 'data:image/svg+xml;base64,' . base64_encode('<svg width="400" height="300" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="300" fill="#F3F4F6"/><rect x="50" y="50" width="300" height="200" fill="#9CA3AF"/><rect x="100" y="100" width="200" height="100" fill="#E5E7EB"/><text x="200" y="150" text-anchor="middle" fill="#6B7280" font-family="Arial" font-size="16">' . $this->name . '</text></svg>');
    }

    /**
     * Get the category that owns the facility.
     */
    public function category()
    {
        return $this->belongsTo(FacilityCategory::class);
    }
}
