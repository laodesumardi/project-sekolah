<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\LearningMaterial;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LearningMaterialController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $query = $teacher->learningMaterials()->with(['class', 'subject']);

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
            }
        }

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $materials = $query->orderBy('created_at', 'desc')->paginate(10);

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        return view('teacher.learning-materials.index', compact('materials', 'classes', 'subjects'));
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

        return view('teacher.learning-materials.create', compact('classes', 'subjects'));
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
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt,jpg,jpeg,png,gif|max:10240',
            'is_published' => 'boolean',
        ]);

        $data = $request->only([
            'class_id', 'subject_id', 'title', 'description', 
            'content', 'is_published'
        ]);

        $data['teacher_id'] = $teacher->id;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('learning-materials', $fileName, 'public');
            $data['file_path'] = $filePath;
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_size'] = $file->getSize();
        }

        $material = LearningMaterial::create($data);

        return redirect()->route('teacher.learning-materials.show', $material)
            ->with('success', 'Materi pembelajaran berhasil dibuat!');
    }

    public function show(LearningMaterial $learningMaterial)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if material belongs to teacher
        if ($learningMaterial->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to learning material.');
        }

        $learningMaterial->load(['class', 'subject']);

        return view('teacher.learning-materials.show', compact('learningMaterial'));
    }

    public function edit(LearningMaterial $learningMaterial)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if material belongs to teacher
        if ($learningMaterial->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to learning material.');
        }

        $classes = $teacher->classes;
        $subjects = $teacher->subjects;

        return view('teacher.learning-materials.edit', compact('learningMaterial', 'classes', 'subjects'));
    }

    public function update(Request $request, LearningMaterial $learningMaterial)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if material belongs to teacher
        if ($learningMaterial->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to learning material.');
        }

        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt,jpg,jpeg,png,gif|max:10240',
            'is_published' => 'boolean',
        ]);

        $data = $request->only([
            'class_id', 'subject_id', 'title', 'description', 
            'content', 'is_published'
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($learningMaterial->file_path && Storage::disk('public')->exists($learningMaterial->file_path)) {
                Storage::disk('public')->delete($learningMaterial->file_path);
            }
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('learning-materials', $fileName, 'public');
            $data['file_path'] = $filePath;
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_size'] = $file->getSize();
        }

        $learningMaterial->update($data);

        return redirect()->route('teacher.learning-materials.show', $learningMaterial)
            ->with('success', 'Materi pembelajaran berhasil diperbarui!');
    }

    public function destroy(LearningMaterial $learningMaterial)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Check if material belongs to teacher
        if ($learningMaterial->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to learning material.');
        }

        // Delete file if exists
        if ($learningMaterial->file_path && Storage::disk('public')->exists($learningMaterial->file_path)) {
            Storage::disk('public')->delete($learningMaterial->file_path);
        }

        $learningMaterial->delete();

        return redirect()->route('teacher.learning-materials.index')
            ->with('success', 'Materi pembelajaran berhasil dihapus!');
    }

    public function togglePublish(LearningMaterial $learningMaterial)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return response()->json(['error' => 'Teacher profile not found'], 404);
        }

        // Check if material belongs to teacher
        if ($learningMaterial->teacher_id !== $teacher->id) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $learningMaterial->update(['is_published' => !$learningMaterial->is_published]);

        return response()->json([
            'success' => true,
            'is_published' => $learningMaterial->is_published,
            'message' => $learningMaterial->is_published ? 'Materi dipublikasikan' : 'Materi tidak dipublikasikan'
        ]);
    }

    public function download(LearningMaterial $learningMaterial)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        // Check if material belongs to teacher
        if ($learningMaterial->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to learning material.');
        }

        if (!$learningMaterial->file_path || !Storage::disk('public')->exists($learningMaterial->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download($learningMaterial->file_path);
    }
}
