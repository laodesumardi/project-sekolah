<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Get all messages for the student.
     */
    public function index()
    {
        $student = Auth::user()->profile;
        
        // Get messages (placeholder data for now)
        $messages = collect([
            (object) [
                'id' => 1,
                'from' => 'Bu Sari (Guru Matematika)',
                'from_avatar' => 'https://ui-avatars.com/api/?name=Bu+Sari&background=3b82f6&color=ffffff',
                'subject' => 'Pertanyaan tentang Tugas Matematika',
                'message' => 'Halo, saya ingin bertanya tentang soal nomor 5 di tugas matematika...',
                'is_read' => false,
                'created_at' => now()->subHours(1),
                'type' => 'teacher',
                'priority' => 'normal'
            ],
            (object) [
                'id' => 2,
                'from' => 'Pak Budi (Wali Kelas)',
                'from_avatar' => 'https://ui-avatars.com/api/?name=Pak+Budi&background=10b981&color=ffffff',
                'subject' => 'Informasi Penting Kelas',
                'message' => 'Mohon perhatian, besok ada rapat orang tua siswa...',
                'is_read' => false,
                'created_at' => now()->subHours(3),
                'type' => 'homeroom',
                'priority' => 'high'
            ],
            (object) [
                'id' => 3,
                'from' => 'Admin Sekolah',
                'from_avatar' => 'https://ui-avatars.com/api/?name=Admin&background=6366f1&color=ffffff',
                'subject' => 'Pembaruan Sistem',
                'message' => 'Sistem akan mengalami maintenance pada hari Minggu...',
                'is_read' => true,
                'created_at' => now()->subDays(1),
                'type' => 'admin',
                'priority' => 'normal'
            ],
            (object) [
                'id' => 4,
                'from' => 'Bu Dewi (Guru Bahasa Indonesia)',
                'from_avatar' => 'https://ui-avatars.com/api/?name=Bu+Dewi&background=f59e0b&color=ffffff',
                'subject' => 'Feedback Essay',
                'message' => 'Essay Anda sudah saya baca, ada beberapa yang perlu diperbaiki...',
                'is_read' => true,
                'created_at' => now()->subDays(2),
                'type' => 'teacher',
                'priority' => 'normal'
            ]
        ]);
        
        $unreadCount = $messages->where('is_read', false)->count();
        
        return view('student.messages.index', compact('messages', 'unreadCount'));
    }
    
    /**
     * Show specific message.
     */
    public function show($id)
    {
        // Get message details (placeholder)
        $message = (object) [
            'id' => $id,
            'from' => 'Bu Sari (Guru Matematika)',
            'from_avatar' => 'https://ui-avatars.com/api/?name=Bu+Sari&background=3b82f6&color=ffffff',
            'subject' => 'Pertanyaan tentang Tugas Matematika',
            'message' => 'Halo, saya ingin bertanya tentang soal nomor 5 di tugas matematika. Bisakah Anda menjelaskan langkah-langkah penyelesaiannya? Terima kasih.',
            'is_read' => true,
            'created_at' => now()->subHours(1),
            'type' => 'teacher',
            'priority' => 'normal'
        ];
        
        return view('student.messages.show', compact('message'));
    }
    
    /**
     * Mark message as read.
     */
    public function markAsRead(Request $request, $id)
    {
        // In real implementation, update database
        return response()->json([
            'success' => true,
            'message' => 'Pesan telah ditandai sebagai dibaca'
        ]);
    }
    
    /**
     * Mark all messages as read.
     */
    public function markAllAsRead(Request $request)
    {
        // In real implementation, update database
        return response()->json([
            'success' => true,
            'message' => 'Semua pesan telah ditandai sebagai dibaca'
        ]);
    }
    
    /**
     * Get unread message count.
     */
    public function getUnreadCount()
    {
        // Placeholder count
        $count = 2;
        
        return response()->json([
            'count' => $count
        ]);
    }
    
    /**
     * Get recent messages for dropdown.
     */
    public function getRecent()
    {
        $messages = collect([
            (object) [
                'id' => 1,
                'from' => 'Bu Sari (Guru Matematika)',
                'from_avatar' => 'https://ui-avatars.com/api/?name=Bu+Sari&background=3b82f6&color=ffffff',
                'subject' => 'Pertanyaan tentang Tugas Matematika',
                'message' => 'Halo, saya ingin bertanya tentang soal nomor 5...',
                'is_read' => false,
                'created_at' => now()->subHours(1),
                'type' => 'teacher'
            ],
            (object) [
                'id' => 2,
                'from' => 'Pak Budi (Wali Kelas)',
                'from_avatar' => 'https://ui-avatars.com/api/?name=Pak+Budi&background=10b981&color=ffffff',
                'subject' => 'Informasi Penting Kelas',
                'message' => 'Mohon perhatian, besok ada rapat orang tua...',
                'is_read' => false,
                'created_at' => now()->subHours(3),
                'type' => 'homeroom'
            ]
        ]);
        
        return response()->json([
            'messages' => $messages,
            'unread_count' => $messages->where('is_read', false)->count()
        ]);
    }
    
    /**
     * Send new message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);
        
        // In real implementation, save to database
        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim'
        ]);
    }
}







