<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'class_id',
        'subject_id',
        'academic_year_id',
        'is_homeroom',
    ];

    protected function casts(): array
    {
        return [
            'is_homeroom' => 'boolean',
        ];
    }

    /**
     * Get the teacher that owns the class.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the class that belongs to the teacher.
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the subject that belongs to the teacher.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the academic year that belongs to the teacher.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}

