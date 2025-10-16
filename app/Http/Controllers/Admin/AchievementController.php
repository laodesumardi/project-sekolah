<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Profile;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::with(['images', 'participants', 'teachers']);

        // Filter
        if ($request->has('level') && $request->level !== 'all') {
            $query->byLevel($request->level);
        }

        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        if ($request->has('year') && $request->year !== 'all') {
            $query->byYear($request->year);
        }

        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        if ($request->has('featured') && $request->featured !== 'all') {
            $query->where('is_featured', $request->featured === 'yes');
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $achievements = $query->orderBy('created_at', 'desc')->paginate(25);

        // Get statistics
        $stats = [
            'total' => Achievement::count(),
            'national' => Achievement::byLevel('nasional')->count(),
            'international' => Achievement::byLevel('internasional')->count(),
            'this_year' => Achievement::byYear(date('Y'))->count(),
            'views' => Achievement::sum('view_count') ?? 0
        ];

        return view('admin.achievements.index', compact('achievements', 'stats'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->with('profile')->get();
        $teachers = Teacher::with('user')->get();
        
        $categories = [
            'akademik' => 'Akademik',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
            'teknologi' => 'Teknologi',
            'keagamaan' => 'Keagamaan',
            'lomba' => 'Lomba',
            'kompetisi' => 'Kompetisi',
            'olimpiade' => 'Olimpiade',
            'lainnya' => 'Lainnya'
        ];

        $levels = [
            'sekolah' => 'Sekolah',
            'kecamatan' => 'Kecamatan',
            'kota' => 'Kota/Kabupaten',
            'provinsi' => 'Provinsi',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional'
        ];

        return view('admin.achievements.create', compact('students', 'teachers', 'categories', 'levels'));
    }

    public function store(Request $request)
    {
        \Log::info('Store method called with data: ' . json_encode($request->all()));
        \Log::info('Files received: ' . json_encode($request->allFiles()));
        
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:akademik,olahraga,seni,teknologi,keagamaan,lomba,kompetisi,olimpiade,lainnya',
            'achievement_level' => 'required|in:sekolah,kecamatan,kota,provinsi,nasional,internasional',
            'rank' => 'required|string|max:100',
            'event_name' => 'required|string|max:255',
            'date' => 'required|date',
            'participant_type' => 'required|in:individu,kelompok,tim',
            'description' => 'required|string',
            'organizer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'prize' => 'nullable|string|max:255',
            'score' => 'nullable|string|max:255',
            'video_url' => 'nullable|url|max:500',
            'news_url' => 'nullable|url|max:500',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'trophy_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'documentation_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:3072'
        ]);

        $data = $request->except(['participants', 'teachers']);
        $data['created_by'] = auth()->id();
        
        \Log::info('Data before file processing: ' . json_encode($data));

        // Handle certificate image
        if ($request->hasFile('certificate_image')) {
            $certificate = $request->file('certificate_image');
            $certificateName = time() . '_certificate.' . $certificate->getClientOriginalExtension();
            
            // Ensure directory exists
            $certDir = storage_path('app/public/achievements/certificates');
            if (!file_exists($certDir)) {
                mkdir($certDir, 0755, true);
            }
            
            $path = $certificate->storeAs('public/achievements/certificates', $certificateName);
            $data['certificate_image'] = $certificateName;
            
            // Verify file exists - check both possible paths
            $fullPath1 = storage_path('app/public/achievements/certificates/' . $certificateName);
            $fullPath2 = storage_path('app/' . $path);
            \Log::info('Certificate uploaded: ' . $certificateName . ' to path: ' . $path);
            \Log::info('Full path 1: ' . $fullPath1);
            \Log::info('Full path 2: ' . $fullPath2);
            \Log::info('File exists path 1: ' . (file_exists($fullPath1) ? 'Yes' : 'No'));
            \Log::info('File exists path 2: ' . (file_exists($fullPath2) ? 'Yes' : 'No'));
            
            // If file doesn't exist, try to find it
            if (!file_exists($fullPath1) && !file_exists($fullPath2)) {
                \Log::error('File not found in either path!');
                // Try to manually save the file using move method
                try {
                    $manualPath = storage_path('app/public/achievements/certificates/' . $certificateName);
                    $certificate->move(dirname($manualPath), basename($manualPath));
                    \Log::info('Manually saved to: ' . $manualPath);
                    \Log::info('Manual save exists: ' . (file_exists($manualPath) ? 'Yes' : 'No'));
                } catch (\Exception $e) {
                    \Log::error('Manual save failed: ' . $e->getMessage());
                }
            }
        } else {
            \Log::info('No certificate image received');
        }

        // Handle trophy image
        if ($request->hasFile('trophy_image')) {
            $trophy = $request->file('trophy_image');
            $trophyName = time() . '_trophy.' . $trophy->getClientOriginalExtension();
            
            // Ensure directory exists
            $trophyDir = storage_path('app/public/achievements/trophies');
            if (!file_exists($trophyDir)) {
                mkdir($trophyDir, 0755, true);
            }
            
            $path = $trophy->storeAs('public/achievements/trophies', $trophyName);
            $data['trophy_image'] = $trophyName;
            
            // Verify file exists - check both possible paths
            $fullPath1 = storage_path('app/public/achievements/trophies/' . $trophyName);
            $fullPath2 = storage_path('app/' . $path);
            \Log::info('Trophy uploaded: ' . $trophyName . ' to path: ' . $path);
            \Log::info('Full path 1: ' . $fullPath1);
            \Log::info('Full path 2: ' . $fullPath2);
            \Log::info('File exists path 1: ' . (file_exists($fullPath1) ? 'Yes' : 'No'));
            \Log::info('File exists path 2: ' . (file_exists($fullPath2) ? 'Yes' : 'No'));
            
            // If file doesn't exist, try to find it
            if (!file_exists($fullPath1) && !file_exists($fullPath2)) {
                \Log::error('Trophy file not found in either path!');
                // Try to manually save the file
                try {
                    $manualPath = storage_path('app/public/achievements/trophies/' . $trophyName);
                    $trophy->move(dirname($manualPath), basename($manualPath));
                    \Log::info('Manually saved trophy to: ' . $manualPath);
                    \Log::info('Manual save exists: ' . (file_exists($manualPath) ? 'Yes' : 'No'));
                } catch (\Exception $e) {
                    \Log::error('Manual trophy save failed: ' . $e->getMessage());
                }
            }
        } else {
            \Log::info('No trophy image received');
        }

        // Handle documentation images
        if ($request->hasFile('documentation_images')) {
            $docImages = [];
            
            // Ensure directory exists
            $docDir = storage_path('app/public/achievements/documentation');
            if (!file_exists($docDir)) {
                mkdir($docDir, 0755, true);
            }
            
            foreach ($request->file('documentation_images') as $image) {
                $imageName = time() . '_doc_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/achievements/documentation', $imageName);
                $docImages[] = $imageName;
                
                // Verify file exists
                $fullPath = storage_path('app/public/achievements/documentation/' . $imageName);
                \Log::info('Documentation image uploaded: ' . $imageName . ' to path: ' . $path);
                \Log::info('Full path: ' . $fullPath);
                \Log::info('File exists: ' . (file_exists($fullPath) ? 'Yes' : 'No'));
            }
            $data['documentation_images'] = $docImages;
        } else {
            \Log::info('No documentation images received');
        }

        \Log::info('Creating achievement with data: ' . json_encode($data));
        
        try {
            $achievement = Achievement::create($data);
            \Log::info('Achievement created successfully with ID: ' . $achievement->id);
        } catch (\Exception $e) {
            \Log::error('Error creating achievement: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan prestasi: ' . $e->getMessage());
        }


        \Log::info('Achievement creation completed successfully');
        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil ditambahkan!');
    }

    public function show(Achievement $achievement)
    {
        $achievement->load(['images', 'participants.student', 'teachers.teacher']);
        return view('admin.achievements.show', compact('achievement'));
    }

    public function edit(Achievement $achievement)
    {
        $students = User::where('role', 'student')->with('profile')->get();
        $teachers = Teacher::with('user')->get();
        
        $categories = [
            'akademik' => 'Akademik',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
            'teknologi' => 'Teknologi',
            'keagamaan' => 'Keagamaan',
            'lomba' => 'Lomba',
            'kompetisi' => 'Kompetisi',
            'olimpiade' => 'Olimpiade',
            'lainnya' => 'Lainnya'
        ];

        $levels = [
            'sekolah' => 'Sekolah',
            'kecamatan' => 'Kecamatan',
            'kota' => 'Kota/Kabupaten',
            'provinsi' => 'Provinsi',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional'
        ];

        $achievement->load(['participants', 'teachers']);

        return view('admin.achievements.edit', compact('achievement', 'students', 'teachers', 'categories', 'levels'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:akademik,olahraga,seni,teknologi,keagamaan,lomba,kompetisi,olimpiade,lainnya',
            'achievement_level' => 'required|in:sekolah,kecamatan,kota,provinsi,nasional,internasional',
            'rank' => 'required|string|max:100',
            'event_name' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'certificate_image' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'trophy_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'documentation_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:3072'
        ]);

        $data = $request->except(['participants', 'teachers']);
        $data['updated_by'] = auth()->id();

        // Handle certificate image removal
        if ($request->input('remove_certificate') == '1') {
            if ($achievement->certificate_image) {
                \Storage::delete('public/achievements/certificates/' . $achievement->certificate_image);
                $data['certificate_image'] = null;
                \Log::info('Certificate removed: ' . $achievement->certificate_image);
            }
        }
        
        // Debug: Log all files in request
        \Log::info('Files in request: ' . json_encode($request->allFiles()));
        \Log::info('Has certificate file: ' . ($request->hasFile('certificate_image') ? 'Yes' : 'No'));
        
        // Handle certificate image upload
        if ($request->hasFile('certificate_image')) {
            // Delete old certificate
            if ($achievement->certificate_image) {
                \Storage::delete('public/achievements/certificates/' . $achievement->certificate_image);
            }
            
            $certificate = $request->file('certificate_image');
            $certificateName = time() . '_certificate.' . $certificate->getClientOriginalExtension();
            
            // Ensure directory exists
            $certDir = storage_path('app/public/achievements/certificates');
            if (!file_exists($certDir)) {
                mkdir($certDir, 0755, true);
            }
            
            // Try storeAs first
            $path = $certificate->storeAs('public/achievements/certificates', $certificateName);
            $data['certificate_image'] = $certificateName;
            
            // Verify file exists
            $fullPath = storage_path('app/public/achievements/certificates/' . $certificateName);
            \Log::info('Certificate updated: ' . $certificateName . ' to path: ' . $path);
            \Log::info('File exists: ' . (file_exists($fullPath) ? 'Yes' : 'No'));
            
            // If storeAs fails, try direct save
            if (!file_exists($fullPath)) {
                \Log::info('storeAs failed, trying direct save...');
                $certificate->move($certDir, $certificateName);
                \Log::info('Direct save completed, file exists: ' . (file_exists($fullPath) ? 'Yes' : 'No'));
            }
            \Log::info('Full path: ' . $fullPath);
            \Log::info('Storage path: ' . storage_path('app/public/achievements/certificates/'));
            \Log::info('Directory contents: ' . implode(', ', scandir(storage_path('app/public/achievements/certificates/'))));
        }

        // Handle trophy image removal
        if ($request->input('remove_trophy') == '1') {
            if ($achievement->trophy_image) {
                \Storage::delete('public/achievements/trophies/' . $achievement->trophy_image);
                $data['trophy_image'] = null;
                \Log::info('Trophy removed: ' . $achievement->trophy_image);
            }
        }
        
        // Handle trophy image upload
        if ($request->hasFile('trophy_image')) {
            // Delete old trophy
            if ($achievement->trophy_image) {
                \Storage::delete('public/achievements/trophies/' . $achievement->trophy_image);
            }
            
            $trophy = $request->file('trophy_image');
            $trophyName = time() . '_trophy.' . $trophy->getClientOriginalExtension();
            
            // Ensure directory exists
            $trophyDir = storage_path('app/public/achievements/trophies');
            if (!file_exists($trophyDir)) {
                mkdir($trophyDir, 0755, true);
            }
            
            // Try storeAs first
            $path = $trophy->storeAs('public/achievements/trophies', $trophyName);
            $data['trophy_image'] = $trophyName;
            
            // Verify file exists
            $fullPath = storage_path('app/public/achievements/trophies/' . $trophyName);
            \Log::info('Trophy updated: ' . $trophyName . ' to path: ' . $path);
            \Log::info('File exists: ' . (file_exists($fullPath) ? 'Yes' : 'No'));
            
            // If storeAs fails, try direct save
            if (!file_exists($fullPath)) {
                \Log::info('Trophy storeAs failed, trying direct save...');
                $trophy->move($trophyDir, $trophyName);
                \Log::info('Trophy direct save completed, file exists: ' . (file_exists($fullPath) ? 'Yes' : 'No'));
            }
        }

        // Handle documentation images
        if ($request->hasFile('documentation_images')) {
            $docImages = $achievement->getDocumentationImagesArray();
            $docDir = storage_path('app/public/achievements/documentation');
            if (!file_exists($docDir)) {
                mkdir($docDir, 0755, true);
            }
            
            foreach ($request->file('documentation_images') as $image) {
                $imageName = time() . '_doc_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Try storeAs first
                $path = $image->storeAs('public/achievements/documentation', $imageName);
                $fullPath = storage_path('app/public/achievements/documentation/' . $imageName);
                
                // If storeAs fails, try direct save
                if (!file_exists($fullPath)) {
                    \Log::info('Doc storeAs failed, trying direct save...');
                    $image->move($docDir, $imageName);
                    \Log::info('Doc direct save completed, file exists: ' . (file_exists($fullPath) ? 'Yes' : 'No'));
                }
                
                $docImages[] = $imageName;
            }
            $data['documentation_images'] = $docImages;
        }

        \Log::info('Updating achievement with data: ' . json_encode($data));
        
        try {
            $achievement->update($data);
            \Log::info('Achievement updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating achievement: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui prestasi: ' . $e->getMessage());
        }


        \Log::info('Achievement update completed successfully');
        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil diperbarui!');
    }

    public function destroy(Achievement $achievement)
    {
        // Delete images
        if ($achievement->certificate_image) {
            Storage::delete('public/achievements/certificates/' . $achievement->certificate_image);
        }
        
        if ($achievement->trophy_image) {
            Storage::delete('public/achievements/trophies/' . $achievement->trophy_image);
        }

        $documentationImages = $achievement->getDocumentationImagesArray();
        if (!empty($documentationImages)) {
            foreach ($documentationImages as $image) {
                Storage::delete('public/achievements/documentation/' . $image);
            }
        }

        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil dihapus!');
    }

    public function toggleFeatured(Achievement $achievement)
    {
        $achievement->update(['is_featured' => !$achievement->is_featured]);
        
        return response()->json([
            'success' => true,
            'featured' => $achievement->is_featured
        ]);
    }

    public function togglePublished(Achievement $achievement)
    {
        $achievement->update(['is_published' => !$achievement->is_published]);
        
        return response()->json([
            'success' => true,
            'published' => $achievement->is_published
        ]);
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['error' => 'Tidak ada prestasi yang dipilih'], 400);
        }

        switch ($action) {
            case 'delete':
                Achievement::whereIn('id', $ids)->delete();
                return response()->json(['success' => 'Prestasi berhasil dihapus']);
                
            case 'publish':
                Achievement::whereIn('id', $ids)->update(['is_published' => true]);
                return response()->json(['success' => 'Prestasi berhasil dipublikasikan']);
                
            case 'unpublish':
                Achievement::whereIn('id', $ids)->update(['is_published' => false]);
                return response()->json(['success' => 'Prestasi berhasil diunpublish']);
                
            case 'featured':
                Achievement::whereIn('id', $ids)->update(['is_featured' => true]);
                return response()->json(['success' => 'Prestasi berhasil dijadikan unggulan']);
                
            case 'unfeatured':
                Achievement::whereIn('id', $ids)->update(['is_featured' => false]);
                return response()->json(['success' => 'Prestasi berhasil dihapus dari unggulan']);
        }

        return response()->json(['error' => 'Aksi tidak valid'], 400);
    }
}