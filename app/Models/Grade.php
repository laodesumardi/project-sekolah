<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'student_id',
        'class_id',
        'subject_id',
        'assignment_id',
        'grade_type',
        'score',
        'max_score',
        'description',
        'graded_at',
    ];

    protected $casts = [
        'graded_at' => 'datetime',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'student_id');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function getPercentageAttribute(): float
    {
        if (!$this->max_score || $this->max_score == 0) {
            return 0;
        }
        
        return round(($this->score / $this->max_score) * 100, 2);
    }

    public function getGradeAttribute(): string
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'E';
    }

    public function getGradeColorAttribute(): string
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 90) return 'green';
        if ($percentage >= 80) return 'blue';
        if ($percentage >= 70) return 'yellow';
        if ($percentage >= 60) return 'orange';
        return 'red';
    }

    // Grade types
    const TYPE_ASSIGNMENT = 'assignment';
    const TYPE_QUIZ = 'quiz';
    const TYPE_EXAM = 'exam';
    const TYPE_PROJECT = 'project';
    const TYPE_ATTENDANCE = 'attendance';
    const TYPE_OTHER = 'other';

    public static function getGradeTypes(): array
    {
        return [
            self::TYPE_ASSIGNMENT => 'Tugas',
            self::TYPE_QUIZ => 'Kuis',
            self::TYPE_EXAM => 'Ujian',
            self::TYPE_PROJECT => 'Proyek',
            self::TYPE_ATTENDANCE => 'Kehadiran',
            self::TYPE_OTHER => 'Lainnya',
        ];
    }

    public function getGradeTypeNameAttribute(): string
    {
        return self::getGradeTypes()[$this->grade_type] ?? 'Tidak Diketahui';
    }
}