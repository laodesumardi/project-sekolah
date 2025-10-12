<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\RegistrationSetting;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('admin.ppdb.index', compact('registrations'));
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
}
