<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'os',
        'location',
        'is_current',
        'last_activity',
    ];

    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
            'last_activity' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the session.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for current sessions.
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Scope for other sessions (not current).
     */
    public function scopeOther($query)
    {
        return $query->where('is_current', false);
    }

    /**
     * Get the device icon based on device type.
     */
    public function getDeviceIconAttribute()
    {
        return match($this->device_type) {
            'desktop' => 'fas fa-desktop',
            'mobile' => 'fas fa-mobile-alt',
            'tablet' => 'fas fa-tablet-alt',
            default => 'fas fa-question-circle'
        };
    }

    /**
     * Get the session status (active/inactive).
     */
    public function getStatusAttribute()
    {
        $lastActivity = $this->last_activity;
        $now = now();
        
        if ($lastActivity->diffInMinutes($now) < 5) {
            return 'active';
        } elseif ($lastActivity->diffInHours($now) < 1) {
            return 'recent';
        } else {
            return 'inactive';
        }
    }

    /**
     * Get the last activity in human readable format.
     */
    public function getLastActivityHumanAttribute()
    {
        return $this->last_activity->diffForHumans();
    }
}

