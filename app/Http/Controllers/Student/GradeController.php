<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\AcademicYear;
use App\Models\Subject;
use App\Models\SchoolClass;

class GradeController extends Controller
{
    /**
     * Display grades and report dashboard.
     */
    public function index(Request $request)
    {
        $student = Auth::user()->profile;
        $currentYear = $this->getCurrentAcademicYear();
        
        // Get filter parameters
        $search = $request->get('search', '');
        $subject = $request->get('subject', '');
        $semester = $request->get('semester', '');
        $period = $request->get('period', '');
        
        // Get grades data
        $grades = $this->getGrades($student, $search, $subject, $semester, $period);
        
        // Get statistics
        $stats = $this->getGradeStats($student);
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($student);
        
        // Get academic progress
        $academicProgress = $this->getAcademicProgress($student);
        
        // Get performance analytics
        $analytics = $this->getPerformanceAnalytics($student);
        
        // Get filter options
        $filterOptions = $this->getFilterOptions($student);
        
        return view('student.nilai.index', compact(
            'grades',
            'stats',
            'recentActivities',
            'academicProgress',
            'analytics',
            'filterOptions',
            'search',
            'subject',
            'semester',
            'period'
        ));
    }
    
    /**
     * Display specific subject grades.
     */
    public function show($subjectId)
    {
        $student = Auth::user()->profile;
        $subject = $this->getSubjectById($subjectId);
        
        if (!$subject) {
            abort(404, 'Mata pelajaran tidak ditemukan');
        }
        
        // Get subject grades
        $subjectGrades = $this->getSubjectGrades($student, $subjectId);
        
        // Get subject statistics
        $subjectStats = $this->getSubjectStats($subjectGrades);
        
        // Get grade history
        $gradeHistory = $this->getGradeHistory($student, $subjectId);
        
        // Get teacher feedback
        $teacherFeedback = $this->getTeacherFeedback($student, $subjectId);
        
        return view('student.nilai.show', compact(
            'subject',
            'subjectGrades',
            'subjectStats',
            'gradeHistory',
            'teacherFeedback'
        ));
    }
    
    /**
     * Display report card.
     */
    public function report(Request $request)
    {
        $student = Auth::user()->profile;
        $semester = $request->get('semester', '1');
        $academicYear = $request->get('academic_year', $this->getCurrentAcademicYear()->id);
        
        // Get report data
        $reportData = $this->getReportData($student, $semester, $academicYear);
        
        // Get report statistics
        $reportStats = $this->getReportStats($reportData);
        
        // Get academic year options
        $academicYears = $this->getAcademicYearOptions();
        
        return view('student.nilai.report', compact(
            'reportData',
            'reportStats',
            'academicYears',
            'semester',
            'academicYear'
        ));
    }
    
    /**
     * Download report card.
     */
    public function downloadReport(Request $request)
    {
        $student = Auth::user()->profile;
        $semester = $request->get('semester', '1');
        $academicYear = $request->get('academic_year', $this->getCurrentAcademicYear()->id);
        
        // Generate PDF report
        $reportData = $this->getReportData($student, $semester, $academicYear);
        
        // Placeholder for PDF generation
        return response()->json([
            'message' => 'Rapor berhasil diunduh',
            'filename' => 'rapor_semester_' . $semester . '.pdf',
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
     * Get grades with filters.
     */
    private function getGrades($student, $search, $subject, $semester, $period)
    {
        // Placeholder data - implement with actual grades
        $grades = collect([
            (object)[
                'id' => 1,
                'subject' => 'Matematika',
                'teacher' => 'Bu Sari',
                'semester' => 1,
                'period' => 'UTS',
                'grade' => 85,
                'max_grade' => 100,
                'weight' => 30,
                'description' => 'Ujian Tengah Semester',
                'date' => now()->subDays(10),
                'status' => 'final'
            ],
            (object)[
                'id' => 2,
                'subject' => 'Matematika',
                'teacher' => 'Bu Sari',
                'semester' => 1,
                'period' => 'UAS',
                'grade' => 88,
                'max_grade' => 100,
                'weight' => 40,
                'description' => 'Ujian Akhir Semester',
                'date' => now()->subDays(5),
                'status' => 'final'
            ],
            (object)[
                'id' => 3,
                'subject' => 'IPA',
                'teacher' => 'Pak Budi',
                'semester' => 1,
                'period' => 'UTS',
                'grade' => 92,
                'max_grade' => 100,
                'weight' => 30,
                'description' => 'Ujian Tengah Semester',
                'date' => now()->subDays(12),
                'status' => 'final'
            ],
            (object)[
                'id' => 4,
                'subject' => 'IPA',
                'teacher' => 'Pak Budi',
                'semester' => 1,
                'period' => 'UAS',
                'grade' => 90,
                'max_grade' => 100,
                'weight' => 40,
                'description' => 'Ujian Akhir Semester',
                'date' => now()->subDays(7),
                'status' => 'final'
            ],
            (object)[
                'id' => 5,
                'subject' => 'IPS',
                'teacher' => 'Bu Rina',
                'semester' => 1,
                'period' => 'UTS',
                'grade' => 87,
                'max_grade' => 100,
                'weight' => 30,
                'description' => 'Ujian Tengah Semester',
                'date' => now()->subDays(15),
                'status' => 'final'
            ],
            (object)[
                'id' => 6,
                'subject' => 'IPS',
                'teacher' => 'Bu Rina',
                'semester' => 1,
                'period' => 'UAS',
                'grade' => 89,
                'max_grade' => 100,
                'weight' => 40,
                'description' => 'Ujian Akhir Semester',
                'date' => now()->subDays(3),
                'status' => 'final'
            ],
            (object)[
                'id' => 7,
                'subject' => 'Bahasa Inggris',
                'teacher' => 'Mr. John',
                'semester' => 1,
                'period' => 'UTS',
                'grade' => 78,
                'max_grade' => 100,
                'weight' => 30,
                'description' => 'Ujian Tengah Semester',
                'date' => now()->subDays(8),
                'status' => 'final'
            ],
            (object)[
                'id' => 8,
                'subject' => 'Bahasa Inggris',
                'teacher' => 'Mr. John',
                'semester' => 1,
                'period' => 'UAS',
                'grade' => 82,
                'max_grade' => 100,
                'weight' => 40,
                'description' => 'Ujian Akhir Semester',
                'date' => now()->subDays(1),
                'status' => 'final'
            ]
        ]);
        
        // Apply filters
        if ($search) {
            $grades = $grades->filter(function($item) use ($search) {
                return stripos($item->subject, $search) !== false || 
                       stripos($item->description, $search) !== false;
            });
        }
        
        if ($subject) {
            $grades = $grades->filter(function($item) use ($subject) {
                return $item->subject === $subject;
            });
        }
        
        if ($semester) {
            $grades = $grades->filter(function($item) use ($semester) {
                return $item->semester == $semester;
            });
        }
        
        if ($period) {
            $grades = $grades->filter(function($item) use ($period) {
                return $item->period === $period;
            });
        }
        
        return $grades;
    }
    
    /**
     * Get grade statistics.
     */
    private function getGradeStats($student)
    {
        return [
            'total_subjects' => 8,
            'average_grade' => 86.5,
            'highest_grade' => 92,
            'lowest_grade' => 78,
            'grade_distribution' => [
                'A' => 4,
                'B' => 3,
                'C' => 1,
                'D' => 0,
                'E' => 0
            ],
            'semester_average' => 86.5,
            'rank' => 5,
            'total_students' => 30
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
                'type' => 'grade_added',
                'title' => 'Nilai Bahasa Inggris UAS',
                'subject' => 'Bahasa Inggris',
                'grade' => 82,
                'created_at' => now()->subDays(1)
            ],
            (object)[
                'id' => 2,
                'type' => 'grade_updated',
                'title' => 'Nilai IPS UAS',
                'subject' => 'IPS',
                'grade' => 89,
                'created_at' => now()->subDays(3)
            ],
            (object)[
                'id' => 3,
                'type' => 'report_generated',
                'title' => 'Rapor Semester 1',
                'subject' => 'Semua Mata Pelajaran',
                'grade' => null,
                'created_at' => now()->subWeek()
            ]
        ]);
    }
    
    /**
     * Get academic progress.
     */
    private function getAcademicProgress($student)
    {
        return [
            'semester_1' => [
                'average' => 86.5,
                'status' => 'completed',
                'completion_date' => now()->subWeek()
            ],
            'semester_2' => [
                'average' => 0,
                'status' => 'in_progress',
                'completion_date' => null
            ]
        ];
    }
    
    /**
     * Get performance analytics.
     */
    private function getPerformanceAnalytics($student)
    {
        return [
            'subject_performance' => [
                'Matematika' => 86.5,
                'IPA' => 91.0,
                'IPS' => 88.0,
                'Bahasa Indonesia' => 85.0,
                'Bahasa Inggris' => 80.0,
                'TIK' => 90.0,
                'PJOK' => 88.0,
                'Seni Budaya' => 87.0
            ],
            'period_performance' => [
                'UTS' => 85.5,
                'UAS' => 87.5
            ],
            'trend' => 'improving',
            'strengths' => ['IPA', 'TIK'],
            'weaknesses' => ['Bahasa Inggris']
        ];
    }
    
    /**
     * Get filter options.
     */
    private function getFilterOptions($student)
    {
        return [
            'subjects' => ['Matematika', 'IPA', 'IPS', 'Bahasa Indonesia', 'Bahasa Inggris', 'TIK', 'PJOK', 'Seni Budaya'],
            'semesters' => [1, 2],
            'periods' => ['UTS', 'UAS', 'Tugas', 'Quiz', 'Praktik'],
            'academic_years' => ['2024/2025', '2023/2024', '2022/2023']
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
     * Get subject grades.
     */
    private function getSubjectGrades($student, $subjectId)
    {
        $allGrades = $this->getGrades($student, '', '', '', '');
        return $allGrades->filter(function($grade) use ($subjectId) {
            return $grade->subject === $this->getSubjectById($subjectId)->name;
        });
    }
    
    /**
     * Get subject statistics.
     */
    private function getSubjectStats($subjectGrades)
    {
        if ($subjectGrades->isEmpty()) {
            return [
                'average' => 0,
                'highest' => 0,
                'lowest' => 0,
                'total_grades' => 0
            ];
        }
        
        return [
            'average' => $subjectGrades->avg('grade'),
            'highest' => $subjectGrades->max('grade'),
            'lowest' => $subjectGrades->min('grade'),
            'total_grades' => $subjectGrades->count()
        ];
    }
    
    /**
     * Get grade history.
     */
    private function getGradeHistory($student, $subjectId)
    {
        return collect([
            (object)['period' => 'UTS', 'grade' => 85, 'date' => now()->subDays(10)],
            (object)['period' => 'UAS', 'grade' => 88, 'date' => now()->subDays(5)],
            (object)['period' => 'Tugas', 'grade' => 90, 'date' => now()->subDays(3)]
        ]);
    }
    
    /**
     * Get teacher feedback.
     */
    private function getTeacherFeedback($student, $subjectId)
    {
        return collect([
            (object)[
                'teacher' => 'Bu Sari',
                'feedback' => 'Kemampuan matematika sudah baik, perlu lebih teliti dalam perhitungan.',
                'date' => now()->subDays(5)
            ],
            (object)[
                'teacher' => 'Bu Sari',
                'feedback' => 'Pemahaman konsep sudah meningkat, pertahankan!',
                'date' => now()->subDays(2)
            ]
        ]);
    }
    
    /**
     * Get report data.
     */
    private function getReportData($student, $semester, $academicYear)
    {
        return [
            'student_info' => [
                'name' => $student->user->name,
                'nis' => $student->nis,
                'class' => 'VII A',
                'academic_year' => '2024/2025'
            ],
            'semester' => $semester,
            'academic_year' => $academicYear,
            'subjects' => [
                ['name' => 'Matematika', 'teacher' => 'Bu Sari', 'grade' => 86.5, 'predicate' => 'B+'],
                ['name' => 'IPA', 'teacher' => 'Pak Budi', 'grade' => 91.0, 'predicate' => 'A-'],
                ['name' => 'IPS', 'teacher' => 'Bu Rina', 'grade' => 88.0, 'predicate' => 'B+'],
                ['name' => 'Bahasa Indonesia', 'teacher' => 'Bu Siti', 'grade' => 85.0, 'predicate' => 'B'],
                ['name' => 'Bahasa Inggris', 'teacher' => 'Mr. John', 'grade' => 80.0, 'predicate' => 'B-'],
                ['name' => 'TIK', 'teacher' => 'Pak Andi', 'grade' => 90.0, 'predicate' => 'A-'],
                ['name' => 'PJOK', 'teacher' => 'Pak Rudi', 'grade' => 88.0, 'predicate' => 'B+'],
                ['name' => 'Seni Budaya', 'teacher' => 'Bu Maya', 'grade' => 87.0, 'predicate' => 'B+']
            ],
            'summary' => [
                'average' => 86.5,
                'rank' => 5,
                'total_students' => 30,
                'attendance' => 95.5,
                'behavior' => 'Sangat Baik'
            ]
        ];
    }
    
    /**
     * Get report statistics.
     */
    private function getReportStats($reportData)
    {
        return [
            'total_subjects' => count($reportData['subjects']),
            'average_grade' => $reportData['summary']['average'],
            'highest_grade' => max(array_column($reportData['subjects'], 'grade')),
            'lowest_grade' => min(array_column($reportData['subjects'], 'grade')),
            'rank' => $reportData['summary']['rank'],
            'total_students' => $reportData['summary']['total_students']
        ];
    }
    
    /**
     * Get academic year options.
     */
    private function getAcademicYearOptions()
    {
        return [
            (object)['id' => 1, 'name' => '2024/2025', 'is_active' => true],
            (object)['id' => 2, 'name' => '2023/2024', 'is_active' => false],
            (object)['id' => 3, 'name' => '2022/2023', 'is_active' => false]
        ];
    }
}





