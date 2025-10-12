<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'grade_level',
        'hours_per_week',
        'syllabus_file',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include active subjects.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by grade level.
     */
    public function scopeByGrade($query, $grade)
    {
        return $query->where('grade_level', $grade)->orWhere('grade_level', 'all');
    }

    /**
     * Get the syllabus file URL.
     */
    public function getSyllabusUrlAttribute()
    {
        if ($this->syllabus_file) {
            return asset('storage/syllabi/' . $this->syllabus_file);
        }
        return null;
    }

    /**
     * Get formatted grade level.
     */
    public function getFormattedGradeLevelAttribute()
    {
        return $this->grade_level === 'all' ? 'Semua Tingkat' : 'Kelas ' . $this->grade_level;
    }
}