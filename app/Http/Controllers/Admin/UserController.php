<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $users = $query->paginate(15)->withQueryString();

        // Statistics
        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'admin' => User::where('role', 'admin')->count(),
            'teacher' => User::where('role', 'teacher')->count(),
            'student' => User::where('role', 'student')->count(),
            'parent' => User::where('role', 'parent')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Log request data
        \Log::info('User creation request: ' . json_encode($request->all()));
        \Log::info('Has avatar file: ' . ($request->hasFile('avatar') ? 'Yes' : 'No'));
        if ($request->hasFile('avatar')) {
            \Log::info('Avatar file details:', [
                'name' => $request->file('avatar')->getClientOriginalName(),
                'size' => $request->file('avatar')->getSize(),
                'mime' => $request->file('avatar')->getMimeType()
            ]);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,teacher,student,parent',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['is_active'] = $request->has('is_active');

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_avatar.' . $avatar->getClientOriginalExtension();
            
            // Ensure directory exists
            $avatarDir = storage_path('app/public/avatars');
            if (!file_exists($avatarDir)) {
                mkdir($avatarDir, 0755, true);
            }
            
            // Try storeAs first
            $path = $avatar->storeAs('public/avatars', $avatarName);
            $data['avatar'] = $avatarName;
            
            // If storeAs fails, try direct save
            $fullPath = storage_path('app/public/avatars/' . $avatarName);
            if (!file_exists($fullPath)) {
                \Log::info('Avatar storeAs failed, trying direct save...');
                $avatar->move($avatarDir, $avatarName);
                \Log::info('Avatar direct save completed, file exists: ' . (file_exists($fullPath) ? 'Yes' : 'No'));
            }
            
            \Log::info('Avatar uploaded: ' . $avatarName . ' to path: ' . $path);
        }

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Debug: Log request data
        \Log::info('User update request: ' . json_encode($request->all()));
        \Log::info('Has avatar file: ' . ($request->hasFile('avatar') ? 'Yes' : 'No'));
        if ($request->hasFile('avatar')) {
            \Log::info('Avatar file details:', [
                'name' => $request->file('avatar')->getClientOriginalName(),
                'size' => $request->file('avatar')->getSize(),
                'mime' => $request->file('avatar')->getMimeType()
            ]);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,teacher,student,parent',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            $avatar = $request->file('avatar');
            $avatarName = time() . '_avatar.' . $avatar->getClientOriginalExtension();
            
            // Ensure directory exists
            $avatarDir = storage_path('app/public/avatars');
            if (!file_exists($avatarDir)) {
                mkdir($avatarDir, 0755, true);
            }
            
            // Try storeAs first
            $path = $avatar->storeAs('public/avatars', $avatarName);
            $data['avatar'] = $avatarName;
            
            // If storeAs fails, try direct save
            $fullPath = storage_path('app/public/avatars/' . $avatarName);
            if (!file_exists($fullPath)) {
                \Log::info('Avatar storeAs failed, trying direct save...');
                $avatar->move($avatarDir, $avatarName);
                \Log::info('Avatar direct save completed, file exists: ' . (file_exists($fullPath) ? 'Yes' : 'No'));
            }
            
            \Log::info('Avatar updated: ' . $avatarName . ' to path: ' . $path);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Toggle user active status
     */
    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return response()->json([
            'success' => true,
            'message' => "User berhasil {$status}",
            'is_active' => $user->is_active
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        $userIds = $request->user_ids;
        $action = $request->action;

        // Prevent deleting own account
        if ($action === 'delete' && in_array(auth()->id(), $userIds)) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        switch ($action) {
            case 'activate':
                User::whereIn('id', $userIds)->update(['is_active' => true]);
                $message = 'User berhasil diaktifkan!';
                break;
            case 'deactivate':
                User::whereIn('id', $userIds)->update(['is_active' => false]);
                $message = 'User berhasil dinonaktifkan!';
                break;
            case 'delete':
                // Delete avatars
                $users = User::whereIn('id', $userIds)->get();
                foreach ($users as $user) {
                    if ($user->avatar) {
                        Storage::delete('public/avatars/' . $user->avatar);
                    }
                }
                User::whereIn('id', $userIds)->delete();
                $message = 'User berhasil dihapus!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Export users
     */
    public function export(Request $request)
    {
        $query = User::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->get();

        $filename = 'users_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Nama', 'Email', 'Role', 'Phone', 'Address', 
                'Status', 'Created At', 'Updated At'
            ]);

            // CSV data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->phone,
                    $user->address,
                    $user->is_active ? 'Active' : 'Inactive',
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
