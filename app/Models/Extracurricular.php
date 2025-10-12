<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'schedule_day',
        'schedule_time',
        'instructor_id',
        'icon',
        'max_participants',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the instructor that owns the extracurricular.
     */
    public function instructor()
    {
        return $this->belongsTo(Teacher::class, 'instructor_id');
    }

    /**
     * Get the images for the extracurricular.
     */
    public function images()
    {
        return $this->hasMany(ExtracurricularImage::class);
    }

    /**
     * Scope a query to only include active extracurriculars.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get the icon URL.
     */
    public function getIconUrlAttribute()
    {
        if ($this->icon) {
            return asset('storage/extracurriculars/' . $this->icon);
        }
        return asset('images/default-extracurricular.png');
    }

    /**
     * Get formatted schedule.
     */
    public function getFormattedScheduleAttribute()
    {
        $dayNames = [
            'monday' => 'Senin',
            'tuesday' => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat',
            'saturday' => 'Sabtu',
            'sunday' => 'Minggu'
        ];

        $day = $dayNames[$this->schedule_day] ?? ucfirst($this->schedule_day);
        $time = date('H:i', strtotime($this->schedule_time));
        
        return $day . ', ' . $time;
    }
}