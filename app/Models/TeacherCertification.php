<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherCertification extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'certificate_name',
        'issuing_institution',
        'issue_date',
        'expiry_date',
        'certificate_number',
        'file_path',
        'is_active',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function getIsExpiredAttribute(): bool
    {
        if (!$this->expiry_date) {
            return false;
        }
        
        return $this->expiry_date->isPast();
    }

    public function getDaysUntilExpiryAttribute(): int
    {
        if (!$this->expiry_date) {
            return 0;
        }
        
        return $this->expiry_date->diffInDays(now(), false);
    }
}
