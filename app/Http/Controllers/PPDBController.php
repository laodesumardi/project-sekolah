<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\RegistrationSetting;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PPDBController extends Controller
{
    /**
     * Display PPDB landing page.
     */
    public function index()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        if (!$currentYear) {
            abort(404, 'Tahun ajaran aktif tidak ditemukan.');
        }

        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)
            ->where('is_open', true)
            ->first();

        if (!$setting) {
            abort(404, 'Pendaftaran PPDB belum dibuka.');
        }

        // Statistics
        $totalRegistrations = Registration::where('academic_year_id', $currentYear->id)->count();
        $pendingCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'pending')->count();
        $acceptedCount = Registration::where('academic_year_id', $currentYear->id)
            ->where('status', 'accepted')->count();

        return view('ppdb.index', compact('setting', 'totalRegistrations', 'pendingCount', 'acceptedCount'));
    }

    /**
     * Display registration form.
     */
    public function form()
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        if (!$currentYear) {
            abort(404, 'Tahun ajaran aktif tidak ditemukan.');
        }

        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)
            ->where('is_open', true)
            ->first();

        if (!$setting || !$setting->isCurrentlyOpen()) {
            return redirect()->route('ppdb.index')
                ->with('error', 'Pendaftaran PPDB belum dibuka atau sudah ditutup.');
        }

        return view('ppdb.form', compact('setting'));
    }

    /**
     * Store registration data step by step.
     */
    public function storeStep(Request $request, $step)
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)
            ->where('is_open', true)
            ->first();

        if (!$setting || !$setting->isCurrentlyOpen()) {
            return response()->json(['error' => 'Pendaftaran sudah ditutup.'], 400);
        }

        // Validate based on step
        $validationRules = $this->getValidationRules($step);
        $request->validate($validationRules);

        // Store in session for multi-step process
        $sessionKey = "ppdb_step_{$step}";
        session([$sessionKey => $request->all()]);

        return response()->json(['success' => true, 'step' => $step]);
    }

    /**
     * Submit final registration.
     */
    public function submit(Request $request)
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        $setting = RegistrationSetting::where('academic_year_id', $currentYear->id)
            ->where('is_open', true)
            ->first();

        if (!$setting || !$setting->isCurrentlyOpen()) {
            return redirect()->route('ppdb.index')
                ->with('error', 'Pendaftaran PPDB sudah ditutup.');
        }

        // Validate all steps
        $this->validateAllSteps($request);

        // Create registration
        $registration = $this->createRegistration($request, $setting);

        // Upload documents
        $this->uploadDocuments($request, $registration);

        // Log activity
        $registration->activities()->create([
            'activity_type' => 'registration_submitted',
            'description' => 'Pendaftaran PPDB berhasil dikirim',
            'metadata' => [
                'registration_path' => $registration->registration_path,
                'ip_address' => $request->ip(),
            ],
        ]);

        // Clear session data
        $this->clearSessionData();

        return redirect()->route('ppdb.confirmation', $registration->registration_number)
            ->with('success', 'Pendaftaran berhasil dikirim!');
    }

    /**
     * Display confirmation page.
     */
    public function confirmation($registrationNumber)
    {
        $registration = Registration::where('registration_number', $registrationNumber)->firstOrFail();

        return view('ppdb.confirmation', compact('registration'));
    }

    /**
     * Display status check form.
     */
    public function statusForm()
    {
        return view('ppdb.status');
    }

    /**
     * Check registration status.
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string',
            'email' => 'required|email',
        ]);

        $registration = Registration::where('registration_number', $request->registration_number)
            ->where('email', $request->email)
            ->first();

        if (!$registration) {
            return back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        return view('ppdb.status-result', compact('registration'));
    }

    /**
     * Display announcement page.
     */
    public function announcement(Request $request)
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        $query = Registration::where('academic_year_id', $currentYear->id)
            ->whereIn('status', ['accepted', 'rejected', 'reserved']);

        // Filter by path
        if ($request->path) {
            $query->where('registration_path', $request->path);
        }

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('registration_number', 'like', '%' . $request->search . '%');
            });
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('ppdb.announcement', compact('registrations'));
    }

    /**
     * Get validation rules for specific step.
     */
    private function getValidationRules($step)
    {
        return match($step) {
            1 => [
                'full_name' => 'required|string|max:255',
                'nik' => 'required|digits:16|unique:registrations,nik',
                'nisn' => 'required|digits:10|unique:registrations,nisn',
                'birth_place' => 'required|string|max:255',
                'birth_date' => 'required|date|before:today|after:2005-01-01',
                'gender' => 'required|in:L,P',
                'religion' => 'required|string|max:50',
                'child_number' => 'required|integer|min:1|max:20',
                'siblings_count' => 'required|integer|min:0|max:20',
                'address' => 'required|string|max:500',
                'rt' => 'required|string|max:3',
                'rw' => 'required|string|max:3',
                'kelurahan' => 'required|string|max:100',
                'kecamatan' => 'required|string|max:100',
                'city' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'postal_code' => 'required|string|max:5',
                'phone' => 'required|string|min:10|max:15',
                'email' => 'required|email|unique:registrations,email',
                'height' => 'nullable|integer|min:50|max:250',
                'weight' => 'nullable|integer|min:10|max:200',
                'blood_type' => 'nullable|string|max:5',
                'medical_history' => 'nullable|string|max:1000',
                'photo' => 'required|image|max:2048|mimes:jpg,jpeg,png',
            ],
            2 => [
                'father_name' => 'required|string|max:255',
                'father_nik' => 'required|digits:16',
                'father_birth_year' => 'required|integer|min:1950|max:' . (date('Y') - 15),
                'father_education' => 'required|string|max:100',
                'father_occupation' => 'required|string|max:100',
                'father_income' => 'required|string|max:50',
                'father_phone' => 'required|string|min:10|max:15',
                'mother_name' => 'required|string|max:255',
                'mother_nik' => 'required|digits:16',
                'mother_birth_year' => 'required|integer|min:1950|max:' . (date('Y') - 15),
                'mother_education' => 'required|string|max:100',
                'mother_occupation' => 'required|string|max:100',
                'mother_income' => 'required|string|max:50',
                'mother_phone' => 'required|string|min:10|max:15',
                'guardian_name' => 'nullable|string|max:255',
                'guardian_relation' => 'nullable|string|max:50',
                'guardian_phone' => 'nullable|string|min:10|max:15',
            ],
            3 => [
                'previous_school' => 'required|string|max:255',
                'school_npsn' => 'required|string|size:8',
                'school_address' => 'required|string|max:500',
                'graduation_year' => 'required|integer|min:2020|max:' . date('Y'),
                'certificate_number' => 'required|string|max:100',
                'average_score' => 'required|numeric|min:0|max:100',
                'achievements' => 'nullable|string|max:1000',
            ],
            4 => [
                'documents' => 'required|array|min:4',
                'documents.photo' => 'required|file|max:1024|mimes:jpg,jpeg,png',
                'documents.ijazah' => 'required|file|max:2048|mimes:pdf,jpg,jpeg,png',
                'documents.kk' => 'required|file|max:2048|mimes:pdf,jpg,jpeg,png',
                'documents.akta' => 'required|file|max:2048|mimes:pdf,jpg,jpeg,png',
                'documents.achievement' => 'nullable|array',
                'documents.achievement.*' => 'file|max:3072|mimes:pdf,jpg,jpeg,png',
            ],
            default => [],
        };
    }

    /**
     * Validate all steps.
     */
    private function validateAllSteps(Request $request)
    {
        $rules = [];
        for ($i = 1; $i <= 4; $i++) {
            $rules = array_merge($rules, $this->getValidationRules($i));
        }
        
        $request->validate($rules);
    }

    /**
     * Create registration record.
     */
    private function createRegistration(Request $request, RegistrationSetting $setting)
    {
        $data = $request->all();
        $data['academic_year_id'] = $setting->academic_year_id;
        $data['registration_setting_id'] = $setting->id;
        $data['registration_path'] = $request->registration_path ?? 'regular';
        $data['status'] = 'pending';

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = 'photo_' . time() . '.' . $photo->getClientOriginalExtension();
            $data['photo'] = $photoName;
        }

        return Registration::create($data);
    }

    /**
     * Upload documents.
     */
    private function uploadDocuments(Request $request, Registration $registration)
    {
        $documents = $request->file('documents', []);
        $uploadPath = "registrations/{$registration->registration_number}";

        foreach ($documents as $type => $files) {
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                $fileName = $type . '_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs($uploadPath, $fileName, 'public');

                $registration->documents()->create([
                    'document_type' => $type,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }
    }

    /**
     * Clear session data.
     */
    private function clearSessionData()
    {
        for ($i = 1; $i <= 4; $i++) {
            session()->forget("ppdb_step_{$i}");
        }
    }
}

