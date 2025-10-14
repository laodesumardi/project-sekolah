<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'class_id',
        'academic_year_id',
        'gender',
        'birth_place',
        'birth_date',
        'religion',
        'parent_name',
        'parent_phone',
        'phone',
        'address',
        'profile_picture',
        'bio',
        'show_profile_to_students',
        'show_email_to_teachers',
        'allow_parent_access',
        'two_factor_enabled',
        'two_factor_secret',
        // General settings
        'language',
        'timezone',
        'date_format',
        'time_format',
        'theme',
        // Notification settings
        'email_notifications',
        'sms_notifications',
        'push_notifications',
        'assignment_reminders',
        'grade_notifications',
        'announcement_notifications',
        // Privacy settings
        'show_attendance_to_parents',
        'show_grades_to_parents',
        // Account settings
        'auto_logout',
        'session_timeout',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'show_profile_to_students' => 'boolean',
            'show_email_to_teachers' => 'boolean',
            'allow_parent_access' => 'boolean',
            'two_factor_enabled' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the class that the profile belongs to.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
    }

    /**
     * Get the academic year that the profile belongs to.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the documents for the profile.
     */
    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }

    /**
     * Get the profile picture URL.
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        
        // Return default avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name) . '&background=13315c&color=fff&size=150';
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
     * Get the age from birth date.
     */
    public function getAgeAttribute()
    {
        if (!$this->birth_date) {
            return null;
        }
        
        return $this->birth_date->age;
    }
}
