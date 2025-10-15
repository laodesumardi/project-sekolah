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
        $startDate = $this->start_date;
        $endDate = $this->end_date;
        
        // Check if current time is between start and end date (inclusive)
        return $now->gte($startDate) && $now->lte($endDate);
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

    /**
     * Get registration status.
     */
    public function getRegistrationStatus(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        if (!$this->start_date || !$this->end_date) {
            return 'not_configured';
        }

        $now = now();
        $startDate = $this->start_date;
        $endDate = $this->end_date;

        if ($now->lt($startDate)) {
            return 'not_started';
        }

        if ($now->gt($endDate)) {
            return 'ended';
        }

        return 'open';
    }

    /**
     * Get days until registration starts.
     */
    public function getDaysUntilStart(): int
    {
        if (!$this->start_date) {
            return 0;
        }

        $now = now();
        $startDate = $this->start_date;

        if ($now->gte($startDate)) {
            return 0;
        }

        return $now->diffInDays($startDate);
    }

    /**
     * Get days until registration ends.
     */
    public function getDaysUntilEnd(): int
    {
        if (!$this->end_date) {
            return 0;
        }

        $now = now();
        $endDate = $this->end_date;

        if ($now->gt($endDate)) {
            return 0;
        }

        return $now->diffInDays($endDate);
    }

    /**
     * Get active registration setting.
     */
    public static function getActive(): ?self
    {
        return static::where('is_active', true)
            ->with('academicYear')
            ->first();
    }
}