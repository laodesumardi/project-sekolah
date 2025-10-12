<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'activity_type',
        'description',
        'metadata',
        'user_id',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Get the registration that owns the activity.
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the user who performed the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get activity type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->activity_type) {
            'registration_submitted' => 'Pendaftaran Dikirim',
            'document_uploaded' => 'Dokumen Diupload',
            'document_verified' => 'Dokumen Diverifikasi',
            'status_changed' => 'Status Diubah',
            'payment_submitted' => 'Pembayaran Dikirim',
            'payment_confirmed' => 'Pembayaran Dikonfirmasi',
            'admin_viewed' => 'Dilihat Admin',
            'notification_sent' => 'Notifikasi Dikirim',
            'form_edited' => 'Formulir Diedit',
            'announcement_published' => 'Pengumuman Dipublikasi',
            default => 'Aktivitas Lainnya',
        };
    }

    /**
     * Get activity icon.
     */
    public function getIconAttribute(): string
    {
        return match($this->activity_type) {
            'registration_submitted' => '📝',
            'document_uploaded' => '📄',
            'document_verified' => '✅',
            'status_changed' => '🔄',
            'payment_submitted' => '💳',
            'payment_confirmed' => '✅',
            'admin_viewed' => '👁️',
            'notification_sent' => '📧',
            'form_edited' => '✏️',
            'announcement_published' => '📢',
            default => '📋',
        };
    }

    /**
     * Get formatted timestamp.
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->created_at->format('d M Y, H:i');
    }

    /**
     * Get relative time.
     */
    public function getRelativeTimeAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Scope by activity type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Scope for recent activities.
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for admin activities.
     */
    public function scopeAdminActivities($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Scope for user activities.
     */
    public function scopeUserActivities($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Create activity log.
     */
    public static function log(
        int $registrationId,
        string $activityType,
        string $description,
        array $metadata = [],
        ?int $userId = null,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): self {
        return self::create([
            'registration_id' => $registrationId,
            'activity_type' => $activityType,
            'description' => $description,
            'metadata' => $metadata,
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    }
}

