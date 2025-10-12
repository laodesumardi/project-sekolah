<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Subject::query();

        // Filter by grade level
        if ($request->has('grade_level') && $request->grade_level) {
            $query->where('grade_level', $request->grade_level);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $subjects = $query->orderBy('grade_level')->orderBy('name')->paginate(15);

        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:subjects,code',
            'description' => 'nullable|string',
            'grade_level' => 'required|in:10,11,12,all',
            'hours_per_week' => 'required|integer|min:1|max:10',
            'syllabus_file' => 'nullable|file|mimes:pdf|max:5120',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle syllabus file upload
        if ($request->hasFile('syllabus_file')) {
            $file = $request->file('syllabus_file');
            $fileName = time() . '_' . Str::slug($request->name) . '.pdf';
            $file->storeAs('public/syllabi', $fileName);
            $data['syllabus_file'] = $fileName;
        }

        $data['is_active'] = $request->has('is_active');

        Subject::create($data);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return view('admin.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
            'grade_level' => 'required|in:10,11,12,all',
            'hours_per_week' => 'required|integer|min:1|max:10',
            'syllabus_file' => 'nullable|file|mimes:pdf|max:5120',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle syllabus file upload
        if ($request->hasFile('syllabus_file')) {
            // Delete old file
            if ($subject->syllabus_file) {
                Storage::delete('public/syllabi/' . $subject->syllabus_file);
            }

            $file = $request->file('syllabus_file');
            $fileName = time() . '_' . Str::slug($request->name) . '.pdf';
            $file->storeAs('public/syllabi', $fileName);
            $data['syllabus_file'] = $fileName;
        }

        $data['is_active'] = $request->has('is_active');

        $subject->update($data);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        // Delete syllabus file
        if ($subject->syllabus_file) {
            Storage::delete('public/syllabi/' . $subject->syllabus_file);
        }

        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Subject $subject)
    {
        $subject->update(['is_active' => !$subject->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $subject->is_active
        ]);
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:subjects,id'
        ]);

        $subjectIds = $request->subject_ids;

        switch ($request->action) {
            case 'delete':
                $subjects = Subject::whereIn('id', $subjectIds)->get();
                foreach ($subjects as $subject) {
                    if ($subject->syllabus_file) {
                        Storage::delete('public/syllabi/' . $subject->syllabus_file);
                    }
                }
                Subject::whereIn('id', $subjectIds)->delete();
                $message = 'Mata pelajaran berhasil dihapus.';
                break;
            case 'activate':
                Subject::whereIn('id', $subjectIds)->update(['is_active' => true]);
                $message = 'Mata pelajaran berhasil diaktifkan.';
                break;
            case 'deactivate':
                Subject::whereIn('id', $subjectIds)->update(['is_active' => false]);
                $message = 'Mata pelajaran berhasil dinonaktifkan.';
                break;
        }

        return redirect()->route('admin.subjects.index')->with('success', $message);
    }
}