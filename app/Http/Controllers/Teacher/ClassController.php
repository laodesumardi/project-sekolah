<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    /**
     * Display a listing of teacher's classes.
     */
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        // Get filter parameters
        $selectedClass = $request->get('class', null);
        $selectedSubject = $request->get('subject', null);
        
        // Get classes taught by this teacher
        $classes = $teacher->teacherClasses()
            ->with(['subject', 'class'])
            ->get()
            ->groupBy('class.name');
        
        // Apply filters if any
        if ($selectedClass) {
            $classes = $classes->filter(function ($classData, $className) use ($selectedClass) {
                return $className === $selectedClass;
            });
        }
        
        if ($selectedSubject) {
            $classes = $classes->filter(function ($classData) use ($selectedSubject) {
                return $classData->contains('subject.name', $selectedSubject);
            });
        }
        
        // Get class statistics
        $stats = $this->getClassStats($teacher);
        
        // Get filter options
        $filterOptions = $this->getFilterOptions($teacher);
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($teacher);
        
        // Get upcoming schedules
        $upcomingSchedules = $this->getUpcomingSchedules($teacher);
        
        return view('teacher.kelas.index', compact(
            'teacher', 
            'classes', 
            'stats', 
            'filterOptions',
            'recentActivities',
            'upcomingSchedules',
            'selectedClass',
            'selectedSubject'
        ));
    }
    
    /**
     * Display students in a specific class.
     */
    public function show($classId, Request $request)
    {
        $teacher = Auth::user()->teacher;
        $class = SchoolClass::findOrFail($classId);
        
        // Get filter parameters
        $search = $request->get('search', '');
        $sortBy = $request->get('sort', 'nis');
        $sortOrder = $request->get('order', 'asc');
        
        // Get students in this class with filters
        $studentsQuery = Profile::where('class_id', $classId)
            ->with(['user', 'academicYear']);
        
        if ($search) {
            $studentsQuery->whereHas('user', function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });
        }
        
        $students = $studentsQuery->orderBy($sortBy, $sortOrder)->get();
        
        // Get class statistics
        $stats = $this->getClassDetailStats($classId);
        
        // Get recent activities for this class
        $activities = $this->getClassActivities($classId);
        
        // Get attendance summary
        $attendanceSummary = $this->getAttendanceSummary($classId);
        
        // Get grade summary
        $gradeSummary = $this->getGradeSummary($classId);
        
        // Get class performance metrics
        $performanceMetrics = $this->getPerformanceMetrics($classId);
        
        // Get upcoming assignments
        $upcomingAssignments = $this->getUpcomingAssignments($classId);
        
        // Get class announcements
        $announcements = $this->getClassAnnouncements($classId);
        
        return view('teacher.kelas.show', compact(
            'class', 
            'students', 
            'stats', 
            'activities',
            'attendanceSummary',
            'gradeSummary',
            'performanceMetrics',
            'upcomingAssignments',
            'announcements',
            'search',
            'sortBy',
            'sortOrder'
        ));
    }
    
    /**
     * Get class statistics.
     */
    private function getClassStats($teacher)
    {
        $totalClasses = $teacher->teachingClasses()->distinct('class_id')->count();
        $totalStudents = $teacher->total_students;
        
        // Get class breakdown
        $classBreakdown = $teacher->teacherClasses()
            ->with(['subject', 'class'])
            ->get()
            ->groupBy('class.name')
            ->map(function ($classItems, $className) {
                return [
                    'name' => $className,
                    'subjects' => $classItems->pluck('subject.name')->toArray(),
                    'student_count' => rand(25, 35) // Placeholder
                ];
            });
        
        return [
            'total_classes' => $totalClasses,
            'total_students' => $totalStudents,
            'class_breakdown' => $classBreakdown
        ];
    }
    
    /**
     * Get detailed class statistics.
     */
    private function getClassDetailStats($classId)
    {
        $class = SchoolClass::find($classId);
        $totalStudents = Profile::where('class_id', $classId)->count();
        
        // Get attendance stats (placeholder)
        $attendanceStats = [
            'present' => rand(20, $totalStudents),
            'absent' => rand(0, 5),
            'late' => rand(0, 3)
        ];
        
        // Get grade stats (placeholder)
        $gradeStats = [
            'average' => rand(75, 95),
            'highest' => rand(90, 100),
            'lowest' => rand(60, 80)
        ];
        
        return [
            'total_students' => $totalStudents,
            'attendance' => $attendanceStats,
            'grades' => $gradeStats
        ];
    }
    
    /**
     * Get recent class activities.
     */
    private function getClassActivities($classId)
    {
        // Placeholder - implement with actual activity data
        return collect([
            (object)[
                'type' => 'assignment',
                'title' => 'Tugas Matematika Dikumpulkan',
                'description' => '25 dari 30 siswa mengumpulkan tugas',
                'time' => '2 jam yang lalu',
                'created_at' => now()->subHours(2)
            ],
            (object)[
                'type' => 'attendance',
                'title' => 'Absensi Hari Ini',
                'description' => '28 siswa hadir, 2 siswa tidak hadir',
                'time' => '4 jam yang lalu',
                'created_at' => now()->subHours(4)
            ],
            (object)[
                'type' => 'grade',
                'title' => 'Nilai UTS Diinput',
                'description' => 'Nilai UTS Matematika untuk semua siswa',
                'time' => '1 hari yang lalu',
                'created_at' => now()->subDay()
            ]
        ]);
    }
    
    /**
     * Get filter options for classes.
     */
    private function getFilterOptions($teacher)
    {
        $classes = $teacher->teacherClasses()
            ->with(['subject', 'class'])
            ->get()
            ->groupBy('class.name');
        
        $classNames = $classes->keys()->toArray();
        $subjects = $classes->flatten()->pluck('subject.name')->unique()->toArray();
        
        return [
            'classes' => $classNames,
            'subjects' => $subjects
        ];
    }
    
    /**
     * Get recent activities for teacher.
     */
    private function getRecentActivities($teacher)
    {
        // Placeholder - implement with actual activity data
        return collect([
            (object)[
                'type' => 'class_activity',
                'title' => 'Kelas VII A - Matematika',
                'description' => 'Materi baru: Persamaan Linear',
                'time' => '1 jam yang lalu',
                'created_at' => now()->subHour()
            ],
            (object)[
                'type' => 'assignment',
                'title' => 'Tugas Dikumpulkan',
                'description' => 'VII B - 28 dari 30 siswa mengumpulkan tugas',
                'time' => '3 jam yang lalu',
                'created_at' => now()->subHours(3)
            ],
            (object)[
                'type' => 'grade',
                'title' => 'Nilai Diinput',
                'description' => 'VIII A - UTS Matematika',
                'time' => '1 hari yang lalu',
                'created_at' => now()->subDay()
            ]
        ]);
    }
    
    /**
     * Get upcoming schedules for teacher.
     */
    private function getUpcomingSchedules($teacher)
    {
        // Placeholder - implement with actual schedule data
        return collect([
            (object)[
                'class' => 'VII A',
                'subject' => 'Matematika',
                'time' => '08:00 - 08:45',
                'room' => 'A-101',
                'date' => now()->addDay()->format('d M Y'),
                'day' => 'Besok'
            ],
            (object)[
                'class' => 'VII B',
                'subject' => 'Matematika',
                'time' => '09:00 - 09:45',
                'room' => 'A-102',
                'date' => now()->addDay()->format('d M Y'),
                'day' => 'Besok'
            ],
            (object)[
                'class' => 'VIII A',
                'subject' => 'Matematika',
                'time' => '10:00 - 10:45',
                'room' => 'A-103',
                'date' => now()->addDays(2)->format('d M Y'),
                'day' => 'Lusa'
            ]
        ]);
    }
    
    /**
     * Get class performance analytics.
     */
    public function analytics($classId)
    {
        $teacher = Auth::user()->teacher;
        $class = SchoolClass::findOrFail($classId);
        
        // Get performance data (placeholder)
        $analytics = [
            'attendance_trend' => $this->getAttendanceTrend($classId),
            'grade_distribution' => $this->getGradeDistribution($classId),
            'subject_performance' => $this->getSubjectPerformance($classId),
            'student_progress' => $this->getStudentProgress($classId)
        ];
        
        return view('teacher.kelas.analytics', compact('class', 'analytics'));
    }
    
    /**
     * Get attendance trend data.
     */
    private function getAttendanceTrend($classId)
    {
        // Placeholder data
        return [
            'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
            'datasets' => [
                [
                    'label' => 'Kehadiran',
                    'data' => [28, 30, 27, 29, 28],
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)'
                ]
            ]
        ];
    }
    
    /**
     * Get grade distribution data.
     */
    private function getGradeDistribution($classId)
    {
        // Placeholder data
        return [
            'A' => 8,
            'B' => 12,
            'C' => 6,
            'D' => 2,
            'E' => 1
        ];
    }
    
    /**
     * Get subject performance data.
     */
    private function getSubjectPerformance($classId)
    {
        // Placeholder data
        return [
            'Matematika' => 85,
            'IPA' => 78,
            'Bahasa Indonesia' => 82,
            'Bahasa Inggris' => 75
        ];
    }
    
    /**
     * Get student progress data.
     */
    private function getStudentProgress($classId)
    {
        // Placeholder data
        return collect([
            (object)[
                'name' => 'Ahmad Rizki',
                'nis' => '2024001',
                'progress' => 85,
                'trend' => 'up'
            ],
            (object)[
                'name' => 'Siti Aminah',
                'nis' => '2024002',
                'progress' => 92,
                'trend' => 'up'
            ],
            (object)[
                'name' => 'Budi Santoso',
                'nis' => '2024003',
                'progress' => 78,
                'trend' => 'down'
            ]
        ]);
    }
    
    /**
     * Export class data.
     */
    public function export($classId, $format = 'pdf')
    {
        $teacher = Auth::user()->teacher;
        $class = SchoolClass::findOrFail($classId);
        $students = Profile::where('class_id', $classId)->with('user')->get();
        
        if ($format === 'excel') {
            return $this->exportToExcel($class, $students);
        }
        
        return $this->exportToPdf($class, $students);
    }
    
    /**
     * Export to Excel.
     */
    private function exportToExcel($class, $students)
    {
        // Placeholder - implement Excel export
        return response()->json([
            'message' => 'Excel export functionality will be implemented',
            'class' => $class->name,
            'student_count' => $students->count()
        ]);
    }
    
    /**
     * Export to PDF.
     */
    private function exportToPdf($class, $students)
    {
        // Placeholder - implement PDF export
        return response()->json([
            'message' => 'PDF export functionality will be implemented',
            'class' => $class->name,
            'student_count' => $students->count()
        ]);
    }
    
    /**
     * Get attendance summary for class.
     */
    private function getAttendanceSummary($classId)
    {
        $totalStudents = Profile::where('class_id', $classId)->count();
        
        // Placeholder data - implement with actual attendance data
        return [
            'total_students' => $totalStudents,
            'present_today' => rand($totalStudents - 5, $totalStudents),
            'absent_today' => rand(0, 5),
            'late_today' => rand(0, 3),
            'attendance_rate' => rand(85, 100),
            'weekly_average' => rand(80, 95)
        ];
    }
    
    /**
     * Get grade summary for class.
     */
    private function getGradeSummary($classId)
    {
        // Placeholder data - implement with actual grade data
        return [
            'average_grade' => rand(75, 95),
            'highest_grade' => rand(90, 100),
            'lowest_grade' => rand(60, 80),
            'grade_distribution' => [
                'A' => rand(5, 15),
                'B' => rand(10, 20),
                'C' => rand(5, 15),
                'D' => rand(0, 5),
                'E' => rand(0, 3)
            ],
            'improvement_rate' => rand(5, 25)
        ];
    }
    
    /**
     * Get performance metrics for class.
     */
    private function getPerformanceMetrics($classId)
    {
        // Placeholder data - implement with actual performance data
        return [
            'participation_rate' => rand(70, 95),
            'assignment_completion' => rand(80, 100),
            'quiz_average' => rand(75, 90),
            'homework_completion' => rand(85, 100),
            'behavior_score' => rand(80, 100)
        ];
    }
    
    /**
     * Get upcoming assignments for class.
     */
    private function getUpcomingAssignments($classId)
    {
        // Placeholder data - implement with actual assignment data
        return collect([
            (object)[
                'title' => 'Tugas Matematika - Persamaan Linear',
                'subject' => 'Matematika',
                'due_date' => now()->addDays(3),
                'submitted' => rand(15, 30),
                'total' => 30,
                'status' => 'active'
            ],
            (object)[
                'title' => 'Essay Bahasa Indonesia',
                'subject' => 'Bahasa Indonesia',
                'due_date' => now()->addDays(5),
                'submitted' => rand(5, 15),
                'total' => 30,
                'status' => 'active'
            ],
            (object)[
                'title' => 'Laporan Praktikum IPA',
                'subject' => 'IPA',
                'due_date' => now()->addDays(7),
                'submitted' => 0,
                'total' => 30,
                'status' => 'upcoming'
            ]
        ]);
    }
    
    /**
     * Get class announcements.
     */
    private function getClassAnnouncements($classId)
    {
        // Placeholder data - implement with actual announcement data
        return collect([
            (object)[
                'title' => 'Ujian Tengah Semester',
                'content' => 'Ujian Tengah Semester akan dilaksanakan pada tanggal 15-20 Oktober 2024.',
                'author' => 'Kepala Sekolah',
                'created_at' => now()->subDays(2),
                'priority' => 'high'
            ],
            (object)[
                'title' => 'Pembagian Rapor',
                'content' => 'Pembagian rapor akan dilaksanakan pada tanggal 25 Oktober 2024.',
                'author' => 'Wali Kelas',
                'created_at' => now()->subDay(),
                'priority' => 'medium'
            ],
            (object)[
                'title' => 'Ekstrakurikuler',
                'content' => 'Pendaftaran ekstrakurikuler dibuka mulai hari ini.',
                'author' => 'Guru Pembina',
                'created_at' => now()->subHours(6),
                'priority' => 'low'
            ]
        ]);
    }
    
    /**
     * Input attendance for class.
     */
    public function inputAttendance($classId)
    {
        $teacher = Auth::user()->teacher;
        $class = SchoolClass::findOrFail($classId);
        $students = Profile::where('class_id', $classId)->with('user')->get();
        
        return view('teacher.kelas.attendance', compact('class', 'students'));
    }
    
    /**
     * Store attendance data.
     */
    public function storeAttendance(Request $request, $classId)
    {
        // Placeholder - implement attendance storage
        return response()->json([
            'message' => 'Attendance data saved successfully',
            'class_id' => $classId,
            'attendance_count' => count($request->attendance ?? [])
        ]);
    }
    
    /**
     * Input grades for class.
     */
    public function inputGrades($classId)
    {
        $teacher = Auth::user()->teacher;
        $class = SchoolClass::findOrFail($classId);
        $students = Profile::where('class_id', $classId)->with('user')->get();
        
        return view('teacher.kelas.grades', compact('class', 'students'));
    }
    
    /**
     * Store grade data.
     */
    public function storeGrades(Request $request, $classId)
    {
        // Placeholder - implement grade storage
        return response()->json([
            'message' => 'Grade data saved successfully',
            'class_id' => $classId,
            'grades_count' => count($request->grades ?? [])
        ]);
    }
    
    /**
     * Get student details.
     */
    public function studentDetails($classId, $studentId)
    {
        $teacher = Auth::user()->teacher;
        $class = SchoolClass::findOrFail($classId);
        $student = Profile::where('id', $studentId)
            ->where('class_id', $classId)
            ->with(['user', 'academicYear'])
            ->firstOrFail();
        
        // Get student performance data
        $performance = $this->getStudentPerformance($studentId);
        
        return view('teacher.kelas.student-details', compact('class', 'student', 'performance'));
    }
    
    /**
     * Get student performance data.
     */
    private function getStudentPerformance($studentId)
    {
        // Placeholder data - implement with actual performance data
        return [
            'attendance_rate' => rand(80, 100),
            'average_grade' => rand(75, 95),
            'assignment_completion' => rand(80, 100),
            'participation_score' => rand(70, 95),
            'behavior_score' => rand(80, 100),
            'recent_grades' => [
                'Matematika' => rand(70, 95),
                'IPA' => rand(75, 90),
                'Bahasa Indonesia' => rand(80, 95),
                'Bahasa Inggris' => rand(70, 85)
            ]
        ];
    }
}
