<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of documents.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $documents = $teacher->documents()->orderBy('created_at', 'desc')->get();
        
        // Calculate stats
        $totalDocuments = $documents->count();
        $verifiedDocuments = $documents->where('is_verified', true)->count();
        $unverifiedDocuments = $documents->where('is_verified', false)->count();
        $totalSize = $documents->sum('file_size');
        
        return view('teacher.dokumen.index', compact('documents', 'totalDocuments', 'verifiedDocuments', 'unverifiedDocuments', 'totalSize'));
    }
    
    /**
     * Show the form for creating a new document.
     */
    public function create()
    {
        return view('teacher.dokumen.create');
    }
    
    /**
     * Store a newly created document.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|in:ktp,ijazah,certificate,sk,cv,other',
            'document_name' => 'required|string|max:255',
            'file' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:issue_date',
        ]);
        
        $teacher = Auth::user()->teacher;
        
        // Store file
        $file = $request->file('file');
        $path = $file->store('teacher-documents', 'public');
        
        // Create document record
        $document = $teacher->documents()->create([
            'document_type' => $request->document_type,
            'document_name' => $request->document_name,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'issue_date' => $request->issue_date,
            'expiry_date' => $request->expiry_date,
        ]);
        
        return redirect()->route('teacher.dokumen.index')
            ->with('success', 'Dokumen berhasil diupload.');
    }
    
    /**
     * Show the form for editing the specified document.
     */
    public function edit($id)
    {
        $document = TeacherDocument::where('teacher_id', Auth::user()->teacher->id)
            ->findOrFail($id);
            
        return view('teacher.dokumen.edit', compact('document'));
    }
    
    /**
     * Update the specified document.
     */
    public function update(Request $request, $id)
    {
        $document = TeacherDocument::where('teacher_id', Auth::user()->teacher->id)
            ->findOrFail($id);
            
        $request->validate([
            'document_type' => 'required|in:ktp,ijazah,certificate,sk,cv,other',
            'document_name' => 'required|string|max:255',
            'file' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:issue_date',
        ]);
        
        $data = [
            'document_type' => $request->document_type,
            'document_name' => $request->document_name,
            'issue_date' => $request->issue_date,
            'expiry_date' => $request->expiry_date,
        ];
        
        // Handle file upload if new file is provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            // Store new file
            $file = $request->file('file');
            $path = $file->store('teacher-documents', 'public');
            $data['file_path'] = $path;
            $data['file_size'] = $file->getSize();
        }
        
        $document->update($data);
        
        return redirect()->route('teacher.dokumen.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }
    
    /**
     * Download a document.
     */
    public function download($id)
    {
        $document = TeacherDocument::where('teacher_id', Auth::user()->teacher->id)
            ->findOrFail($id);
        
        $filePath = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }
        
        return response()->download($filePath, $document->document_name);
    }
    
    /**
     * Remove the specified document.
     */
    public function destroy($id)
    {
        $document = TeacherDocument::where('teacher_id', Auth::user()->teacher->id)
            ->findOrFail($id);
        
        // Delete file from storage
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        // Delete record
        $document->delete();
        
        return redirect()->route('teacher.dokumen.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}