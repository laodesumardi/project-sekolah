<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationSetting extends Model
{
    protected $table = 'registration_settings';

    protected $fillable = [
        'academic_year_id',
        'start_date',
        'end_date',
        'quota_regular',
        'quota_achievement',
        'quota_affirmation',
        'registration_fee',
        'announcement_date',
        'is_active',
        'is_open',
        'information',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'announcement_date' => 'date',
            'is_active' => 'boolean',
            'is_open' => 'boolean',
            'registration_fee' => 'decimal:2',
        ];
    }

    /**
     * Get the academic year that owns the registration setting.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get total quota.
     */
    public function getTotalQuotaAttribute(): int
    {
        return $this->quota_regular + $this->quota_achievement + $this->quota_affirmation;
    }

    /**
     * Check if registration is currently open.
     */
    public function isRegistrationOpen(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // Check if dates are not null
        if (!$this->start_date || !$this->end_date) {
            return false;
        }

        $now = now();
        return $now->between($this->start_date, $this->end_date);
    }

    /**
     * Check if announcement date has passed.
     */
    public function isAnnouncementTime(): bool
    {
        if (!$this->announcement_date) {
            return false;
        }
        
        return now()->gte($this->announcement_date);
    }
}