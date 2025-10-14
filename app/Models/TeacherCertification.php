<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCertification extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'certification_name',
        'issuing_organization',
        'issue_date',
        'expiry_date',
        'certificate_file',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'expiry_date' => 'date',
        ];
    }

    /**
     * Get the teacher that owns the certification.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the certificate file URL.
     */
    public function getCertificateFileUrlAttribute()
    {
        if ($this->certificate_file) {
            return asset('storage/teacher-certificates/' . $this->certificate_file);
        }
        return null;
    }

    /**
     * Check if certification is expired.
     */
    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if certification is expiring soon (within 30 days).
     */
    public function isExpiringSoon()
    {
        return $this->expiry_date && $this->expiry_date->isFuture() && $this->expiry_date->diffInDays(now()) <= 30;
    }

    /**
     * Get the duration of the certification.
     */
    public function getDurationAttribute()
    {
        if ($this->expiry_date) {
            return $this->issue_date->diffInDays($this->expiry_date);
        }
        return null;
    }

    /**
     * Get the days until expiry.
     */
    public function getDaysUntilExpiryAttribute()
    {
        if ($this->expiry_date) {
            return $this->expiry_date->diffInDays(now());
        }
        return null;
    }

    /**
     * Scope for active certifications (not expired).
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expiry_date')
              ->orWhere('expiry_date', '>', now());
        });
    }

    /**
     * Scope for expired certifications.
     */
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    /**
     * Scope for expiring soon certifications.
     */
    public function scopeExpiringSoon($query)
    {
        return $query->whereBetween('expiry_date', [now(), now()->addDays(30)]);
    }
}

