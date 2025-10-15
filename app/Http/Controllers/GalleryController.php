<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Display a listing of galleries.
     */
    public function index(Request $request): View
    {
        $query = Gallery::published()->with(['images' => function ($q) {
            $q->orderBy('sort_order')->orderBy('created_at');
        }]);

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('date', 'asc')->orderBy('created_at', 'asc');
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
                $query->recent();
                break;
        }

        $galleries = $query->paginate(12);

        // Get featured galleries for carousel
        $featuredGalleries = Gallery::published()
            ->featured()
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order')->orderBy('created_at');
            }])
            ->recent()
            ->limit(3)
            ->get();

        // Get categories for filter
        $categories = [
            'all' => 'Semua',
            'kegiatan' => 'Kegiatan',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'event' => 'Event',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni',
            'akademik' => 'Akademik',
            'lainnya' => 'Lainnya'
        ];

        return view('gallery.index', compact('galleries', 'featuredGalleries', 'categories'));
    }

    /**
     * Display the specified gallery.
     */
    public function show(string $slug): View
    {
        $gallery = Gallery::published()
            ->where('slug', $slug)
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order')->orderBy('created_at');
            }])
            ->firstOrFail();

        // Increment view count
        $gallery->incrementViewCount();

        // Get related galleries
        $relatedGalleries = Gallery::published()
            ->where('category', $gallery->category)
            ->where('id', '!=', $gallery->id)
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order')->orderBy('created_at');
            }])
            ->recent()
            ->limit(3)
            ->get();

        return view('gallery.show', compact('gallery', 'relatedGalleries'));
    }

    /**
     * Filter galleries via AJAX.
     */
    public function filter(Request $request)
    {
        $query = Gallery::published()->with(['images' => function ($q) {
            $q->orderBy('sort_order')->orderBy('created_at');
        }]);

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('date', 'asc')->orderBy('created_at', 'asc');
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
                $query->recent();
                break;
        }

        $galleries = $query->paginate(12);

        return view('gallery.partials.gallery-grid', compact('galleries'));
    }
}