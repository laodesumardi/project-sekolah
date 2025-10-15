<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExtracurricularAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'extracurricular_id', 'title', 'description', 'achievement_level',
        'rank', 'event_name', 'date', 'certificate_image', 'participants', 'sort_order'
    ];

    protected $casts = [
        'date' => 'date',
        'participants' => 'array'
    ];

    protected $appends = ['certificate_url', 'formatted_date', 'achievement_level_name'];

    // Relationships
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }

    // Accessors
    public function getCertificateUrlAttribute()
    {
        if ($this->certificate_image) {
            return asset('storage/' . $this->certificate_image);
        }
        return null;
    }

    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('d F Y') : null;
    }

    public function getAchievementLevelNameAttribute()
    {
        $levels = [
            'sekolah' => 'Sekolah',
            'kecamatan' => 'Kecamatan',
            'kota' => 'Kota/Kabupaten',
            'provinsi' => 'Provinsi',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional'
        ];

        return $levels[$this->achievement_level] ?? 'Sekolah';
    }
}
