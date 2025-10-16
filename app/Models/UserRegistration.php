<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserRegistration extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'registration_number',
        'registration_type',
        'full_name',
        'email',
        'phone',
        'nik',
        'birth_place',
        'birth_date',
        'gender',
        'address',
        'city',
        'province',
        'postal_code',
        'school_origin',
        'last_education',
        'graduation_year',
        'nisn',
        'relation_type',
        'occupation',
        'student_name',
        'student_nis',
        'password',
        'email_verification_token',
        'email_verified_at',
        'phone_verification_code',
        'phone_verified_at',
        'status',
        'rejection_reason',
        'approved_by',
        'approved_at',
        'agreed_to_terms',
        'agreed_to_privacy',
        'ip_address',
        'user_agent',
        'photo_3x4',
        'birth_certificate',
        'family_card',
        'diploma',
        'report_card',
        'parent_id_card',
        'other_documents',
    ];

    protected $hidden = [
        'password',
        'email_verification_token',
        'phone_verification_code',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'agreed_to_terms' => 'boolean',
        'agreed_to_privacy' => 'boolean',
        'graduation_year' => 'integer',
    ];

    protected $appends = [
        'formatted_birth_date',
        'age',
        'is_verified',
        'status_badge',
        'gender_name'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            if (empty($registration->registration_number)) {
                $registration->registration_number = self::generateRegistrationNumber();
            }
            if (empty($registration->email_verification_token)) {
                $registration->email_verification_token = Str::random(60);
            }
        });
    }

    // Relationships
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Accessors
    public function getFormattedBirthDateAttribute()
    {
        return $this->birth_date ? $this->birth_date->format('d F Y') : null;
    }

    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->diffInYears(Carbon::now()) : null;
    }

    public function getIsVerifiedAttribute()
    {
        return $this->email_verified_at && $this->phone_verified_at;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>',
            'verified' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Terverifikasi</span>',
            'approved' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>',
            'rejected' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>',
        ];

        return $badges[$this->status] ?? '';
    }

    public function getGenderNameAttribute()
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // Mutators
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower(trim($value));
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at')
                    ->whereNotNull('phone_verified_at');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('registration_type', $type);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Methods
    public static function generateRegistrationNumber()
    {
        $year = date('Y');
        $prefix = "REG{$year}";
        
        do {
            $number = $prefix . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('registration_number', $number)->exists());
        
        return $number;
    }

    public function sendEmailVerification()
    {
        // Implementation for sending email verification
        // This would typically use Laravel's Mail facade
        return true;
    }

    public function sendPhoneVerification()
    {
        // Implementation for sending SMS verification
        // This would typically use a SMS service provider
        $this->phone_verification_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->save();
        return true;
    }

    public function verifyEmail($token)
    {
        if ($this->email_verification_token === $token) {
            $this->email_verified_at = now();
            $this->save();
            return true;
        }
        return false;
    }

    public function verifyPhone($code)
    {
        if ($this->phone_verification_code === $code) {
            $this->phone_verified_at = now();
            $this->save();
            return true;
        }
        return false;
    }

    public function approve($adminId)
    {
        $this->status = 'approved';
        $this->approved_by = $adminId;
        $this->approved_at = now();
        $this->save();
        
        // Create actual user account
        $this->createUserAccount();
        
        return true;
    }

    public function reject($adminId, $reason)
    {
        $this->status = 'rejected';
        $this->approved_by = $adminId;
        $this->rejection_reason = $reason;
        $this->save();
        
        return true;
    }

    public function createUserAccount()
    {
        $user = User::create([
            'name' => $this->full_name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->registration_type,
            'email_verified_at' => $this->email_verified_at,
        ]);

        return $user;
    }
}
