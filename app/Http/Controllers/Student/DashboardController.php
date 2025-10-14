<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function index()
    {
        $student = Auth::user()->profile;
        
        // Get dashboard statistics
        $stats = $this->getDashboardStats($student);
        
        // Get today's schedule (placeholder - you'll implement this later)
        $todaySchedule = $this->getTodaySchedule($student);
        
        // Get recent announcements
        $announcements = $this->getRecentAnnouncements();
        
        // Get pending tasks (placeholder)
        $pendingTasks = $this->getPendingTasks($student);
        
        // Get recent activities (placeholder)
        $recentActivities = $this->getRecentActivities($student);
        
        return view('student.dashboard.index', compact(
            'student',
            'stats',
            'todaySchedule',
            'announcements',
            'pendingTasks',
            'recentActivities'
        ));
    }
    
    /**
     * Get dashboard statistics via AJAX.
     */
    public function getStats(Request $request)
    {
        $student = Auth::user()->profile;
        $stats = $this->getDashboardStats($student);
        
        return response()->json($stats);
    }
    
    /**
     * Get recent activities via AJAX.
     */
    public function getActivities(Request $request)
    {
        $student = Auth::user()->profile;
        $activities = $this->getRecentActivities($student);
        
        return response()->json($activities);
    }
    
    /**
     * Get dashboard statistics.
     */
    private function getDashboardStats($student)
    {
        return [
            'attendance' => [
                'percentage' => 95,
                'present' => 19,
                'absent' => 1,
                'sick' => 0,
                'excused' => 0,
            ],
            'grades' => [
                'average' => 85.5,
                'class_average' => 82.3,
                'subjects' => [
                    ['name' => 'Matematika', 'grade' => 88],
                    ['name' => 'Bahasa Indonesia', 'grade' => 85],
                    ['name' => 'Bahasa Inggris', 'grade' => 82],
                    ['name' => 'IPA', 'grade' => 90],
                ]
            ],
            'tasks' => [
                'pending' => 3,
                'urgent' => 1,
                'recent' => [
                    ['title' => 'Tugas Matematika', 'deadline' => '2025-10-15', 'urgent' => true],
                    ['title' => 'Essay Bahasa Indonesia', 'deadline' => '2025-10-18', 'urgent' => false],
                    ['title' => 'Presentasi IPA', 'deadline' => '2025-10-20', 'urgent' => false],
                ]
            ],
            'materials' => [
                'new' => 5,
                'recent' => [
                    ['title' => 'Materi Aljabar', 'subject' => 'Matematika', 'date' => '2025-10-12'],
                    ['title' => 'Tata Bahasa', 'subject' => 'Bahasa Indonesia', 'date' => '2025-10-11'],
                    ['title' => 'Present Perfect', 'subject' => 'Bahasa Inggris', 'date' => '2025-10-10'],
                ]
            ]
        ];
    }
    
    /**
     * Get today's schedule.
     */
    private function getTodaySchedule($student)
    {
        // Placeholder - implement with actual schedule data
        return collect([
            (object) ['time' => '07:00-08:30', 'subject' => 'Matematika', 'teacher' => 'Bu Sari', 'room' => 'A-101', 'status' => 'completed'],
            (object) ['time' => '08:45-10:15', 'subject' => 'Bahasa Indonesia', 'teacher' => 'Pak Budi', 'room' => 'A-102', 'status' => 'current'],
            (object) ['time' => '10:30-12:00', 'subject' => 'Bahasa Inggris', 'teacher' => 'Bu Lisa', 'room' => 'A-103', 'status' => 'upcoming'],
            (object) ['time' => '13:00-14:30', 'subject' => 'IPA', 'teacher' => 'Pak Andi', 'room' => 'Lab-1', 'status' => 'upcoming'],
        ]);
    }
    
    /**
     * Get recent announcements.
     */
    private function getRecentAnnouncements()
    {
        try {
            return Announcement::published()
                ->active()
                ->forStudents()
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Return placeholder data if database error
            return collect([
                (object) [
                    'id' => 1,
                    'title' => 'Pengumuman Libur Semester',
                    'content' => 'Libur semester akan dimulai tanggal 20 Desember 2024',
                    'type' => 'school',
                    'published_at' => now()->subDays(1),
                    'excerpt' => 'Libur semester akan dimulai tanggal 20 Desember 2024'
                ],
                (object) [
                    'id' => 2,
                    'title' => 'Rapat Orang Tua Siswa',
                    'content' => 'Rapat orang tua siswa akan dilaksanakan pada tanggal 25 Oktober 2024',
                    'type' => 'school',
                    'published_at' => now()->subDays(2),
                    'excerpt' => 'Rapat orang tua siswa akan dilaksanakan pada tanggal 25 Oktober 2024'
                ]
            ]);
        }
    }
    
    /**
     * Get pending tasks.
     */
    private function getPendingTasks($student)
    {
        // Placeholder - implement with actual task data
        return collect([
            (object) ['id' => 1, 'title' => 'Tugas Matematika', 'subject' => 'Matematika', 'deadline' => '2025-10-15', 'urgent' => true],
            (object) ['id' => 2, 'title' => 'Essay Bahasa Indonesia', 'subject' => 'Bahasa Indonesia', 'deadline' => '2025-10-18', 'urgent' => false],
            (object) ['id' => 3, 'title' => 'Presentasi IPA', 'subject' => 'IPA', 'deadline' => '2025-10-20', 'urgent' => false],
        ]);
    }
    
    /**
     * Get recent activities.
     */
    private function getRecentActivities($student)
    {
        // Placeholder - implement with actual activity data
        return collect([
            (object) ['type' => 'material', 'title' => 'Materi baru diupload', 'description' => 'Aljabar - Matematika', 'time' => '2 jam yang lalu'],
            (object) ['type' => 'grade', 'title' => 'Nilai baru tersedia', 'description' => 'Ujian Matematika: 88', 'time' => '4 jam yang lalu'],
            (object) ['type' => 'task', 'title' => 'Tugas baru ditambahkan', 'description' => 'Essay Bahasa Indonesia', 'time' => '1 hari yang lalu'],
            (object) ['type' => 'announcement', 'title' => 'Pengumuman penting', 'description' => 'Libur nasional tanggal 17 Oktober', 'time' => '2 hari yang lalu'],
        ]);
    }
}