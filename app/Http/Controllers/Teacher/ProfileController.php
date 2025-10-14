<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\LoginSession;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the teacher profile.
     */
    public function show()
    {
        $teacher = Auth::user()->teacher;
        $documents = $teacher->documents()->orderBy('created_at', 'desc')->get();
        $certifications = $teacher->certifications()->orderBy('issue_date', 'desc')->get();
        
        return view('teacher.profile.show', compact('teacher', 'documents', 'certifications'));
    }
    
    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $teacher = Auth::user()->teacher;
        
        return view('teacher.profile.edit', compact('teacher'));
    }
    
    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:500',
            'bio' => 'nullable|string|max:1000',
        ]);
        
        // Update user email
        Auth::user()->update([
            'email' => $request->email,
        ]);
        
        // Update teacher profile
        $teacher->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
        ]);
        
        return redirect()->route('teacher.profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }
    
    /**
     * Update profile picture.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $teacher = Auth::user()->teacher;
        
        // Delete old photo if exists
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }
        
        // Store new photo
        $path = $request->file('photo')->store('teacher-photos', 'public');
        
        $teacher->update([
            'photo' => $path,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui.',
            'photo_url' => $teacher->fresh()->profile_picture_url,
        ]);
    }
    
    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        
        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('teacher.profile.show')
            ->with('success', 'Password berhasil diperbarui.');
    }
    
    /**
     * Show teaching portfolio.
     */
    public function portfolio()
    {
        $teacher = Auth::user()->teacher;
        
        // Get portfolio statistics
        $stats = [
            'total_materials' => 45,
            'total_tasks' => 23,
            'total_students' => $teacher->total_students,
            'average_grade' => 85.5,
        ];
        
        // Get teaching history
        $teachingHistory = $teacher->teachingClasses()
            ->with(['class', 'subject', 'academicYear'])
            ->orderBy('academic_year_id', 'desc')
            ->get();
        
        // Get certifications
        $certifications = $teacher->certifications()
            ->orderBy('issue_date', 'desc')
            ->get();
        
        return view('teacher.profile.portfolio', compact(
            'teacher',
            'stats',
            'teachingHistory',
            'certifications'
        ));
    }
    
    /**
     * Show security settings.
     */
    public function security()
    {
        $teacher = Auth::user()->teacher;
        $sessions = LoginSession::where('user_id', Auth::id())
            ->orderBy('last_activity', 'desc')
            ->get();
        
        return view('teacher.profile.security', compact('teacher', 'sessions'));
    }
    
    /**
     * Get active sessions.
     */
    public function sessions()
    {
        $sessions = LoginSession::where('user_id', Auth::id())
            ->orderBy('last_activity', 'desc')
            ->get();
        
        return response()->json($sessions);
    }
    
    /**
     * Logout other devices.
     */
    public function logoutOtherDevices(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);
        
        // Invalidate other sessions
        LoginSession::where('user_id', Auth::id())
            ->where('is_current', false)
            ->update(['is_current' => false]);
        
        return redirect()->route('teacher.profile.security')
            ->with('success', 'Sesi lain berhasil diakhiri.');
    }
    
    /**
     * Update privacy settings.
     */
    public function updatePrivacy(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        $request->validate([
            'show_profile_to_students' => 'boolean',
            'show_email_publicly' => 'boolean',
            'allow_parent_messages' => 'boolean',
        ]);
        
        // Update privacy settings (you'll need to add these fields to teachers table)
        $teacher->update([
            'show_profile_to_students' => $request->boolean('show_profile_to_students'),
            'show_email_publicly' => $request->boolean('show_email_publicly'),
            'allow_parent_messages' => $request->boolean('allow_parent_messages'),
        ]);
        
        return redirect()->route('teacher.profile.security')
            ->with('success', 'Pengaturan privasi berhasil diperbarui.');
    }
}