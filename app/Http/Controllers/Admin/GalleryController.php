<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Gallery::query();

        // Filter by category
        if ($request->has('category') && $request->category && $request->category !== 'all') {
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
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $galleries = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(20);
        
        // Get categories for filter
        $categories = Gallery::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get();

        return view('admin.gallery.index', compact('galleries', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'alt_text' => 'nullable|string|max:255',
            'category' => 'required|in:general,kegiatan,prestasi,fasilitas,event',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            
            // Store original image
            $image->storeAs('public/gallery', $imageName);
            
            // Create thumbnail
            $thumbnail = Image::make($image)->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $thumbnailName = 'thumb_' . $imageName;
            $thumbnail->save(storage_path('app/public/gallery/thumbnails/' . $thumbnailName));
            
            $data['image'] = $imageName;
            $data['thumbnail'] = $thumbnailName;
            
            // Get image info
            $data['file_size'] = $image->getSize();
            $data['dimensions'] = $image->getWidth() . 'x' . $image->getHeight();
        }

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('admin.gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'alt_text' => 'nullable|string|max:255',
            'category' => 'required|in:general,kegiatan,prestasi,fasilitas,event',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old images
            if ($gallery->image) {
                Storage::delete('public/gallery/' . $gallery->image);
                Storage::delete('public/gallery/thumbnails/' . $gallery->thumbnail);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            
            // Store original image
            $image->storeAs('public/gallery', $imageName);
            
            // Create thumbnail
            $thumbnail = Image::make($image)->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $thumbnailName = 'thumb_' . $imageName;
            $thumbnail->save(storage_path('app/public/gallery/thumbnails/' . $thumbnailName));
            
            $data['image'] = $imageName;
            $data['thumbnail'] = $thumbnailName;
            
            // Get image info
            $data['file_size'] = $image->getSize();
            $data['dimensions'] = $image->getWidth() . 'x' . $image->getHeight();
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete image files
        if ($gallery->image) {
            Storage::delete('public/gallery/' . $gallery->image);
            Storage::delete('public/gallery/thumbnails/' . $gallery->thumbnail);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }

    /**
     * Bulk upload images.
     */
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'images' => 'required|array|max:20',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'category' => 'required|in:general,kegiatan,prestasi,fasilitas,event',
            'title_prefix' => 'nullable|string|max:100',
        ]);

        $uploadedCount = 0;
        $errors = [];

        foreach ($request->file('images') as $index => $image) {
            try {
                $imageName = time() . '_' . $index . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                
                // Store original image
                $image->storeAs('public/gallery', $imageName);
                
                // Create thumbnail
                $thumbnail = Image::make($image)->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                $thumbnailName = 'thumb_' . $imageName;
                $thumbnail->save(storage_path('app/public/gallery/thumbnails/' . $thumbnailName));
                
                Gallery::create([
                    'title' => ($request->title_prefix ? $request->title_prefix . ' ' : '') . ($index + 1),
                    'image' => $imageName,
                    'thumbnail' => $thumbnailName,
                    'category' => $request->category,
                    'file_size' => $image->getSize(),
                    'dimensions' => $image->getWidth() . 'x' . $image->getHeight(),
                    'sort_order' => $uploadedCount,
                ]);
                
                $uploadedCount++;
            } catch (\Exception $e) {
                $errors[] = "Gambar " . ($index + 1) . ": " . $e->getMessage();
            }
        }

        $message = "Berhasil mengupload {$uploadedCount} gambar.";
        if (!empty($errors)) {
            $message .= " Error: " . implode(', ', $errors);
        }

        return redirect()->route('admin.gallery.index')
            ->with('success', $message);
    }

    /**
     * Update sort order.
     */
    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:galleries,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            Gallery::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Gallery $gallery)
    {
        $gallery->update(['is_active' => !$gallery->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $gallery->is_active
        ]);
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'gallery_ids' => 'required|array',
            'gallery_ids.*' => 'exists:galleries,id'
        ]);

        $galleryIds = $request->gallery_ids;

        switch ($request->action) {
            case 'delete':
                $galleries = Gallery::whereIn('id', $galleryIds)->get();
                foreach ($galleries as $gallery) {
                    if ($gallery->image) {
                        Storage::delete('public/gallery/' . $gallery->image);
                        Storage::delete('public/gallery/thumbnails/' . $gallery->thumbnail);
                    }
                }
                Gallery::whereIn('id', $galleryIds)->delete();
                $message = 'Galeri berhasil dihapus.';
                break;
            case 'activate':
                Gallery::whereIn('id', $galleryIds)->update(['is_active' => true]);
                $message = 'Galeri berhasil diaktifkan.';
                break;
            case 'deactivate':
                Gallery::whereIn('id', $galleryIds)->update(['is_active' => false]);
                $message = 'Galeri berhasil dinonaktifkan.';
                break;
        }

        return redirect()->route('admin.gallery.index')->with('success', $message);
    }
}