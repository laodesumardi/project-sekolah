<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'start_date',
        'end_date',
        'announcement_date',
        'quota_regular',
        'quota_achievement',
        'quota_affirmation',
        'registration_fee',
        'is_open',
        'information',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'announcement_date' => 'date',
        'is_open' => 'boolean',
        'registration_fee' => 'decimal:2',
    ];

    /**
     * Get the academic year that owns the registration setting.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the registrations for the setting.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get total quota.
     */
    public function getTotalQuotaAttribute(): int
    {
        return $this->quota_regular + $this->quota_achievement + $this->quota_affirmation;
    }

    /**
     * Get quota for specific path.
     */
    public function getQuotaForPath(string $path): int
    {
        return match($path) {
            'regular' => $this->quota_regular,
            'achievement' => $this->quota_achievement,
            'affirmation' => $this->quota_affirmation,
            default => 0,
        };
    }

    /**
     * Check if registration is currently open.
     */
    public function isCurrentlyOpen(): bool
    {
        if (!$this->is_open) {
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
        return now()->gte($this->announcement_date);
    }

    /**
     * Scope for active settings.
     */
    public function scopeActive($query)
    {
        return $query->where('is_open', true);
    }

    /**
     * Scope for current academic year.
     */
    public function scopeCurrentYear($query)
    {
        return $query->whereHas('academicYear', function ($q) {
            $q->where('is_active', true);
        });
    }
}

