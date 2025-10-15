<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ExtracurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $extracurriculars = Extracurricular::with(['instructor.user', 'images'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Extracurricular::count(),
            'active' => Extracurricular::where('is_active', true)->count(),
            'total_participants' => Extracurricular::sum('current_participants'),
            'pending_registrations' => \App\Models\ExtracurricularRegistration::where('status', 'pending')->count()
        ];

        return view('admin.extracurriculars.index', compact('extracurriculars', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.extracurriculars.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:extracurriculars,name',
            'category' => 'required|in:olahraga,seni,akademik,keagamaan,teknologi,bahasa,sosial,lainnya',
            'description' => 'required|string|min:50',
            'short_description' => 'nullable|string|max:500',
            'instructor_id' => 'nullable|exists:teachers,id',
            'instructor_name' => 'nullable|required_without:instructor_id|string|max:255',
            'schedule_day' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'schedule_time_start' => 'nullable|date_format:H:i',
            'schedule_time_end' => 'nullable|date_format:H:i|after:schedule_time_start',
            'location' => 'required|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'is_registration_open' => 'boolean',
            'registration_start' => 'nullable|date',
            'registration_end' => 'nullable|date|after_or_equal:registration_start',
            'requirements' => 'nullable|array',
            'benefits' => 'nullable|array',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png|max:3072',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        DB::beginTransaction();

        try {
            $data = $request->all();
            $data['slug'] = Str::slug($request->name);
            $data['created_by'] = auth()->id();

            // Handle Logo Upload
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoFilename = time() . '_logo_' . Str::slug($request->name) . '.' . $logo->getClientOriginalExtension();
                
                $logoPath = $logo->storeAs('extracurriculars/logos', $logoFilename, 'public');
                
                // Optimize logo (500x500)
                $manager = new ImageManager(new Driver());
                $logoImage = $manager->read($logo);
                $logoImage->cover(500, 500);
                $logoImage->save(Storage::disk('public')->path($logoPath), 90);
                
                $data['logo'] = $logoPath;
            }

            // Handle Cover Image Upload
            if ($request->hasFile('cover_image')) {
                $cover = $request->file('cover_image');
                $coverFilename = time() . '_cover_' . Str::slug($request->name) . '.' . $cover->getClientOriginalExtension();
                
                $coverPath = $cover->storeAs('extracurriculars/covers', $coverFilename, 'public');
                
                // Optimize cover (1920x1080)
                $manager = new ImageManager(new Driver());
                $coverImage = $manager->read($cover);
                $coverImage->cover(1920, 1080);
                $coverImage->save(Storage::disk('public')->path($coverPath), 85);
                
                // Generate thumbnail (800x450)
                $thumbnailFilename = time() . '_thumb_' . Str::slug($request->name) . '.' . $cover->getClientOriginalExtension();
                $thumbnailPath = 'extracurriculars/thumbnails/' . $thumbnailFilename;
                
                $thumbnailImage = $manager->read($cover);
                $thumbnailImage->cover(800, 450);
                $thumbnailImage->save(Storage::disk('public')->path($thumbnailPath), 80);
                
                $data['cover_image'] = $coverPath;
                $data['thumbnail'] = $thumbnailPath;
            }

            // Convert arrays to JSON
            if (isset($data['requirements'])) {
                $data['requirements'] = json_encode($data['requirements']);
            }
            if (isset($data['benefits'])) {
                $data['benefits'] = json_encode($data['benefits']);
            }

            // Convert checkboxes
            $data['is_registration_open'] = $request->has('is_registration_open');
            $data['is_active'] = $request->has('is_active');
            $data['is_featured'] = $request->has('is_featured');

            $extracurricular = Extracurricular::create($data);

            DB::commit();

            return redirect()
                ->route('admin.extracurriculars.index')
                ->with('success', 'Ekstrakurikuler berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan ekstrakurikuler: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $extracurricular = Extracurricular::with([
            'instructor.user',
            'images',
            'achievements',
            'registrations.student.user',
            'creator',
            'updater'
        ])->findOrFail($id);

        return view('admin.extracurriculars.show', compact('extracurricular'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $extracurricular = Extracurricular::findOrFail($id);
        $teachers = Teacher::with('user')->get();

        return view('admin.extracurriculars.edit', compact('extracurricular', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $extracurricular = Extracurricular::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:extracurriculars,name,' . $id,
            'category' => 'required|in:olahraga,seni,akademik,keagamaan,teknologi,bahasa,sosial,lainnya',
            'description' => 'required|string|min:50',
            'short_description' => 'nullable|string|max:500',
            'instructor_id' => 'nullable|exists:teachers,id',
            'instructor_name' => 'nullable|required_without:instructor_id|string|max:255',
            'schedule_day' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'schedule_time_start' => 'nullable|date_format:H:i',
            'schedule_time_end' => 'nullable|date_format:H:i|after:schedule_time_start',
            'location' => 'required|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'is_registration_open' => 'boolean',
            'registration_start' => 'nullable|date',
            'registration_end' => 'nullable|date|after_or_equal:registration_start',
            'requirements' => 'nullable|array',
            'benefits' => 'nullable|array',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png|max:3072',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        DB::beginTransaction();

        try {
            $data = $request->all();
            $data['slug'] = Str::slug($request->name);
            $data['updated_by'] = auth()->id();

            // Handle Logo
            if ($request->hasFile('logo')) {
                // Delete old logo
                if ($extracurricular->logo) {
                    Storage::disk('public')->delete($extracurricular->logo);
                }

                $logo = $request->file('logo');
                $logoFilename = time() . '_logo_' . Str::slug($request->name) . '.' . $logo->getClientOriginalExtension();
                
                $logoPath = $logo->storeAs('extracurriculars/logos', $logoFilename, 'public');
                
                $manager = new ImageManager(new Driver());
                $logoImage = $manager->read($logo);
                $logoImage->cover(500, 500);
                $logoImage->save(Storage::disk('public')->path($logoPath), 90);
                
                $data['logo'] = $logoPath;
            } elseif ($request->has('remove_logo')) {
                if ($extracurricular->logo) {
                    Storage::disk('public')->delete($extracurricular->logo);
                }
                $data['logo'] = null;
            }

            // Handle Cover Image
            if ($request->hasFile('cover_image')) {
                // Delete old cover & thumbnail
                if ($extracurricular->cover_image) {
                    Storage::disk('public')->delete($extracurricular->cover_image);
                }
                if ($extracurricular->thumbnail) {
                    Storage::disk('public')->delete($extracurricular->thumbnail);
                }

                $cover = $request->file('cover_image');
                $coverFilename = time() . '_cover_' . Str::slug($request->name) . '.' . $cover->getClientOriginalExtension();
                
                $coverPath = $cover->storeAs('extracurriculars/covers', $coverFilename, 'public');
                
                $manager = new ImageManager(new Driver());
                $coverImage = $manager->read($cover);
                $coverImage->cover(1920, 1080);
                $coverImage->save(Storage::disk('public')->path($coverPath), 85);
                
                // Generate thumbnail
                $thumbnailFilename = time() . '_thumb_' . Str::slug($request->name) . '.' . $cover->getClientOriginalExtension();
                $thumbnailPath = 'extracurriculars/thumbnails/' . $thumbnailFilename;
                
                $thumbnailImage = $manager->read($cover);
                $thumbnailImage->cover(800, 450);
                $thumbnailImage->save(Storage::disk('public')->path($thumbnailPath), 80);
                
                $data['cover_image'] = $coverPath;
                $data['thumbnail'] = $thumbnailPath;
            } elseif ($request->has('remove_cover')) {
                if ($extracurricular->cover_image) {
                    Storage::disk('public')->delete($extracurricular->cover_image);
                }
                if ($extracurricular->thumbnail) {
                    Storage::disk('public')->delete($extracurricular->thumbnail);
                }
                $data['cover_image'] = null;
                $data['thumbnail'] = null;
            }

            // Convert arrays to JSON
            if (isset($data['requirements'])) {
                $data['requirements'] = json_encode($data['requirements']);
            }
            if (isset($data['benefits'])) {
                $data['benefits'] = json_encode($data['benefits']);
            }

            // Convert checkboxes
            $data['is_registration_open'] = $request->has('is_registration_open');
            $data['is_active'] = $request->has('is_active');
            $data['is_featured'] = $request->has('is_featured');

            $extracurricular->update($data);

            DB::commit();

            return redirect()
                ->route('admin.extracurriculars.index')
                ->with('success', 'Ekstrakurikuler berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui ekstrakurikuler: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $extracurricular = Extracurricular::findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete images
            if ($extracurricular->logo) {
                Storage::disk('public')->delete($extracurricular->logo);
            }
            if ($extracurricular->cover_image) {
                Storage::disk('public')->delete($extracurricular->cover_image);
            }
            if ($extracurricular->thumbnail) {
                Storage::disk('public')->delete($extracurricular->thumbnail);
            }

            // Delete related images
            foreach ($extracurricular->images as $image) {
                Storage::disk('public')->delete($image->image);
                Storage::disk('public')->delete($image->thumbnail);
            }

            // Delete related achievements certificates
            foreach ($extracurricular->achievements as $achievement) {
                if ($achievement->certificate_image) {
                    Storage::disk('public')->delete($achievement->certificate_image);
                }
            }

            $extracurricular->delete();

            DB::commit();

            return redirect()
                ->route('admin.extracurriculars.index')
                ->with('success', 'Ekstrakurikuler berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus ekstrakurikuler: ' . $e->getMessage());
        }
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id)
    {
        $extracurricular = Extracurricular::findOrFail($id);
        $extracurricular->update(['is_active' => !$extracurricular->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $extracurricular->is_active
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,feature,unfeature',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:extracurriculars,id'
        ]);

        $ids = $request->ids;
        $action = $request->action;

        DB::beginTransaction();

        try {
            switch ($action) {
                case 'delete':
                    foreach ($ids as $id) {
                        $this->destroy($id);
                    }
                    $message = count($ids) . ' ekstrakurikuler berhasil dihapus!';
                    break;

                case 'activate':
                    Extracurricular::whereIn('id', $ids)->update(['is_active' => true]);
                    $message = count($ids) . ' ekstrakurikuler berhasil diaktifkan!';
                    break;

                case 'deactivate':
                    Extracurricular::whereIn('id', $ids)->update(['is_active' => false]);
                    $message = count($ids) . ' ekstrakurikuler berhasil dinonaktifkan!';
                    break;

                case 'feature':
                    Extracurricular::whereIn('id', $ids)->update(['is_featured' => true]);
                    $message = count($ids) . ' ekstrakurikuler berhasil dijadikan unggulan!';
                    break;

                case 'unfeature':
                    Extracurricular::whereIn('id', $ids)->update(['is_featured' => false]);
                    $message = count($ids) . ' ekstrakurikuler berhasil dihapus dari unggulan!';
                    break;
            }

            DB::commit();

            return redirect()
                ->route('admin.extracurriculars.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Gagal melakukan aksi massal: ' . $e->getMessage());
        }
    }
}
