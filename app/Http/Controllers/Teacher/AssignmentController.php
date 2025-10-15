<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $query = $teacher->assignments()->with(['class', 'subject']);

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'published':
                    $query->where('is_published', true);
                    break;
                case 'draft':
                    $query->where('is_published', false);
                    break;
                case 'overdue':
                    $query->where('is_published', true)
                          ->where('due_date', '<', now());
                    break;
                case 'upcoming':
                    $query->where('is_published', true)
                          ->where('due_date', '>=', now())
                          ->where('due_date', '<=', now()->addDays(7));
                    break;
            }
        }

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $assignments = $query->orderBy('created_at', 'desc')->paginate(10);

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        return view('teacher.assignments.index', compact('assignments', 'classes', 'subjects'));
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

        return view('teacher.assignments.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'due_date' => 'required|date|after:now',
            'max_score' => 'required|integer|min:1|max:1000',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt|max:10240',
            'is_published' => 'boolean',
        ]);

        $data = $request->only([
            'class_id', 'subject_id', 'title', 'description', 
            'instructions', 'due_date', 'max_score', 'is_published'
        ]);

        $data['teacher_id'] = $teacher->id;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments', $fileName, 'public');
            $data['file_path'] = $filePath;
        }

        $assignment = Assignment::create($data);

        return redirect()->route('teacher.assignments.show', $assignment)
            ->with('success', 'Tugas berhasil dibuat!');
    }

    public function show(Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if assignment belongs to teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        $assignment->load(['class', 'subject', 'submissions.student']);
        
        $submissions = $assignment->submissions()
            ->with('student')
            ->orderBy('submitted_at', 'desc')
            ->get();

        $stats = [
            'total_submissions' => $submissions->count(),
            'graded_submissions' => $submissions->where('score', '!=', null)->count(),
            'pending_submissions' => $submissions->where('score', null)->count(),
            'late_submissions' => $submissions->where('is_late', true)->count(),
        ];

        return view('teacher.assignments.show', compact('assignment', 'submissions', 'stats'));
    }

    public function edit(Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if assignment belongs to teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        return view('teacher.assignments.edit', compact('assignment', 'classes', 'subjects'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if assignment belongs to teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'due_date' => 'required|date|after:now',
            'max_score' => 'required|integer|min:1|max:1000',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt|max:10240',
            'is_published' => 'boolean',
        ]);

        $data = $request->only([
            'class_id', 'subject_id', 'title', 'description', 
            'instructions', 'due_date', 'max_score', 'is_published'
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
                Storage::disk('public')->delete($assignment->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments', $fileName, 'public');
            $data['file_path'] = $filePath;
        }

        $assignment->update($data);

        return redirect()->route('teacher.assignments.show', $assignment)
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if assignment belongs to teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        // Delete file if exists
        if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();

        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Tugas berhasil dihapus!');
    }

    public function togglePublish(Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return response()->json(['error' => 'Teacher profile not found'], 404);
        }

        // Check if assignment belongs to teacher
        if ($assignment->teacher_id !== $teacher->id) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $assignment->update(['is_published' => !$assignment->is_published]);

        return response()->json([
            'success' => true,
            'is_published' => $assignment->is_published,
            'message' => $assignment->is_published ? 'Tugas dipublikasikan' : 'Tugas tidak dipublikasikan'
        ]);
    }

    public function download(Assignment $assignment)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        // Check if assignment belongs to teacher
        if ($assignment->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to assignment.');
        }

        if (!$assignment->file_path || !Storage::disk('public')->exists($assignment->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download($assignment->file_path);
    }

    public function gradeSubmission(Request $request, Assignment $assignment, AssignmentSubmission $submission)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return response()->json(['error' => 'Teacher profile not found'], 404);
        }

        // Check if assignment belongs to teacher
        if ($assignment->teacher_id !== $teacher->id) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        // Check if submission belongs to assignment
        if ($submission->assignment_id !== $assignment->id) {
            return response()->json(['error' => 'Invalid submission'], 400);
        }

        $request->validate([
            'score' => 'required|numeric|min:0|max:' . $assignment->max_score,
            'feedback' => 'nullable|string|max:1000',
        ]);

        $submission->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
            'graded_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil disimpan',
            'submission' => $submission->fresh()
        ]);
    }
}
