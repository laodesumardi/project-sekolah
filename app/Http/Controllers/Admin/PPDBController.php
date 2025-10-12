<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\RegistrationSetting;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PPDBController extends Controller
{
    /**
     * Display PPDB dashboard.
     */
    public function dashboard()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        if (!$currentYear) {
            return view('admin.ppdb.dashboard', [
                'totalRegistrations' => 0,
                'pendingCount' => 0,
                'verifiedCount' => 0,
                'acceptedCount' => 0,
                'rejectedCount' => 0,
                'reservedCount' => 0,
                'dailyRegistrations' => [],
                'pathDistribution' => [],
                'recentRegistrations' => collect(),
            ]);
        }

        // Statistics
        $totalRegistrations = Registration::where('academic_year_id', $currentYear->id)->count();
        $pendingCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'pending')->count();
        $verifiedCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'verified')->count();
        $acceptedCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'accepted')->count();
        $rejectedCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'rejected')->count();
        $reservedCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'reserved')->count();

        // Daily registrations (last 30 days)
        $dailyRegistrations = Registration::where('academic_year_id', $currentYear->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Path distribution
        $pathDistribution = Registration::where('academic_year_id', $currentYear->id)
            ->select('registration_path', DB::raw('COUNT(*) as count'))
            ->groupBy('registration_path')
            ->get();

        // Recent registrations
        $recentRegistrations = Registration::where('academic_year_id', $currentYear->id)
            ->with(['documents'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent applicants (today)
        $recentApplicants = Registration::where('academic_year_id', $currentYear->id)
            ->whereDate('created_at', today())->count();

        // Path distribution as array
        $pathDistributionArray = [
            'regular' => $pathDistribution->where('registration_path', 'regular')->first()->count ?? 0,
            'achievement' => $pathDistribution->where('registration_path', 'achievement')->first()->count ?? 0,
            'affirmation' => $pathDistribution->where('registration_path', 'affirmation')->first()->count ?? 0,
        ];

        // Get setting
        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)->first();

        return view('admin.ppdb.dashboard', compact(
            'totalRegistrations',
            'pendingCount',
            'verifiedCount',
            'acceptedCount',
            'rejectedCount',
            'reservedCount',
            'recentApplicants',
            'dailyRegistrations',
            'pathDistribution',
            'pathDistributionArray',
            'setting',
            'recentRegistrations'
        ));
    }

    /**
     * Display list of registrations.
     */
    public function index(Request $request)
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        $query = Registration::where('academic_year_id', $currentYear->id)
            ->with(['documents', 'verifier']);

        // Filters
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->path) {
            $query->where('registration_path', $request->path);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('registration_number', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statistics for the view
        $totalRegistrations = Registration::where('academic_year_id', $currentYear->id)->count();
        $pendingCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'pending')->count();
        $acceptedCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'accepted')->count();
        $rejectedCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'rejected')->count();

        return view('admin.ppdb.index', compact(
            'registrations',
            'totalRegistrations',
            'pendingCount',
            'acceptedCount',
            'rejectedCount'
        ));
    }

    /**
     * Store a new registration.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:registrations,nisn',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'religion' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:registrations,email',
            'address' => 'required|string',
            'registration_path' => 'required|in:regular,achievement,affirmation',
            'status' => 'nullable|in:pending,verified,accepted,rejected,reserved',
        ]);

        $currentYear = AcademicYear::where('is_active', true)->first();
        
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

        $registration = Registration::create([
            'academic_year_id' => $currentYear->id,
            'registration_number' => $registrationNumber,
            'full_name' => $request->full_name,
            'nisn' => $request->nisn,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'registration_path' => $request->registration_path,
            'status' => $request->status ?? 'pending',
        ]);

        // Log activity
        $registration->activities()->create([
            'activity_type' => 'created',
            'description' => 'Pendaftar baru ditambahkan oleh admin',
            'metadata' => [
                'admin_id' => auth()->id(),
                'registration_path' => $request->registration_path,
            ],
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Pendaftar berhasil ditambahkan.');
    }

    /**
     * Show edit form.
     */
    public function edit(Registration $registration)
    {
        return response()->json([
            'full_name' => $registration->full_name,
            'nisn' => $registration->nisn,
            'birth_place' => $registration->birth_place,
            'birth_date' => $registration->birth_date->format('Y-m-d'),
            'gender' => $registration->gender,
            'religion' => $registration->religion,
            'phone' => $registration->phone,
            'email' => $registration->email,
            'address' => $registration->address,
            'registration_path' => $registration->registration_path,
            'status' => $registration->status,
        ]);
    }

    /**
     * Update registration.
     */
    public function update(Request $request, Registration $registration)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:registrations,nisn,' . $registration->id,
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'religion' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:registrations,email,' . $registration->id,
            'address' => 'required|string',
            'registration_path' => 'required|in:regular,achievement,affirmation',
            'status' => 'nullable|in:pending,verified,accepted,rejected,reserved',
        ]);

        $oldStatus = $registration->status;
        
        $registration->update([
            'full_name' => $request->full_name,
            'nisn' => $request->nisn,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'registration_path' => $request->registration_path,
            'status' => $request->status ?? $registration->status,
        ]);

        // Log activity if status changed
        if ($oldStatus !== $registration->status) {
            $registration->activities()->create([
                'activity_type' => 'status_changed',
                'description' => "Status berubah dari {$oldStatus} menjadi {$registration->status}",
                'metadata' => [
                    'old_status' => $oldStatus,
                    'new_status' => $registration->status,
                ],
                'user_id' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Data pendaftar berhasil diupdate.');
    }

    /**
     * Display registration details.
     */
    public function show(Registration $registration)
    {
        $registration->load(['documents', 'payments', 'activities.user', 'verifier']);
        
        return view('admin.ppdb.show', compact('registration'));
    }

    /**
     * Update registration status.
     */
    public function updateStatus(Request $request, Registration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,accepted,rejected,reserved',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $registration->status;
        $registration->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        // Log activity
        $registration->activities()->create([
            'activity_type' => 'status_changed',
            'description' => "Status berubah dari {$oldStatus} menjadi {$request->status}",
            'metadata' => [
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'admin_notes' => $request->admin_notes,
            ],
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Status berhasil diupdate.');
    }

    /**
     * Bulk update status.
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'registration_ids' => 'required|array',
            'registration_ids.*' => 'exists:registrations,id',
            'status' => 'required|in:pending,verified,accepted,rejected,reserved',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $count = 0;
        foreach ($request->registration_ids as $id) {
            $registration = Registration::find($id);
            if ($registration) {
                $oldStatus = $registration->status;
                $registration->update([
                    'status' => $request->status,
                    'admin_notes' => $request->admin_notes,
                    'verified_at' => now(),
                    'verified_by' => auth()->id(),
                ]);

                // Log activity
                $registration->activities()->create([
                    'activity_type' => 'status_changed',
                    'description' => "Status berubah dari {$oldStatus} menjadi {$request->status} (bulk update)",
                    'metadata' => [
                        'old_status' => $oldStatus,
                        'new_status' => $request->status,
                        'admin_notes' => $request->admin_notes,
                    ],
                    'user_id' => auth()->id(),
                ]);

                $count++;
            }
        }

        return back()->with('success', "Status {$count} pendaftar berhasil diupdate.");
    }

    /**
     * Bulk delete registrations.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'registration_ids' => 'required|array',
            'registration_ids.*' => 'exists:registrations,id',
        ]);

        $count = 0;
        foreach ($request->registration_ids as $id) {
            $registration = Registration::find($id);
            if ($registration) {
                // Delete documents
                foreach ($registration->documents as $document) {
                    \Storage::disk('public')->delete($document->file_path);
                }

                // Delete payments
                foreach ($registration->payments as $payment) {
                    if ($payment->payment_proof) {
                        \Storage::disk('public')->delete('payments/' . $payment->payment_proof);
                    }
                }

                // Delete photo
                if ($registration->photo) {
                    \Storage::disk('public')->delete("registrations/{$registration->registration_number}/{$registration->photo}");
                }

                $registration->delete();
                $count++;
            }
        }

        return back()->with('success', "{$count} pendaftar berhasil dihapus.");
    }

    /**
     * Delete registration.
     */
    public function destroy(Registration $registration)
    {
        // Delete documents
        foreach ($registration->documents as $document) {
            \Storage::disk('public')->delete($document->file_path);
        }

        // Delete payments
        foreach ($registration->payments as $payment) {
            if ($payment->payment_proof) {
                \Storage::disk('public')->delete('payments/' . $payment->payment_proof);
            }
        }

        // Delete photo
        if ($registration->photo) {
            \Storage::disk('public')->delete("registrations/{$registration->registration_number}/{$registration->photo}");
        }

        $registration->delete();

        return back()->with('success', 'Data pendaftaran berhasil dihapus.');
    }

    /**
     * Export registrations to Excel.
     */
    public function export(Request $request)
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        $query = Registration::where('academic_year_id', $currentYear->id);

        // Apply filters
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->path) {
            $query->where('registration_path', $request->path);
        }

        $registrations = $query->orderBy('created_at', 'desc')->get();

        // TODO: Implement Excel export using Laravel Excel
        return response()->json(['message' => 'Export functionality will be implemented with Laravel Excel']);
    }

    /**
     * Get registration statistics.
     */
    public function statistics()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        $stats = [
            'total' => Registration::where('academic_year_id', $currentYear->id)->count(),
            'pending' => Registration::where('academic_year_id', $currentYear->id)->where('status', 'pending')->count(),
            'verified' => Registration::where('academic_year_id', $currentYear->id)->where('status', 'verified')->count(),
            'accepted' => Registration::where('academic_year_id', $currentYear->id)->where('status', 'accepted')->count(),
            'rejected' => Registration::where('academic_year_id', $currentYear->id)->where('status', 'rejected')->count(),
            'reserved' => Registration::where('academic_year_id', $currentYear->id)->where('status', 'reserved')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Handle quick registration from admin settings page.
     */
    public function quickRegister(Request $request)
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

        $request->validate([
            'registration_path' => 'required|in:regular,achievement,affirmation',
            'full_name' => 'required|string|max:255',
            'nik' => 'required|string|max:16|min:16',
            'nisn' => 'required|string|max:10|min:10',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'father_occupation' => 'nullable|string|max:100',
            'mother_occupation' => 'nullable|string|max:100',
            'parent_phone' => 'required|string|max:15',
            'address' => 'required|string|max:500',
            'achievement_name' => 'nullable|string|max:255',
            'achievement_level' => 'nullable|string|max:50',
            'achievement_year' => 'nullable|integer|min:2010|max:2025',
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

        // Check for duplicate NIK or NISN
        $existingNik = Registration::where('nik', $request->nik)->first();
        if ($existingNik) {
            return back()->with('error', 'NIK sudah terdaftar sebelumnya.');
        }

        $existingNisn = Registration::where('nisn', $request->nisn)->first();
        if ($existingNisn) {
            return back()->with('error', 'NISN sudah terdaftar sebelumnya.');
        }

        try {
            DB::beginTransaction();

            // Generate registration number
            $year = date('Y');
            $pathCode = strtoupper(substr($request->registration_path, 0, 3));
            $lastNumber = Registration::where('academic_year_id', $currentYear->id)
                ->where('registration_path', $request->registration_path)
                ->count() + 1;
            $registrationNumber = "PPDB-{$year}-{$pathCode}-" . str_pad($lastNumber, 4, '0', STR_PAD_LEFT);

            // Create registration
            $registration = Registration::create([
                'academic_year_id' => $currentYear->id,
                'registration_number' => $registrationNumber,
                'registration_path' => $request->registration_path,
                'full_name' => $request->full_name,
                'nik' => $request->nik,
                'nisn' => $request->nisn,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'father_occupation' => $request->father_occupation,
                'mother_occupation' => $request->mother_occupation,
                'parent_phone' => $request->parent_phone,
                'address' => $request->address,
                'status' => 'pending',
                'registered_by' => auth()->id(),
            ]);

            // Add achievement data if achievement path
            if ($request->registration_path === 'achievement' && $request->achievement_name) {
                $registration->update([
                    'achievement_name' => $request->achievement_name,
                    'achievement_level' => $request->achievement_level,
                    'achievement_year' => $request->achievement_year,
                    'achievement_rank' => $request->achievement_rank,
                ]);
            }

            DB::commit();

            return back()->with('success', "Pendaftaran berhasil! Nomor pendaftaran: {$registrationNumber}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
}
