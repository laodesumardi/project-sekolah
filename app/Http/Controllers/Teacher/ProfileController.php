<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\TeacherDocument;
use App\Models\TeacherCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $documents = $teacher->documents()->orderBy('created_at', 'desc')->get();
        $certifications = $teacher->certifications()->orderBy('issue_date', 'desc')->get();
        
        return view('teacher.profile.show', compact('teacher', 'documents', 'certifications'));
    }
    
    public function create()
    {
        return view('teacher.profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20|min:8|unique:teachers,nip|regex:/^[0-9]+$/',
            'nik' => 'required|string|max:16|min:16|unique:teachers,nik|regex:/^[0-9]+$/',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'religion' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:15',
            'employment_status' => 'required|string|max:50',
            'join_date' => 'required|date',
            'education_level' => 'required|string|max:20',
            'major' => 'nullable|string|max:100',
            'university' => 'nullable|string|max:100',
            'graduation_year' => 'nullable|integer|min:1950|max:' . date('Y'),
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'required|string',
            'classes' => 'nullable|array',
            'classes.*' => 'string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
        ], [
            'nip.required' => 'NIP wajib diisi',
            'nip.max' => 'NIP tidak boleh lebih dari 20 karakter',
            'nip.min' => 'NIP minimal 8 karakter',
            'nip.unique' => 'NIP sudah digunakan',
            'nip.regex' => 'NIP hanya boleh berisi angka',
            'nik.required' => 'NIK wajib diisi',
            'nik.max' => 'NIK tidak boleh lebih dari 16 karakter',
            'nik.min' => 'NIK harus tepat 16 karakter',
            'nik.unique' => 'NIK sudah digunakan',
            'nik.regex' => 'NIK hanya boleh berisi angka',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'nip' => $request->nip,
            'nik' => $request->nik,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'address' => $request->address,
            'phone' => $request->phone,
            'employment_status' => $request->employment_status,
            'join_date' => $request->join_date,
            'education_level' => $request->education_level,
            'major' => $request->major,
            'university' => $request->university,
            'graduation_year' => $request->graduation_year,
            'bio' => $request->bio,
            'is_active' => true,
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $fileName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = $photo->storeAs('teacher-photos', $fileName, 'public');
            $data['photo'] = $photoPath;
        }

        $teacher = Teacher::create($data);

        // Handle subjects
        if ($request->has('subjects')) {
            foreach ($request->subjects as $subjectName) {
                // Find or create subject
                $subject = \App\Models\Subject::firstOrCreate([
                    'name' => $subjectName
                ]);
                
                // Attach subject to teacher
                $teacher->subjects()->attach($subject->id);
            }
        }

        // Handle classes
        if ($request->has('classes')) {
            foreach ($request->classes as $className) {
                // Find or create class
                $class = \App\Models\SchoolClass::firstOrCreate([
                    'name' => $className
                ]);
                
                // Attach class to teacher
                $teacher->classes()->attach($class->id);
            }
        }

        return redirect()->route('teacher.profile.show')
            ->with('success', 'Profil guru berhasil dibuat!');
    }

    public function edit()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $teacher->load('user');
        
        return view('teacher.profile.edit', compact('teacher'));
    }
    
    public function update(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }
        
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);
        
        // Update user email
        Auth::user()->update([
            'email' => $request->email,
        ]);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                Storage::disk('public')->delete($teacher->photo);
            }
            
            // Store new photo
            $photoPath = $request->file('photo')->store('teacher-photos', 'public');
            $teacher->update(['photo' => $photoPath]);
        }
        
        // Handle password update
        if ($request->filled('new_password')) {
            Auth::user()->update([
                'password' => Hash::make($request->new_password),
            ]);
        }
        
        // Update teacher profile
        $teacher->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
        ]);
        
        return redirect()->route('teacher.profile.show')
            ->with('success', 'Profil guru berhasil diperbarui!');
    }
    
    public function updatePhoto(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return response()->json(['error' => 'Teacher profile not found'], 404);
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Delete old photo if exists
        if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
            Storage::disk('public')->delete($teacher->photo);
        }
        
        // Store new photo
        $photoPath = $request->file('photo')->store('teacher-photos', 'public');
        $teacher->update(['photo' => $photoPath]);
        
        return response()->json([
            'success' => true,
            'photo_url' => $teacher->fresh()->profile_picture_url,
        ]);
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);
        
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);
        
        return redirect()->route('teacher.profile.show')
            ->with('success', 'Password berhasil diperbarui!');
    }
    
    public function portfolio()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        $documents = $teacher->documents()->orderBy('created_at', 'desc')->get();
        $certifications = $teacher->certifications()->orderBy('issue_date', 'desc')->get();
        $activities = $teacher->activities()->orderBy('date', 'desc')->get();

        return view('teacher.profile.portfolio', compact('teacher', 'documents', 'certifications', 'activities'));
    }

    public function security()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        return view('teacher.profile.security', compact('teacher'));
    }

    public function sessions()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        return view('teacher.profile.sessions', compact('teacher'));
    }

    public function logoutOtherDevices(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);
        
        Auth::logoutOtherDevices($request->password);
        
        return redirect()->route('teacher.profile.sessions')
            ->with('success', 'Sesi lain telah diakhiri!');
    }
    
    public function updatePrivacy(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }
        
        $request->validate([
            'is_public' => 'boolean',
        ]);

        // Update privacy settings if needed
        // This would depend on your specific privacy requirements

        return redirect()->route('teacher.profile.show')
            ->with('success', 'Pengaturan privasi berhasil diperbarui!');
    }
}
