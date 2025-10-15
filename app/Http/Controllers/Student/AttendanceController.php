<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\AcademicYear;
use App\Models\Subject;
use App\Models\SchoolClass;

class AttendanceController extends Controller
{
    /**
     * Display attendance dashboard.
     */
    public function index(Request $request)
    {
        $student = Auth::user()->profile;
        $currentYear = $this->getCurrentAcademicYear();
        
        // Get filter parameters
        $search = $request->get('search', '');
        $subject = $request->get('subject', '');
        $month = $request->get('month', date('Y-m'));
        $status = $request->get('status', '');
        
        // Get attendance data
        $attendance = $this->getAttendance($student, $search, $subject, $month, $status);
        
        // Get statistics
        $stats = $this->getAttendanceStats($student);
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($student);
        
        // Get monthly summary
        $monthlySummary = $this->getMonthlySummary($student);
        
        // Get attendance trends
        $attendanceTrends = $this->getAttendanceTrends($student);
        
        // Get filter options
        $filterOptions = $this->getFilterOptions($student);
        
        return view('student.absensi.index', compact(
            'attendance',
            'stats',
            'recentActivities',
            'monthlySummary',
            'attendanceTrends',
            'filterOptions',
            'search',
            'subject',
            'month',
            'status'
        ));
    }
    
    /**
     * Display specific subject attendance.
     */
    public function show($subjectId)
    {
        $student = Auth::user()->profile;
        $subject = $this->getSubjectById($subjectId);
        
        if (!$subject) {
            abort(404, 'Mata pelajaran tidak ditemukan');
        }
        
        // Get subject attendance
        $subjectAttendance = $this->getSubjectAttendance($student, $subjectId);
        
        // Get subject statistics
        $subjectStats = $this->getSubjectStats($subjectAttendance);
        
        // Get attendance history
        $attendanceHistory = $this->getAttendanceHistory($student, $subjectId);
        
        // Get teacher notes
        $teacherNotes = $this->getTeacherNotes($student, $subjectId);
        
        return view('student.absensi.show', compact(
            'subject',
            'subjectAttendance',
            'subjectStats',
            'attendanceHistory',
            'teacherNotes'
        ));
    }
    
    /**
     * Display attendance calendar.
     */
    public function calendar(Request $request)
    {
        $student = Auth::user()->profile;
        $month = $request->get('month', date('Y-m'));
        
        // Get calendar data
        $calendarData = $this->getCalendarData($student, $month);
        
        // Get monthly stats
        $monthlyStats = $this->getMonthlyStats($student, $month);
        
        return view('student.absensi.calendar', compact(
            'calendarData',
            'monthlyStats',
            'month'
        ));
    }
    
    /**
     * Export attendance report.
     */
    public function export(Request $request)
    {
        $student = Auth::user()->profile;
        $format = $request->get('format', 'pdf');
        $month = $request->get('month', date('Y-m'));
        
        // Generate report data
        $reportData = $this->getReportData($student, $month);
        
        // Placeholder for export functionality
        return response()->json([
            'message' => 'Laporan absensi berhasil diunduh',
            'filename' => 'laporan_absensi_' . $month . '.' . $format,
            'success' => true
        ]);
    }
    
    /**
     * Get current academic year.
     */
    private function getCurrentAcademicYear()
    {
        return AcademicYear::where('is_active', true)->first() ?? 
               AcademicYear::latest()->first();
    }
    
    /**
     * Get attendance with filters.
     */
    private function getAttendance($student, $search, $subject, $month, $status)
    {
        // Placeholder data - implement with actual attendance
        $attendance = collect([
            (object)[
                'id' => 1,
                'date' => now()->subDays(1),
                'subject' => 'Matematika',
                'teacher' => 'Bu Sari',
                'status' => 'present',
                'time_in' => '07:30',
                'time_out' => '09:00',
                'notes' => 'Hadir tepat waktu',
                'class' => 'VII A',
                'room' => 'Ruang 1'
            ],
            (object)[
                'id' => 2,
                'date' => now()->subDays(1),
                'subject' => 'IPA',
                'teacher' => 'Pak Budi',
                'status' => 'present',
                'time_in' => '09:15',
                'time_out' => '10:45',
                'notes' => 'Hadir tepat waktu',
                'class' => 'VII A',
                'room' => 'Lab IPA'
            ],
            (object)[
                'id' => 3,
                'date' => now()->subDays(2),
                'subject' => 'IPS',
                'teacher' => 'Bu Rina',
                'status' => 'late',
                'time_in' => '10:50',
                'time_out' => '12:20',
                'notes' => 'Terlambat 10 menit',
                'class' => 'VII A',
                'room' => 'Ruang 2'
            ],
            (object)[
                'id' => 4,
                'date' => now()->subDays(3),
                'subject' => 'Bahasa Indonesia',
                'teacher' => 'Bu Siti',
                'status' => 'present',
                'time_in' => '07:30',
                'time_out' => '09:00',
                'notes' => 'Hadir tepat waktu',
                'class' => 'VII A',
                'room' => 'Ruang 3'
            ],
            (object)[
                'id' => 5,
                'date' => now()->subDays(4),
                'subject' => 'Bahasa Inggris',
                'teacher' => 'Mr. John',
                'status' => 'absent',
                'time_in' => null,
                'time_out' => null,
                'notes' => 'Tidak hadir - sakit',
                'class' => 'VII A',
                'room' => 'Ruang 4'
            ],
            (object)[
                'id' => 6,
                'date' => now()->subDays(5),
                'subject' => 'TIK',
                'teacher' => 'Pak Andi',
                'status' => 'present',
                'time_in' => '09:15',
                'time_out' => '10:45',
                'notes' => 'Hadir tepat waktu',
                'class' => 'VII A',
                'room' => 'Lab Komputer'
            ],
            (object)[
                'id' => 7,
                'date' => now()->subDays(6),
                'subject' => 'PJOK',
                'teacher' => 'Pak Rudi',
                'status' => 'present',
                'time_in' => '10:50',
                'time_out' => '12:20',
                'notes' => 'Hadir tepat waktu',
                'class' => 'VII A',
                'room' => 'Lapangan'
            ],
            (object)[
                'id' => 8,
                'date' => now()->subDays(7),
                'subject' => 'Seni Budaya',
                'teacher' => 'Bu Maya',
                'status' => 'present',
                'time_in' => '07:30',
                'time_out' => '09:00',
                'notes' => 'Hadir tepat waktu',
                'class' => 'VII A',
                'room' => 'Ruang Seni'
            ]
        ]);
        
        // Apply filters
        if ($search) {
            $attendance = $attendance->filter(function($item) use ($search) {
                return stripos($item->subject, $search) !== false || 
                       stripos($item->teacher, $search) !== false ||
                       stripos($item->notes, $search) !== false;
            });
        }
        
        if ($subject) {
            $attendance = $attendance->filter(function($item) use ($subject) {
                return $item->subject === $subject;
            });
        }
        
        if ($month) {
            $attendance = $attendance->filter(function($item) use ($month) {
                return $item->date->format('Y-m') === $month;
            });
        }
        
        if ($status) {
            $attendance = $attendance->filter(function($item) use ($status) {
                return $item->status === $status;
            });
        }
        
        return $attendance;
    }
    
    /**
     * Get attendance statistics.
     */
    private function getAttendanceStats($student)
    {
        return [
            'total_days' => 20,
            'present_days' => 18,
            'late_days' => 1,
            'absent_days' => 1,
            'attendance_rate' => 90.0,
            'punctuality_rate' => 94.4,
            'current_streak' => 5,
            'longest_streak' => 12
        ];
    }
    
    /**
     * Get recent activities.
     */
    private function getRecentActivities($student)
    {
        return collect([
            (object)[
                'id' => 1,
                'type' => 'attendance_recorded',
                'title' => 'Absensi Matematika',
                'subject' => 'Matematika',
                'status' => 'present',
                'created_at' => now()->subHours(2)
            ],
            (object)[
                'id' => 2,
                'type' => 'late_marked',
                'title' => 'Terlambat IPS',
                'subject' => 'IPS',
                'status' => 'late',
                'created_at' => now()->subDays(1)
            ],
            (object)[
                'id' => 3,
                'type' => 'absence_excused',
                'title' => 'Izin tidak hadir',
                'subject' => 'Bahasa Inggris',
                'status' => 'absent',
                'created_at' => now()->subDays(2)
            ]
        ]);
    }
    
    /**
     * Get monthly summary.
     */
    private function getMonthlySummary($student)
    {
        return [
            'current_month' => [
                'total_days' => 20,
                'present' => 18,
                'late' => 1,
                'absent' => 1,
                'attendance_rate' => 90.0
            ],
            'previous_month' => [
                'total_days' => 22,
                'present' => 21,
                'late' => 0,
                'absent' => 1,
                'attendance_rate' => 95.5
            ]
        ];
    }
    
    /**
     * Get attendance trends.
     */
    private function getAttendanceTrends($student)
    {
        return [
            'weekly_trend' => [
                'week_1' => 95.0,
                'week_2' => 90.0,
                'week_3' => 85.0,
                'week_4' => 90.0
            ],
            'subject_performance' => [
                'Matematika' => 100.0,
                'IPA' => 95.0,
                'IPS' => 85.0,
                'Bahasa Indonesia' => 90.0,
                'Bahasa Inggris' => 80.0,
                'TIK' => 100.0,
                'PJOK' => 95.0,
                'Seni Budaya' => 90.0
            ],
            'trend' => 'stable',
            'recommendations' => [
                'Tingkatkan kehadiran di mata pelajaran Bahasa Inggris',
                'Pertahankan kehadiran yang baik di mata pelajaran eksakta'
            ]
        ];
    }
    
    /**
     * Get filter options.
     */
    private function getFilterOptions($student)
    {
        return [
            'subjects' => ['Matematika', 'IPA', 'IPS', 'Bahasa Indonesia', 'Bahasa Inggris', 'TIK', 'PJOK', 'Seni Budaya'],
            'statuses' => ['present', 'late', 'absent', 'excused'],
            'months' => [
                '2024-01' => 'Januari 2024',
                '2024-02' => 'Februari 2024',
                '2024-03' => 'Maret 2024',
                '2024-04' => 'April 2024',
                '2024-05' => 'Mei 2024',
                '2024-06' => 'Juni 2024'
            ]
        ];
    }
    
    /**
     * Get subject by ID.
     */
    private function getSubjectById($subjectId)
    {
        $subjects = [
            1 => (object)['id' => 1, 'name' => 'Matematika', 'teacher' => 'Bu Sari'],
            2 => (object)['id' => 2, 'name' => 'IPA', 'teacher' => 'Pak Budi'],
            3 => (object)['id' => 3, 'name' => 'IPS', 'teacher' => 'Bu Rina'],
            4 => (object)['id' => 4, 'name' => 'Bahasa Indonesia', 'teacher' => 'Bu Siti'],
            5 => (object)['id' => 5, 'name' => 'Bahasa Inggris', 'teacher' => 'Mr. John'],
            6 => (object)['id' => 6, 'name' => 'TIK', 'teacher' => 'Pak Andi'],
            7 => (object)['id' => 7, 'name' => 'PJOK', 'teacher' => 'Pak Rudi'],
            8 => (object)['id' => 8, 'name' => 'Seni Budaya', 'teacher' => 'Bu Maya']
        ];
        
        return $subjects[$subjectId] ?? null;
    }
    
    /**
     * Get subject attendance.
     */
    private function getSubjectAttendance($student, $subjectId)
    {
        $allAttendance = $this->getAttendance($student, '', '', '', '');
        return $allAttendance->filter(function($attendance) use ($subjectId) {
            return $attendance->subject === $this->getSubjectById($subjectId)->name;
        });
    }
    
    /**
     * Get subject statistics.
     */
    private function getSubjectStats($subjectAttendance)
    {
        if ($subjectAttendance->isEmpty()) {
            return [
                'total_sessions' => 0,
                'present' => 0,
                'late' => 0,
                'absent' => 0,
                'attendance_rate' => 0
            ];
        }
        
        $total = $subjectAttendance->count();
        $present = $subjectAttendance->where('status', 'present')->count();
        $late = $subjectAttendance->where('status', 'late')->count();
        $absent = $subjectAttendance->where('status', 'absent')->count();
        
        return [
            'total_sessions' => $total,
            'present' => $present,
            'late' => $late,
            'absent' => $absent,
            'attendance_rate' => $total > 0 ? round(($present + $late) / $total * 100, 1) : 0
        ];
    }
    
    /**
     * Get attendance history.
     */
    private function getAttendanceHistory($student, $subjectId)
    {
        return collect([
            (object)['date' => now()->subDays(1), 'status' => 'present', 'time_in' => '07:30'],
            (object)['date' => now()->subDays(2), 'status' => 'late', 'time_in' => '07:40'],
            (object)['date' => now()->subDays(3), 'status' => 'present', 'time_in' => '07:30'],
            (object)['date' => now()->subDays(4), 'status' => 'absent', 'time_in' => null],
            (object)['date' => now()->subDays(5), 'status' => 'present', 'time_in' => '07:30']
        ]);
    }
    
    /**
     * Get teacher notes.
     */
    private function getTeacherNotes($student, $subjectId)
    {
        return collect([
            (object)[
                'teacher' => 'Bu Sari',
                'note' => 'Kehadiran sangat baik, selalu tepat waktu.',
                'date' => now()->subDays(1)
            ],
            (object)[
                'teacher' => 'Bu Sari',
                'note' => 'Perlu perbaikan dalam ketepatan waktu.',
                'date' => now()->subDays(3)
            ]
        ]);
    }
    
    /**
     * Get calendar data.
     */
    private function getCalendarData($student, $month)
    {
        $startDate = \Carbon\Carbon::parse($month . '-01');
        $endDate = $startDate->copy()->endOfMonth();
        
        $calendar = [];
        $current = $startDate->copy()->startOfWeek();
        
        while ($current->lte($endDate->copy()->endOfWeek())) {
            $day = $current->copy();
            $attendance = $this->getAttendanceForDate($student, $day);
            
            $calendar[] = [
                'date' => $day,
                'attendance' => $attendance,
                'is_current_month' => $day->format('Y-m') === $month,
                'is_today' => $day->isToday()
            ];
            
            $current->addDay();
        }
        
        return $calendar;
    }
    
    /**
     * Get attendance for specific date.
     */
    private function getAttendanceForDate($student, $date)
    {
        // Placeholder - implement with actual data
        $attendance = $this->getAttendance($student, '', '', $date->format('Y-m'), '');
        
        if ($attendance->isEmpty()) {
            return null;
        }
        
        $statuses = $attendance->pluck('status')->toArray();
        
        if (in_array('absent', $statuses)) {
            return 'absent';
        } elseif (in_array('late', $statuses)) {
            return 'late';
        } else {
            return 'present';
        }
    }
    
    /**
     * Get monthly stats.
     */
    private function getMonthlyStats($student, $month)
    {
        return [
            'total_days' => 20,
            'present_days' => 18,
            'late_days' => 1,
            'absent_days' => 1,
            'attendance_rate' => 90.0,
            'best_day' => 'Senin',
            'worst_day' => 'Jumat'
        ];
    }
    
    /**
     * Get report data.
     */
    private function getReportData($student, $month)
    {
        return [
            'student_info' => [
                'name' => $student->user->name,
                'nis' => $student->nis,
                'class' => 'VII A',
                'month' => $month
            ],
            'attendance_summary' => [
                'total_days' => 20,
                'present' => 18,
                'late' => 1,
                'absent' => 1,
                'attendance_rate' => 90.0
            ],
            'daily_attendance' => $this->getAttendance($student, '', '', $month, ''),
            'subject_breakdown' => [
                'Matematika' => ['present' => 5, 'late' => 0, 'absent' => 0],
                'IPA' => ['present' => 5, 'late' => 0, 'absent' => 0],
                'IPS' => ['present' => 4, 'late' => 1, 'absent' => 0],
                'Bahasa Indonesia' => ['present' => 5, 'late' => 0, 'absent' => 0],
                'Bahasa Inggris' => ['present' => 4, 'late' => 0, 'absent' => 1],
                'TIK' => ['present' => 5, 'late' => 0, 'absent' => 0],
                'PJOK' => ['present' => 5, 'late' => 0, 'absent' => 0],
                'Seni Budaya' => ['present' => 5, 'late' => 0, 'absent' => 0]
            ]
        ];
    }
}




