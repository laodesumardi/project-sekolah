<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Show settings dashboard.
     */
    public function index()
    {
        $student = Auth::user()->profile;
        $user = Auth::user();
        
        // Get current settings
        $settings = [
            'notifications' => [
                'email_notifications' => $student->email_notifications ?? true,
                'sms_notifications' => $student->sms_notifications ?? false,
                'push_notifications' => $student->push_notifications ?? true,
                'assignment_reminders' => $student->assignment_reminders ?? true,
                'grade_notifications' => $student->grade_notifications ?? true,
                'announcement_notifications' => $student->announcement_notifications ?? true,
            ],
            'privacy' => [
                'show_profile_to_students' => $student->show_profile_to_students ?? true,
                'show_email_to_teachers' => $student->show_email_to_teachers ?? true,
                'allow_parent_access' => $student->allow_parent_access ?? true,
                'show_attendance_to_parents' => $student->show_attendance_to_parents ?? true,
                'show_grades_to_parents' => $student->show_grades_to_parents ?? true,
            ],
            'account' => [
                'two_factor_enabled' => $student->two_factor_enabled ?? false,
                'auto_logout' => $student->auto_logout ?? false,
                'session_timeout' => $student->session_timeout ?? 30,
            ],
            'preferences' => [
                'language' => $student->language ?? 'id',
                'timezone' => $student->timezone ?? 'Asia/Jakarta',
                'date_format' => $student->date_format ?? 'd/m/Y',
                'time_format' => $student->time_format ?? '24',
                'theme' => $student->theme ?? 'light',
            ]
        ];
        
        return view('student.pengaturan.index', compact('student', 'user', 'settings'));
    }
    
    /**
     * Update general settings.
     */
    public function updateGeneral(Request $request)
    {
        $student = Auth::user()->profile;
        
        $validator = Validator::make($request->all(), [
            'language' => 'required|string|in:id,en',
            'timezone' => 'required|string',
            'date_format' => 'required|string|in:d/m/Y,m/d/Y,Y-m-d',
            'time_format' => 'required|string|in:12,24',
            'theme' => 'required|string|in:light,dark,auto',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all()),
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $student->update([
                'language' => $request->language,
                'timezone' => $request->timezone,
                'date_format' => $request->date_format,
                'time_format' => $request->time_format,
                'theme' => $request->theme,
            ]);
            
            return response()->json([
                'message' => 'Pengaturan umum berhasil diperbarui',
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui pengaturan: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    
    /**
     * Update notification settings.
     */
    public function updateNotifications(Request $request)
    {
        $student = Auth::user()->profile;
        
        $validator = Validator::make($request->all(), [
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'assignment_reminders' => 'boolean',
            'grade_notifications' => 'boolean',
            'announcement_notifications' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all()),
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $student->update([
                'email_notifications' => $request->boolean('email_notifications'),
                'sms_notifications' => $request->boolean('sms_notifications'),
                'push_notifications' => $request->boolean('push_notifications'),
                'assignment_reminders' => $request->boolean('assignment_reminders'),
                'grade_notifications' => $request->boolean('grade_notifications'),
                'announcement_notifications' => $request->boolean('announcement_notifications'),
            ]);
            
            return response()->json([
                'message' => 'Pengaturan notifikasi berhasil diperbarui',
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui pengaturan: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    
    /**
     * Update privacy settings.
     */
    public function updatePrivacy(Request $request)
    {
        $student = Auth::user()->profile;
        
        $validator = Validator::make($request->all(), [
            'show_profile_to_students' => 'boolean',
            'show_email_to_teachers' => 'boolean',
            'allow_parent_access' => 'boolean',
            'show_attendance_to_parents' => 'boolean',
            'show_grades_to_parents' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all()),
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $student->update([
                'show_profile_to_students' => $request->boolean('show_profile_to_students'),
                'show_email_to_teachers' => $request->boolean('show_email_to_teachers'),
                'allow_parent_access' => $request->boolean('allow_parent_access'),
                'show_attendance_to_parents' => $request->boolean('show_attendance_to_parents'),
                'show_grades_to_parents' => $request->boolean('show_grades_to_parents'),
            ]);
            
            return response()->json([
                'message' => 'Pengaturan privasi berhasil diperbarui',
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui pengaturan: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    
    /**
     * Update account settings.
     */
    public function updateAccount(Request $request)
    {
        $student = Auth::user()->profile;
        
        $validator = Validator::make($request->all(), [
            'two_factor_enabled' => 'boolean',
            'auto_logout' => 'boolean',
            'session_timeout' => 'integer|min:5|max:480',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all()),
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $student->update([
                'two_factor_enabled' => $request->boolean('two_factor_enabled'),
                'auto_logout' => $request->boolean('auto_logout'),
                'session_timeout' => $request->session_timeout,
            ]);
            
            return response()->json([
                'message' => 'Pengaturan akun berhasil diperbarui',
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui pengaturan: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    
    /**
     * Change password.
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all()),
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Password saat ini tidak benar',
                'success' => false
            ], 422);
        }
        
        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            
            return response()->json([
                'message' => 'Password berhasil diubah',
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengubah password: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    
    /**
     * Export settings.
     */
    public function exportSettings()
    {
        $student = Auth::user()->profile;
        $user = Auth::user();
        
        $settings = [
            'general' => [
                'name' => $user->name,
                'email' => $user->email,
                'language' => $student->language ?? 'id',
                'timezone' => $student->timezone ?? 'Asia/Jakarta',
                'date_format' => $student->date_format ?? 'd/m/Y',
                'time_format' => $student->time_format ?? '24',
                'theme' => $student->theme ?? 'light',
            ],
            'notifications' => [
                'email_notifications' => $student->email_notifications ?? true,
                'sms_notifications' => $student->sms_notifications ?? false,
                'push_notifications' => $student->push_notifications ?? true,
                'assignment_reminders' => $student->assignment_reminders ?? true,
                'grade_notifications' => $student->grade_notifications ?? true,
                'announcement_notifications' => $student->announcement_notifications ?? true,
            ],
            'privacy' => [
                'show_profile_to_students' => $student->show_profile_to_students ?? true,
                'show_email_to_teachers' => $student->show_email_to_teachers ?? true,
                'allow_parent_access' => $student->allow_parent_access ?? true,
                'show_attendance_to_parents' => $student->show_attendance_to_parents ?? true,
                'show_grades_to_parents' => $student->show_grades_to_parents ?? true,
            ],
            'account' => [
                'two_factor_enabled' => $student->two_factor_enabled ?? false,
                'auto_logout' => $student->auto_logout ?? false,
                'session_timeout' => $student->session_timeout ?? 30,
            ]
        ];
        
        $filename = 'pengaturan_' . $user->name . '_' . date('Y-m-d_H-i-s') . '.json';
        
        return response()->json($settings)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Type', 'application/json');
    }
    
    /**
     * Reset settings to default.
     */
    public function resetSettings()
    {
        $student = Auth::user()->profile;
        
        try {
            $student->update([
                'language' => 'id',
                'timezone' => 'Asia/Jakarta',
                'date_format' => 'd/m/Y',
                'time_format' => '24',
                'theme' => 'light',
                'email_notifications' => true,
                'sms_notifications' => false,
                'push_notifications' => true,
                'assignment_reminders' => true,
                'grade_notifications' => true,
                'announcement_notifications' => true,
                'show_profile_to_students' => true,
                'show_email_to_teachers' => true,
                'allow_parent_access' => true,
                'show_attendance_to_parents' => true,
                'show_grades_to_parents' => true,
                'two_factor_enabled' => false,
                'auto_logout' => false,
                'session_timeout' => 30,
            ]);
            
            return response()->json([
                'message' => 'Pengaturan berhasil direset ke default',
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mereset pengaturan: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
}




