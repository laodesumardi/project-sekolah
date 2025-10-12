<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrationSetting;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PPDBSettingController extends Controller
{
    /**
     * Display PPDB settings.
     */
    public function index()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)->first();

        return view('admin.ppdb.settings', compact('setting', 'currentYear'));
    }

    /**
     * Store or update PPDB settings.
     */
    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'announcement_date' => 'required|date|after:end_date',
            'quota_regular' => 'required|integer|min:0',
            'quota_achievement' => 'required|integer|min:0',
            'quota_affirmation' => 'required|integer|min:0',
            'registration_fee' => 'required|numeric|min:0',
            'is_open' => 'boolean',
            'information' => 'nullable|string',
        ]);

        $setting = RegistrationSetting::updateOrCreate(
            ['academic_year_id' => $request->academic_year_id],
            $request->all()
        );

        return back()->with('success', 'Pengaturan PPDB berhasil disimpan.');
    }

    /**
     * Toggle registration status.
     */
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'is_open' => 'required|boolean',
        ]);

        $currentYear = AcademicYear::where('is_active', true)->first();
        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)->first();

        if ($setting) {
            $setting->update(['is_open' => $request->is_open]);
            
            $status = $request->is_open ? 'dibuka' : 'ditutup';
            return back()->with('success', "Pendaftaran PPDB berhasil {$status}.");
        }

        return back()->with('error', 'Pengaturan PPDB tidak ditemukan.');
    }

    /**
     * Get quota statistics.
     */
    public function quotaStatistics()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)->first();

        if (!$setting) {
            return response()->json(['error' => 'Pengaturan tidak ditemukan'], 404);
        }

        $stats = [
            'quota' => [
                'regular' => $setting->quota_regular,
                'achievement' => $setting->quota_achievement,
                'affirmation' => $setting->quota_affirmation,
                'total' => $setting->total_quota,
            ],
            'filled' => [
                'regular' => Registration::where('academic_year_id', $currentYear->id)
                    ->where('registration_path', 'regular')
                    ->where('status', 'accepted')
                    ->count(),
                'achievement' => Registration::where('academic_year_id', $currentYear->id)
                    ->where('registration_path', 'achievement')
                    ->where('status', 'accepted')
                    ->count(),
                'affirmation' => Registration::where('academic_year_id', $currentYear->id)
                    ->where('registration_path', 'affirmation')
                    ->where('status', 'accepted')
                    ->count(),
            ],
        ];

        $stats['filled']['total'] = array_sum($stats['filled']);
        $stats['percentage'] = [
            'regular' => $setting->quota_regular > 0 ? round(($stats['filled']['regular'] / $setting->quota_regular) * 100, 2) : 0,
            'achievement' => $setting->quota_achievement > 0 ? round(($stats['filled']['achievement'] / $setting->quota_achievement) * 100, 2) : 0,
            'affirmation' => $setting->quota_affirmation > 0 ? round(($stats['filled']['affirmation'] / $setting->quota_affirmation) * 100, 2) : 0,
            'total' => $setting->total_quota > 0 ? round(($stats['filled']['total'] / $setting->total_quota) * 100, 2) : 0,
        ];

        return response()->json($stats);
    }
}

