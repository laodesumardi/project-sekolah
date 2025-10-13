<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\RegistrationSetting;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PPDBController extends Controller
{
    /**
     * Display PPDB landing page.
     */
    public function index()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        if (!$currentYear) {
            abort(404, 'Tahun ajaran aktif tidak ditemukan.');
        }

        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)
            ->where('is_active', true)
            ->first();

        if (!$setting) {
            abort(404, 'Pendaftaran PPDB belum dibuka.');
        }

        // Statistics
        $totalRegistrations = Registration::where('academic_year_id', $currentYear->id)->count();
        $pendingCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'pending')->count();
        $acceptedCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'accepted')->count();

        return view('ppdb.index', compact('setting', 'totalRegistrations', 'pendingCount', 'acceptedCount'));
    }

    /**
     * Display registration form.
     */
    public function form()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        if (!$currentYear) {
            abort(404, 'Tahun ajaran aktif tidak ditemukan.');
        }

        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)
            ->where('is_active', true)
            ->first();

        if (!$setting || !$setting->isRegistrationOpen()) {
            return redirect()->route('ppdb.index')
                ->with('error', 'Pendaftaran PPDB belum dibuka atau sudah ditutup.');
        }

        return view('ppdb.form', compact('setting'));
    }


    /**
     * Submit simplified registration.
     */
    public function submit(Request $request)
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        if (!$currentYear) {
            return back()->with('error', 'Tahun akademik aktif tidak ditemukan.');
        }

        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)
            ->where('is_active', true)
            ->first();

        if (!$setting || !$setting->isRegistrationOpen()) {
            return back()->with('error', 'Pendaftaran PPDB belum dibuka atau sudah ditutup.');
        }

        // Validation rules untuk form yang disederhanakan
        $request->validate([
            'registration_path' => 'required|in:regular,achievement,affirmation',
            'full_name' => 'required|string|max:255',
            'nisn' => 'required|string|max:10|min:10|unique:registrations,nisn',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today|after:2005-01-01',
            'gender' => 'required|in:L,P',
            'religion' => 'required|string|max:50',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'father_occupation' => 'nullable|string|max:100',
            'mother_occupation' => 'nullable|string|max:100',
            'phone' => 'required|string|min:10|max:15',
            'email' => 'required|email|unique:registrations,email',
            'address' => 'required|string|max:500',
            'photo' => 'required|image|max:2048|mimes:jpg,jpeg,png',
            // Prestasi fields (optional untuk jalur prestasi)
            'achievement_name' => 'nullable|string|max:255',
            'achievement_level' => 'nullable|string|max:50',
            'achievement_year' => 'nullable|integer|min:2020|max:2025',
            'achievement_rank' => 'nullable|string|max:100',
        ]);

        // Check quota
        $currentCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('registration_path', $request->registration_path)
            ->count();

        $quotaField = 'quota_' . $request->registration_path;
        if ($currentCount >= $setting->$quotaField) {
            return back()->with('error', "Kuota jalur {$request->registration_path} sudah penuh.");
        }

        // Generate registration number
        $year = date('Y');
        $lastRegistration = Registration::where('academic_year_id', $currentYear->id)
            ->where('registration_number', 'like', "PPDB{$year}%")
            ->orderBy('registration_number', 'desc')
            ->first();
        
        $sequence = 1;
        if ($lastRegistration) {
            $lastSequence = (int) substr($lastRegistration->registration_number, -4);
            $sequence = $lastSequence + 1;
        }
        
        $registrationNumber = "PPDB{$year}" . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('registrations', 'public');
        }

        // Create registration
        $registration = Registration::create([
            'academic_year_id' => $currentYear->id,
            'registration_setting_id' => $setting->id,
            'registration_number' => $registrationNumber,
            'registration_path' => $request->registration_path,
            'full_name' => $request->full_name,
            'nisn' => $request->nisn,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'father_occupation' => $request->father_occupation,
            'mother_occupation' => $request->mother_occupation,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'photo' => $photoPath,
            'achievement_name' => $request->achievement_name,
            'achievement_level' => $request->achievement_level,
            'achievement_year' => $request->achievement_year,
            'achievement_rank' => $request->achievement_rank,
            'status' => 'pending',
        ]);

        return redirect()->route('ppdb.confirmation', $registration->registration_number)
            ->with('success', 'Pendaftaran berhasil! Nomor pendaftaran Anda: ' . $registrationNumber);
    }

    /**
     * Display confirmation page.
     */
    public function confirmation($registrationNumber)
    {
        $registration = Registration::where('registration_number', $registrationNumber)->firstOrFail();

        return view('ppdb.confirmation', compact('registration'));
    }

    /**
     * Download registration form.
     */
    public function downloadForm($registrationNumber)
    {
        $registration = Registration::where('registration_number', $registrationNumber)->firstOrFail();

        return view('ppdb.download-form', compact('registration'));
    }

    /**
     * Display status check form.
     */
    public function statusForm()
    {
        return view('ppdb.status');
    }

    /**
     * Check registration status.
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string',
        ]);

        $registration = Registration::where('registration_number', $request->registration_number)
            ->first();

        if (!$registration) {
            return back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        return back()->with('registration', $registration);
    }

    /**
     * Display announcement page.
     */
    public function announcement(Request $request)
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        $query = Registration::where('academic_year_id', $currentYear->id)
            ->whereIn('status', ['accepted', 'rejected', 'reserved']);

        // Filter by path
        if ($request->path) {
            $query->where('registration_path', $request->path);
        }

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('registration_number', 'like', '%' . $request->search . '%');
            });
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('ppdb.announcement', compact('registrations'));
    }

}

