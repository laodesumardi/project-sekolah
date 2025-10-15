<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $fillable = [
        'name',
        'grade_level',
        'academic_year_id',
        'homeroom_teacher_id',
    ];

    /**
     * Get the academic year that owns the class.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the homeroom teacher for the class.
     */
    public function homeroomTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }

    /**
     * Get the profiles for the class.
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class, 'class_id');
    }

    /**
     * Get the teacher classes for this school class.
     */
    public function teacherClasses(): HasMany
    {
        return $this->hasMany(TeacherClass::class, 'class_id');
    }
}
