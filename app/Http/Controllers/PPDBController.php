<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistration;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\NotificationService;

class PPDBController extends Controller
{
    /**
     * Display PPDB form
     */
    public function index()
    {
        // Get PPDB settings from database
        $settings = $this->getPPDBSettings();
        
        // Check if registration is open
        if (!$settings['is_open']) {
            return view('ppdb.closed', compact('settings'));
        }
        
        return view('ppdb.index', compact('settings'));
    }

    /**
     * Get PPDB settings from database
     */
    private function getPPDBSettings()
    {
        $settings = DB::table('ppdb_settings')->pluck('value', 'key')->toArray();
        
        return [
            'registration_period_start' => $settings['registration_period_start'] ?? date('Y-m-d'),
            'registration_period_end' => $settings['registration_period_end'] ?? date('Y-m-d', strtotime('+3 months')),
            'quota' => $settings['quota'] ?? 200,
            'is_open' => ($settings['is_open'] ?? '1') === '1',
            'description' => $settings['description'] ?? 'Penerimaan Peserta Didik Baru SMP Negeri 01 Namrole Tahun Ajaran 2025/2026',
            'requirements' => $settings['requirements'] ?? '• Usia maksimal 15 tahun pada 1 Juli 2025\n• Memiliki ijazah SD/MI atau sederajat\n• Foto berwarna 3x4 (2 lembar)\n• Fotokopi akta kelahiran',
            'contact_phone' => $settings['contact_phone'] ?? '(021) 1234-5678',
            'contact_email' => $settings['contact_email'] ?? 'ppdb@smpn01namrole.sch.id',
            'contact_whatsapp' => $settings['contact_whatsapp'] ?? '0812-3456-7890',
            'contact_address' => $settings['contact_address'] ?? 'Jl. Pendidikan No. 1, Namrole',
            'banner_image' => $settings['banner_image'] ?? null,
            'hero_title' => $settings['hero_title'] ?? 'PPDB 2025',
            'hero_subtitle' => $settings['hero_subtitle'] ?? 'Penerimaan Peserta Didik Baru',
            'hero_description' => $settings['hero_description'] ?? 'Bergabunglah dengan keluarga besar SMP Negeri 01 Namrole',
        ];
    }

    /**
     * Store PPDB registration
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_registrations,email',
            'phone' => 'required|string|max:20',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'school_origin' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:2015|max:' . date('Y'),
            'nisn' => 'nullable|string|max:20',
            'photo_3x4' => 'required|file|mimes:jpeg,jpg,png|max:2048',
            'birth_certificate' => 'required|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'family_card' => 'required|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'diploma' => 'required|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'report_card' => 'required|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'parent_id_card' => 'required|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'agreed_to_terms' => 'required|accepted',
            'agreed_to_privacy' => 'required|accepted',
        ], [
            'full_name.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor telepon harus diisi',
            'birth_date.required' => 'Tanggal lahir harus diisi',
            'gender.required' => 'Jenis kelamin harus dipilih',
            'address.required' => 'Alamat harus diisi',
            'city.required' => 'Kota harus diisi',
            'province.required' => 'Provinsi harus diisi',
            'school_origin.required' => 'Asal sekolah harus diisi',
            'graduation_year.required' => 'Tahun lulus harus diisi',
            'photo_3x4.required' => 'Foto 3x4 harus diupload.',
            'photo_3x4.mimes' => 'Foto 3x4 harus berupa file JPEG, JPG, atau PNG.',
            'photo_3x4.max' => 'Foto 3x4 maksimal 2MB.',
            'birth_certificate.required' => 'Akta kelahiran harus diupload.',
            'birth_certificate.mimes' => 'Akta kelahiran harus berupa file PDF, JPEG, JPG, atau PNG.',
            'birth_certificate.max' => 'Akta kelahiran maksimal 5MB.',
            'family_card.required' => 'Kartu keluarga harus diupload.',
            'family_card.mimes' => 'Kartu keluarga harus berupa file PDF, JPEG, JPG, atau PNG.',
            'family_card.max' => 'Kartu keluarga maksimal 5MB.',
            'diploma.required' => 'Ijazah SD/MI harus diupload.',
            'diploma.mimes' => 'Ijazah harus berupa file PDF, JPEG, JPG, atau PNG.',
            'diploma.max' => 'Ijazah maksimal 5MB.',
            'report_card.required' => 'Rapor SD/MI harus diupload.',
            'report_card.mimes' => 'Rapor harus berupa file PDF, JPEG, JPG, atau PNG.',
            'report_card.max' => 'Rapor maksimal 5MB.',
            'parent_id_card.required' => 'KTP orang tua harus diupload.',
            'parent_id_card.mimes' => 'KTP orang tua harus berupa file PDF, JPEG, JPG, atau PNG.',
            'parent_id_card.max' => 'KTP orang tua maksimal 5MB.',
            'agreed_to_terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'agreed_to_privacy.required' => 'Anda harus menyetujui kebijakan privasi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Handle file uploads
            $filePaths = [];
            $fileFields = [
                'photo_3x4',
                'birth_certificate', 
                'family_card',
                'diploma',
                'report_card',
                'parent_id_card'
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = time() . '_' . $field . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('ppdb/documents', $filename, 'public');
                    $filePaths[$field] = $path;
                }
            }

            // Generate registration number
            $registrationNumber = $this->generateRegistrationNumber();
            
            // Create registration
            $registration = UserRegistration::create([
                'registration_number' => $registrationNumber,
                'registration_type' => 'student',
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'address' => $request->address,
                'city' => $request->city,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'school_origin' => $request->school_origin,
                'graduation_year' => $request->graduation_year,
                'nisn' => $request->nisn,
                'photo_3x4' => $filePaths['photo_3x4'] ?? null,
                'birth_certificate' => $filePaths['birth_certificate'] ?? null,
                'family_card' => $filePaths['family_card'] ?? null,
                'diploma' => $filePaths['diploma'] ?? null,
                'report_card' => $filePaths['report_card'] ?? null,
                'parent_id_card' => $filePaths['parent_id_card'] ?? null,
                'password' => Str::random(12), // Generate random password
                'agreed_to_terms' => true,
                'agreed_to_privacy' => true,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Send notification to admins
            NotificationService::notifyNewPPDBRegistration($registration);

            // Generate success URL with proper domain
            $successUrl = url('/ppdb/success/' . $registration->registration_number);
            
            return redirect($successUrl)
                ->with('success', 'Pendaftaran berhasil! Silakan cek email untuk informasi selanjutnya.');
                
        } catch (\Exception $e) {
            \Log::error('PPDB Registration Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show success page
     */
    public function success($registrationNumber)
    {
        $registration = UserRegistration::where('registration_number', $registrationNumber)->first();
        
        if (!$registration) {
            return redirect()->route('ppdb.index')->with('error', 'Data pendaftaran tidak ditemukan.');
        }
        
        return view('ppdb.success', compact('registration'));
    }

    /**
     * Show status check form
     */
    public function checkStatusForm()
    {
        return view('ppdb.status');
    }

    /**
     * Check registration status
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string',
            'email' => 'required|email',
        ]);

        $registration = UserRegistration::where('registration_number', $request->registration_number)
            ->where('email', $request->email)
            ->first();

        if (!$registration) {
            return back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        return view('ppdb.status', compact('registration'));
    }

    /**
     * Generate unique registration number
     */
    private function generateRegistrationNumber()
    {
        $year = date('Y');
        $prefix = "PPDB{$year}";
        
        do {
            $number = $prefix . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (UserRegistration::where('registration_number', $number)->exists());
        
        return $number;
    }

    /**
     * Session ping to keep session alive
     */
    public function sessionPing(Request $request)
    {
        // Update session timestamp to keep it alive
        $request->session()->put('last_activity', time());
        
        // Also update the session in database if using database driver
        if (config('session.driver') === 'database') {
            $sessionId = $request->session()->getId();
            DB::table('sessions')
                ->where('id', $sessionId)
                ->update([
                    'last_activity' => time(),
                    'updated_at' => now()
                ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Session extended',
            'timestamp' => time()
        ]);
    }

}