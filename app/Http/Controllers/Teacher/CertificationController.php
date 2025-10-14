<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificationController extends Controller
{
    /**
     * Display a listing of certifications.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $certifications = $teacher->certifications()->orderBy('issue_date', 'desc')->get();
        
        return view('teacher.sertifikasi.index', compact('certifications'));
    }
    
    /**
     * Store a newly created certification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'certification_name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'certificate_file' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
        ]);
        
        $teacher = Auth::user()->teacher;
        
        $data = [
            'certification_name' => $request->certification_name,
            'issuing_organization' => $request->issuing_organization,
            'issue_date' => $request->issue_date,
            'expiry_date' => $request->expiry_date,
        ];
        
        // Handle file upload
        if ($request->hasFile('certificate_file')) {
            $file = $request->file('certificate_file');
            $path = $file->store('teacher-certificates', 'public');
            $data['certificate_file'] = $path;
        }
        
        $teacher->certifications()->create($data);
        
        return redirect()->route('teacher.sertifikasi.index')
            ->with('success', 'Sertifikasi berhasil ditambahkan.');
    }
    
    /**
     * Update the specified certification.
     */
    public function update(Request $request, $id)
    {
        $certification = TeacherCertification::where('teacher_id', Auth::user()->teacher->id)
            ->findOrFail($id);
        
        $request->validate([
            'certification_name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'certificate_file' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
        ]);
        
        $data = [
            'certification_name' => $request->certification_name,
            'issuing_organization' => $request->issuing_organization,
            'issue_date' => $request->issue_date,
            'expiry_date' => $request->expiry_date,
        ];
        
        // Handle file upload
        if ($request->hasFile('certificate_file')) {
            // Delete old file
            if ($certification->certificate_file) {
                Storage::disk('public')->delete($certification->certificate_file);
            }
            
            $file = $request->file('certificate_file');
            $path = $file->store('teacher-certificates', 'public');
            $data['certificate_file'] = $path;
        }
        
        $certification->update($data);
        
        return redirect()->route('teacher.sertifikasi.index')
            ->with('success', 'Sertifikasi berhasil diperbarui.');
    }
    
    /**
     * Remove the specified certification.
     */
    public function destroy($id)
    {
        $certification = TeacherCertification::where('teacher_id', Auth::user()->teacher->id)
            ->findOrFail($id);
        
        // Delete file if exists
        if ($certification->certificate_file) {
            Storage::disk('public')->delete($certification->certificate_file);
        }
        
        $certification->delete();
        
        return redirect()->route('teacher.sertifikasi.index')
            ->with('success', 'Sertifikasi berhasil dihapus.');
    }
}