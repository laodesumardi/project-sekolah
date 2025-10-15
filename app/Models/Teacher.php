<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'nik',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'address',
        'phone',
        'employment_status',
        'join_date',
        'education_level',
        'subject',
        'major',
        'university',
        'graduation_year',
        'bio',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'full_name',
        'profile_picture_url',
        'age',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects');
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'teacher_classes');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function learningMaterials(): HasMany
    {
        return $this->hasMany(LearningMaterial::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(TeacherDocument::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(TeacherCertification::class);
    }

    public function extracurriculars(): BelongsToMany
    {
        return $this->belongsToMany(Extracurricular::class, 'teacher_extracurriculars');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->user->name ?? 'Nama tidak tersedia';
    }

    public function getProfilePictureUrlAttribute(): string
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return Storage::disk('public')->url($this->photo);
        }
        
        return asset('images/default-avatar.png');
    }

    public function getAgeAttribute(): int
    {
        return $this->birth_date ? $this->birth_date->age : 0;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBySubject($query, $subjectId)
    {
        return $query->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('subjects.id', $subjectId);
        });
    }

    public function scopeByClass($query, $classId)
    {
        return $query->whereHas('classes', function ($q) use ($classId) {
            $q->where('school_classes.id', $classId);
        });
    }
}
