<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     * Create a new notification
     */
    public static function create(array $data): Notification
    {
        return Notification::create($data);
    }

    /**
     * Create notification for all admins
     */
    public static function notifyAdmins(string $title, string $message, array $options = []): void
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            self::create([
                'type' => $options['type'] ?? 'info',
                'title' => $title,
                'message' => $message,
                'icon' => $options['icon'] ?? 'fas fa-bell',
                'color' => $options['color'] ?? 'blue',
                'data' => $options['data'] ?? null,
                'user_id' => $admin->id,
                'related_type' => $options['related_type'] ?? null,
                'related_id' => $options['related_id'] ?? null,
            ]);
        }
    }

    /**
     * Create notification for specific user
     */
    public static function notifyUser(int $userId, string $title, string $message, array $options = []): Notification
    {
        return self::create([
            'type' => $options['type'] ?? 'info',
            'title' => $title,
            'message' => $message,
            'icon' => $options['icon'] ?? 'fas fa-bell',
            'color' => $options['color'] ?? 'blue',
            'data' => $options['data'] ?? null,
            'user_id' => $userId,
            'related_type' => $options['related_type'] ?? null,
            'related_id' => $options['related_id'] ?? null,
        ]);
    }

    /**
     * Get unread notifications count for current user
     */
    public static function getUnreadCount(?int $userId = null): int
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return 0;
        }

        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get notifications for current user
     */
    public static function getUserNotifications(?int $userId = null, int $limit = 10)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return collect();
        }

        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Mark notification as read
     */
    public static function markAsRead(int $notificationId): bool
    {
        $notification = Notification::find($notificationId);
        
        if ($notification && $notification->user_id === Auth::id()) {
            $notification->markAsRead();
            return true;
        }

        return false;
    }

    /**
     * Mark all notifications as read for current user
     */
    public static function markAllAsRead(?int $userId = null): int
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return 0;
        }

        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    /**
     * Create PPDB registration notification
     */
    public static function notifyNewPPDBRegistration($registration): void
    {
        $title = 'Pendaftaran PPDB Baru';
        $message = "Siswa baru mendaftar: {$registration->full_name} ({$registration->registration_number})";
        
        self::notifyAdmins($title, $message, [
            'type' => 'success',
            'icon' => 'fas fa-user-plus',
            'color' => 'green',
            'related_type' => 'App\Models\UserRegistration',
            'related_id' => $registration->id,
            'data' => [
                'registration_number' => $registration->registration_number,
                'student_name' => $registration->full_name,
                'registration_type' => $registration->registration_type,
            ]
        ]);
    }
}
