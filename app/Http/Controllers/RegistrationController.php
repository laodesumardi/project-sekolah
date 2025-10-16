<?php

namespace App\Http\Controllers;

use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    /**
     * Show the registration form.
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * Handle registration form submission.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'registration_type' => 'required|in:student,parent,teacher',
            'full_name' => 'required|string|max:255|min:3',
            'email' => 'required|email|max:255|unique:user_registrations,email',
            'phone' => 'required|string|min:10|max:15|regex:/^[0-9+\-\s]+$/',
            'nik' => 'nullable|string|size:16|regex:/^[0-9]+$/',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'required|date|before:today|after:1900-01-01',
            'gender' => 'required|in:L,P',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'nullable|string|size:5|regex:/^[0-9]+$/',
            
            // Student fields
            'school_origin' => 'required_if:registration_type,student|nullable|string|max:255',
            'last_education' => 'required_if:registration_type,student|nullable|string|max:100',
            'graduation_year' => 'required_if:registration_type,student|nullable|integer|min:2000|max:' . date('Y'),
            'nisn' => 'nullable|string|size:10|regex:/^[0-9]+$/',
            
            // Parent fields
            'relation_type' => 'required_if:registration_type,parent|nullable|in:ayah,ibu,wali',
            'occupation' => 'required_if:registration_type,parent|nullable|string|max:100',
            'student_name' => 'required_if:registration_type,parent|nullable|string|max:255',
            'student_nis' => 'nullable|string|max:20',
            
            // Password
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            
            // Terms
            'agreed_to_terms' => 'required|accepted',
            'agreed_to_privacy' => 'required|accepted',
        ], [
            'registration_type.required' => 'Pilih tipe pendaftaran.',
            'registration_type.in' => 'Tipe pendaftaran tidak valid.',
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'full_name.min' => 'Nama lengkap minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.regex' => 'NIK hanya boleh berisi angka.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.before' => 'Tanggal lahir harus di masa lalu.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'address.required' => 'Alamat wajib diisi.',
            'city.required' => 'Kota wajib diisi.',
            'province.required' => 'Provinsi wajib diisi.',
            'postal_code.size' => 'Kode pos harus 5 digit.',
            'school_origin.required_if' => 'Asal sekolah wajib diisi untuk siswa.',
            'last_education.required_if' => 'Pendidikan terakhir wajib diisi untuk siswa.',
            'graduation_year.required_if' => 'Tahun lulus wajib diisi untuk siswa.',
            'relation_type.required_if' => 'Hubungan wajib diisi untuk orang tua.',
            'occupation.required_if' => 'Pekerjaan wajib diisi untuk orang tua.',
            'student_name.required_if' => 'Nama siswa wajib diisi untuk orang tua.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'agreed_to_terms.required' => 'Anda harus menyetujui syarat dan ketentuan.',
            'agreed_to_privacy.required' => 'Anda harus menyetujui kebijakan privasi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create registration
            $registration = UserRegistration::create([
                'registration_type' => $request->registration_type,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'nik' => $request->nik,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'address' => $request->address,
                'city' => $request->city,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'school_origin' => $request->school_origin,
                'last_education' => $request->last_education,
                'graduation_year' => $request->graduation_year,
                'nisn' => $request->nisn,
                'relation_type' => $request->relation_type,
                'occupation' => $request->occupation,
                'student_name' => $request->student_name,
                'student_nis' => $request->student_nis,
                'password' => $request->password,
                'agreed_to_terms' => true,
                'agreed_to_privacy' => true,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Send verification email
            $registration->sendEmailVerification();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil! Silakan cek email untuk verifikasi.',
                'registration_number' => $registration->registration_number,
                'redirect_url' => route('registration.success', $registration->registration_number)
            ]);

        } catch (\Exception $e) {
            \Log::error('Registration Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show registration success page.
     */
    public function success($registrationNumber)
    {
        $registration = UserRegistration::where('registration_number', $registrationNumber)->first();
        
        if (!$registration) {
            return redirect()->route('register')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        return view('auth.registration-success', compact('registration'));
    }

    /**
     * Verify email.
     */
    public function verifyEmail($token)
    {
        $registration = UserRegistration::where('email_verification_token', $token)->first();
        
        if (!$registration) {
            return redirect()->route('register')->with('error', 'Token verifikasi tidak valid.');
        }

        if ($registration->verifyEmail($token)) {
            return redirect()->route('registration.success', $registration->registration_number)
                ->with('success', 'Email berhasil diverifikasi!');
        }

        return redirect()->route('register')->with('error', 'Gagal memverifikasi email.');
    }

    /**
     * Check registration status.
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string',
            'email' => 'required|email'
        ]);

        $registration = UserRegistration::where('registration_number', $request->registration_number)
            ->where('email', $request->email)
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftaran tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'registration' => [
                'registration_number' => $registration->registration_number,
                'full_name' => $registration->full_name,
                'email' => $registration->email,
                'status' => $registration->status,
                'status_badge' => $registration->status_badge,
                'created_at' => $registration->created_at->format('d F Y H:i'),
                'is_verified' => $registration->is_verified,
            ]
        ]);
    }
}