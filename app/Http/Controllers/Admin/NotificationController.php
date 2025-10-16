<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\UserRegistration;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = [];
        
        // Get unread messages (both from contact form and students)
        $unreadMessages = Message::where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        foreach ($unreadMessages as $message) {
            $messageType = $message->from_student_id ? 'student_message' : 'contact_message';
            $title = $message->from_student_id ? 'Pesan dari Siswa' : 'Pesan Kontak';
            $senderName = $message->from_student_id ? 
                ($message->student ? $message->student->name : $message->name) : 
                $message->name;
                
            $notifications[] = [
                'id' => 'message_' . $message->id,
                'type' => $messageType,
                'title' => $title,
                'message' => $senderName . ' mengirim pesan: ' . \Str::limit($message->subject, 50),
                'url' => route('admin.messages.show', $message),
                'created_at' => $message->created_at,
                'is_read' => $message->is_read
            ];
        }
        
        // Get recent student registrations
        $recentRegistrations = UserRegistration::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
            
        foreach ($recentRegistrations as $registration) {
            $notifications[] = [
                'id' => 'registration_' . $registration->id,
                'type' => 'registration',
                'title' => 'Pendaftaran Baru',
                'message' => $registration->full_name . ' mendaftar sebagai siswa baru',
                'url' => route('admin.ppdb.show', $registration),
                'created_at' => $registration->created_at,
                'is_read' => false
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

    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('id');
        
        if (strpos($notificationId, 'message_') === 0) {
            $messageId = str_replace('message_', '', $notificationId);
            $message = Message::find($messageId);
            if ($message) {
                $message->update(['is_read' => true]);
                return response()->json(['success' => true]);
            }
        }
        
        return response()->json(['success' => false, 'message' => 'Notification not found']);
    }

    public function delete(Request $request)
    {
        $notificationId = $request->input('id');
        
        if (strpos($notificationId, 'message_') === 0) {
            $messageId = str_replace('message_', '', $notificationId);
            $message = Message::find($messageId);
            if ($message) {
                $message->delete();
                return response()->json(['success' => true]);
            }
        }
        
        return response()->json(['success' => false, 'message' => 'Notification not found']);
    }
}
