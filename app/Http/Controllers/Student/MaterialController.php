<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\AcademicYear;
use App\Models\Subject;
use App\Models\SchoolClass;

class MaterialController extends Controller
{
    /**
     * Display a listing of materials.
     */
    public function index(Request $request)
    {
        $student = Auth::user()->profile;
        $currentYear = $this->getCurrentAcademicYear();
        $studentClass = $student->class;
        
        // Get filter parameters
        $search = $request->get('search', '');
        $subject = $request->get('subject', '');
        $type = $request->get('type', '');
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        // Get materials with filters
        $materials = $this->getMaterials($studentClass, $search, $subject, $type, $sortBy, $sortOrder);
        
        // Get filter options
        $filterOptions = $this->getFilterOptions($studentClass);
        
        // Get recent materials
        $recentMaterials = $this->getRecentMaterials($studentClass);
        
        // Get favorite materials
        $favoriteMaterials = $this->getFavoriteMaterials($studentClass);
        
        // Get material statistics
        $stats = $this->getMaterialStats($studentClass);
        
        // Get upcoming materials
        $upcomingMaterials = $this->getUpcomingMaterials($studentClass);
        
        return view('student.materi.index', compact(
            'materials',
            'filterOptions',
            'recentMaterials',
            'favoriteMaterials',
            'stats',
            'upcomingMaterials',
            'search',
            'subject',
            'type',
            'sortBy',
            'sortOrder'
        ));
    }
    
    /**
     * Display the specified material.
     */
    public function show($id)
    {
        $student = Auth::user()->profile;
        $material = $this->getMaterialById($id);
        
        if (!$material) {
            abort(404, 'Materi tidak ditemukan');
        }
        
        // Get related materials
        $relatedMaterials = $this->getRelatedMaterials($material);
        
        // Get material comments
        $comments = $this->getMaterialComments($id);
        
        // Get material progress
        $progress = $this->getMaterialProgress($id, $student->id);
        
        return view('student.materi.show', compact(
            'material',
            'relatedMaterials',
            'comments',
            'progress'
        ));
    }
    
    /**
     * Download material file.
     */
    public function download($id)
    {
        $material = $this->getMaterialById($id);
        
        if (!$material) {
            abort(404, 'Materi tidak ditemukan');
        }
        
        // Placeholder - implement file download
        return response()->json([
            'message' => 'File download functionality will be implemented',
            'material' => $material->title,
            'file_type' => $material->file_type ?? 'PDF'
        ]);
    }
    
    /**
     * Toggle favorite material.
     */
    public function toggleFavorite($id)
    {
        $student = Auth::user()->profile;
        
        // Placeholder - implement favorite toggle
        return response()->json([
            'message' => 'Favorite toggle functionality will be implemented',
            'material_id' => $id,
            'student_id' => $student->id
        ]);
    }
    
    /**
     * Add material comment.
     */
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);
        
        $student = Auth::user()->profile;
        
        // Placeholder - implement comment storage
        return response()->json([
            'message' => 'Comment added successfully',
            'material_id' => $id,
            'student_id' => $student->id,
            'comment' => $request->comment
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
     * Get materials with filters.
     */
    private function getMaterials($class, $search, $subject, $type, $sortBy, $sortOrder)
    {
        // Placeholder data - implement with actual material data
        $materials = collect([
            (object)[
                'id' => 1,
                'title' => 'Persamaan Linear Satu Variabel',
                'subject' => 'Matematika',
                'teacher' => 'Bu Sari',
                'type' => 'pdf',
                'file_size' => '2.5 MB',
                'downloads' => 45,
                'views' => 120,
                'is_favorite' => true,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(1),
                'description' => 'Materi tentang persamaan linear satu variabel dengan contoh soal dan latihan.',
                'tags' => ['aljabar', 'linear', 'persamaan'],
                'difficulty' => 'medium'
            ],
            (object)[
                'id' => 2,
                'title' => 'Struktur Sel dan Organel',
                'subject' => 'IPA',
                'teacher' => 'Pak Budi',
                'type' => 'video',
                'file_size' => '15.2 MB',
                'downloads' => 38,
                'views' => 95,
                'is_favorite' => false,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(3),
                'description' => 'Video pembelajaran tentang struktur sel dan fungsi organel-organel sel.',
                'tags' => ['biologi', 'sel', 'organel'],
                'difficulty' => 'easy'
            ],
            (object)[
                'id' => 3,
                'title' => 'Sejarah Perjuangan Kemerdekaan',
                'subject' => 'IPS',
                'teacher' => 'Bu Dewi',
                'type' => 'presentation',
                'file_size' => '8.7 MB',
                'downloads' => 52,
                'views' => 140,
                'is_favorite' => true,
                'created_at' => now()->subWeek(),
                'updated_at' => now()->subDays(4),
                'description' => 'Presentasi tentang perjuangan kemerdekaan Indonesia.',
                'tags' => ['sejarah', 'kemerdekaan', 'perjuangan'],
                'difficulty' => 'hard'
            ],
            (object)[
                'id' => 4,
                'title' => 'Grammar: Present Perfect Tense',
                'subject' => 'Bahasa Inggris',
                'teacher' => 'Mr. John',
                'type' => 'document',
                'file_size' => '1.8 MB',
                'downloads' => 67,
                'views' => 180,
                'is_favorite' => false,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(1),
                'description' => 'Materi tentang present perfect tense dengan contoh dan latihan.',
                'tags' => ['grammar', 'tense', 'english'],
                'difficulty' => 'medium'
            ],
            (object)[
                'id' => 5,
                'title' => 'Pemrograman Dasar Python',
                'subject' => 'TIK',
                'teacher' => 'Pak Andi',
                'type' => 'code',
                'file_size' => '3.2 MB',
                'downloads' => 29,
                'views' => 75,
                'is_favorite' => true,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subHours(6),
                'description' => 'Tutorial pemrograman dasar menggunakan Python.',
                'tags' => ['programming', 'python', 'coding'],
                'difficulty' => 'hard'
            ]
        ]);
        
        // Apply filters
        if ($search) {
            $materials = $materials->filter(function($material) use ($search) {
                return stripos($material->title, $search) !== false || 
                       stripos($material->description, $search) !== false;
            });
        }
        
        if ($subject) {
            $materials = $materials->filter(function($material) use ($subject) {
                return $material->subject === $subject;
            });
        }
        
        if ($type) {
            $materials = $materials->filter(function($material) use ($type) {
                return $material->type === $type;
            });
        }
        
        // Apply sorting
        $materials = $materials->sortBy(function($material) use ($sortBy) {
            return $material->$sortBy;
        });
        
        if ($sortOrder === 'desc') {
            $materials = $materials->reverse();
        }
        
        return $materials;
    }
    
    /**
     * Get filter options.
     */
    private function getFilterOptions($class)
    {
        return [
            'subjects' => ['Matematika', 'IPA', 'IPS', 'Bahasa Indonesia', 'Bahasa Inggris', 'TIK', 'PJOK', 'Seni Budaya'],
            'types' => [
                'pdf' => 'PDF Document',
                'video' => 'Video',
                'presentation' => 'Presentation',
                'document' => 'Word Document',
                'code' => 'Code File',
                'image' => 'Image',
                'audio' => 'Audio'
            ],
            'difficulties' => ['easy', 'medium', 'hard'],
            'sort_options' => [
                'created_at' => 'Tanggal Upload',
                'title' => 'Judul',
                'subject' => 'Mata Pelajaran',
                'downloads' => 'Jumlah Download',
                'views' => 'Jumlah View'
            ]
        ];
    }
    
    /**
     * Get recent materials.
     */
    private function getRecentMaterials($class)
    {
        return collect([
            (object)[
                'id' => 1,
                'title' => 'Persamaan Linear Satu Variabel',
                'subject' => 'Matematika',
                'created_at' => now()->subDays(2)
            ],
            (object)[
                'id' => 2,
                'title' => 'Struktur Sel dan Organel',
                'subject' => 'IPA',
                'created_at' => now()->subDays(5)
            ],
            (object)[
                'id' => 3,
                'title' => 'Grammar: Present Perfect Tense',
                'subject' => 'Bahasa Inggris',
                'created_at' => now()->subDays(3)
            ]
        ]);
    }
    
    /**
     * Get favorite materials.
     */
    private function getFavoriteMaterials($class)
    {
        return collect([
            (object)[
                'id' => 1,
                'title' => 'Persamaan Linear Satu Variabel',
                'subject' => 'Matematika',
                'type' => 'pdf'
            ],
            (object)[
                'id' => 3,
                'title' => 'Sejarah Perjuangan Kemerdekaan',
                'subject' => 'IPS',
                'type' => 'presentation'
            ],
            (object)[
                'id' => 5,
                'title' => 'Pemrograman Dasar Python',
                'subject' => 'TIK',
                'type' => 'code'
            ]
        ]);
    }
    
    /**
     * Get material statistics.
     */
    private function getMaterialStats($class)
    {
        return [
            'total_materials' => 25,
            'downloaded_today' => 8,
            'favorites_count' => 12,
            'total_downloads' => 156,
            'completion_rate' => 78,
            'average_rating' => 4.2
        ];
    }
    
    /**
     * Get upcoming materials.
     */
    private function getUpcomingMaterials($class)
    {
        return collect([
            (object)[
                'title' => 'Integral dan Turunan',
                'subject' => 'Matematika',
                'teacher' => 'Bu Sari',
                'scheduled_date' => now()->addDays(2)
            ],
            (object)[
                'title' => 'Sistem Pencernaan Manusia',
                'subject' => 'IPA',
                'teacher' => 'Pak Budi',
                'scheduled_date' => now()->addDays(3)
            ],
            (object)[
                'title' => 'Database Management',
                'subject' => 'TIK',
                'teacher' => 'Pak Andi',
                'scheduled_date' => now()->addDays(5)
            ]
        ]);
    }
    
    /**
     * Get material by ID.
     */
    private function getMaterialById($id)
    {
        $materials = $this->getMaterials(null, '', '', '', 'created_at', 'desc');
        return $materials->where('id', $id)->first();
    }
    
    /**
     * Get related materials.
     */
    private function getRelatedMaterials($material)
    {
        return collect([
            (object)[
                'id' => 2,
                'title' => 'Struktur Sel dan Organel',
                'subject' => 'IPA',
                'type' => 'video'
            ],
            (object)[
                'id' => 3,
                'title' => 'Sejarah Perjuangan Kemerdekaan',
                'subject' => 'IPS',
                'type' => 'presentation'
            ]
        ]);
    }
    
    /**
     * Get material comments.
     */
    private function getMaterialComments($materialId)
    {
        return collect([
            (object)[
                'id' => 1,
                'student_name' => 'Ahmad Rizki',
                'comment' => 'Materi yang sangat membantu! Terima kasih.',
                'created_at' => now()->subHours(2),
                'is_helpful' => true
            ],
            (object)[
                'id' => 2,
                'student_name' => 'Siti Nurhaliza',
                'comment' => 'Bisa tolong jelaskan bagian yang sulit?',
                'created_at' => now()->subHours(5),
                'is_helpful' => false
            ]
        ]);
    }
    
    /**
     * Get material progress.
     */
    private function getMaterialProgress($materialId, $studentId)
    {
        return [
            'progress_percentage' => 75,
            'time_spent' => '15 menit',
            'last_accessed' => now()->subHours(2),
            'completion_status' => 'in_progress',
            'notes_count' => 3,
            'bookmarks_count' => 2
        ];
    }
}




