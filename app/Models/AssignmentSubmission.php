<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'submission_text',
        'file_path',
        'submitted_at',
        'score',
        'feedback',
        'graded_at',
        'is_late',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'is_late' => 'boolean',
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'student_id');
    }

    public function getFileUrlAttribute(): string
    {
        if ($this->file_path && Storage::disk('public')->exists($this->file_path)) {
            return Storage::disk('public')->url($this->file_path);
        }
        
        return '';
    }

    public function getIsGradedAttribute(): bool
    {
        return !is_null($this->score);
    }

    public function getGradeAttribute(): string
    {
        if (!$this->score) {
            return 'Belum Dinilai';
        }

        $percentage = ($this->score / $this->assignment->max_score) * 100;
        
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'E';
    }

    public function getPercentageAttribute(): float
    {
        if (!$this->score) {
            return 0;
        }
        
        return round(($this->score / $this->assignment->max_score) * 100, 2);
    }
}