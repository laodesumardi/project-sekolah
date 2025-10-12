<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'achievement_level',
        'rank',
        'participant_type',
        'participant_names',
        'date',
        'certificate_image',
        'competition_name',
        'organizer',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Scope a query to filter by year.
     */
    public function scopeByYear($query, $year)
    {
        return $query->whereYear('date', $year);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to filter by achievement level.
     */
    public function scopeByLevel($query, $level)
    {
        return $query->where('achievement_level', $level);
    }

    /**
     * Scope a query to only include featured achievements.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the certificate image URL.
     */
    public function getCertificateUrlAttribute()
    {
        if ($this->certificate_image) {
            return asset('storage/achievements/' . $this->certificate_image);
        }
        return null;
    }

    /**
     * Get formatted achievement level.
     */
    public function getFormattedLevelAttribute()
    {
        $levels = [
            'kecamatan' => 'Kecamatan',
            'kota' => 'Kota/Kabupaten',
            'provinsi' => 'Provinsi',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional'
        ];

        return $levels[$this->achievement_level] ?? ucfirst($this->achievement_level);
    }

    /**
     * Get formatted participant type.
     */
    public function getFormattedParticipantTypeAttribute()
    {
        return $this->participant_type === 'individual' ? 'Individu' : 'Tim';
    }

    /**
     * Get achievement year.
     */
    public function getYearAttribute()
    {
        return $this->date->year;
    }

    /**
     * Get achievement month.
     */
    public function getMonthAttribute()
    {
        return $this->date->format('F');
    }
}