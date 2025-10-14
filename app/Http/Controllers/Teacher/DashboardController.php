<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the teacher dashboard.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;
        
        // Get dashboard statistics
        $stats = $this->getDashboardStats($teacher);
        
        // Get today's schedule
        $todaySchedule = $this->getTodaySchedule($teacher);
        
        // Get pending tasks
        $pendingTasks = $this->getPendingTasksData($teacher);
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($teacher);
        
        // Get announcements
        $announcements = $this->getAnnouncements();
        
        return view('teacher.dashboard.index', compact(
            'teacher',
            'stats',
            'todaySchedule',
            'pendingTasks',
            'recentActivities',
            'announcements'
        ));
    }
    
    /**
     * Get dashboard statistics via AJAX.
     */
    public function getStats(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $stats = $this->getDashboardStats($teacher);
        
        return response()->json($stats);
    }
    
    /**
     * Get today's schedule via AJAX.
     */
    public function getScheduleToday(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $schedule = $this->getTodaySchedule($teacher);
        
        return response()->json($schedule);
    }
    
    /**
     * Get pending tasks via AJAX.
     */
    public function getPendingTasks(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $tasks = $this->getPendingTasksData($teacher);
        
        return response()->json($tasks);
    }
    
    /**
     * Get recent activities via AJAX.
     */
    public function getActivities(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $activities = $this->getRecentActivities($teacher);
        
        return response()->json($activities);
    }
    
    /**
     * Get dashboard statistics.
     */
    private function getDashboardStats($teacher)
    {
        return [
            'students' => [
                'total' => $teacher->total_students,
                'by_class' => [
                    ['class' => 'XI IPA 1', 'count' => 32],
                    ['class' => 'XI IPA 2', 'count' => 30],
                    ['class' => 'XI IPS', 'count' => 28],
                ]
            ],
            'tasks' => [
                'pending' => 5,
                'urgent' => 2,
                'recent' => [
                    ['title' => 'Tugas Matematika - Integral', 'class' => 'XI IPA 1', 'submissions' => '28/32', 'deadline' => '2025-10-15'],
                    ['title' => 'Essay Bahasa Indonesia', 'class' => 'XI IPS', 'submissions' => '15/28', 'deadline' => '2025-10-18'],
                    ['title' => 'Presentasi IPA', 'class' => 'XI IPA 2', 'submissions' => '25/30', 'deadline' => '2025-10-20'],
                ]
            ],
            'materials' => [
                'total' => 45,
                'this_week' => 3,
                'views' => 1250,
                'recent' => [
                    ['title' => 'Materi Aljabar', 'subject' => 'Matematika', 'views' => 85, 'date' => '2025-10-12'],
                    ['title' => 'Tata Bahasa', 'subject' => 'Bahasa Indonesia', 'views' => 72, 'date' => '2025-10-11'],
                    ['title' => 'Present Perfect', 'subject' => 'Bahasa Inggris', 'views' => 68, 'date' => '2025-10-10'],
                ]
            ],
            'schedule' => [
                'today_classes' => 4,
                'next_class' => [
                    'time' => '10:30-12:00',
                    'class' => 'XI IPA 1',
                    'subject' => 'Matematika',
                    'room' => 'A-101'
                ],
                'status' => 'upcoming'
            ]
        ];
    }
    
    /**
     * Get today's schedule.
     */
    private function getTodaySchedule($teacher)
    {
        // Placeholder - implement with actual schedule data
        return collect([
            (object)['time' => '07:00-08:30', 'class' => (object)['name' => 'XI IPA 1'], 'subject' => (object)['name' => 'Matematika'], 'room' => 'A-101', 'students' => 32, 'status' => 'completed'],
            (object)['time' => '08:45-10:15', 'class' => (object)['name' => 'XI IPA 2'], 'subject' => (object)['name' => 'Matematika'], 'room' => 'A-102', 'students' => 30, 'status' => 'current'],
            (object)['time' => '10:30-12:00', 'class' => (object)['name' => 'XI IPS'], 'subject' => (object)['name' => 'Bahasa Indonesia'], 'room' => 'A-103', 'students' => 28, 'status' => 'upcoming'],
            (object)['time' => '13:00-14:30', 'class' => (object)['name' => 'XI IPA 1'], 'subject' => (object)['name' => 'Matematika'], 'room' => 'A-101', 'students' => 32, 'status' => 'upcoming'],
        ]);
    }
    
    /**
     * Get pending tasks.
     */
    private function getPendingTasksData($teacher)
    {
        // Placeholder - implement with actual task data
        return collect([
            (object)['id' => 1, 'title' => 'Tugas Matematika - Integral', 'class' => 'XI IPA 1', 'subject' => 'Matematika', 'submissions' => '28/32', 'deadline' => '2025-10-15', 'progress' => 87],
            (object)['id' => 2, 'title' => 'Essay Bahasa Indonesia', 'class' => 'XI IPS', 'subject' => 'Bahasa Indonesia', 'submissions' => '15/28', 'deadline' => '2025-10-18', 'progress' => 54],
            (object)['id' => 3, 'title' => 'Presentasi IPA', 'class' => 'XI IPA 2', 'subject' => 'IPA', 'submissions' => '25/30', 'deadline' => '2025-10-20', 'progress' => 83],
        ]);
    }
    
    /**
     * Get recent activities.
     */
    private function getRecentActivities($teacher)
    {
        // Placeholder - implement with actual activity data
        return collect([
            (object)['type' => 'submission', 'title' => 'Siswa mengumpulkan tugas', 'description' => 'Ahmad mengumpulkan Tugas Matematika', 'time' => '2 jam yang lalu', 'created_at' => now()->subHours(2)],
            (object)['type' => 'material', 'title' => 'Materi diakses siswa', 'description' => 'Materi Aljabar diakses 15 siswa', 'time' => '4 jam yang lalu', 'created_at' => now()->subHours(4)],
            (object)['type' => 'grade', 'title' => 'Nilai baru diinput', 'description' => 'Nilai UTS Matematika XI IPA 1', 'time' => '1 hari yang lalu', 'created_at' => now()->subDay()],
            (object)['type' => 'message', 'title' => 'Pertanyaan dari siswa', 'description' => 'Sari bertanya tentang soal no. 5', 'time' => '2 hari yang lalu', 'created_at' => now()->subDays(2)],
        ]);
    }
    
    /**
     * Get announcements.
     */
    private function getAnnouncements()
    {
        // Placeholder - implement with actual announcement data
        return collect([
            (object)[
                'id' => 1,
                'title' => 'Rapat Guru Bulan Oktober',
                'content' => 'Rapat guru akan dilaksanakan pada tanggal 15 Oktober 2024 pukul 14:00 WIB di ruang guru.',
                'created_at' => now()->subDays(2),
                'published_at' => now()->subDays(2)
            ],
            (object)[
                'id' => 2,
                'title' => 'Pembagian Rapor Tengah Semester',
                'content' => 'Pembagian rapor tengah semester akan dilaksanakan pada tanggal 20 Oktober 2024.',
                'created_at' => now()->subDays(1),
                'published_at' => now()->subDays(1)
            ],
            (object)[
                'id' => 3,
                'title' => 'Pelatihan Teknologi Pendidikan',
                'content' => 'Pelatihan penggunaan platform pembelajaran digital akan diadakan pada tanggal 25 Oktober 2024.',
                'created_at' => now()->subHours(6),
                'published_at' => now()->subHours(6)
            ]
        ]);
    }
}