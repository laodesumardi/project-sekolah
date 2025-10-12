<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_number',
        'academic_year_id',
        'registration_setting_id',
        'registration_path',
        'full_name',
        'nik',
        'nisn',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'child_number',
        'siblings_count',
        'address',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'height',
        'weight',
        'blood_type',
        'medical_history',
        'photo',
        'father_name',
        'father_nik',
        'father_birth_year',
        'father_education',
        'father_occupation',
        'father_income',
        'father_phone',
        'mother_name',
        'mother_nik',
        'mother_birth_year',
        'mother_education',
        'mother_occupation',
        'mother_income',
        'mother_phone',
        'guardian_name',
        'guardian_relation',
        'guardian_phone',
        'previous_school',
        'school_npsn',
        'school_address',
        'graduation_year',
        'certificate_number',
        'average_score',
        'achievements',
        'status',
        'admin_notes',
        'verified_at',
        'verified_by',
        'announced_at',
        'payment_status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'verified_at' => 'datetime',
        'announced_at' => 'datetime',
        'average_score' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            if (empty($registration->registration_number)) {
                $registration->registration_number = self::generateRegistrationNumber();
            }
        });
    }

    /**
     * Generate unique registration number.
     */
    public static function generateRegistrationNumber(): string
    {
        $year = now()->year;
        $prefix = "PPDB{$year}";
        
        do {
            $number = $prefix . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('registration_number', $number)->exists());
        
        return $number;
    }

    /**
     * Get the academic year that owns the registration.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the registration setting that owns the registration.
     */
    public function registrationSetting(): BelongsTo
    {
        return $this->belongsTo(RegistrationSetting::class);
    }

    /**
     * Get the user who verified the registration.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get the documents for the registration.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(RegistrationDocument::class);
    }

    /**
     * Get the payments for the registration.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(RegistrationPayment::class);
    }

    /**
     * Get the activities for the registration.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(RegistrationActivity::class);
    }

    /**
     * Get age from birth date.
     */
    public function getAgeAttribute(): int
    {
        return $this->birth_date->age;
    }

    /**
     * Get full address.
     */
    public function getFullAddressAttribute(): string
    {
        return "{$this->address}, RT {$this->rt}/RW {$this->rw}, {$this->kelurahan}, {$this->kecamatan}, {$this->city}, {$this->province} {$this->postal_code}";
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'verified' => 'blue',
            'accepted' => 'green',
            'rejected' => 'red',
            'reserved' => 'purple',
            default => 'gray',
        };
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'reserved' => 'Cadangan',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get registration path label.
     */
    public function getPathLabelAttribute(): string
    {
        return match($this->registration_path) {
            'regular' => 'Reguler',
            'achievement' => 'Prestasi',
            'affirmation' => 'Afirmasi',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Scope for status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for registration path.
     */
    public function scopeByPath($query, string $path)
    {
        return $query->where('registration_path', $path);
    }

    /**
     * Scope for recent registrations.
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for verified registrations.
     */
    public function scopeVerified($query)
    {
        return $query->whereIn('status', ['verified', 'accepted', 'rejected', 'reserved']);
    }

    /**
     * Scope for pending verification.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for accepted registrations.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Check if registration is verified.
     */
    public function isVerified(): bool
    {
        return in_array($this->status, ['verified', 'accepted', 'rejected', 'reserved']);
    }

    /**
     * Check if registration is accepted.
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if registration is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if registration is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Get photo URL.
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/registrations/' . $this->registration_number . '/' . $this->photo);
        }
        return asset('images/default-avatar.png');
    }

    /**
     * Get formatted phone number.
     */
    public function getFormattedPhoneAttribute(): string
    {
        $phone = $this->phone;
        if (str_starts_with($phone, '0')) {
            return '62' . substr($phone, 1);
        }
        return $phone;
    }
}

