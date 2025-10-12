<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Achievement::query();

        // Filter by year
        if ($request->has('year') && $request->year) {
            $query->byYear($request->year);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by achievement level
        if ($request->has('level') && $request->level) {
            $query->byLevel($request->level);
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured === '1');
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('participant_names', 'like', "%{$search}%")
                  ->orWhere('competition_name', 'like', "%{$search}%");
            });
        }

        $achievements = $query->orderBy('date', 'desc')->paginate(15);
        
        // Get years, categories, and levels for filter
        $years = Achievement::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
            
        $categories = Achievement::select('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();
            
        $levels = [
            'kecamatan' => 'Kecamatan',
            'kota' => 'Kota/Kabupaten',
            'provinsi' => 'Provinsi',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional'
        ];

        return view('admin.achievements.index', compact('achievements', 'years', 'categories', 'levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['Akademik', 'Olahraga', 'Seni', 'Teknologi', 'Keagamaan', 'Lain-lain'];
        $levels = [
            'kecamatan' => 'Kecamatan',
            'kota' => 'Kota/Kabupaten',
            'provinsi' => 'Provinsi',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional'
        ];
        $ranks = ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Peserta'];
        $participantTypes = [
            'individual' => 'Individu',
            'team' => 'Tim'
        ];
        
        return view('admin.achievements.create', compact('categories', 'levels', 'ranks', 'participantTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'achievement_level' => 'required|in:kecamatan,kota,provinsi,nasional,internasional',
            'rank' => 'required|string|max:255',
            'participant_type' => 'required|in:individual,team',
            'participant_names' => 'required|string',
            'date' => 'required|date',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'competition_name' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');

        // Handle certificate image upload
        if ($request->hasFile('certificate_image')) {
            $image = $request->file('certificate_image');
            $imageName = time() . '_' . Str::slug($request->title) . '_certificate.' . $image->getClientOriginalExtension();
            $image->storeAs('public/achievements', $imageName);
            $data['certificate_image'] = $imageName;
        }

        Achievement::create($data);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Achievement $achievement)
    {
        return view('admin.achievements.show', compact('achievement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achievement $achievement)
    {
        $categories = ['Akademik', 'Olahraga', 'Seni', 'Teknologi', 'Keagamaan', 'Lain-lain'];
        $levels = [
            'kecamatan' => 'Kecamatan',
            'kota' => 'Kota/Kabupaten',
            'provinsi' => 'Provinsi',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional'
        ];
        $ranks = ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Peserta'];
        $participantTypes = [
            'individual' => 'Individu',
            'team' => 'Tim'
        ];
        
        return view('admin.achievements.edit', compact('achievement', 'categories', 'levels', 'ranks', 'participantTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Achievement $achievement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'achievement_level' => 'required|in:kecamatan,kota,provinsi,nasional,internasional',
            'rank' => 'required|string|max:255',
            'participant_type' => 'required|in:individual,team',
            'participant_names' => 'required|string',
            'date' => 'required|date',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'competition_name' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');

        // Handle certificate image upload
        if ($request->hasFile('certificate_image')) {
            // Delete old certificate
            if ($achievement->certificate_image) {
                Storage::delete('public/achievements/' . $achievement->certificate_image);
            }

            $image = $request->file('certificate_image');
            $imageName = time() . '_' . Str::slug($request->title) . '_certificate.' . $image->getClientOriginalExtension();
            $image->storeAs('public/achievements', $imageName);
            $data['certificate_image'] = $imageName;
        }

        $achievement->update($data);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achievement $achievement)
    {
        // Delete certificate image
        if ($achievement->certificate_image) {
            Storage::delete('public/achievements/' . $achievement->certificate_image);
        }

        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil dihapus.');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Achievement $achievement)
    {
        $achievement->update(['is_featured' => !$achievement->is_featured]);
        
        return response()->json([
            'success' => true,
            'is_featured' => $achievement->is_featured
        ]);
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,feature,unfeature,change_category,change_level',
            'achievement_ids' => 'required|array',
            'achievement_ids.*' => 'exists:achievements,id',
            'category' => 'nullable|string',
            'level' => 'nullable|in:kecamatan,kota,provinsi,nasional,internasional',
        ]);

        $achievementIds = $request->achievement_ids;

        switch ($request->action) {
            case 'delete':
                $achievements = Achievement::whereIn('id', $achievementIds)->get();
                foreach ($achievements as $achievement) {
                    if ($achievement->certificate_image) {
                        Storage::delete('public/achievements/' . $achievement->certificate_image);
                    }
                }
                Achievement::whereIn('id', $achievementIds)->delete();
                $message = 'Prestasi berhasil dihapus.';
                break;
            case 'feature':
                Achievement::whereIn('id', $achievementIds)->update(['is_featured' => true]);
                $message = 'Prestasi berhasil dijadikan featured.';
                break;
            case 'unfeature':
                Achievement::whereIn('id', $achievementIds)->update(['is_featured' => false]);
                $message = 'Prestasi berhasil dihapus dari featured.';
                break;
            case 'change_category':
                if (!$request->category) {
                    return redirect()->back()->withErrors(['category' => 'Kategori harus dipilih untuk aksi ini.']);
                }
                Achievement::whereIn('id', $achievementIds)->update(['category' => $request->category]);
                $message = 'Kategori prestasi berhasil diubah.';
                break;
            case 'change_level':
                if (!$request->level) {
                    return redirect()->back()->withErrors(['level' => 'Tingkat prestasi harus dipilih untuk aksi ini.']);
                }
                Achievement::whereIn('id', $achievementIds)->update(['achievement_level' => $request->level]);
                $message = 'Tingkat prestasi berhasil diubah.';
                break;
        }

        return redirect()->route('admin.achievements.index')->with('success', $message);
    }
}