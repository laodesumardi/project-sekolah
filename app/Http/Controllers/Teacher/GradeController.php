<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $query = Grade::where('teacher_id', $teacher->id)
            ->with(['student', 'class', 'subject', 'assignment']);

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter by grade type
        if ($request->filled('grade_type')) {
            $query->where('grade_type', $request->grade_type);
        }

        // Search
        if ($request->filled('search')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $grades = $query->orderBy('graded_at', 'desc')->paginate(20);

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        return view('teacher.grades.index', compact('grades', 'classes', 'subjects'));
    }

    public function create()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        return view('teacher.grades.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $request->validate([
            'student_id' => 'required|exists:profiles,id',
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade_type' => 'required|in:assignment,quiz,exam,project,attendance,other',
            'score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        $data = $request->only([
            'student_id', 'class_id', 'subject_id', 'grade_type',
            'score', 'max_score', 'description'
        ]);

        $data['teacher_id'] = $teacher->id;
        $data['graded_at'] = now();

        Grade::create($data);

        return redirect()->route('teacher.grades.index')
            ->with('success', 'Nilai berhasil disimpan!');
    }

    public function show(Grade $grade)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if grade belongs to teacher
        if ($grade->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to grade.');
        }

        $grade->load(['student', 'class', 'subject', 'assignment']);

        return view('teacher.grades.show', compact('grade'));
    }

    public function edit(Grade $grade)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if grade belongs to teacher
        if ($grade->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to grade.');
        }

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        return view('teacher.grades.edit', compact('grade', 'classes', 'subjects'));
    }

    public function update(Request $request, Grade $grade)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if grade belongs to teacher
        if ($grade->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to grade.');
        }

        $request->validate([
            'student_id' => 'required|exists:profiles,id',
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade_type' => 'required|in:assignment,quiz,exam,project,attendance,other',
            'score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        $data = $request->only([
            'student_id', 'class_id', 'subject_id', 'grade_type',
            'score', 'max_score', 'description'
        ]);

        $grade->update($data);

        return redirect()->route('teacher.grades.show', $grade)
            ->with('success', 'Nilai berhasil diperbarui!');
    }

    public function destroy(Grade $grade)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if grade belongs to teacher
        if ($grade->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to grade.');
        }

        $grade->delete();

        return redirect()->route('teacher.grades.index')
            ->with('success', 'Nilai berhasil dihapus!');
    }

    public function showClass(SchoolClass $class)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if teacher teaches this class
        if (!$teacher->classes->contains($class)) {
            abort(403, 'Unauthorized access to class.');
        }

        $students = $class->students()->with('user')->get();
        $subjects = $teacher->subjects;
        
        $grades = Grade::where('teacher_id', $teacher->id)
            ->where('class_id', $class->id)
            ->with(['student', 'subject'])
            ->get()
            ->groupBy('student_id');

        return view('teacher.grades.class', compact('class', 'students', 'subjects', 'grades'));
    }

    public function analytics()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $analytics = [
            'total_grades' => Grade::where('teacher_id', $teacher->id)->count(),
            'average_score' => Grade::where('teacher_id', $teacher->id)->avg('score'),
            'grades_by_type' => Grade::where('teacher_id', $teacher->id)
                ->selectRaw('grade_type, COUNT(*) as count')
                ->groupBy('grade_type')
                ->get(),
            'grades_by_class' => Grade::where('teacher_id', $teacher->id)
                ->join('school_classes', 'grades.class_id', '=', 'school_classes.id')
                ->selectRaw('school_classes.name, COUNT(*) as count')
                ->groupBy('school_classes.id', 'school_classes.name')
                ->get(),
            'grades_by_subject' => Grade::where('teacher_id', $teacher->id)
                ->join('subjects', 'grades.subject_id', '=', 'subjects.id')
                ->selectRaw('subjects.name, COUNT(*) as count')
                ->groupBy('subjects.id', 'subjects.name')
                ->get(),
        ];

        return view('teacher.grades.analytics', compact('analytics'));
    }

    public function export(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $query = Grade::where('teacher_id', $teacher->id)
            ->with(['student', 'class', 'subject']);

        // Apply filters
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('grade_type')) {
            $query->where('grade_type', $request->grade_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('graded_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('graded_at', '<=', $request->date_to);
        }

        $grades = $query->orderBy('graded_at', 'desc')->get();

        // Generate CSV
        $filename = 'grades_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($grades) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Nama Siswa',
                'Kelas',
                'Mata Pelajaran',
                'Jenis Nilai',
                'Nilai',
                'Nilai Maksimal',
                'Persentase',
                'Huruf',
                'Deskripsi',
                'Tanggal Dinilai'
            ]);

            foreach ($grades as $grade) {
                fputcsv($file, [
                    $grade->student->name,
                    $grade->class->name,
                    $grade->subject->name,
                    $grade->grade_type_name,
                    $grade->score,
                    $grade->max_score,
                    $grade->percentage . '%',
                    $grade->grade,
                    $grade->description,
                    $grade->graded_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
