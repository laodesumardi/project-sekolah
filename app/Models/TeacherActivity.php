<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'activity_type',
        'title',
        'description',
        'date',
        'location',
        'participants',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'participants' => 'array',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    // Activity types
    const TYPE_TEACHING = 'teaching';
    const TYPE_TRAINING = 'training';
    const TYPE_MEETING = 'meeting';
    const TYPE_EVENT = 'event';
    const TYPE_OTHER = 'other';

    public static function getActivityTypes(): array
    {
        return [
            self::TYPE_TEACHING => 'Mengajar',
            self::TYPE_TRAINING => 'Pelatihan',
            self::TYPE_MEETING => 'Rapat',
            self::TYPE_EVENT => 'Acara',
            self::TYPE_OTHER => 'Lainnya',
        ];
    }

    public function getActivityTypeNameAttribute(): string
    {
        return self::getActivityTypes()[$this->activity_type] ?? 'Tidak Diketahui';
    }
}
