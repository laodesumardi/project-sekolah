<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the student.
     */
    public function index()
    {
        $student = Auth::user()->profile;
        
        // Get notifications (placeholder data for now)
        $notifications = collect([
            (object) [
                'id' => 1,
                'type' => 'assignment',
                'title' => 'Tugas Matematika Baru',
                'message' => 'Tugas Matematika tentang Aljabar telah diberikan. Deadline: 15 Oktober 2024',
                'is_read' => false,
                'created_at' => now()->subHours(2),
                'icon' => 'assignment',
                'color' => 'blue'
            ],
            (object) [
                'id' => 2,
                'type' => 'grade',
                'title' => 'Nilai Baru',
                'message' => 'Nilai Ujian Bahasa Indonesia telah diumumkan. Nilai Anda: 85',
                'is_read' => false,
                'created_at' => now()->subHours(5),
                'icon' => 'grade',
                'color' => 'green'
            ],
            (object) [
                'id' => 3,
                'type' => 'announcement',
                'title' => 'Pengumuman Sekolah',
                'message' => 'Libur semester akan dimulai tanggal 20 Desember 2024',
                'is_read' => true,
                'created_at' => now()->subDays(1),
                'icon' => 'announcement',
                'color' => 'yellow'
            ],
            (object) [
                'id' => 4,
                'type' => 'attendance',
                'title' => 'Absensi Diperbarui',
                'message' => 'Data absensi Anda telah diperbarui untuk minggu ini',
                'is_read' => false,
                'created_at' => now()->subDays(2),
                'icon' => 'attendance',
                'color' => 'orange'
            ],
            (object) [
                'id' => 5,
                'type' => 'schedule',
                'title' => 'Jadwal Berubah',
                'message' => 'Jadwal pelajaran hari Jumat telah diubah',
                'is_read' => true,
                'created_at' => now()->subDays(3),
                'icon' => 'schedule',
                'color' => 'purple'
            ]
        ]);
        
        $unreadCount = $notifications->where('is_read', false)->count();
        
        return view('student.notifications.index', compact('notifications', 'unreadCount'));
    }
    
    /**
     * Mark notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        // In real implementation, update database
        // For now, just return success
        return response()->json([
            'success' => true,
            'message' => 'Notifikasi telah ditandai sebagai dibaca'
        ]);
    }
    
    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        // In real implementation, update database
        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai sebagai dibaca'
        ]);
    }
    
    /**
     * Get unread notification count.
     */
    public function getUnreadCount()
    {
        // Placeholder count
        $count = 3;
        
        return response()->json([
            'count' => $count
        ]);
    }
    
    /**
     * Get recent notifications for dropdown.
     */
    public function getRecent()
    {
        $notifications = collect([
            (object) [
                'id' => 1,
                'type' => 'assignment',
                'title' => 'Tugas Matematika Baru',
                'message' => 'Tugas Matematika tentang Aljabar telah diberikan',
                'is_read' => false,
                'created_at' => now()->subHours(2),
                'icon' => 'assignment',
                'color' => 'blue'
            ],
            (object) [
                'id' => 2,
                'type' => 'grade',
                'title' => 'Nilai Baru',
                'message' => 'Nilai Ujian Bahasa Indonesia telah diumumkan',
                'is_read' => false,
                'created_at' => now()->subHours(5),
                'icon' => 'grade',
                'color' => 'green'
            ],
            (object) [
                'id' => 3,
                'type' => 'announcement',
                'title' => 'Pengumuman Sekolah',
                'message' => 'Libur semester akan dimulai tanggal 20 Desember',
                'is_read' => true,
                'created_at' => now()->subDays(1),
                'icon' => 'announcement',
                'color' => 'yellow'
            ]
        ]);
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $notifications->where('is_read', false)->count()
        ]);
    }
}









