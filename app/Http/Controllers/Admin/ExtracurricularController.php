<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Teacher;
use App\Models\ExtracurricularImage;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExtracurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Extracurricular::with(['instructor', 'images']);

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
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
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('instructor', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $extracurriculars = $query->orderBy('category')->orderBy('name')->paginate(15);
        
        // Get categories for filter
        $categories = Extracurricular::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get();

        return view('admin.extracurriculars.index', compact('extracurriculars', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::orderBy('name')->get();
        $categories = ['Olahraga', 'Seni', 'Akademik', 'Keagamaan', 'Teknologi', 'Lain-lain'];
        return view('admin.extracurriculars.create', compact('teachers', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'schedule_day' => 'required|string',
            'schedule_time' => 'required|date_format:H:i',
            'instructor_id' => 'required|exists:teachers,id',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Handle icon upload with optimization
        if ($request->hasFile('icon')) {
            $imageService = new ImageService();
            $processedIcon = $imageService->processImage(
                $request->file('icon'),
                'extracurriculars/icons',
                [
                    'thumbnail' => [150, 150],
                    'medium' => [300, 300]
                ]
            );
            $data['icon'] = $processedIcon['original'];
        }

        $extracurricular = Extracurricular::create($data);

        // Handle multiple images upload with optimization
        if ($request->hasFile('images')) {
            $imageService = new ImageService();
            $processedImages = $imageService->processMultipleImages(
                $request->file('images'),
                'extracurriculars/gallery',
                [
                    'thumbnail' => [300, 300],
                    'medium' => [800, 600],
                    'large' => [1200, 900]
                ]
            );

            foreach ($processedImages as $index => $imageSet) {
                $extracurricular->images()->create([
                    'image' => $imageSet['original'],
                    'thumbnail' => $imageSet['thumbnail'],
                    'medium' => $imageSet['medium'],
                    'large' => $imageSet['large'],
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('admin.extracurriculars.index')
            ->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Extracurricular $extracurricular)
    {
        $extracurricular->load(['instructor', 'images']);
        return view('admin.extracurriculars.show', compact('extracurricular'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Extracurricular $extracurricular)
    {
        $teachers = Teacher::orderBy('name')->get();
        $categories = ['Olahraga', 'Seni', 'Akademik', 'Keagamaan', 'Teknologi', 'Lain-lain'];
        $extracurricular->load('images');
        return view('admin.extracurriculars.edit', compact('extracurricular', 'teachers', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Extracurricular $extracurricular)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'schedule_day' => 'required|string',
            'schedule_time' => 'required|date_format:H:i',
            'instructor_id' => 'required|exists:teachers,id',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($extracurricular->icon) {
                Storage::delete('public/extracurriculars/' . $extracurricular->icon);
            }

            $icon = $request->file('icon');
            $iconName = time() . '_' . Str::slug($request->name) . '_icon.' . $icon->getClientOriginalExtension();
            $icon->storeAs('public/extracurriculars', $iconName);
            $data['icon'] = $iconName;
        }

        $extracurricular->update($data);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . Str::slug($request->name) . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/extracurriculars/images', $imageName);
                
                $extracurricular->images()->create([
                    'image' => $imageName,
                    'sort_order' => $extracurricular->images()->max('sort_order') + $index + 1
                ]);
            }
        }

        return redirect()->route('admin.extracurriculars.index')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Extracurricular $extracurricular)
    {
        // Delete icon
        if ($extracurricular->icon) {
            Storage::delete('public/extracurriculars/' . $extracurricular->icon);
        }

        // Delete images
        foreach ($extracurricular->images as $image) {
            Storage::delete('public/extracurriculars/images/' . $image->image);
        }

        $extracurricular->delete();

        return redirect()->route('admin.extracurriculars.index')
            ->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Extracurricular $extracurricular)
    {
        $extracurricular->update(['is_active' => !$extracurricular->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $extracurricular->is_active
        ]);
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,change_category',
            'extracurricular_ids' => 'required|array',
            'extracurricular_ids.*' => 'exists:extracurriculars,id',
            'category' => 'nullable|string',
        ]);

        $extracurricularIds = $request->extracurricular_ids;

        switch ($request->action) {
            case 'delete':
                $extracurriculars = Extracurricular::whereIn('id', $extracurricularIds)->get();
                foreach ($extracurriculars as $extracurricular) {
                    if ($extracurricular->icon) {
                        Storage::delete('public/extracurriculars/' . $extracurricular->icon);
                    }
                    foreach ($extracurricular->images as $image) {
                        Storage::delete('public/extracurriculars/images/' . $image->image);
                    }
                }
                Extracurricular::whereIn('id', $extracurricularIds)->delete();
                $message = 'Ekstrakurikuler berhasil dihapus.';
                break;
            case 'activate':
                Extracurricular::whereIn('id', $extracurricularIds)->update(['is_active' => true]);
                $message = 'Ekstrakurikuler berhasil diaktifkan.';
                break;
            case 'deactivate':
                Extracurricular::whereIn('id', $extracurricularIds)->update(['is_active' => false]);
                $message = 'Ekstrakurikuler berhasil dinonaktifkan.';
                break;
            case 'change_category':
                if (!$request->category) {
                    return redirect()->back()->withErrors(['category' => 'Kategori harus dipilih untuk aksi ini.']);
                }
                Extracurricular::whereIn('id', $extracurricularIds)->update(['category' => $request->category]);
                $message = 'Kategori ekstrakurikuler berhasil diubah.';
                break;
        }

        return redirect()->route('admin.extracurriculars.index')->with('success', $message);
    }
}