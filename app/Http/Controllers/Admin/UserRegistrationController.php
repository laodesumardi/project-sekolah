<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRegistrationController extends Controller
{
    /**
     * Display a listing of user registrations.
     */
    public function index(Request $request)
    {
        $query = UserRegistration::with('approver');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('registration_type', $request->type);
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
            'total' => UserRegistration::count(),
            'pending' => UserRegistration::pending()->count(),
            'verified' => UserRegistration::where('status', 'verified')->count(),
            'approved' => UserRegistration::approved()->count(),
            'rejected' => UserRegistration::where('status', 'rejected')->count(),
        ];

        return view('admin.user-registrations.index', compact('registrations', 'stats'));
    }

    /**
     * Display the specified registration.
     */
    public function show(UserRegistration $userRegistration)
    {
        $userRegistration->load('approver');
        return view('admin.user-registrations.show', compact('userRegistration'));
    }

    /**
     * Approve a registration.
     */
    public function approve(Request $request, UserRegistration $userRegistration)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $userRegistration->approve(auth()->id());
            
            // Add admin notes if provided
            if ($request->notes) {
                $userRegistration->update(['admin_notes' => $request->notes]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil disetujui.'
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
    public function reject(Request $request, UserRegistration $userRegistration)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $userRegistration->reject(auth()->id(), $request->rejection_reason);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil ditolak.'
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

            $registrations = UserRegistration::whereIn('id', $request->ids);
            
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
                'message' => 'Status berhasil diperbarui untuk ' . count($request->ids) . ' pendaftaran.'
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
    public function destroy(Request $request, UserRegistration $userRegistration)
    {
        try {
            $userRegistration->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil dihapus.'
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
        $query = UserRegistration::with('approver');

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('registration_type', $request->type);
        }

        $registrations = $query->recent()->get();

        // Generate CSV
        $filename = 'user_registrations_' . date('Y-m-d_H-i-s') . '.csv';
        
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
                'Tipe',
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
                    $registration->registration_type === 'student' ? 'Siswa' : 'Orang Tua',
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