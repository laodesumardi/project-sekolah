<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Get notifications for current user
     */
    public function index(Request $request)
    {
        $notifications = NotificationService::getUserNotifications(null, 20);
        $unreadCount = NotificationService::getUnreadCount();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount()
    {
        $count = NotificationService::getUnreadCount();
        
        return response()->json([
            'count' => $count,
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, $id)
    {
        $success = NotificationService::markAsRead($id);
        
        return response()->json([
            'success' => $success,
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $count = NotificationService::markAllAsRead();
        
        return response()->json([
            'success' => true,
            'marked_count' => $count,
        ]);
    }

    /**
     * Get notification details
     */
    public function show($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
            
        if (!$notification) {
            return response()->json([
                'error' => 'Notification not found'
            ], 404);
        }

        // Mark as read when viewed
        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return response()->json([
            'notification' => $notification,
        ]);
    }
}