<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of galleries.
     */
    public function index(Request $request)
    {
        $query = Gallery::active();

        // Filter by category
        if ($request->has('category') && $request->category && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('title', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $galleries = $query->paginate(20);

        // Get categories for filter
        $categories = Gallery::active()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get();

        return view('frontend.gallery.index', compact('galleries', 'categories'));
    }

    /**
     * Get gallery data for lightbox (AJAX).
     */
    public function getGalleryData(Request $request)
    {
        $galleries = Gallery::active()
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        $data = $galleries->map(function ($gallery) {
            return [
                'id' => $gallery->id,
                'title' => $gallery->title,
                'description' => $gallery->description,
                'image_url' => $gallery->image_url,
                'thumbnail_url' => $gallery->thumbnail_url,
                'alt_text' => $gallery->alt_text,
                'category' => $gallery->category,
                'file_size' => $gallery->formatted_file_size,
                'dimensions' => $gallery->dimensions,
            ];
        });

        return response()->json($data);
    }

    /**
     * Download gallery image.
     */
    public function download(Gallery $gallery)
    {
        if (!$gallery->is_active) {
            abort(404);
        }

        $filePath = storage_path('app/public/gallery/' . $gallery->image);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $gallery->title . '.jpg');
    }
}