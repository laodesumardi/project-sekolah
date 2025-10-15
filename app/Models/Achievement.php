<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Achievement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'achievement_level',
        'rank',
        'event_name',
        'organizer',
        'location',
        'date',
        'achievement_date',
        'year',
        'participant_type',
        'student_ids',
        'teacher_ids',
        'certificate_image',
        'trophy_image',
        'documentation_images',
        'video_url',
        'news_url',
        'prize',
        'score',
        'is_featured',
        'is_published',
        'sort_order',
        'view_count',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'date' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'view_count' => 'integer',
        'year' => 'integer',
        'student_ids' => 'array',
        'teacher_ids' => 'array',
        'documentation_images' => 'array'
    ];

    protected $appends = [
        'certificate_url',
        'trophy_url',
        'formatted_date',
        'level_color',
        'level_color_name',
        'level_badge',
        'category_name',
        'level_name'
    ];

    // Relationships
    public function images()
    {
        return $this->hasMany(AchievementImage::class);
    }

    public function participants()
    {
        return $this->hasMany(AchievementParticipant::class);
    }

    public function teachers()
    {
        return $this->hasMany(AchievementTeacher::class);
    }

    public function students()
    {
        return $this->belongsToMany(Profile::class, 'achievement_participants', 'achievement_id', 'student_id');
    }

    public function teacherUsers()
    {
        return $this->belongsToMany(Teacher::class, 'achievement_teachers', 'achievement_id', 'teacher_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Accessors
    public function getCertificateUrlAttribute()
    {
        return $this->certificate_image ? asset('storage/achievements/certificates/' . $this->certificate_image) : null;
    }

    public function getTrophyUrlAttribute()
    {
        return $this->trophy_image ? asset('storage/achievements/trophies/' . $this->trophy_image) : null;
    }

    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->locale('id')->isoFormat('D MMMM Y') : null;
    }

    public function getLevelColorAttribute()
    {
        $colors = [
            'sekolah' => 'bg-blue-100 text-blue-800',
            'kecamatan' => 'bg-green-100 text-green-800',
            'kota' => 'bg-yellow-100 text-yellow-800',
            'provinsi' => 'bg-orange-100 text-orange-800',
            'nasional' => 'bg-red-100 text-red-800',
            'internasional' => 'bg-purple-100 text-purple-800'
        ];

        return $colors[$this->achievement_level] ?? 'bg-gray-100 text-gray-800';
    }

    public function getLevelColorNameAttribute()
    {
        $colorNames = [
            'sekolah' => 'blue',
            'kecamatan' => 'green',
            'kota' => 'yellow',
            'provinsi' => 'orange',
            'nasional' => 'red',
            'internasional' => 'purple'
        ];

        return $colorNames[$this->achievement_level] ?? 'gray';
    }

    public function getLevelBadgeAttribute()
    {
        $colors = [
            'sekolah' => 'bg-blue-100 text-blue-800',
            'kecamatan' => 'bg-green-100 text-green-800',
            'kota' => 'bg-yellow-100 text-yellow-800',
            'provinsi' => 'bg-orange-100 text-orange-800',
            'nasional' => 'bg-red-100 text-red-800',
            'internasional' => 'bg-purple-100 text-purple-800'
        ];

        $colorClass = $colors[$this->achievement_level] ?? 'bg-gray-100 text-gray-800';
        $levelName = $this->getLevelNameAttribute();

        return "<span class='inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$colorClass}'>
                    <i class='fas fa-trophy mr-1'></i>
                    {$levelName}
                </span>";
    }

    public function getCategoryNameAttribute()
    {
        $categories = [
            'akademik' => 'Akademik',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
            'teknologi' => 'Teknologi',
            'keagamaan' => 'Keagamaan',
            'lomba' => 'Lomba',
            'kompetisi' => 'Kompetisi',
            'olimpiade' => 'Olimpiade',
            'lainnya' => 'Lainnya'
        ];

        return $categories[$this->category] ?? $this->category;
    }

    public function getLevelNameAttribute()
    {
        $levels = [
            'sekolah' => 'Sekolah',
            'kecamatan' => 'Kecamatan',
            'kota' => 'Kota/Kabupaten',
            'provinsi' => 'Provinsi',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional'
        ];

        return $levels[$this->achievement_level] ?? $this->achievement_level;
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value;
        if ($value) {
            $this->attributes['year'] = Carbon::parse($value)->year;
        }
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('achievement_level', $level);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('event_name', 'like', "%{$keyword}%")
              ->orWhere('participants', 'like', "%{$keyword}%");
        });
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('date', 'desc');
    }

    // Methods
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function getParticipantNames()
    {
        return $this->participants->pluck('participant_name')->toArray();
    }

    public function getTeacherNames()
    {
        return $this->teachers->with('teacher')->get()->pluck('teacher.name')->toArray();
    }

    public function isIndividual()
    {
        return $this->participant_type === 'individu';
    }

    public function isTeam()
    {
        return in_array($this->participant_type, ['kelompok', 'tim']);
    }

    // Helper method to safely get documentation images as array
    public function getDocumentationImagesArray()
    {
        if (is_array($this->documentation_images)) {
            return $this->documentation_images;
        }
        
        if (is_string($this->documentation_images)) {
            $decoded = json_decode($this->documentation_images, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return [];
    }
}