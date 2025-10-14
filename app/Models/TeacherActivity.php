<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'activity_type',
        'description',
        'metadata',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    /**
     * Get the teacher that owns the activity.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the activity icon based on type.
     */
    public function getActivityIconAttribute()
    {
        return match($this->activity_type) {
            'login' => 'fas fa-sign-in-alt',
            'logout' => 'fas fa-sign-out-alt',
            'upload' => 'fas fa-upload',
            'grade' => 'fas fa-graduation-cap',
            'attendance' => 'fas fa-user-check',
            'message' => 'fas fa-comment',
            'profile_update' => 'fas fa-user-edit',
            'password_change' => 'fas fa-key',
            'document_upload' => 'fas fa-file-upload',
            'certification_add' => 'fas fa-certificate',
            default => 'fas fa-circle'
        };
    }

    /**
     * Get the activity color based on type.
     */
    public function getActivityColorAttribute()
    {
        return match($this->activity_type) {
            'login' => 'text-green-600',
            'logout' => 'text-gray-600',
            'upload' => 'text-blue-600',
            'grade' => 'text-purple-600',
            'attendance' => 'text-orange-600',
            'message' => 'text-indigo-600',
            'profile_update' => 'text-yellow-600',
            'password_change' => 'text-red-600',
            'document_upload' => 'text-teal-600',
            'certification_add' => 'text-pink-600',
            default => 'text-gray-600'
        };
    }

    /**
     * Get the activity description with context.
     */
    public function getFormattedDescriptionAttribute()
    {
        $description = $this->description;
        
        if ($this->metadata) {
            foreach ($this->metadata as $key => $value) {
                $description = str_replace("{{$key}}", $value, $description);
            }
        }
        
        return $description;
    }

    /**
     * Scope for recent activities.
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for specific activity type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Scope for login activities.
     */
    public function scopeLogins($query)
    {
        return $query->where('activity_type', 'login');
    }

    /**
     * Scope for upload activities.
     */
    public function scopeUploads($query)
    {
        return $query->where('activity_type', 'upload');
    }

    /**
     * Scope for grading activities.
     */
    public function scopeGrading($query)
    {
        return $query->where('activity_type', 'grade');
    }
}

