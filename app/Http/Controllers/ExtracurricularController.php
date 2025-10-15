<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use Illuminate\Http\Request;

class ExtracurricularController extends Controller
{
    public function index(Request $request)
    {
        $query = Extracurricular::with(['instructor.user', 'images'])
            ->active();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by day
        if ($request->filled('day')) {
            $query->where('schedule_day', $request->day);
        }

        // Filter by registration status
        if ($request->filled('registration')) {
            if ($request->registration === 'open') {
                $query->registrationOpen();
            }
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');

        switch ($sortBy) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'slots':
                $query->orderByRaw('(max_participants - current_participants) DESC');
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
        }

        // Featured
        $featured = Extracurricular::with(['instructor.user'])
            ->active()
            ->featured()
            ->limit(3)
            ->get();

        // Paginate
        $extracurriculars = $query->paginate(9);

        // Categories with count
        $categories = Extracurricular::select('category', \DB::raw('count(*) as total'))
            ->active()
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('extracurriculars.index', compact(
            'extracurriculars',
            'featured',
            'categories'
        ));
    }

    public function show($slug)
    {
        $extracurricular = Extracurricular::with([
            'instructor.user',
            'images' => function($q) {
                $q->orderBy('sort_order');
            },
            'achievements' => function($q) {
                $q->orderBy('date', 'desc');
            },
            'activeMembers.student.user'
        ])
        ->where('slug', $slug)
        ->active()
        ->firstOrFail();

        // Increment view count
        $extracurricular->incrementViewCount();

        // Related extracurriculars (same category)
        $relatedExtracurriculars = Extracurricular::where('category', $extracurricular->category)
            ->where('id', '!=', $extracurricular->id)
            ->active()
            ->limit(3)
            ->get();

        // Check if user already registered
        $isRegistered = false;
        $userRegistration = null;

        if (auth()->check() && auth()->user()->student) {
            $userRegistration = $extracurricular->registrations()
                ->where('student_id', auth()->user()->student->id)
                ->first();

            $isRegistered = $userRegistration !== null;
        }

        return view('extracurriculars.show', compact(
            'extracurricular',
            'relatedExtracurriculars',
            'isRegistered',
            'userRegistration'
        ));
    }

    public function register(Request $request, $id)
    {
        // Check if logged in
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // Check if student
        if (!auth()->user()->student) {
            return redirect()->back()
                ->with('error', 'Hanya siswa yang dapat mendaftar');
        }

        $extracurricular = Extracurricular::findOrFail($id);

        // Check if registration open
        if (!$extracurricular->isRegistrationPeriod()) {
            return redirect()->back()
                ->with('error', 'Pendaftaran tidak dibuka saat ini');
        }

        // Check if already registered
        $existingRegistration = $extracurricular->registrations()
            ->where('student_id', auth()->user()->student->id)
            ->first();

        if ($existingRegistration) {
            return redirect()->back()
                ->with('error', 'Anda sudah terdaftar di ekstrakurikuler ini');
        }

        // Check if has available slot
        if (!$extracurricular->hasAvailableSlot()) {
            return redirect()->back()
                ->with('error', 'Kuota sudah penuh');
        }

        // Validate request
        $request->validate([
            'reason' => 'required|string|min:50|max:500',
            'experience' => 'nullable|string|max:500',
            'requirements_agreed' => 'required|accepted',
            'parent_consent' => 'required|accepted'
        ], [
            'reason.required' => 'Alasan mendaftar wajib diisi',
            'reason.min' => 'Alasan mendaftar minimal 50 karakter',
            'reason.max' => 'Alasan mendaftar maksimal 500 karakter',
            'requirements_agreed.required' => 'Anda harus menyetujui persyaratan',
            'parent_consent.required' => 'Anda harus mendapat izin dari orang tua'
        ]);

        // Create registration
        $extracurricular->registrations()->create([
            'student_id' => auth()->user()->student->id,
            'registration_date' => now(),
            'status' => 'pending',
            'notes' => $request->reason . ($request->experience ? "\n\nPengalaman: " . $request->experience : '')
        ]);

        return redirect()->back()
            ->with('success', 'Pendaftaran berhasil! Silakan tunggu konfirmasi dari pembina.');
    }

    public function cancelRegistration($id)
    {
        if (!auth()->check() || !auth()->user()->student) {
            return redirect()->back()
                ->with('error', 'Akses ditolak');
        }

        $extracurricular = Extracurricular::findOrFail($id);

        $registration = $extracurricular->registrations()
            ->where('student_id', auth()->user()->student->id)
            ->where('status', 'pending')
            ->first();

        if (!$registration) {
            return redirect()->back()
                ->with('error', 'Pendaftaran tidak ditemukan');
        }

        $registration->delete();

        return redirect()->back()
            ->with('success', 'Pendaftaran berhasil dibatalkan');
    }

    public function filter(Request $request)
    {
        $query = Extracurricular::with(['instructor.user'])
            ->active();

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('day')) {
            $query->where('schedule_day', $request->day);
        }

        if ($request->filled('registration')) {
            if ($request->registration === 'open') {
                $query->registrationOpen();
            }
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort
        $sortBy = $request->get('sort', 'name');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'slots':
                $query->orderByRaw('(max_participants - current_participants) DESC');
                break;
            default:
                $query->orderBy($sortBy, 'asc');
        }

        $extracurriculars = $query->paginate(9);

        return response()->json([
            'html' => view('extracurriculars.partials.extracurricular-grid', compact('extracurriculars'))->render(),
            'pagination' => $extracurriculars->links()->render()
        ]);
    }
}
