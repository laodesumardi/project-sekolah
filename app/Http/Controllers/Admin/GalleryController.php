<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GalleryController extends Controller
{
    /**
     * Display a listing of galleries.
     */
    public function index(Request $request): View
    {
        $query = Gallery::with(['images', 'creator']);

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Filter by featured
        if ($request->filled('featured')) {
            if ($request->featured === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->featured === 'not_featured') {
                $query->where('is_featured', false);
            }
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'views':
                $query->orderBy('view_count', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default: // recent
                $query->orderBy('created_at', 'desc');
                break;
        }

        $galleries = $query->paginate(10);

        // Statistics
        $stats = [
            'total_albums' => Gallery::count(),
            'total_photos' => GalleryImage::count(),
            'featured_albums' => Gallery::featured()->count(),
            'total_views' => Gallery::sum('view_count')
        ];

        // Categories for filter
        $categories = [
            'kegiatan' => 'Kegiatan',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'event' => 'Event',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
            'akademik' => 'Akademik',
            'lainnya' => 'Lainnya'
        ];

        return view('admin.gallery.index', compact('galleries', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new gallery.
     */
    public function create(): View
    {
        $categories = [
            'kegiatan' => 'Kegiatan',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'event' => 'Event',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
            'akademik' => 'Akademik',
            'lainnya' => 'Lainnya'
        ];

        return view('admin.gallery.create', compact('categories'));
    }

    /**
     * Store a newly created gallery.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'category' => 'required|in:kegiatan,prestasi,fasilitas,event,olahraga,seni,akademik,lainnya',
            'date' => 'nullable|date|before_or_equal:today',
            'location' => 'nullable|string|max:255',
            'photographer' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max
            'image_titles' => 'nullable|array',
            'image_titles.*' => 'nullable|string|max:255',
            'image_captions' => 'nullable|array',
            'image_captions.*' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            // Create gallery
            $gallery = Gallery::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'category' => $request->category,
                'date' => $request->date,
                'location' => $request->location,
                'photographer' => $request->photographer,
                'is_published' => $request->has('is_published'),
                'is_featured' => $request->has('is_featured'),
                'created_by' => auth()->id()
            ]);

            // Handle image uploads
            if ($request->hasFile('images')) {
                $manager = new ImageManager(new Driver());
                $sortOrder = 0;

                foreach ($request->file('images') as $index => $image) {
                    // Generate unique filename
                    $filename = time() . '_' . $sortOrder . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                    
                    // Store original image
                    $imagePath = $image->storeAs('gallery', $filename, 'public');
                    
                    // Generate thumbnail
                    $thumbnailPath = 'gallery/thumbnails/' . $filename;
                    $manager->read($image)
                        ->cover(400, 300)
                        ->save(storage_path('app/public/' . $thumbnailPath));
                    
                    // Generate medium size
                    $mediumPath = 'gallery/medium/' . $filename;
                    $manager->read($image)
                        ->scaleDown(800)
                        ->save(storage_path('app/public/' . $mediumPath));
                    
                    // Get image dimensions
                    $imageInfo = getimagesize($image->getPathname());
                    
                    // Create gallery image record
                    GalleryImage::create([
                        'gallery_id' => $gallery->id,
                        'image' => $filename,
                        'thumbnail' => $filename,
                        'medium' => $filename,
                        'title' => $request->image_titles[$index] ?? null,
                        'caption' => $request->image_captions[$index] ?? null,
                        'alt_text' => $request->image_titles[$index] ?? $gallery->title,
                        'file_size' => $image->getSize(),
                        'mime_type' => $image->getMimeType(),
                        'width' => $imageInfo[0] ?? null,
                        'height' => $imageInfo[1] ?? null,
                        'sort_order' => $sortOrder,
                        'is_cover' => $sortOrder === 0 // First image as cover
                    ]);
                    
                    $sortOrder++;
                }
                
                // Update gallery with cover image and total photos
                $gallery->update([
                    'cover_image' => $gallery->images()->first()->image,
                    'total_photos' => $gallery->images()->count()
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.gallery.index')
                ->with('success', 'Album galeri berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat album: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified gallery.
     */
    public function show(Gallery $gallery): View
    {
        $gallery->load(['images' => function ($q) {
            $q->orderBy('sort_order')->orderBy('created_at');
        }, 'creator', 'updater']);

        return view('admin.gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified gallery.
     */
    public function edit(Gallery $gallery): View
    {
        $gallery->load(['images' => function ($q) {
            $q->orderBy('sort_order')->orderBy('created_at');
        }]);

        $categories = [
            'kegiatan' => 'Kegiatan',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'event' => 'Event',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
            'akademik' => 'Akademik',
            'lainnya' => 'Lainnya'
        ];

        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    /**
     * Update the specified gallery.
     */
    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'category' => 'required|in:kegiatan,prestasi,fasilitas,event,olahraga,seni,akademik,lainnya',
            'date' => 'nullable|date|before_or_equal:today',
            'location' => 'nullable|string|max:255',
            'photographer' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max
            'new_image_titles' => 'nullable|array',
            'new_image_titles.*' => 'nullable|string|max:255',
            'new_image_captions' => 'nullable|array',
            'new_image_captions.*' => 'nullable|string|max:500',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'integer|exists:gallery_images,id',
            'cover_image_id' => 'nullable|integer|exists:gallery_images,id'
        ]);

        DB::beginTransaction();
        try {
            // Update gallery basic info
            $gallery->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'category' => $request->category,
                'date' => $request->date,
                'location' => $request->location,
                'photographer' => $request->photographer,
                'is_published' => $request->has('is_published'),
                'is_featured' => $request->has('is_featured'),
                'updated_by' => auth()->id()
            ]);

            // Handle deleted images
            if ($request->has('deleted_images')) {
                foreach ($request->deleted_images as $imageId) {
                    $image = $gallery->images()->find($imageId);
                    if ($image) {
                        // Delete files from storage
                        Storage::disk('public')->delete($image->image);
                        Storage::disk('public')->delete($image->thumbnail);
                        Storage::disk('public')->delete($image->medium);
                        
                        // Delete from database
                        $image->delete();
                    }
                }
            }

            // Handle new images upload
            if ($request->hasFile('new_images')) {
                $sortOrder = $gallery->images()->max('sort_order') ?? 0;
                
                foreach ($request->file('new_images') as $index => $file) {
                    // Generate unique filename
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    
                    // Store original image
                    $imagePath = $file->storeAs('gallery', $filename, 'public');
                    
                    // Generate thumbnail and medium sizes
                    $thumbnailPath = 'gallery/thumbnails/' . $filename;
                    $mediumPath = 'gallery/medium/' . $filename;
                    
                    // Use ImageManager for Intervention Image v3
                    $manager = new ImageManager(new Driver());
                    
                    // Generate thumbnail (300x300)
                    $manager->read($file)
                        ->cover(300, 300)
                        ->save(storage_path('app/public/' . $thumbnailPath));
                    
                    // Generate medium size (800x600)
                    $manager->read($file)
                        ->scaleDown(800, 600)
                        ->save(storage_path('app/public/' . $mediumPath));
                    
                    // Optimize original image
                    $manager->read(storage_path('app/public/' . $imagePath))
                        ->scaleDown(1200)
                        ->save(storage_path('app/public/' . $imagePath), 85);
                    
                    // Create gallery image record
                    $galleryImage = $gallery->images()->create([
                        'image' => $imagePath,
                        'thumbnail' => $thumbnailPath,
                        'medium' => $mediumPath,
                        'title' => $request->new_image_titles[$index] ?? null,
                        'caption' => $request->new_image_captions[$index] ?? null,
                        'alt_text' => $request->new_image_titles[$index] ?? $gallery->title,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'width' => getimagesize($file)[0],
                        'height' => getimagesize($file)[1],
                        'sort_order' => ++$sortOrder,
                        'is_cover' => false
                    ]);
                }
            }

            // Handle cover image change
            if ($request->has('cover_image_id')) {
                // Remove cover from all images
                $gallery->images()->update(['is_cover' => false]);
                
                // Set new cover
                $coverImage = $gallery->images()->find($request->cover_image_id);
                if ($coverImage) {
                    $coverImage->update(['is_cover' => true]);
                    $gallery->update(['cover_image' => $coverImage->image]);
                }
            }

            // Update total photos count
            $gallery->update(['total_photos' => $gallery->images()->count()]);

            DB::commit();

            return redirect()
                ->route('admin.gallery.index')
                ->with('success', 'Album galeri berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui album: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified gallery.
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        // Delete all images
        foreach ($gallery->images as $image) {
            Storage::disk('public')->delete('gallery/' . $image->image);
            Storage::disk('public')->delete('gallery/thumbnails/' . $image->thumbnail);
            Storage::disk('public')->delete('gallery/medium/' . $image->medium);
        }

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Album galeri berhasil dihapus!');
    }

    /**
     * Bulk delete galleries.
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'gallery_ids' => 'required|array',
            'gallery_ids.*' => 'exists:galleries,id'
        ]);

        $galleries = Gallery::whereIn('id', $request->gallery_ids)->get();

        foreach ($galleries as $gallery) {
            // Delete all images
            foreach ($gallery->images as $image) {
                Storage::disk('public')->delete('gallery/' . $image->image);
                Storage::disk('public')->delete('gallery/thumbnails/' . $image->thumbnail);
                Storage::disk('public')->delete('gallery/medium/' . $image->medium);
            }
            $gallery->delete();
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', count($galleries) . ' album galeri berhasil dihapus!');
    }

    /**
     * Bulk update gallery status.
     */
    public function bulkStatus(Request $request): RedirectResponse
    {
        $request->validate([
            'gallery_ids' => 'required|array',
            'gallery_ids.*' => 'exists:galleries,id',
            'action' => 'required|in:publish,unpublish,feature,unfeature'
        ]);

        $galleries = Gallery::whereIn('id', $request->gallery_ids);

        switch ($request->action) {
            case 'publish':
                $galleries->update(['is_published' => true]);
                $message = 'Album galeri berhasil dipublikasikan!';
                break;
            case 'unpublish':
                $galleries->update(['is_published' => false]);
                $message = 'Album galeri berhasil disembunyikan!';
                break;
            case 'feature':
                $galleries->update(['is_featured' => true]);
                $message = 'Album galeri berhasil dijadikan featured!';
                break;
            case 'unfeature':
                $galleries->update(['is_featured' => false]);
                $message = 'Album galeri berhasil dihapus dari featured!';
                break;
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', $message);
    }
}