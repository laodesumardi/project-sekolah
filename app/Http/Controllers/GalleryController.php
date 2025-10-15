<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display the gallery index page.
     */
    public function index(Request $request)
    {
        $query = Gallery::published()->with(['images' => function($q) {
            $q->orderBy('sort_order')->orderBy('id');
        }]);

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Sort by date or created_at
        $sortBy = $request->get('sort', 'recent');
        if ($sortBy === 'oldest') {
            $query->orderBy('date', 'asc')->orderBy('created_at', 'asc');
        } else {
            $query->recent();
        }

        $galleries = $query->paginate(12);

        // Get categories for filter
        $categories = [
            'all' => 'Semua Kategori',
            'kegiatan' => 'Kegiatan',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'event' => 'Event',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
            'akademik' => 'Akademik',
            'lainnya' => 'Lainnya'
        ];

        // Get featured galleries
        $featuredGalleries = Gallery::published()
            ->featured()
            ->with(['images' => function($q) {
                $q->orderBy('sort_order')->orderBy('id');
            }])
            ->recent()
            ->limit(6)
            ->get();

        return view('gallery.index', compact('galleries', 'categories', 'featuredGalleries'));
    }

    /**
     * Display a specific gallery.
     */
    public function show($slug)
    {
        $gallery = Gallery::published()
            ->where('slug', $slug)
            ->with(['images' => function($q) {
                $q->orderBy('sort_order')->orderBy('id');
            }])
            ->firstOrFail();

        // Increment view count
        $gallery->incrementViewCount();

        // Get related galleries
        $relatedGalleries = Gallery::published()
            ->where('id', '!=', $gallery->id)
            ->where('category', $gallery->category)
            ->with(['images' => function($q) {
                $q->orderBy('sort_order')->orderBy('id');
            }])
            ->recent()
            ->limit(4)
            ->get();

        return view('gallery.show', compact('gallery', 'relatedGalleries'));
    }

    /**
     * Display gallery by category.
     */
    public function category($category)
    {
        $galleries = Gallery::published()
            ->byCategory($category)
            ->with(['images' => function($q) {
                $q->orderBy('sort_order')->orderBy('id');
            }])
            ->recent()
            ->paginate(12);

        $categoryName = [
            'kegiatan' => 'Kegiatan',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'event' => 'Event',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
            'akademik' => 'Akademik',
            'lainnya' => 'Lainnya'
        ][$category] ?? 'Kategori';

        return view('gallery.category', compact('galleries', 'categoryName', 'category'));
    }
}