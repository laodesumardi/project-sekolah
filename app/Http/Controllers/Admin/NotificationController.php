<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Registration;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = [];
        
        // Get unread messages
        $unreadMessages = Message::where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        foreach ($unreadMessages as $message) {
            $notifications[] = [
                'type' => 'message',
                'title' => 'Pesan Baru',
                'message' => $message->name . ' mengirim pesan: ' . \Str::limit($message->subject, 50),
                'url' => route('admin.messages.show', $message),
                'created_at' => $message->created_at
            ];
        }
        
        // Get recent student registrations
        $recentRegistrations = Registration::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
            
        foreach ($recentRegistrations as $registration) {
            $notifications[] = [
                'type' => 'registration',
                'title' => 'Pendaftaran Baru',
                'message' => $registration->full_name . ' mendaftar sebagai siswa baru',
                'url' => route('admin.ppdb.show', $registration),
                'created_at' => $registration->created_at
            ];
        }
        
        // Sort by created_at desc
        usort($notifications, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        return response()->json([
            'notifications' => $notifications,
            'count' => count($notifications)
        ]);
    }
}
