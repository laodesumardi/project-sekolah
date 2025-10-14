<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\AcademicYear;

class DocumentController extends Controller
{
    /**
     * Display documents dashboard.
     */
    public function index(Request $request)
    {
        $student = Auth::user()->profile;
        $currentYear = $this->getCurrentAcademicYear();
        
        // Get filter parameters
        $search = $request->get('search', '');
        $category = $request->get('category', '');
        $type = $request->get('type', '');
        $status = $request->get('status', '');
        
        // Get documents data
        $documents = $this->getDocuments($student, $search, $category, $type, $status);
        
        // Get statistics
        $stats = $this->getDocumentStats($student);
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($student);
        
        // Get document categories
        $categories = $this->getDocumentCategories();
        
        // Get filter options
        $filterOptions = $this->getFilterOptions($student);
        
        return view('student.dokumen.index', compact(
            'documents',
            'stats',
            'recentActivities',
            'categories',
            'filterOptions',
            'search',
            'category',
            'type',
            'status'
        ));
    }
    
    /**
     * Display specific document.
     */
    public function show($id)
    {
        $student = Auth::user()->profile;
        $document = $this->getDocumentById($id);
        
        if (!$document) {
            abort(404, 'Dokumen tidak ditemukan');
        }
        
        // Get document details
        $documentDetails = $this->getDocumentDetails($document);
        
        // Get related documents
        $relatedDocuments = $this->getRelatedDocuments($document);
        
        // Get document history
        $documentHistory = $this->getDocumentHistory($document);
        
        return view('student.dokumen.show', compact(
            'document',
            'documentDetails',
            'relatedDocuments',
            'documentHistory'
        ));
    }
    
    /**
     * Upload new document.
     */
    public function upload(Request $request)
    {
        $student = Auth::user()->profile;
        
        // Validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|in:academic,personal,medical,other',
            'type' => 'required|string|in:pdf,image,document,other',
            'file' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,txt'
        ]);
        
        // Handle file upload
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('student-documents/' . $student->id, $filename, 'public');
        
        // Create document record (placeholder)
        $document = (object)[
            'id' => rand(1000, 9999),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'type' => $request->type,
            'filename' => $filename,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'uploaded_at' => now(),
            'status' => 'pending'
        ];
        
        return response()->json([
            'message' => 'Dokumen berhasil diunggah',
            'document' => $document,
            'success' => true
        ]);
    }
    
    /**
     * Download document.
     */
    public function download($id)
    {
        $student = Auth::user()->profile;
        $document = $this->getDocumentById($id);
        
        if (!$document) {
            abort(404, 'Dokumen tidak ditemukan');
        }
        
        // Check if user has access to this document
        if ($document->student_id !== $student->id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini');
        }
        
        // Placeholder for actual download
        return response()->json([
            'message' => 'Dokumen berhasil diunduh',
            'filename' => $document->filename,
            'success' => true
        ]);
    }
    
    /**
     * Delete document.
     */
    public function delete($id)
    {
        $student = Auth::user()->profile;
        $document = $this->getDocumentById($id);
        
        if (!$document) {
            abort(404, 'Dokumen tidak ditemukan');
        }
        
        // Check if user has access to this document
        if ($document->student_id !== $student->id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini');
        }
        
        // Placeholder for actual deletion
        return response()->json([
            'message' => 'Dokumen berhasil dihapus',
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
     * Get documents with filters.
     */
    private function getDocuments($student, $search, $category, $type, $status)
    {
        // Placeholder data - implement with actual documents
        $documents = collect([
            (object)[
                'id' => 1,
                'title' => 'Ijazah SD',
                'description' => 'Ijazah Sekolah Dasar',
                'category' => 'academic',
                'type' => 'pdf',
                'filename' => 'ijazah_sd.pdf',
                'file_size' => 2048576,
                'uploaded_at' => now()->subDays(30),
                'status' => 'verified',
                'student_id' => $student->id
            ],
            (object)[
                'id' => 2,
                'title' => 'Kartu Keluarga',
                'description' => 'Kartu Keluarga (KK)',
                'category' => 'personal',
                'type' => 'image',
                'filename' => 'kartu_keluarga.jpg',
                'file_size' => 1024000,
                'uploaded_at' => now()->subDays(25),
                'status' => 'verified',
                'student_id' => $student->id
            ],
            (object)[
                'id' => 3,
                'title' => 'Akta Kelahiran',
                'description' => 'Akta Kelahiran',
                'category' => 'personal',
                'type' => 'pdf',
                'filename' => 'akta_kelahiran.pdf',
                'file_size' => 1536000,
                'uploaded_at' => now()->subDays(20),
                'status' => 'verified',
                'student_id' => $student->id
            ],
            (object)[
                'id' => 4,
                'title' => 'Surat Keterangan Sehat',
                'description' => 'Surat Keterangan Sehat dari Dokter',
                'category' => 'medical',
                'type' => 'pdf',
                'filename' => 'surat_sehat.pdf',
                'file_size' => 512000,
                'uploaded_at' => now()->subDays(15),
                'status' => 'pending',
                'student_id' => $student->id
            ],
            (object)[
                'id' => 5,
                'title' => 'Foto 3x4',
                'description' => 'Foto berwarna 3x4 cm',
                'category' => 'personal',
                'type' => 'image',
                'filename' => 'foto_3x4.jpg',
                'file_size' => 256000,
                'uploaded_at' => now()->subDays(10),
                'status' => 'verified',
                'student_id' => $student->id
            ],
            (object)[
                'id' => 6,
                'title' => 'Rapor Semester 1',
                'description' => 'Rapor Semester 1 Kelas 7',
                'category' => 'academic',
                'type' => 'pdf',
                'filename' => 'rapor_sem1.pdf',
                'file_size' => 3072000,
                'uploaded_at' => now()->subDays(5),
                'status' => 'verified',
                'student_id' => $student->id
            ],
            (object)[
                'id' => 7,
                'title' => 'Sertifikat Prestasi',
                'description' => 'Sertifikat Juara 1 Lomba Matematika',
                'category' => 'other',
                'type' => 'pdf',
                'filename' => 'sertifikat_prestasi.pdf',
                'file_size' => 768000,
                'uploaded_at' => now()->subDays(3),
                'status' => 'pending',
                'student_id' => $student->id
            ],
            (object)[
                'id' => 8,
                'title' => 'Surat Izin Orang Tua',
                'description' => 'Surat Izin dari Orang Tua',
                'category' => 'personal',
                'type' => 'pdf',
                'filename' => 'surat_izin.pdf',
                'file_size' => 384000,
                'uploaded_at' => now()->subDays(1),
                'status' => 'verified',
                'student_id' => $student->id
            ]
        ]);
        
        // Apply filters
        if ($search) {
            $documents = $documents->filter(function($item) use ($search) {
                return stripos($item->title, $search) !== false || 
                       stripos($item->description, $search) !== false;
            });
        }
        
        if ($category) {
            $documents = $documents->filter(function($item) use ($category) {
                return $item->category === $category;
            });
        }
        
        if ($type) {
            $documents = $documents->filter(function($item) use ($type) {
                return $item->type === $type;
            });
        }
        
        if ($status) {
            $documents = $documents->filter(function($item) use ($status) {
                return $item->status === $status;
            });
        }
        
        return $documents;
    }
    
    /**
     * Get document statistics.
     */
    private function getDocumentStats($student)
    {
        return [
            'total_documents' => 8,
            'verified_documents' => 6,
            'pending_documents' => 2,
            'total_size' => '9.5 MB',
            'categories' => [
                'academic' => 2,
                'personal' => 4,
                'medical' => 1,
                'other' => 1
            ],
            'types' => [
                'pdf' => 6,
                'image' => 2,
                'document' => 0,
                'other' => 0
            ]
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
                'type' => 'document_uploaded',
                'title' => 'Surat Izin Orang Tua',
                'description' => 'Dokumen baru diunggah',
                'created_at' => now()->subHours(2)
            ],
            (object)[
                'id' => 2,
                'type' => 'document_verified',
                'title' => 'Foto 3x4',
                'description' => 'Dokumen telah diverifikasi',
                'created_at' => now()->subDays(1)
            ],
            (object)[
                'id' => 3,
                'type' => 'document_downloaded',
                'title' => 'Rapor Semester 1',
                'description' => 'Dokumen diunduh',
                'created_at' => now()->subDays(2)
            ]
        ]);
    }
    
    /**
     * Get document categories.
     */
    private function getDocumentCategories()
    {
        return [
            'academic' => 'Akademik',
            'personal' => 'Personal',
            'medical' => 'Kesehatan',
            'other' => 'Lainnya'
        ];
    }
    
    /**
     * Get filter options.
     */
    private function getFilterOptions($student)
    {
        return [
            'categories' => ['academic', 'personal', 'medical', 'other'],
            'types' => ['pdf', 'image', 'document', 'other'],
            'statuses' => ['verified', 'pending', 'rejected']
        ];
    }
    
    /**
     * Get document by ID.
     */
    private function getDocumentById($id)
    {
        $documents = $this->getDocuments(Auth::user()->profile, '', '', '', '');
        return $documents->where('id', $id)->first();
    }
    
    /**
     * Get document details.
     */
    private function getDocumentDetails($document)
    {
        return [
            'file_size_formatted' => $this->formatFileSize($document->file_size),
            'upload_date' => $document->uploaded_at->format('d M Y H:i'),
            'category_label' => $this->getDocumentCategories()[$document->category] ?? $document->category,
            'type_label' => strtoupper($document->type),
            'status_label' => ucfirst($document->status)
        ];
    }
    
    /**
     * Get related documents.
     */
    private function getRelatedDocuments($document)
    {
        $allDocuments = $this->getDocuments(Auth::user()->profile, '', '', '', '');
        return $allDocuments->filter(function($item) use ($document) {
            return $item->id !== $document->id && $item->category === $document->category;
        })->take(3);
    }
    
    /**
     * Get document history.
     */
    private function getDocumentHistory($document)
    {
        return collect([
            (object)[
                'action' => 'uploaded',
                'description' => 'Dokumen diunggah',
                'date' => $document->uploaded_at,
                'user' => 'Siswa'
            ],
            (object)[
                'action' => 'verified',
                'description' => 'Dokumen diverifikasi oleh admin',
                'date' => $document->uploaded_at->addHours(2),
                'user' => 'Admin'
            ]
        ]);
    }
    
    /**
     * Format file size.
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}