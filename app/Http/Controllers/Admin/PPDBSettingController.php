<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrationSetting;
use App\Models\AcademicYear;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PPDBSettingController extends Controller
{
    /**
     * Display PPDB settings.
     */
    public function index()
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        $setting = null;
        $statistics = [
            'total_registrations' => 0,
            'accepted_count' => 0,
            'pending_count' => 0,
            'regular_count' => 0,
            'achievement_count' => 0,
            'affirmation_count' => 0,
        ];
        
        if ($currentYear) {
            $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)->first();
            
            if ($setting) {
                $statistics = [
                    'total_registrations' => Registration::where('academic_year_id', $setting->academic_year_id)->count(),
                    'accepted_count' => Registration::where('academic_year_id', $setting->academic_year_id)
                        ->where('status', 'accepted')->count(),
                    'pending_count' => Registration::where('academic_year_id', $setting->academic_year_id)
                        ->where('status', 'pending')->count(),
                    'regular_count' => Registration::where('academic_year_id', $setting->academic_year_id)
                        ->where('registration_path', 'regular')->count(),
                    'achievement_count' => Registration::where('academic_year_id', $setting->academic_year_id)
                        ->where('registration_path', 'achievement')->count(),
                    'affirmation_count' => Registration::where('academic_year_id', $setting->academic_year_id)
                        ->where('registration_path', 'affirmation')->count(),
                ];
            }
        }

        return view('admin.ppdb-settings.index', compact('academicYears', 'setting', 'statistics', 'currentYear'));
    }

    /**
     * Store PPDB settings.
     */
    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'quota_regular' => 'required|integer|min:0',
            'quota_achievement' => 'required|integer|min:0',
            'quota_affirmation' => 'required|integer|min:0',
            'registration_fee' => 'required|numeric|min:0',
            'announcement_date' => 'required|date|after:end_date',
            'is_active' => 'nullable|boolean',
            'information' => 'nullable|string|max:2000',
        ], [
            'information.max' => 'Deskripsi PPDB tidak boleh lebih dari 2000 karakter.',
            'start_date.required' => 'Tanggal mulai pendaftaran harus diisi.',
            'end_date.required' => 'Tanggal selesai pendaftaran harus diisi.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'announcement_date.after' => 'Tanggal pengumuman harus setelah tanggal selesai pendaftaran.',
            'quota_regular.required' => 'Kuota jalur reguler harus diisi.',
            'quota_achievement.required' => 'Kuota jalur prestasi harus diisi.',
            'quota_affirmation.required' => 'Kuota jalur afirmasi harus diisi.',
            'registration_fee.required' => 'Biaya pendaftaran harus diisi.',
        ]);

        // Check if setting already exists for this academic year
        $existingSetting = RegistrationSetting::where('academic_year_id', $request->academic_year_id)->first();
        
        if ($existingSetting) {
            $existingSetting->update([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'quota_regular' => $request->quota_regular,
                'quota_achievement' => $request->quota_achievement,
                'quota_affirmation' => $request->quota_affirmation,
                'registration_fee' => $request->registration_fee,
                'announcement_date' => $request->announcement_date,
                'is_active' => $request->has('is_active'),
                'information' => $request->information,
            ]);
        } else {
            RegistrationSetting::create([
                'academic_year_id' => $request->academic_year_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'quota_regular' => $request->quota_regular,
                'quota_achievement' => $request->quota_achievement,
                'quota_affirmation' => $request->quota_affirmation,
                'registration_fee' => $request->registration_fee,
                'announcement_date' => $request->announcement_date,
                'is_active' => $request->has('is_active'),
                'information' => $request->information,
            ]);
        }

        return back()->with('success', 'Pengaturan PPDB berhasil disimpan.');
    }

    /**
     * Toggle PPDB status.
     */
    public function toggleStatus(Request $request)
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        if (!$currentYear) {
            return response()->json(['success' => false, 'message' => 'Tidak ada tahun akademik aktif']);
        }

        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)->first();
        
        if (!$setting) {
            return response()->json(['success' => false, 'message' => 'Pengaturan PPDB belum dikonfigurasi']);
        }

        $setting->update([
            'is_active' => !$setting->is_active
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Status PPDB berhasil diubah',
            'is_active' => $setting->is_active
        ]);
    }

    /**
     * Get quota statistics.
     */
    public function quotaStatistics(Request $request)
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        if (!$currentYear) {
            return response()->json(['error' => 'Tidak ada tahun akademik aktif']);
        }

        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)->first();
        
        if (!$setting) {
            return response()->json(['error' => 'Pengaturan PPDB belum dikonfigurasi']);
        }

        $statistics = [
            'quota_regular' => $setting->quota_regular,
            'quota_achievement' => $setting->quota_achievement,
            'quota_affirmation' => $setting->quota_affirmation,
            'regular_count' => Registration::where('academic_year_id', $currentYear->id)
                ->where('registration_path', 'regular')->count(),
            'achievement_count' => Registration::where('academic_year_id', $currentYear->id)
                ->where('registration_path', 'achievement')->count(),
            'affirmation_count' => Registration::where('academic_year_id', $currentYear->id)
                ->where('registration_path', 'affirmation')->count(),
            'total_registrations' => Registration::where('academic_year_id', $currentYear->id)->count(),
        ];

        return response()->json($statistics);
    }
}