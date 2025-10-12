<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\FacilityCategory;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of facilities.
     */
    public function index(Request $request)
    {
        $query = Facility::available()->with('category');
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        $facilities = $query->orderBy('name')->paginate(12);
        $categories = FacilityCategory::active()->orderBy('sort_order')->get();

        return view('frontend.facilities.index', compact('facilities', 'categories'));
    }

    /**
     * Display the specified facility.
     */
    public function show(Facility $facility)
    {
        $relatedFacilities = Facility::available()
            ->where('id', '!=', $facility->id)
            ->limit(4)
            ->get();

        return view('frontend.facilities.show', compact('facility', 'relatedFacilities'));
    }

    /**
     * Get facility data for API (modal).
     */
    public function apiShow(Facility $facility)
    {
        return response()->json([
            'id' => $facility->id,
            'name' => $facility->name,
            'description' => $facility->description,
            'image_url' => $facility->image_url,
            'capacity' => $facility->capacity,
            'is_available' => $facility->is_available,
            'category' => $facility->category ? [
                'id' => $facility->category->id,
                'name' => $facility->category->name,
            ] : null,
        ]);
    }
}
