<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FacilityController extends Controller
{
    /**
     * Display a listing of facilities.
     */
    public function index(Request $request): View
    {
        $query = Facility::with(['creator', 'updater']);

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_available', $request->status === 'available');
        }

        $facilities = $query->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistics
        $stats = [
            'total' => Facility::count(),
            'available' => Facility::where('is_available', true)->count(),
            'unavailable' => Facility::where('is_available', false)->count(),
            'total_views' => Facility::sum('view_count')
        ];

        return view('admin.facilities.index', compact('facilities', 'stats'));
    }

    /**
     * Show the form for creating a new facility.
     */
    public function create(): View
    {
        return view('admin.facilities.create');
    }

    /**
     * Store a newly created facility.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:facilities,name',
            'slug' => 'required|string|max:255|unique:facilities,slug',
            'category' => 'required|in:ruang_kelas,laboratorium,olahraga,perpustakaan,mushola,kantin,lainnya',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'description' => 'required|string|max:5000',
            'capacity' => 'nullable|integer|min:1',
            'location' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:50',
            'facilities_spec' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_available' => 'boolean'
        ], [
            'name.required' => 'Nama fasilitas wajib diisi.',
            'name.unique' => 'Nama fasilitas sudah digunakan.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.unique' => 'Slug sudah digunakan.',
            'category.required' => 'Kategori wajib dipilih.',
            'image.required' => 'Gambar fasilitas wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.max' => 'Deskripsi maksimal 5000 karakter.'
        ]);

        DB::beginTransaction();
        try {
            $imagePath = null;
            $thumbnailPath = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Generate unique filename
                $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                
                // Store original image
                $imagePath = $image->storeAs('facilities', $filename, 'public');
                
                // Generate thumbnail
                $thumbnailPath = 'facilities/thumbnails/' . $filename;
                
                // Create thumbnail directory if not exists
                if (!Storage::disk('public')->exists('facilities/thumbnails')) {
                    Storage::disk('public')->makeDirectory('facilities/thumbnails');
                }
                
                // Generate thumbnail using Intervention Image
                $manager = new ImageManager(new Driver());
                $manager->read($image)
                    ->cover(400, 300)
                    ->save(storage_path('app/public/' . $thumbnailPath));
                
                // Optimize original image
                $manager->read(storage_path('app/public/' . $imagePath))
                    ->scaleDown(1200)
                    ->save(storage_path('app/public/' . $imagePath), 85);
            }

            // Create facility
            Facility::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'category' => $request->category,
                'description' => $request->description,
                'capacity' => $request->capacity,
                'location' => $request->location,
                'floor' => $request->floor,
                'image' => $imagePath,
                'thumbnail' => $thumbnailPath,
                'facilities_spec' => $request->facilities_spec,
                'sort_order' => $request->sort_order ?? 0,
                'is_available' => $request->has('is_available'),
                'created_by' => auth()->id()
            ]);

            DB::commit();

            return redirect()
                ->route('admin.facilities.index')
                ->with('success', 'Fasilitas berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded images if exists
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
                Storage::disk('public')->delete($thumbnailPath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan fasilitas: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified facility.
     */
    public function show(Facility $facility): View
    {
        return view('admin.facilities.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified facility.
     */
    public function edit(Facility $facility): View
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    /**
     * Update the specified facility.
     */
    public function update(Request $request, Facility $facility): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:facilities,name,' . $facility->id,
            'slug' => 'required|string|max:255|unique:facilities,slug,' . $facility->id,
            'category' => 'required|in:ruang_kelas,laboratorium,olahraga,perpustakaan,mushola,kantin,lainnya',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'description' => 'required|string|max:5000',
            'capacity' => 'nullable|integer|min:1',
            'location' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:50',
            'facilities_spec' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_available' => 'boolean'
        ]);

        DB::beginTransaction();
        try {
            $imagePath = $facility->image;
            $thumbnailPath = $facility->thumbnail;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Delete old images
                if ($facility->image) {
                    Storage::disk('public')->delete($facility->image);
                }
                if ($facility->thumbnail) {
                    Storage::disk('public')->delete($facility->thumbnail);
                }
                
                // Generate unique filename
                $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                
                // Store original image
                $imagePath = $image->storeAs('facilities', $filename, 'public');
                
                // Generate thumbnail
                $thumbnailPath = 'facilities/thumbnails/' . $filename;
                
                // Generate thumbnail using Intervention Image
                $manager = new ImageManager(new Driver());
                $manager->read($image)
                    ->cover(400, 300)
                    ->save(storage_path('app/public/' . $thumbnailPath));
                
                // Optimize original image
                $manager->read(storage_path('app/public/' . $imagePath))
                    ->scaleDown(1200)
                    ->save(storage_path('app/public/' . $imagePath), 85);
            }

            // Update facility
            $facility->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'category' => $request->category,
                'description' => $request->description,
                'capacity' => $request->capacity,
                'location' => $request->location,
                'floor' => $request->floor,
                'image' => $imagePath,
                'thumbnail' => $thumbnailPath,
                'facilities_spec' => $request->facilities_spec,
                'sort_order' => $request->sort_order ?? 0,
                'is_available' => $request->has('is_available'),
                'updated_by' => auth()->id()
            ]);

            DB::commit();

            return redirect()
                ->route('admin.facilities.index')
                ->with('success', 'Fasilitas berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui fasilitas: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified facility.
     */
    public function destroy(Facility $facility): RedirectResponse
    {
        try {
            // Delete images
            if ($facility->image) {
                Storage::disk('public')->delete($facility->image);
            }
            if ($facility->thumbnail) {
                Storage::disk('public')->delete($facility->thumbnail);
            }

            $facility->delete();

            return redirect()
                ->route('admin.facilities.index')
                ->with('success', 'Fasilitas berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus fasilitas: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete facilities.
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'facility_ids' => 'required|array',
            'facility_ids.*' => 'exists:facilities,id'
        ]);

        try {
            $facilities = Facility::whereIn('id', $request->facility_ids)->get();
            
            foreach ($facilities as $facility) {
                // Delete images
                if ($facility->image) {
                    Storage::disk('public')->delete($facility->image);
                }
                if ($facility->thumbnail) {
                    Storage::disk('public')->delete($facility->thumbnail);
                }
                
                $facility->delete();
            }

            return redirect()
                ->route('admin.facilities.index')
                ->with('success', count($facilities) . ' fasilitas berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus fasilitas: ' . $e->getMessage());
        }
    }

    /**
     * Bulk change status.
     */
    public function bulkStatus(Request $request): RedirectResponse
    {
        $request->validate([
            'facility_ids' => 'required|array',
            'facility_ids.*' => 'exists:facilities,id',
            'status' => 'required|boolean'
        ]);

        try {
            Facility::whereIn('id', $request->facility_ids)
                ->update([
                    'is_available' => $request->status,
                    'updated_by' => auth()->id()
                ]);

            $statusText = $request->status ? 'Tersedia' : 'Tidak Tersedia';
            
            return redirect()
                ->route('admin.facilities.index')
                ->with('success', 'Status ' . count($request->facility_ids) . ' fasilitas berhasil diubah menjadi ' . $statusText . '!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengubah status fasilitas: ' . $e->getMessage());
        }
    }
}