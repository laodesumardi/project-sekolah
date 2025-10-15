<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'class_id',
        'subject_id',
        'title',
        'description',
        'instructions',
        'due_date',
        'max_score',
        'file_path',
        'is_published',
        'is_active',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'is_published' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function getFileUrlAttribute(): string
    {
        if ($this->file_path && Storage::disk('public')->exists($this->file_path)) {
            return Storage::disk('public')->url($this->file_path);
        }
        
        return '';
    }

    public function getSubmissionCountAttribute(): int
    {
        return $this->submissions()->count();
    }

    public function getGradedCountAttribute(): int
    {
        return $this->submissions()->whereNotNull('score')->count();
    }

    public function getPendingCountAttribute(): int
    {
        return $this->submissions()->whereNull('score')->count();
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date->isPast() && $this->is_published;
    }

    public function getDaysUntilDueAttribute(): int
    {
        return $this->due_date->diffInDays(now(), false);
    }
}