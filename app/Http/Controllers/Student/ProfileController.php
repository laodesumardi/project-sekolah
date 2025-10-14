<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\SchoolClass;

class ProfileController extends Controller
{
    /**
     * Display student profile.
     */
    public function index()
    {
        $student = Auth::user()->profile;
        $user = Auth::user();
        
        // Get profile data
        $profileData = $this->getProfileData($student);
        
        // Get academic data
        $academicData = $this->getAcademicData($student);
        
        // Get parent data
        $parentData = $this->getParentData($student);
        
        // Get documents
        $documents = $this->getDocuments($student);
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($student);
        
        // Get statistics
        $stats = $this->getProfileStats($student);
        
        return view('student.profil.index', compact(
            'student',
            'user',
            'profileData',
            'academicData',
            'parentData',
            'documents',
            'recentActivities',
            'stats'
        ));
    }
    
    /**
     * Show edit profile form.
     */
    public function edit()
    {
        $student = Auth::user()->profile;
        $user = Auth::user();
        
        return view('student.profil.edit', compact('student', 'user'));
    }
    
    /**
     * Update profile.
     */
    public function update(Request $request)
    {
        $student = Auth::user()->profile;
        $user = Auth::user();
        
        // Validate request
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female',
            'religion' => 'nullable|string|max:50',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all()),
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        // Update profile data - only update fields that have values
        $profileData = [];
        
        if ($request->filled('phone')) {
            $profileData['phone'] = $request->phone;
        }
        if ($request->filled('address')) {
            $profileData['address'] = $request->address;
        }
        if ($request->filled('birth_place')) {
            $profileData['birth_place'] = $request->birth_place;
        }
        if ($request->filled('birth_date')) {
            $profileData['birth_date'] = $request->birth_date;
        }
        if ($request->filled('gender')) {
            $profileData['gender'] = $request->gender;
        }
        if ($request->filled('religion')) {
            $profileData['religion'] = $request->religion;
        }
        if ($request->filled('bio')) {
            $profileData['bio'] = $request->bio;
        }
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->profile_picture && Storage::disk('public')->exists($student->profile_picture)) {
                Storage::disk('public')->delete($student->profile_picture);
            }
            
            $photo = $request->file('photo');
            $filename = time() . '_' . $student->id . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('student-photos', $filename, 'public');
            $profileData['profile_picture'] = $path;
        }
        
        try {
            \Log::info('Updating profile data:', $profileData);
            \Log::info('Student ID:', ['id' => $student->id]);
            
            // Only update if there's data to update
            if (!empty($profileData)) {
                $result = $student->update($profileData);
                \Log::info('Update result:', ['result' => $result]);
            } else {
                \Log::info('No profile data to update');
            }
            
            return response()->json([
                'message' => 'Profil berhasil diperbarui',
                'success' => true,
                'redirect' => route('student.profil.index')
            ]);
        } catch (\Exception $e) {
            \Log::error('Profile update error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'Gagal memperbarui profil: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    
    /**
     * Show security settings.
     */
    public function security()
    {
        $student = Auth::user()->profile;
        $user = Auth::user();
        
        // Get active sessions
        $activeSessions = $this->getActiveSessions($user);
        
        // Get login history
        $loginHistory = $this->getLoginHistory($user);
        
        return view('student.profil.security', compact('student', 'user', 'activeSessions', 'loginHistory'));
    }
    
    /**
     * Change password.
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();
        
        // Validate request
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        
        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Password saat ini tidak benar',
                'success' => false
            ], 422);
        }
        
        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
        
        return response()->json([
            'message' => 'Password berhasil diubah',
            'success' => true
        ]);
    }
    
    /**
     * Update privacy settings.
     */
    public function updatePrivacy(Request $request)
    {
        $student = Auth::user()->profile;
        
        // Validate request
        $request->validate([
            'show_profile_to_students' => 'boolean',
            'show_email_to_teachers' => 'boolean',
            'allow_parent_access' => 'boolean',
            'two_factor_enabled' => 'boolean'
        ]);
        
        // Update privacy settings
        $student->update([
            'show_profile_to_students' => $request->show_profile_to_students ?? false,
            'show_email_to_teachers' => $request->show_email_to_teachers ?? false,
            'allow_parent_access' => $request->allow_parent_access ?? false,
            'two_factor_enabled' => $request->two_factor_enabled ?? false
        ]);
        
        return response()->json([
            'message' => 'Pengaturan privasi berhasil diperbarui',
            'success' => true
        ]);
    }
    
    /**
     * Get profile data.
     */
    private function getProfileData($student)
    {
        return [
            'nis' => $student->nis ?? 'N/A',
            'nisn' => $student->nisn ?? 'N/A',
            'name' => $student->user->name,
            'email' => $student->user->email,
            'phone' => $student->phone ?? 'Belum diisi',
            'address' => $student->address ?? 'Belum diisi',
            'birth_place' => $student->birth_place ?? 'Belum diisi',
            'birth_date' => $student->birth_date ? $student->birth_date->format('d M Y') : 'Belum diisi',
            'gender' => $student->gender ? ucfirst($student->gender) : 'Belum diisi',
            'religion' => $student->religion ?? 'Belum diisi',
            'bio' => $student->bio ?? 'Belum ada bio',
            'photo' => $student->profile_picture ? Storage::disk('public')->url($student->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($student->user->name) . '&background=3b82f6&color=ffffff&size=200',
            'created_at' => $student->created_at->format('d M Y'),
            'updated_at' => $student->updated_at->format('d M Y H:i')
        ];
    }
    
    /**
     * Get academic data.
     */
    private function getAcademicData($student)
    {
        $currentYear = $this->getCurrentAcademicYear();
        $currentClass = $this->getCurrentClass($student);
        
        return [
            'current_class' => $currentClass ? $currentClass->name : 'Belum ditentukan',
            'entry_year' => $student->entry_year ?? 'N/A',
            'active_semester' => $currentYear ? $currentYear->name : 'N/A',
            'homeroom_teacher' => $currentClass ? $currentClass->homeroom_teacher : 'Belum ditentukan',
            'student_status' => $student->status ?? 'Aktif',
            'class_history' => $this->getClassHistory($student),
            'academic_year' => $currentYear ? $currentYear->name : 'N/A'
        ];
    }
    
    /**
     * Get parent data.
     */
    private function getParentData($student)
    {
        return [
            'father' => [
                'name' => $student->father_name ?? 'Belum diisi',
                'occupation' => $student->father_occupation ?? 'Belum diisi',
                'phone' => $student->father_phone ?? 'Belum diisi'
            ],
            'mother' => [
                'name' => $student->mother_name ?? 'Belum diisi',
                'occupation' => $student->mother_occupation ?? 'Belum diisi',
                'phone' => $student->mother_phone ?? 'Belum diisi'
            ],
            'parent_account' => [
                'email' => $student->parent_email ?? 'Belum diisi',
                'status' => $student->parent_email ? 'Terdaftar' : 'Belum terdaftar'
            ]
        ];
    }
    
    /**
     * Get documents.
     */
    private function getDocuments($student)
    {
        return collect([
            (object)[
                'id' => 1,
                'type' => 'ijazah',
                'name' => 'Ijazah SD',
                'status' => 'verified',
                'uploaded_at' => now()->subDays(30)
            ],
            (object)[
                'id' => 2,
                'type' => 'akta',
                'name' => 'Akta Kelahiran',
                'status' => 'verified',
                'uploaded_at' => now()->subDays(25)
            ],
            (object)[
                'id' => 3,
                'type' => 'kk',
                'name' => 'Kartu Keluarga',
                'status' => 'verified',
                'uploaded_at' => now()->subDays(20)
            ],
            (object)[
                'id' => 4,
                'type' => 'photo',
                'name' => 'Foto 3x4',
                'status' => 'verified',
                'uploaded_at' => now()->subDays(15)
            ],
            (object)[
                'id' => 5,
                'type' => 'certificate',
                'name' => 'Sertifikat Prestasi',
                'status' => 'pending',
                'uploaded_at' => now()->subDays(10)
            ]
        ]);
    }
    
    /**
     * Get recent activities.
     */
    private function getRecentActivities($student)
    {
        return collect([
            (object)[
                'id' => 1,
                'type' => 'profile_updated',
                'title' => 'Profil diperbarui',
                'description' => 'Data pribadi telah diperbarui',
                'created_at' => now()->subHours(2)
            ],
            (object)[
                'id' => 2,
                'type' => 'password_changed',
                'title' => 'Password diubah',
                'description' => 'Password berhasil diubah',
                'created_at' => now()->subDays(1)
            ],
            (object)[
                'id' => 3,
                'type' => 'document_uploaded',
                'title' => 'Dokumen diunggah',
                'description' => 'Sertifikat Prestasi diunggah',
                'created_at' => now()->subDays(2)
            ],
            (object)[
                'id' => 4,
                'type' => 'login',
                'title' => 'Login berhasil',
                'description' => 'Berhasil login ke sistem',
                'created_at' => now()->subDays(3)
            ]
        ]);
    }
    
    /**
     * Get profile statistics.
     */
    private function getProfileStats($student)
    {
        return [
            'profile_completeness' => $this->calculateProfileCompleteness($student),
            'documents_uploaded' => 5,
            'documents_verified' => 4,
            'documents_pending' => 1,
            'login_count' => 45,
            'last_login' => now()->subHours(2),
            'account_age' => $student->created_at->diffInDays(now())
        ];
    }
    
    /**
     * Get current academic year.
     */
    private function getCurrentAcademicYear()
    {
        return AcademicYear::where('is_active', true)->first() ?? 
               AcademicYear::latest()->first();
    }
    
    /**
     * Get current class.
     */
    private function getCurrentClass($student)
    {
        return SchoolClass::where('id', $student->class_id)->first();
    }
    
    /**
     * Get class history.
     */
    private function getClassHistory($student)
    {
        return collect([
            (object)[
                'year' => '2023/2024',
                'class' => 'Kelas 7A',
                'semester' => 'Semester 1'
            ],
            (object)[
                'year' => '2023/2024',
                'class' => 'Kelas 7A',
                'semester' => 'Semester 2'
            ],
            (object)[
                'year' => '2024/2025',
                'class' => 'Kelas 8A',
                'semester' => 'Semester 1'
            ]
        ]);
    }
    
    /**
     * Get active sessions.
     */
    private function getActiveSessions($user)
    {
        return collect([
            (object)[
                'id' => 1,
                'device' => 'Windows 10 - Chrome',
                'location' => 'Jakarta, Indonesia',
                'ip_address' => '192.168.1.100',
                'last_activity' => now()->subMinutes(30),
                'is_current' => true
            ],
            (object)[
                'id' => 2,
                'device' => 'Android - Chrome Mobile',
                'location' => 'Jakarta, Indonesia',
                'ip_address' => '192.168.1.101',
                'last_activity' => now()->subHours(2),
                'is_current' => false
            ]
        ]);
    }
    
    /**
     * Get login history.
     */
    private function getLoginHistory($user)
    {
        return collect([
            (object)[
                'id' => 1,
                'device' => 'Windows 10 - Chrome',
                'location' => 'Jakarta, Indonesia',
                'ip_address' => '192.168.1.100',
                'login_time' => now()->subHours(2),
                'status' => 'success'
            ],
            (object)[
                'id' => 2,
                'device' => 'Android - Chrome Mobile',
                'location' => 'Jakarta, Indonesia',
                'ip_address' => '192.168.1.101',
                'login_time' => now()->subDays(1),
                'status' => 'success'
            ],
            (object)[
                'id' => 3,
                'device' => 'Windows 10 - Firefox',
                'location' => 'Bandung, Indonesia',
                'ip_address' => '192.168.1.102',
                'login_time' => now()->subDays(2),
                'status' => 'failed'
            ]
        ]);
    }
    
    /**
     * Calculate profile completeness.
     */
    private function calculateProfileCompleteness($student)
    {
        $fields = [
            'name' => !empty($student->user->name),
            'email' => !empty($student->user->email),
            'phone' => !empty($student->phone),
            'address' => !empty($student->address),
            'birth_place' => !empty($student->birth_place),
            'birth_date' => !empty($student->birth_date),
            'gender' => !empty($student->gender),
            'religion' => !empty($student->religion),
            'photo' => !empty($student->photo)
        ];
        
        $completed = array_filter($fields);
        return round((count($completed) / count($fields)) * 100);
    }
}