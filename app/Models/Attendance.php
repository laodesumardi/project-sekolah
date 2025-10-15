<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'student_id',
        'class_id',
        'subject_id',
        'date',
        'status',
        'notes',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'date' => 'date',
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

    // Attendance statuses
    const STATUS_PRESENT = 'present';
    const STATUS_ABSENT = 'absent';
    const STATUS_LATE = 'late';
    const STATUS_EXCUSED = 'excused';
    const STATUS_SICK = 'sick';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PRESENT => 'Hadir',
            self::STATUS_ABSENT => 'Tidak Hadir',
            self::STATUS_LATE => 'Terlambat',
            self::STATUS_EXCUSED => 'Izin',
            self::STATUS_SICK => 'Sakit',
        ];
    }

    public function getStatusNameAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? 'Tidak Diketahui';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PRESENT => 'green',
            self::STATUS_ABSENT => 'red',
            self::STATUS_LATE => 'yellow',
            self::STATUS_EXCUSED => 'blue',
            self::STATUS_SICK => 'orange',
            default => 'gray',
        };
    }

    public function getIsPresentAttribute(): bool
    {
        return $this->status === self::STATUS_PRESENT;
    }

    public function getIsAbsentAttribute(): bool
    {
        return $this->status === self::STATUS_ABSENT;
    }

    public function getIsLateAttribute(): bool
    {
        return $this->status === self::STATUS_LATE;
    }
}