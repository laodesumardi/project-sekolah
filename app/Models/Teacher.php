<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
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
        'major',
        'university',
        'graduation_year',
        'certification_number',
        'cv_path',
        'bio',
        'photo',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'join_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the teacher.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the classes for the teacher.
     */
    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'homeroom_teacher_id');
    }

    /**
     * Get the subjects that the teacher teaches.
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects')
                    ->withPivot('is_primary')
                    ->withTimestamps();
    }

    /**
     * Get the classes that the teacher teaches.
     */
    public function teachingClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'teacher_classes', 'teacher_id', 'class_id')
                    ->withPivot(['subject_id', 'academic_year_id', 'is_homeroom'])
                    ->withTimestamps();
    }

    /**
     * Get the teacher class assignments.
     */
    public function teacherClasses()
    {
        return $this->hasMany(TeacherClass::class);
    }

    /**
     * Get the documents for the teacher.
     */
    public function documents()
    {
        return $this->hasMany(TeacherDocument::class);
    }

    /**
     * Get the certifications for the teacher.
     */
    public function certifications()
    {
        return $this->hasMany(TeacherCertification::class);
    }

    /**
     * Get the activities for the teacher.
     */
    public function activities()
    {
        return $this->hasMany(TeacherActivity::class);
    }

    /**
     * Get the full name from user.
     */
    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    /**
     * Get the email from user.
     */
    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    /**
     * Get the profile picture URL.
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        
        // Return default avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name) . '&background=13315c&color=fff&size=150';
    }

    /**
     * Get the CV file URL.
     */
    public function getCvUrlAttribute()
    {
        if ($this->cv_path) {
            return asset('storage/' . $this->cv_path);
        }
        return null;
    }

    /**
     * Get the teaching years.
     */
    public function getTeachingYearsAttribute()
    {
        if ($this->join_date) {
            return $this->join_date->diffInYears(now());
        }
        return 0;
    }

    /**
     * Get the age from birth date.
     */
    public function getAgeAttribute()
    {
        if ($this->birth_date) {
            return $this->birth_date->age;
        }
        return null;
    }

    /**
     * Get the total students taught.
     */
    public function getTotalStudentsAttribute()
    {
        // Get all class IDs that this teacher teaches
        $classIds = $this->teacherClasses()->pluck('class_id');
        
        // Count profiles in those classes
        return Profile::whereIn('class_id', $classIds)->count();
    }

    /**
     * Scope for active teachers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for teachers by subject.
     */
    public function scopeBySubject($query, $subjectId)
    {
        return $query->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('subject_id', $subjectId);
        });
    }

    /**
     * Scope for homeroom teachers.
     */
    public function scopeHomeroom($query)
    {
        return $query->whereHas('teachingClasses', function ($q) {
            $q->where('is_homeroom', true);
        });
    }
}
