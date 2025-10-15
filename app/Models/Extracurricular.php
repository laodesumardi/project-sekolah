<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Extracurricular extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'category', 'description', 'short_description',
        'instructor_id', 'instructor_name', 'schedule_day', 'schedule_time_start',
        'schedule_time_end', 'location', 'max_participants', 'current_participants',
        'is_registration_open', 'registration_start', 'registration_end',
        'requirements', 'benefits', 'logo', 'cover_image', 'thumbnail',
        'is_active', 'is_featured', 'sort_order', 'view_count',
        'facebook_url', 'instagram_url', 'youtube_url',
        'created_by', 'updated_by'
    ];

    protected $casts = [
        'is_registration_open' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'view_count' => 'integer',
        'max_participants' => 'integer',
        'current_participants' => 'integer',
        'registration_start' => 'date',
        'registration_end' => 'date',
        'schedule_time_start' => 'datetime:H:i',
        'schedule_time_end' => 'datetime:H:i',
        'requirements' => 'array',
        'benefits' => 'array'
    ];

    protected $appends = [
        'logo_url', 'cover_image_url', 'thumbnail_url', 'is_full', 
        'available_slots', 'formatted_schedule', 'category_name', 'schedule_day_name'
    ];

    // Relationships
    public function instructor()
    {
        return $this->belongsTo(Teacher::class, 'instructor_id');
    }

    public function images()
    {
        return $this->hasMany(ExtracurricularImage::class);
    }

    public function achievements()
    {
        return $this->hasMany(ExtracurricularAchievement::class);
    }

    public function registrations()
    {
        return $this->hasMany(ExtracurricularRegistration::class);
    }

    public function activeMembers()
    {
        return $this->hasMany(ExtracurricularRegistration::class)->where('status', 'active');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_extracurriculars');
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
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/default-extracurricular.svg');
    }

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/default-extracurricular-cover.jpg');
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return $this->cover_image_url;
    }

    public function getIsFullAttribute()
    {
        if (!$this->max_participants) {
            return false;
        }
        return $this->current_participants >= $this->max_participants;
    }

    public function getAvailableSlotsAttribute()
    {
        if (!$this->max_participants) {
            return 'Unlimited';
        }
        return $this->max_participants - $this->current_participants;
    }

    public function getFormattedScheduleAttribute()
    {
        if (!$this->schedule_day || !$this->schedule_time_start || !$this->schedule_time_end) {
            return 'Fleksibel';
        }

        $day = $this->schedule_day_name;
        $start = $this->schedule_time_start->format('H:i');
        $end = $this->schedule_time_end->format('H:i');
        
        return "{$day}, {$start} - {$end}";
    }

    public function getCategoryNameAttribute()
    {
        $categories = [
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
            'akademik' => 'Akademik',
            'keagamaan' => 'Keagamaan',
            'teknologi' => 'Teknologi',
            'bahasa' => 'Bahasa',
            'sosial' => 'Sosial',
            'lainnya' => 'Lainnya'
        ];

        return $categories[$this->category] ?? 'Lainnya';
    }

    public function getScheduleDayNameAttribute()
    {
        $days = [
            'senin' => 'Senin',
            'selasa' => 'Selasa',
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu',
            'minggu' => 'Minggu'
        ];

        return $days[$this->schedule_day] ?? 'Fleksibel';
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeRegistrationOpen($query)
    {
        return $query->where('is_registration_open', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where(function($q) {
            $q->whereNull('max_participants')
              ->orWhereRaw('current_participants < max_participants');
        });
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('short_description', 'like', "%{$keyword}%");
        });
    }

    public function scopeByDay($query, $day)
    {
        return $query->where('schedule_day', $day);
    }

    // Methods
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function updateParticipantCount()
    {
        $this->current_participants = $this->activeMembers()->count();
        $this->save();
    }

    public function isRegistrationPeriod()
    {
        if (!$this->registration_start || !$this->registration_end) {
            return $this->is_registration_open;
        }

        $now = now();
        return $this->is_registration_open && 
               $now->between($this->registration_start, $this->registration_end);
    }

    public function hasAvailableSlot()
    {
        if (!$this->max_participants) {
            return true;
        }
        return $this->current_participants < $this->max_participants;
    }

    public function getRegistrationStatus()
    {
        if (!$this->is_registration_open) {
            return 'Closed';
        }

        if ($this->is_full) {
            return 'Full';
        }

        if (!$this->isRegistrationPeriod()) {
            return 'Closed';
        }

        return 'Open';
    }
}
