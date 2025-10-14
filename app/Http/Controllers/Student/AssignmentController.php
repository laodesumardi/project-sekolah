<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\AcademicYear;
use App\Models\Subject;
use App\Models\SchoolClass;

class AssignmentController extends Controller
{
    /**
     * Display assignments and exams dashboard.
     */
    public function index(Request $request)
    {
        $student = Auth::user()->profile;
        $currentYear = $this->getCurrentAcademicYear();
        
        // Get filter parameters
        $search = $request->get('search', '');
        $subject = $request->get('subject', '');
        $type = $request->get('type', '');
        $status = $request->get('status', '');
        $sortBy = $request->get('sort_by', 'due_date');
        $sortOrder = $request->get('sort_order', 'asc');
        
        // Get assignments and exams
        $assignments = $this->getAssignments($student, $search, $subject, $type, $status, $sortBy, $sortOrder);
        
        // Get statistics
        $stats = $this->getAssignmentStats($student);
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($student);
        
        // Get upcoming deadlines
        $upcomingDeadlines = $this->getUpcomingDeadlines($student);
        
        // Get performance analytics
        $analytics = $this->getPerformanceAnalytics($student);
        
        // Get filter options
        $filterOptions = $this->getFilterOptions($student);
        
        return view('student.tugas.index', compact(
            'assignments',
            'stats',
            'recentActivities',
            'upcomingDeadlines',
            'analytics',
            'filterOptions',
            'search',
            'subject',
            'type',
            'status',
            'sortBy',
            'sortOrder'
        ));
    }
    
    /**
     * Display specific assignment/exam.
     */
    public function show($id)
    {
        $student = Auth::user()->profile;
        $assignment = $this->getAssignmentById($id);
        
        if (!$assignment) {
            abort(404, 'Tugas atau ujian tidak ditemukan');
        }
        
        // Get submission details
        $submission = $this->getStudentSubmission($student, $id);
        
        // Get assignment questions (for exams)
        $questions = $this->getAssignmentQuestions($id);
        
        // Get related assignments
        $relatedAssignments = $this->getRelatedAssignments($assignment);
        
        return view('student.tugas.show', compact(
            'assignment',
            'submission',
            'questions',
            'relatedAssignments'
        ));
    }
    
    /**
     * Submit assignment/exam.
     */
    public function submit(Request $request, $id)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);
        
        $student = Auth::user()->profile;
        $assignment = $this->getAssignmentById($id);
        
        if (!$assignment) {
            return response()->json([
                'message' => 'Tugas atau ujian tidak ditemukan',
                'success' => false
            ], 404);
        }
        
        // Check if assignment is still open
        if ($assignment->status !== 'open') {
            return response()->json([
                'message' => 'Tugas atau ujian sudah ditutup',
                'success' => false
            ], 400);
        }
        
        try {
            // Simulate submission
            $submissionId = rand(1000, 9999);
            $score = $this->calculateScore($assignment, $request->input('answers'));
            
            return response()->json([
                'message' => 'Tugas berhasil dikumpulkan!',
                'submission_id' => $submissionId,
                'score' => $score,
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengumpulkan tugas: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    
    /**
     * Get assignment results.
     */
    public function results($id)
    {
        $student = Auth::user()->profile;
        $assignment = $this->getAssignmentById($id);
        $submission = $this->getStudentSubmission($student, $id);
        $results = $this->getAssignmentResults($assignment, $submission);
        
        return view('student.tugas.results', compact(
            'assignment',
            'submission',
            'results'
        ));
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
     * Get assignments with filters.
     */
    private function getAssignments($student, $search, $subject, $type, $status, $sortBy, $sortOrder)
    {
        // Placeholder data - implement with actual assignments
        $assignments = collect([
            (object)[
                'id' => 1,
                'title' => 'Tugas Matematika - Aljabar',
                'subject' => 'Matematika',
                'type' => 'assignment',
                'status' => 'open',
                'due_date' => now()->addDays(3),
                'points' => 100,
                'difficulty' => 'medium',
                'description' => 'Selesaikan soal-soal aljabar berikut dengan benar.',
                'instructions' => 'Kerjakan semua soal dengan teliti. Tulis jawaban dengan jelas.',
                'attachments' => ['soal_aljabar.pdf'],
                'created_at' => now()->subDays(5),
                'teacher' => 'Bu Sari',
                'class' => 'VII A',
                'submission_count' => 25,
                'is_submitted' => false,
                'submission_date' => null,
                'score' => null
            ],
            (object)[
                'id' => 2,
                'title' => 'Ujian IPA - Sifat Cahaya',
                'subject' => 'IPA',
                'type' => 'exam',
                'status' => 'open',
                'due_date' => now()->addDays(1),
                'points' => 100,
                'difficulty' => 'hard',
                'description' => 'Ujian tentang sifat-sifat cahaya dan optik.',
                'instructions' => 'Pilih jawaban yang paling tepat. Waktu ujian: 90 menit.',
                'attachments' => ['materi_cahaya.pdf'],
                'created_at' => now()->subDays(3),
                'teacher' => 'Pak Budi',
                'class' => 'VII A',
                'submission_count' => 28,
                'is_submitted' => true,
                'submission_date' => now()->subHours(2),
                'score' => 85
            ],
            (object)[
                'id' => 3,
                'title' => 'Tugas IPS - Sejarah Indonesia',
                'subject' => 'IPS',
                'type' => 'assignment',
                'status' => 'closed',
                'due_date' => now()->subDays(2),
                'points' => 100,
                'difficulty' => 'easy',
                'description' => 'Buat ringkasan tentang perjuangan kemerdekaan Indonesia.',
                'instructions' => 'Buat ringkasan minimal 2 halaman. Sertakan referensi.',
                'attachments' => ['referensi_sejarah.pdf'],
                'created_at' => now()->subWeek(),
                'teacher' => 'Bu Rina',
                'class' => 'VII A',
                'submission_count' => 30,
                'is_submitted' => true,
                'submission_date' => now()->subDays(3),
                'score' => 92
            ],
            (object)[
                'id' => 4,
                'title' => 'Quiz Bahasa Inggris - Grammar',
                'subject' => 'Bahasa Inggris',
                'type' => 'quiz',
                'status' => 'open',
                'due_date' => now()->addHours(6),
                'points' => 50,
                'difficulty' => 'medium',
                'description' => 'Quiz tentang grammar bahasa Inggris.',
                'instructions' => 'Jawab semua pertanyaan dengan benar. Waktu: 30 menit.',
                'attachments' => [],
                'created_at' => now()->subDay(),
                'teacher' => 'Mr. John',
                'class' => 'VII A',
                'submission_count' => 22,
                'is_submitted' => false,
                'submission_date' => null,
                'score' => null
            ],
            (object)[
                'id' => 5,
                'title' => 'Tugas TIK - Microsoft Word',
                'subject' => 'TIK',
                'type' => 'assignment',
                'status' => 'open',
                'due_date' => now()->addDays(5),
                'points' => 100,
                'difficulty' => 'easy',
                'description' => 'Buat dokumen dengan format yang benar menggunakan Microsoft Word.',
                'instructions' => 'Buat dokumen dengan format: judul, subjudul, paragraf, dan daftar.',
                'attachments' => ['template_word.docx'],
                'created_at' => now()->subDays(2),
                'teacher' => 'Pak Andi',
                'class' => 'VII A',
                'submission_count' => 18,
                'is_submitted' => false,
                'submission_date' => null,
                'score' => null
            ]
        ]);
        
        // Apply filters
        if ($search) {
            $assignments = $assignments->filter(function($item) use ($search) {
                return stripos($item->title, $search) !== false || 
                       stripos($item->description, $search) !== false;
            });
        }
        
        if ($subject) {
            $assignments = $assignments->filter(function($item) use ($subject) {
                return $item->subject === $subject;
            });
        }
        
        if ($type) {
            $assignments = $assignments->filter(function($item) use ($type) {
                return $item->type === $type;
            });
        }
        
        if ($status) {
            $assignments = $assignments->filter(function($item) use ($status) {
                return $item->status === $status;
            });
        }
        
        // Sort
        $assignments = $assignments->sortBy($sortBy, SORT_REGULAR, $sortOrder === 'desc');
        
        return $assignments;
    }
    
    /**
     * Get assignment statistics.
     */
    private function getAssignmentStats($student)
    {
        return [
            'total_assignments' => 15,
            'completed' => 8,
            'pending' => 5,
            'overdue' => 2,
            'average_score' => 87,
            'total_points' => 1200,
            'earned_points' => 1044,
            'completion_rate' => 73
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
                'type' => 'submission',
                'title' => 'Tugas Matematika - Aljabar',
                'subject' => 'Matematika',
                'score' => 85,
                'created_at' => now()->subHours(2)
            ],
            (object)[
                'id' => 2,
                'type' => 'assignment',
                'title' => 'Ujian IPA - Sifat Cahaya',
                'subject' => 'IPA',
                'score' => null,
                'created_at' => now()->subDay()
            ],
            (object)[
                'id' => 3,
                'type' => 'result',
                'title' => 'Tugas IPS - Sejarah Indonesia',
                'subject' => 'IPS',
                'score' => 92,
                'created_at' => now()->subDays(2)
            ]
        ]);
    }
    
    /**
     * Get upcoming deadlines.
     */
    private function getUpcomingDeadlines($student)
    {
        return collect([
            (object)[
                'id' => 4,
                'title' => 'Quiz Bahasa Inggris - Grammar',
                'subject' => 'Bahasa Inggris',
                'due_date' => now()->addHours(6),
                'type' => 'quiz',
                'points' => 50
            ],
            (object)[
                'id' => 1,
                'title' => 'Tugas Matematika - Aljabar',
                'subject' => 'Matematika',
                'due_date' => now()->addDays(3),
                'type' => 'assignment',
                'points' => 100
            ],
            (object)[
                'id' => 5,
                'title' => 'Tugas TIK - Microsoft Word',
                'subject' => 'TIK',
                'due_date' => now()->addDays(5),
                'type' => 'assignment',
                'points' => 100
            ]
        ]);
    }
    
    /**
     * Get performance analytics.
     */
    private function getPerformanceAnalytics($student)
    {
        return [
            'subject_performance' => [
                'Matematika' => 85,
                'IPA' => 87,
                'IPS' => 92,
                'Bahasa Inggris' => 78,
                'TIK' => 90
            ],
            'type_performance' => [
                'assignment' => 89,
                'exam' => 85,
                'quiz' => 82
            ],
            'difficulty_performance' => [
                'easy' => 95,
                'medium' => 87,
                'hard' => 78
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
            'types' => [
                'assignment' => 'Tugas',
                'exam' => 'Ujian',
                'quiz' => 'Quiz'
            ],
            'statuses' => [
                'open' => 'Terbuka',
                'closed' => 'Ditutup',
                'graded' => 'Dinilai'
            ],
            'difficulties' => ['easy', 'medium', 'hard']
        ];
    }
    
    /**
     * Get assignment by ID.
     */
    private function getAssignmentById($id)
    {
        $assignments = $this->getAssignments(null, '', '', '', '', 'due_date', 'asc');
        return $assignments->where('id', $id)->first();
    }
    
    /**
     * Get student submission.
     */
    private function getStudentSubmission($student, $assignmentId)
    {
        // Placeholder - implement with actual submission data
        return (object)[
            'id' => rand(1000, 9999),
            'assignment_id' => $assignmentId,
            'student_id' => $student->id,
            'submitted_at' => now()->subHours(2),
            'score' => 85,
            'status' => 'graded',
            'feedback' => 'Kerja bagus! Perhatikan perhitungan pada soal nomor 3.',
            'attachments' => ['jawaban_aljabar.pdf']
        ];
    }
    
    /**
     * Get assignment questions.
     */
    private function getAssignmentQuestions($assignmentId)
    {
        // Placeholder - implement with actual questions
        return collect([
            (object)[
                'id' => 1,
                'question' => 'Berapakah nilai x jika 2x + 5 = 15?',
                'type' => 'multiple_choice',
                'options' => ['A. 5', 'B. 10', 'C. 15', 'D. 20'],
                'correct_answer' => 'A. 5',
                'points' => 10
            ],
            (object)[
                'id' => 2,
                'question' => 'Jelaskan hukum Newton pertama!',
                'type' => 'essay',
                'options' => null,
                'correct_answer' => null,
                'points' => 20
            ]
        ]);
    }
    
    /**
     * Get related assignments.
     */
    private function getRelatedAssignments($assignment)
    {
        return collect([
            (object)[
                'id' => 6,
                'title' => 'Tugas Matematika - Geometri',
                'subject' => 'Matematika',
                'type' => 'assignment'
            ],
            (object)[
                'id' => 7,
                'title' => 'Quiz IPA - Optik',
                'subject' => 'IPA',
                'type' => 'quiz'
            ]
        ]);
    }
    
    /**
     * Calculate score.
     */
    private function calculateScore($assignment, $answers)
    {
        // Placeholder - implement actual scoring logic
        return rand(70, 100);
    }
    
    /**
     * Get assignment results.
     */
    private function getAssignmentResults($assignment, $submission)
    {
        return [
            'total_questions' => 10,
            'correct_answers' => 8,
            'wrong_answers' => 2,
            'score' => $submission->score,
            'feedback' => $submission->feedback,
            'time_taken' => '45 menit',
            'submitted_at' => $submission->submitted_at
        ];
    }
}
