<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Display the grades management page.
     */
    public function index()
    {
        $teacher = Auth::user()->profile;
        
        // Get teacher's classes
        $classes = $this->getTeacherClasses($teacher);
        
        // Get recent grades
        $recentGrades = $this->getRecentGrades($teacher);
        
        // Get grade statistics
        $stats = $this->getGradeStats($teacher);
        
        // Get upcoming assessments
        $upcomingAssessments = $this->getUpcomingAssessments($teacher);
        
        return view('teacher.penilaian.index', compact(
            'classes',
            'recentGrades',
            'stats',
            'upcomingAssessments'
        ));
    }
    
    /**
     * Show grades for a specific class.
     */
    public function showClass($classId)
    {
        $teacher = Auth::user()->profile;
        
        // Get class details
        $class = $this->getClassDetails($classId);
        
        // Get students in class
        $students = $this->getClassStudents($classId);
        
        // Get grade categories
        $categories = $this->getGradeCategories();
        
        // Get recent assessments
        $assessments = $this->getClassAssessments($classId);
        
        return view('teacher.penilaian.class', compact(
            'class',
            'students',
            'categories',
            'assessments'
        ));
    }
    
    /**
     * Show create grade form.
     */
    public function create()
    {
        $teacher = Auth::user()->profile;
        
        // Get teacher's classes
        $classes = $this->getTeacherClasses($teacher);
        
        // Get grade categories
        $categories = $this->getGradeCategories();
        
        // Get subjects
        $subjects = $this->getTeacherSubjects($teacher);
        
        return view('teacher.penilaian.create', compact(
            'classes',
            'categories',
            'subjects'
        ));
    }
    
    /**
     * Store new grade.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score' => 'required|numeric|min:1',
            'date' => 'required|date',
            'students' => 'required|array',
            'students.*.student_id' => 'required|exists:profiles,id',
            'students.*.score' => 'nullable|numeric|min:0',
            'students.*.note' => 'nullable|string'
        ]);
        
        // In real implementation, save to database
        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil disimpan',
            'redirect' => route('teacher.penilaian.index')
        ]);
    }
    
    /**
     * Show edit grade form.
     */
    public function edit($id)
    {
        $teacher = Auth::user()->profile;
        
        // Get grade details (placeholder)
        $grade = (object) [
            'id' => $id,
            'class' => 'VII A',
            'subject' => 'Matematika',
            'category' => 'Ujian',
            'title' => 'Ujian Tengah Semester',
            'description' => 'Ujian matematika untuk materi aljabar',
            'max_score' => 100,
            'date' => '2024-10-15',
            'students' => [
                (object) ['id' => 1, 'name' => 'Ahmad Rizki', 'score' => 85, 'note' => 'Bagus'],
                (object) ['id' => 2, 'name' => 'Siti Nurhaliza', 'score' => 92, 'note' => 'Sangat bagus'],
                (object) ['id' => 3, 'name' => 'Budi Santoso', 'score' => 78, 'note' => 'Perlu perbaikan'],
            ]
        ];
        
        // Get classes and subjects
        $classes = $this->getTeacherClasses($teacher);
        $subjects = $this->getTeacherSubjects($teacher);
        $categories = $this->getGradeCategories();
        
        return view('teacher.penilaian.edit', compact(
            'grade',
            'classes',
            'subjects',
            'categories'
        ));
    }
    
    /**
     * Update grade.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score' => 'required|numeric|min:1',
            'date' => 'required|date',
            'students' => 'required|array',
            'students.*.student_id' => 'required|exists:profiles,id',
            'students.*.score' => 'nullable|numeric|min:0',
            'students.*.note' => 'nullable|string'
        ]);
        
        // In real implementation, update in database
        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil diperbarui',
            'redirect' => route('teacher.penilaian.index')
        ]);
    }
    
    /**
     * Delete grade.
     */
    public function destroy($id)
    {
        // In real implementation, delete from database
        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil dihapus'
        ]);
    }
    
    /**
     * Get grade analytics.
     */
    public function analytics($classId = null)
    {
        $teacher = Auth::user()->profile;
        
        // Get analytics data
        $analytics = $this->getGradeAnalytics($teacher, $classId);
        
        return view('teacher.penilaian.analytics', compact('analytics'));
    }
    
    /**
     * Export grades.
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'excel');
        $classId = $request->get('class_id');
        
        // In real implementation, generate export file
        return response()->json([
            'success' => true,
            'message' => 'Export berhasil dibuat',
            'download_url' => '/exports/grades-' . time() . '.' . $format
        ]);
    }
    
    /**
     * Get teacher's classes.
     */
    private function getTeacherClasses($teacher)
    {
        return collect([
            (object) [
                'id' => 1,
                'name' => 'VII A',
                'subject' => 'Matematika',
                'student_count' => 25,
                'recent_grade_count' => 3
            ],
            (object) [
                'id' => 2,
                'name' => 'VII B',
                'subject' => 'Matematika',
                'student_count' => 23,
                'recent_grade_count' => 2
            ],
            (object) [
                'id' => 3,
                'name' => 'VIII A',
                'subject' => 'Matematika',
                'student_count' => 24,
                'recent_grade_count' => 4
            ]
        ]);
    }
    
    /**
     * Get recent grades.
     */
    private function getRecentGrades($teacher)
    {
        return collect([
            (object) [
                'id' => 1,
                'class' => 'VII A',
                'subject' => 'Matematika',
                'title' => 'Ujian Tengah Semester',
                'category' => 'Ujian',
                'date' => '2024-10-15',
                'student_count' => 25,
                'average_score' => 82.5,
                'max_score' => 100
            ],
            (object) [
                'id' => 2,
                'class' => 'VII B',
                'subject' => 'Matematika',
                'title' => 'Tugas Aljabar',
                'category' => 'Tugas',
                'date' => '2024-10-12',
                'student_count' => 23,
                'average_score' => 78.3,
                'max_score' => 100
            ],
            (object) [
                'id' => 3,
                'class' => 'VIII A',
                'subject' => 'Matematika',
                'title' => 'Quiz Geometri',
                'category' => 'Quiz',
                'date' => '2024-10-10',
                'student_count' => 24,
                'average_score' => 85.7,
                'max_score' => 50
            ]
        ]);
    }
    
    /**
     * Get grade statistics.
     */
    private function getGradeStats($teacher)
    {
        return [
            'total_assessments' => 15,
            'total_students' => 72,
            'average_grade' => 81.2,
            'grade_distribution' => [
                'A' => 25,
                'B' => 30,
                'C' => 15,
                'D' => 2
            ],
            'recent_activity' => [
                'grades_this_week' => 8,
                'pending_grades' => 3,
                'overdue_grades' => 1
            ]
        ];
    }
    
    /**
     * Get upcoming assessments.
     */
    private function getUpcomingAssessments($teacher)
    {
        return collect([
            (object) [
                'id' => 1,
                'class' => 'VII A',
                'subject' => 'Matematika',
                'title' => 'Ujian Akhir Semester',
                'date' => '2024-12-15',
                'days_left' => 45
            ],
            (object) [
                'id' => 2,
                'class' => 'VII B',
                'subject' => 'Matematika',
                'title' => 'Tugas Trigonometri',
                'date' => '2024-10-25',
                'days_left' => 10
            ]
        ]);
    }
    
    /**
     * Get class details.
     */
    private function getClassDetails($classId)
    {
        return (object) [
            'id' => $classId,
            'name' => 'VII A',
            'subject' => 'Matematika',
            'student_count' => 25,
            'teacher' => 'Bu Sari'
        ];
    }
    
    /**
     * Get students in class.
     */
    private function getClassStudents($classId)
    {
        return collect([
            (object) [
                'id' => 1,
                'name' => 'Ahmad Rizki',
                'nis' => '2024001',
                'recent_grade' => 85,
                'average' => 82.5,
                'status' => 'active'
            ],
            (object) [
                'id' => 2,
                'name' => 'Siti Nurhaliza',
                'nis' => '2024002',
                'recent_grade' => 92,
                'average' => 88.7,
                'status' => 'active'
            ],
            (object) [
                'id' => 3,
                'name' => 'Budi Santoso',
                'nis' => '2024003',
                'recent_grade' => 78,
                'average' => 75.2,
                'status' => 'active'
            ]
        ]);
    }
    
    /**
     * Get grade categories.
     */
    private function getGradeCategories()
    {
        return [
            'Ujian' => 'Ujian',
            'Tugas' => 'Tugas',
            'Quiz' => 'Quiz',
            'Praktikum' => 'Praktikum',
            'Proyek' => 'Proyek',
            'Presentasi' => 'Presentasi'
        ];
    }
    
    /**
     * Get teacher subjects.
     */
    private function getTeacherSubjects($teacher)
    {
        return collect([
            (object) ['id' => 1, 'name' => 'Matematika'],
            (object) ['id' => 2, 'name' => 'Fisika'],
            (object) ['id' => 3, 'name' => 'Kimia']
        ]);
    }
    
    /**
     * Get class assessments.
     */
    private function getClassAssessments($classId)
    {
        return collect([
            (object) [
                'id' => 1,
                'title' => 'Ujian Tengah Semester',
                'category' => 'Ujian',
                'date' => '2024-10-15',
                'max_score' => 100,
                'average' => 82.5
            ],
            (object) [
                'id' => 2,
                'title' => 'Tugas Aljabar',
                'category' => 'Tugas',
                'date' => '2024-10-12',
                'max_score' => 100,
                'average' => 78.3
            ]
        ]);
    }
    
    /**
     * Get grade analytics.
     */
    private function getGradeAnalytics($teacher, $classId = null)
    {
        return [
            'overview' => [
                'total_students' => 72,
                'average_grade' => 81.2,
                'grade_distribution' => [
                    'A' => 25,
                    'B' => 30,
                    'C' => 15,
                    'D' => 2
                ]
            ],
            'trends' => [
                'monthly_average' => [78, 80, 82, 81, 83, 85],
                'subject_performance' => [
                    'Matematika' => 82.5,
                    'Fisika' => 79.3,
                    'Kimia' => 85.1
                ]
            ],
            'top_performers' => [
                (object) ['name' => 'Siti Nurhaliza', 'average' => 95.2],
                (object) ['name' => 'Ahmad Rizki', 'average' => 92.8],
                (object) ['name' => 'Maria Santos', 'average' => 90.5]
            ],
            'needs_improvement' => [
                (object) ['name' => 'Budi Santoso', 'average' => 65.2],
                (object) ['name' => 'John Doe', 'average' => 68.7],
                (object) ['name' => 'Jane Smith', 'average' => 70.1]
            ]
        ];
    }
}

