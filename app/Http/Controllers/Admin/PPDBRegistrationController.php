<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PPDBRegistrationController extends Controller
{
    /**
     * Display a listing of PPDB registrations.
     */
    public function index(Request $request)
    {
        $query = UserRegistration::with('approver')
            ->where('registration_type', 'student'); // Only PPDB registrations

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        $registrations = $query->recent()->paginate(20);

        // Statistics
        $stats = [
            'total' => UserRegistration::where('registration_type', 'student')->count(),
            'pending' => UserRegistration::where('registration_type', 'student')->pending()->count(),
            'verified' => UserRegistration::where('registration_type', 'student')->where('status', 'verified')->count(),
            'approved' => UserRegistration::where('registration_type', 'student')->approved()->count(),
            'rejected' => UserRegistration::where('registration_type', 'student')->where('status', 'rejected')->count(),
        ];

        return view('admin.ppdb-registrations.index', compact('registrations', 'stats'));
    }

    /**
     * Display the specified registration.
     */
    public function show(UserRegistration $ppdbRegistration)
    {
        $ppdbRegistration->load('approver');
        return view('admin.ppdb-registrations.show', compact('ppdbRegistration'));
    }

    /**
     * Approve a registration.
     */
    public function approve(Request $request, UserRegistration $ppdbRegistration)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $ppdbRegistration->approve(auth()->id());
            
            // Add admin notes if provided
            if ($request->notes) {
                $ppdbRegistration->update(['admin_notes' => $request->notes]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran PPDB berhasil disetujui.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyetujui pendaftaran.'
            ], 500);
        }
    }

    /**
     * Reject a registration.
     */
    public function reject(Request $request, UserRegistration $ppdbRegistration)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $ppdbRegistration->reject(auth()->id(), $request->rejection_reason);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran PPDB berhasil ditolak.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak pendaftaran.'
            ], 500);
        }
    }

    /**
     * Bulk update status.
     */
    public function bulkStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:user_registrations,id',
            'status' => 'required|in:approved,rejected',
            'reason' => 'required_if:status,rejected|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $registrations = UserRegistration::whereIn('id', $request->ids)
                ->where('registration_type', 'student');
            
            foreach ($registrations->get() as $registration) {
                if ($request->status === 'approved') {
                    $registration->approve(auth()->id());
                } else {
                    $registration->reject(auth()->id(), $request->reason);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui untuk ' . count($request->ids) . ' pendaftaran PPDB.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status.'
            ], 500);
        }
    }

    /**
     * Delete registrations.
     */
    public function destroy(Request $request, UserRegistration $ppdbRegistration)
    {
        try {
            $ppdbRegistration->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran PPDB berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus pendaftaran.'
            ], 500);
        }
    }

    /**
     * Export registrations.
     */
    public function export(Request $request)
    {
        $query = UserRegistration::with('approver')
            ->where('registration_type', 'student');

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->recent()->get();

        // Generate CSV
        $filename = 'ppdb_registrations_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($registrations) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'No. Pendaftaran',
                'Nama Lengkap',
                'Email',
                'Telepon',
                'Asal Sekolah',
                'Status',
                'Tanggal Daftar',
                'Disetujui Oleh',
                'Tanggal Disetujui'
            ]);

            // CSV Data
            foreach ($registrations as $registration) {
                fputcsv($file, [
                    $registration->registration_number,
                    $registration->full_name,
                    $registration->email,
                    $registration->phone,
                    $registration->school_origin,
                    $registration->status,
                    $registration->created_at->format('d/m/Y H:i'),
                    $registration->approver ? $registration->approver->name : '-',
                    $registration->approved_at ? $registration->approved_at->format('d/m/Y H:i') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}