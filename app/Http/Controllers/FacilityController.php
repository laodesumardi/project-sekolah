<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FacilityController extends Controller
{
    /**
     * Display a listing of facilities.
     */
    public function index(Request $request): View
    {
        $query = Facility::available()
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc');

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $facilities = $query->paginate(9);

        // Get category counts for filter
        $categoryCounts = Facility::available()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');

        return view('facilities.index', compact('facilities', 'categoryCounts'));
    }

    /**
     * Display the specified facility.
     */
    public function show(string $slug): View
    {
        $facility = Facility::where('slug', $slug)->firstOrFail();
        
        // Increment view count
        $facility->incrementViewCount();

        // Get related facilities (same category, exclude current)
        $relatedFacilities = Facility::available()
            ->where('category', $facility->category)
            ->where('id', '!=', $facility->id)
            ->orderBy('sort_order', 'asc')
            ->limit(3)
            ->get();

        return view('facilities.show', compact('facility', 'relatedFacilities'));
    }

    /**
     * Filter facilities via AJAX.
     */
    public function filter(Request $request)
    {
        $query = Facility::available()
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc');

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $facilities = $query->paginate(9);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('facilities.partials.facilities-grid', compact('facilities'))->render(),
                'pagination' => $facilities->links()->render()
            ]);
        }

        return view('facilities.index', compact('facilities'));
    }
}