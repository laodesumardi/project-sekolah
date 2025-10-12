<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Facility::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_available', $request->status);
        }

        // Sort functionality
        switch ($request->get('sort')) {
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'created_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        $facilities = $query->paginate(10)->withQueryString();
        return view('admin.facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = FacilityCategory::active()->orderBy('name')->get();
        return view('admin.facilities.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'capacity' => 'nullable|integer|min:1',
            'category_id' => 'nullable|exists:facility_categories,id',
            'is_available' => 'boolean',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/facilities', $imageName);
            $data['image'] = $imageName;
        }

        $data['is_available'] = $request->has('is_available');

        Facility::create($data);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        return view('admin.facilities.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        $categories = FacilityCategory::active()->orderBy('name')->get();
        return view('admin.facilities.edit', compact('facility', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'capacity' => 'nullable|integer|min:1',
            'category_id' => 'nullable|exists:facility_categories,id',
            'is_available' => 'boolean',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($facility->image) {
                Storage::delete('public/facilities/' . $facility->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/facilities', $imageName);
            $data['image'] = $imageName;
        }

        $data['is_available'] = $request->has('is_available');

        $facility->update($data);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        // Delete image file
        if ($facility->image) {
            Storage::delete('public/facilities/' . $facility->image);
        }

        $facility->delete();

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }

    /**
     * Toggle facility status
     */
    public function toggleStatus(Request $request, Facility $facility)
    {
        $facility->update([
            'is_available' => $request->is_available
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status fasilitas berhasil diubah'
        ]);
    }

    /**
     * Bulk actions for facilities
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:toggle,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:facilities,id'
        ]);

        $facilities = Facility::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'toggle':
                $facilities->update([
                    'is_available' => \DB::raw('NOT is_available')
                ]);
                $message = 'Status fasilitas berhasil diubah';
                break;
            
            case 'delete':
                // Delete images first
                $facilitiesToDelete = $facilities->get();
                foreach ($facilitiesToDelete as $facility) {
                    if ($facility->image) {
                        Storage::delete('public/facilities/' . $facility->image);
                    }
                }
                $facilities->delete();
                $message = 'Fasilitas berhasil dihapus';
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Export facilities to Excel/PDF
     */
    public function export(Request $request)
    {
        $facilities = Facility::with('category')->get();
        
        // For now, return JSON. You can implement Excel/PDF export later
        return response()->json([
            'success' => true,
            'data' => $facilities,
            'message' => 'Export functionality will be implemented'
        ]);
    }
}
