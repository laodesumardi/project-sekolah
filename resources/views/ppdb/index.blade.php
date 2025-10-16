@extends('layouts.app')

@section('title', 'PPDB 2025 - SMP Negeri 01 Namrole')

@section('content')
<style>
/* PPDB Form Responsive Styles */
.ppdb-form-container {
    max-width: 100%;
    margin: 0 auto;
    padding: 1rem;
}

.ppdb-form-section {
    background: #f8fafc;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e2e8f0;
}

.ppdb-form-section h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.ppdb-form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

.ppdb-form-field {
    display: flex;
    flex-direction: column;
}

.ppdb-form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
    display: block;
}

.ppdb-form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    background: white;
}

.ppdb-form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.ppdb-form-input:invalid {
    border-color: #ef4444;
}

.ppdb-form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    resize: vertical;
    min-height: 100px;
    transition: all 0.2s ease;
    background: white;
}

.ppdb-form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.ppdb-form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    background: white;
    transition: all 0.2s ease;
}

.ppdb-form-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.ppdb-form-radio-group {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.ppdb-form-radio-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.ppdb-form-radio {
    width: 1rem;
    height: 1rem;
    accent-color: #3b82f6;
}

.ppdb-form-checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.ppdb-form-checkbox-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.ppdb-form-checkbox {
    width: 1.25rem;
    height: 1.25rem;
    accent-color: #3b82f6;
    margin-top: 0.125rem;
    flex-shrink: 0;
}

.ppdb-form-submit {
    width: 100%;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    border: none;
    border-radius: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.ppdb-form-submit:hover {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.ppdb-form-submit:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.ppdb-form-submit:disabled:hover {
    background: #9ca3af;
    transform: none;
    box-shadow: none;
}

/* Mobile Responsive */
@media (min-width: 640px) {
    .ppdb-form-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .ppdb-form-radio-group {
        flex-direction: row;
        gap: 1.5rem;
    }
}

@media (min-width: 768px) {
    .ppdb-form-container {
        padding: 2rem;
    }
    
    .ppdb-form-section {
        padding: 2rem;
    }
}

@media (min-width: 1024px) {
    .ppdb-form-container {
        max-width: 1200px;
    }
}

/* Form Validation States */
.ppdb-form-field.error .ppdb-form-input,
.ppdb-form-field.error .ppdb-form-textarea,
.ppdb-form-field.error .ppdb-form-select {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.ppdb-form-field.success .ppdb-form-input,
.ppdb-form-field.success .ppdb-form-textarea,
.ppdb-form-field.success .ppdb-form-select {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.ppdb-form-error {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.ppdb-form-success {
    color: #10b981;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Loading States */
.ppdb-form-loading {
    opacity: 0.6;
    pointer-events: none;
}

.ppdb-form-loading .ppdb-form-submit {
    background: #6b7280;
}

/* File Upload Styles */
.ppdb-file-upload {
    border: 2px dashed #d1d5db;
    border-radius: 0.5rem;
    padding: 2rem;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
    background: #f9fafb;
}

.ppdb-file-upload:hover {
    border-color: #3b82f6;
    background: #eff6ff;
}

.ppdb-file-upload.dragover {
    border-color: #3b82f6;
    background: #eff6ff;
}

.ppdb-file-preview {
    margin-top: 1rem;
    padding: 1rem;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.ppdb-file-preview img {
    width: 3rem;
    height: 3rem;
    object-fit: cover;
    border-radius: 0.25rem;
}

.ppdb-file-preview .file-info {
    flex: 1;
}

.ppdb-file-preview .file-name {
    font-weight: 500;
    color: #1f2937;
    font-size: 0.875rem;
}

.ppdb-file-preview .file-size {
    color: #6b7280;
    font-size: 0.75rem;
}

/* Progress Indicator */
.ppdb-form-progress {
    background: #f3f4f6;
    border-radius: 0.5rem;
    height: 0.5rem;
    margin-bottom: 2rem;
    overflow: hidden;
}

.ppdb-form-progress-bar {
    background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    height: 100%;
    transition: width 0.3s ease;
    border-radius: 0.5rem;
}

/* Responsive Typography */
@media (max-width: 640px) {
    .ppdb-form-section h3 {
        font-size: 1rem;
    }
    
    .ppdb-form-label {
        font-size: 0.8rem;
    }
    
    .ppdb-form-input,
    .ppdb-form-textarea,
    .ppdb-form-select {
        font-size: 0.8rem;
        padding: 0.625rem 0.875rem;
    }
    
    .ppdb-form-submit {
        font-size: 0.9rem;
        padding: 0.875rem 1.5rem;
    }
}

/* Session Warning Styles */
.session-warning {
    animation: slideInRight 0.3s ease-out;
    border-left: 4px solid #f59e0b;
}

.session-warning .fa-exclamation-triangle {
    animation: pulse 2s infinite;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

/* Session Status Indicator */
.session-status {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #10b981;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 0.75rem;
    z-index: 40;
    display: none;
}

.session-status.warning {
    background: #f59e0b;
}

.session-status.error {
    background: #ef4444;
}
</style>
<!-- Page Header -->
<section class="relative py-20 bg-primary-500">
    @if($settings['banner_image'])
        <!-- Debug: Banner image path: {{ $settings['banner_image'] }} -->
        <div class="absolute inset-0">
            <img src="{{ asset('storage/' . $settings['banner_image']) }}" 
                 alt="PPDB Banner" 
                 class="w-full h-full object-cover" 
                 onerror="console.log('Banner image failed to load:', this.src); this.style.display='none'; this.nextElementSibling.style.display='block';"
                 onload="console.log('Banner image loaded successfully:', this.src);">
            <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-primary-800" style="display: none;"></div>
            <div class="absolute inset-0 bg-black opacity-40"></div>
        </div>
    @else
        <!-- Debug: No banner image set -->
        <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-primary-800"></div>
        <div class="absolute inset-0 bg-black opacity-20"></div>
    @endif
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ $settings['hero_title'] }}</h1>
        <p class="text-xl text-gray-200 mb-6">{{ $settings['hero_subtitle'] }} - {{ $settings['hero_description'] }}</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-6">
            <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                <span class="text-white font-medium">Tahun Ajaran 2025/2026</span>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                <span class="text-white font-medium">Periode: {{ date('d M', strtotime($settings['registration_period_start'])) }} - {{ date('d M Y', strtotime($settings['registration_period_end'])) }}</span>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ config('app.url') }}/ppdb/status" 
               class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 backdrop-blur-sm border border-white border-opacity-30">
                <i class="fas fa-search mr-2"></i>
                Cek Status Pendaftaran
            </a>
            <a href="#ppdb-form" 
               class="bg-yellow-400 hover:bg-yellow-500 text-primary-700 font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-edit mr-2"></i>
                Daftar Sekarang
            </a>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Periode Pendaftaran</h3>
                        <p class="text-sm text-gray-600">{{ date('d M', strtotime($settings['registration_period_start'])) }} - {{ date('d M Y', strtotime($settings['registration_period_end'])) }}</p>
                                </div>
                            </div>
                        </div>
                        
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                                </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Kuota Tersedia</h3>
                        <p class="text-sm text-gray-600">{{ $settings['quota'] }} Siswa</p>
                        </div>
                    </div>
                </div>
                
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-graduation-cap text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Pendaftar Terdaftar</h3>
                        <p class="text-sm text-gray-600">{{ \App\Models\UserRegistration::where('registration_type', 'student')->count() }} Siswa</p>
                    </div>
                </div>
                </div>
                </div>

        <!-- Form Container -->
        <div class="ppdb-form-container">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Formulir Pendaftaran PPDB 2025</h2>
                    <p class="text-primary-100">Isi data dengan lengkap dan benar sesuai dokumen resmi</p>
                </div>

                <!-- Progress Indicator -->
                <div class="ppdb-form-progress">
                    <div class="ppdb-form-progress-bar" id="form-progress" style="width: 0%"></div>
                </div>

                <div class="p-8">
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
            </div>
            </div>
        </div>
    </div>
                @endif

                <!-- Error Notifications -->
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                            <div>
                                <h4 class="text-red-800 font-medium">Terjadi Kesalahan!</h4>
                                <ul class="text-red-700 text-sm mt-1">
                                    @foreach($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <div>
                                <h4 class="text-green-800 font-medium">Berhasil!</h4>
                                <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <div>
                                <h4 class="text-red-800 font-medium">Gagal!</h4>
                                <p class="text-red-700 text-sm mt-1">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form id="ppdb-form" method="POST" action="{{ config('app.url') }}/ppdb" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Data Pribadi -->
                    <div class="ppdb-form-section">
                        <h3 class="ppdb-form-section h3">
                            <i class="fas fa-user text-blue-600 mr-2"></i>
                            Data Pribadi
                        </h3>
                        
                        <div class="ppdb-form-grid">
                            <div class="ppdb-form-field">
                                <label class="ppdb-form-label">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" 
                                       class="ppdb-form-input"
                                       placeholder="Masukkan nama lengkap sesuai KTP/Akta" required>
                                <div class="ppdb-form-error" id="full_name_error" style="display: none;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span></span>
                                </div>
                            </div>

                            <div class="ppdb-form-field">
                                <label class="ppdb-form-label">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" 
                                       class="ppdb-form-input"
                                       placeholder="contoh@email.com" required>
                                <div class="ppdb-form-error" id="email_error" style="display: none;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span></span>
                                </div>
                            </div>

                            <div class="ppdb-form-field">
                                <label class="ppdb-form-label">
                                    Nomor HP/WhatsApp <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" 
                                       class="ppdb-form-input"
                                       placeholder="08xxxxxxxxxx" required>
                                <div class="ppdb-form-error" id="phone_error" style="display: none;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span></span>
                                </div>
                            </div>

                            <div class="ppdb-form-field">
                                <label class="ppdb-form-label">
                                    NIK (Nomor Induk Kependudukan)
                                </label>
                                <input type="text" name="nik" value="{{ old('nik') }}" 
                                       class="ppdb-form-input"
                                       placeholder="16 digit NIK KTP" maxlength="16">
                                <div class="ppdb-form-error" id="nik_error" style="display: none;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span></span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tempat Lahir
                                </label>
                                <input type="text" name="birth_place" value="{{ old('birth_place') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Contoh: Jakarta">
                </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <div class="flex space-x-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" value="L" {{ old('gender') == 'L' ? 'checked' : '' }} 
                                               class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                                        <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" value="P" {{ old('gender') == 'P' ? 'checked' : '' }} 
                                               class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                                        <span class="ml-2 text-sm text-gray-700">Perempuan</span>
                                    </label>
                </div>
                </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Kode Pos
                                </label>
                                <input type="text" name="postal_code" value="{{ old('postal_code') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="12345" maxlength="5">
                </div>
            </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Jalan, RT/RW, Kelurahan, Kecamatan" required>{{ old('address') }}</textarea>
                </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Kota/Kabupaten <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="city" value="{{ old('city') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Pilih atau ketik kota" required>
                </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Provinsi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="province" value="{{ old('province') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Pilih provinsi" required>
            </div>
        </div>
    </div>

                    <!-- Data Pendidikan -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                            Data Pendidikan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    NISN (Nomor Induk Siswa Nasional)
                                </label>
                                <input type="text" name="nisn" value="{{ old('nisn') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="10 digit NISN" maxlength="10">
        </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Asal Sekolah <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="school_origin" value="{{ old('school_origin') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Nama sekolah terakhir" required>
            </div>


                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tahun Lulus <span class="text-red-500">*</span>
                                </label>
                                <select name="graduation_year" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Pilih tahun lulus</option>
                                    @for($year = date('Y'); $year >= 2015; $year--)
                                        <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
            </div>
        </div>
    </div>

                    <!-- Persetujuan -->
                    <div class="bg-blue-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-shield-alt text-blue-600 mr-2"></i>
                            Persetujuan
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" name="agreed_to_terms" id="agreed_to_terms" 
                                       class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 mt-1" required>
                                <label for="agreed_to_terms" class="text-sm text-gray-700">
                                    Saya menyatakan bahwa data yang diisi adalah benar dan dapat dipertanggungjawabkan. 
                                    <span class="text-red-500">*</span>
                                </label>
        </div>

                            <div class="flex items-start space-x-3">
                                <input type="checkbox" name="agreed_to_privacy" id="agreed_to_privacy" 
                                       class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 mt-1" required>
                                <label for="agreed_to_privacy" class="text-sm text-gray-700">
                                    Saya menyetujui penggunaan data pribadi untuk keperluan administrasi sekolah. 
                                    <span class="text-red-500">*</span>
                                </label>
                    </div>
                </div>
                    </div>

                    <!-- Upload Dokumen -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-file-upload text-blue-600 mr-2"></i>
                            Upload Dokumen Persyaratan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Foto 3x4 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto 3x4 <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-camera text-gray-400 text-4xl"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="photo_3x4" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload foto 3x4</span>
                                                <input id="photo_3x4" name="photo_3x4" type="file" class="sr-only" accept="image/*" required>
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                    </div>
                </div>
                    </div>

                            <!-- Akta Kelahiran -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Akta Kelahiran <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-file-pdf text-gray-400 text-4xl"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="birth_certificate" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload akta kelahiran</span>
                                                <input id="birth_certificate" name="birth_certificate" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required>
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                </div>
                                        <p class="text-xs text-gray-500">PDF, JPG, PNG hingga 5MB</p>
            </div>
        </div>
    </div>

                            <!-- Kartu Keluarga -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Kartu Keluarga <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-id-card text-gray-400 text-4xl"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="family_card" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload KK</span>
                                                <input id="family_card" name="family_card" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required>
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, JPG, PNG hingga 5MB</p>
                                    </div>
                                </div>
        </div>

                            <!-- Ijazah SD/MI -->
                                <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Ijazah SD/MI <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-graduation-cap text-gray-400 text-4xl"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="diploma" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload ijazah</span>
                                                <input id="diploma" name="diploma" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required>
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, JPG, PNG hingga 5MB</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Rapor SD/MI -->
                                <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Rapor SD/MI <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-file-alt text-gray-400 text-4xl"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="report_card" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload rapor</span>
                                                <input id="report_card" name="report_card" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required>
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, JPG, PNG hingga 5MB</p>
                                    </div>
                                </div>
                            </div>

                            <!-- KTP Orang Tua -->
                                <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    KTP Orang Tua <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-id-badge text-gray-400 text-4xl"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="parent_id_card" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload KTP orang tua</span>
                                                <input id="parent_id_card" name="parent_id_card" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required>
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, JPG, PNG hingga 5MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Info Persyaratan -->
                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Persyaratan Dokumen</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Semua dokumen harus dalam format PDF, JPG, atau PNG</li>
                                            <li>Ukuran maksimal 5MB per file (kecuali foto 3x4 maksimal 2MB)</li>
                                            <li>Dokumen harus jelas dan dapat dibaca</li>
                                            <li>Foto 3x4 harus berwarna dengan latar belakang putih</li>
                                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

                    <!-- Submit Button & Status Check -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-6">
                        <button type="submit" 
                                class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition-colors duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Daftar PPDB 2025
                        </button>
                        
                        <a href="{{ config('app.url') }}/ppdb/status" 
                           class="bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition-colors duration-200 shadow-lg hover:shadow-xl text-center">
                            <i class="fas fa-search mr-2"></i>
                            Cek Status Pendaftaran
                        </a>
                    </div>
                </form>
                        </div>
                    </div>

        <!-- Info Tambahan -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Penting</h3>
                <a href="{{ config('app.url') }}/ppdb/status" 
                   class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Cek Status Pendaftaran
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Persyaratan Umum:</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        {!! nl2br(e($settings['requirements'])) !!}
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Kontak Panitia:</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Telepon: {{ $settings['contact_phone'] }}</li>
                        <li>• Email: {{ $settings['contact_email'] }}</li>
                        <li>• WhatsApp: {{ $settings['contact_whatsapp'] }}</li>
                        <li>• Alamat: {{ $settings['contact_address'] }}</li>
                    </ul>
                </div>
                </div>
        </div>
    </div>

    </div>
</section>

<script>
// Form validation and notification system
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    // Form submission with loading state
    if (form) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            }
            
            // Validate required fields
            const requiredFields = form.querySelectorAll('[required]');
            let hasErrors = false;
            const errorMessages = [];
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    hasErrors = true;
                    field.classList.add('border-red-500');
                    errorMessages.push(`${field.previousElementSibling?.textContent?.trim() || field.name} harus diisi`);
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            // Validate file uploads
            const fileInputs = form.querySelectorAll('input[type="file"][required]');
            fileInputs.forEach(input => {
                if (!input.files || input.files.length === 0) {
                    hasErrors = true;
                    input.classList.add('border-red-500');
                    errorMessages.push(`${input.previousElementSibling?.textContent?.trim() || input.name} harus diupload`);
                } else {
                    input.classList.remove('border-red-500');
                }
            });
            
            if (hasErrors) {
                e.preventDefault();
                
                // Show error notification
                showNotification('error', 'Terjadi Kesalahan!', errorMessages.join('<br>'));
                
                // Reset button
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Daftar PPDB 2025';
                }
            }
        });
    }
    
    // Notification system
    function showNotification(type, title, message) {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification-toast');
        existingNotifications.forEach(notification => notification.remove());
        
        const notification = document.createElement('div');
        notification.className = 'notification-toast fixed top-4 right-4 z-50 max-w-sm';
        
        const bgColor = type === 'error' ? 'bg-red-500' : 'bg-green-500';
        const icon = type === 'error' ? 'fa-exclamation-triangle' : 'fa-check-circle';
        
        notification.innerHTML = `
            <div class="${bgColor} text-white p-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <i class="fas ${icon} mr-3"></i>
                    <div>
                        <h4 class="font-medium">${title}</h4>
                        <p class="text-sm opacity-90 mt-1">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }
    
    // Make showNotification globally available
    window.showNotification = showNotification;

// File upload preview functionality
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const container = this.closest('.mt-1');
                const preview = container.querySelector('.file-preview');
                
                // Remove existing preview
                if (preview) {
                    preview.remove();
                }
                
                // Create new preview
                const previewDiv = document.createElement('div');
                previewDiv.className = 'file-preview mt-2 p-3 bg-green-50 border border-green-200 rounded-lg';
                
                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'w-20 h-20 object-cover rounded-lg';
                    previewDiv.appendChild(img);
                } else {
                    const icon = document.createElement('i');
                    icon.className = 'fas fa-file text-green-600 text-2xl';
                    previewDiv.appendChild(icon);
                }
                
                const fileName = document.createElement('p');
                fileName.className = 'text-sm text-green-800 mt-1';
                fileName.textContent = file.name;
                previewDiv.appendChild(fileName);
                
                const fileSize = document.createElement('p');
                fileSize.className = 'text-xs text-green-600';
                fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                previewDiv.appendChild(fileSize);
                
                container.appendChild(previewDiv);
            }
        });
    });
    
    // Drag and drop functionality
    const dropZones = document.querySelectorAll('.border-dashed');
    
    dropZones.forEach(zone => {
        zone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-blue-400', 'bg-blue-50');
        });
        
        zone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-400', 'bg-blue-50');
        });
        
        zone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-400', 'bg-blue-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const fileInput = this.querySelector('input[type="file"]');
                if (fileInput) {
                    fileInput.files = files;
                    fileInput.dispatchEvent(new Event('change'));
                }
            }
        });
    });
});

// Enhanced Form Validation and Progress Tracking
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('ppdb-form');
    const progressBar = document.getElementById('form-progress');
    const formFields = form.querySelectorAll('.ppdb-form-field');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Session Management - Extend session every 5 minutes
    let sessionExtendInterval;
    let lastActivity = Date.now();
    
    function extendSession() {
        // Send a ping to keep session alive
        fetch('/ppdb/session-ping', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ timestamp: Date.now() })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSessionStatus('success', 'Session Diperpanjang');
            }
        })
        .catch(error => {
            console.log('Session ping failed:', error);
            showSessionStatus('error', 'Session Bermasalah');
        });
    }
    
    function startSessionManagement() {
        // Extend session every 5 minutes
        sessionExtendInterval = setInterval(extendSession, 5 * 60 * 1000);
        
        // Track user activity
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
            document.addEventListener(event, function() {
                lastActivity = Date.now();
            }, true);
        });
        
        // Check for inactivity every minute
        setInterval(function() {
            const now = Date.now();
            const timeSinceActivity = now - lastActivity;
            
            // If user has been inactive for more than 8 minutes, show warning
            if (timeSinceActivity > 8 * 60 * 1000) {
                showSessionWarning();
            }
        }, 60 * 1000);
    }
    
    function showSessionWarning() {
        // Remove existing warning if any
        const existingWarning = document.querySelector('.session-warning');
        if (existingWarning) {
            existingWarning.remove();
        }
        
        const warning = document.createElement('div');
        warning.className = 'session-warning fixed top-4 right-4 z-50 bg-yellow-500 text-white p-4 rounded-lg shadow-lg max-w-sm';
        warning.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <div>
                    <h4 class="font-bold">Session Akan Berakhir</h4>
                    <p class="text-sm">Klik di mana saja untuk memperpanjang session</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(warning);
        
        // Auto remove after 30 seconds
        setTimeout(() => {
            if (warning.parentElement) {
                warning.remove();
            }
        }, 30000);
    }
    
    // Start session management
    startSessionManagement();
    
    // Progress tracking
    function updateProgress() {
        const totalFields = formFields.length;
        const filledFields = Array.from(formFields).filter(field => {
            const input = field.querySelector('input, textarea, select');
            return input && input.value.trim() !== '';
        }).length;
        
        const progress = (filledFields / totalFields) * 100;
        progressBar.style.width = progress + '%';
    }
    
    // Real-time validation
    function validateField(field) {
        const input = field.querySelector('input, textarea, select');
        const errorDiv = field.querySelector('.ppdb-form-error');
        const successDiv = field.querySelector('.ppdb-form-success');
        
        if (!input) return;
        
        let isValid = true;
        let errorMessage = '';
        
        // Remove existing states
        field.classList.remove('error', 'success');
        
        // Required field validation
        if (input.hasAttribute('required') && !input.value.trim()) {
            isValid = false;
            errorMessage = 'Field ini wajib diisi';
        }
        
        // Email validation
        if (input.type === 'email' && input.value.trim()) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(input.value)) {
                isValid = false;
                errorMessage = 'Format email tidak valid';
            }
        }
        
        // Phone validation
        if (input.type === 'tel' && input.value.trim()) {
            const phoneRegex = /^08\d{8,11}$/;
            if (!phoneRegex.test(input.value.replace(/\s/g, ''))) {
                isValid = false;
                errorMessage = 'Format nomor HP tidak valid (contoh: 081234567890)';
            }
        }
        
        // NIK validation
        if (input.name === 'nik' && input.value.trim()) {
            if (input.value.length !== 16 || !/^\d{16}$/.test(input.value)) {
                isValid = false;
                errorMessage = 'NIK harus 16 digit angka';
            }
        }
        
        // NISN validation
        if (input.name === 'nisn' && input.value.trim()) {
            if (input.value.length !== 10 || !/^\d{10}$/.test(input.value)) {
                isValid = false;
                errorMessage = 'NISN harus 10 digit angka';
            }
        }
        
        // Postal code validation
        if (input.name === 'postal_code' && input.value.trim()) {
            if (input.value.length !== 5 || !/^\d{5}$/.test(input.value)) {
                isValid = false;
                errorMessage = 'Kode pos harus 5 digit angka';
            }
        }
        
        // Show validation result
        if (!isValid) {
            field.classList.add('error');
            if (errorDiv) {
                errorDiv.style.display = 'flex';
                errorDiv.querySelector('span').textContent = errorMessage;
            }
        } else if (input.value.trim()) {
            field.classList.add('success');
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
        } else {
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
        }
        
        return isValid;
    }
    
    // Add event listeners to all form fields
    formFields.forEach(field => {
        const input = field.querySelector('input, textarea, select');
        if (input) {
            input.addEventListener('blur', () => {
                validateField(field);
                updateProgress();
            });
            
            input.addEventListener('input', () => {
                // Clear error on input
                field.classList.remove('error');
                const errorDiv = field.querySelector('.ppdb-form-error');
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
                updateProgress();
            });
        }
    });
    
    // Form submission with enhanced validation
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let allValid = true;
        formFields.forEach(field => {
            if (!validateField(field)) {
                allValid = false;
            }
        });
        
        if (!allValid) {
            showNotification('error', 'Validasi Gagal', 'Mohon periksa kembali data yang diisi');
            return;
        }
        
        // Show loading state
        form.classList.add('ppdb-form-loading');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim Data...';
        }
        
        // Submit form
        form.submit();
    });
    
    // Auto-save form data to localStorage
    function saveFormData() {
        const formData = new FormData(form);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        localStorage.setItem('ppdb_form_data', JSON.stringify(data));
    }
    
    // Load saved form data
    function loadFormData() {
        const savedData = localStorage.getItem('ppdb_form_data');
        if (savedData) {
            try {
                const data = JSON.parse(savedData);
                Object.keys(data).forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input && input.type !== 'file') {
                        input.value = data[key];
                    }
                });
                updateProgress();
            } catch (e) {
                console.log('Error loading saved form data:', e);
            }
        }
    }
    
    // Auto-save on input
    form.addEventListener('input', saveFormData);
    form.addEventListener('change', saveFormData);
    
    // Load saved data on page load
    loadFormData();
    
    // Clear saved data on successful submission
    window.addEventListener('beforeunload', function() {
        if (form.checkValidity()) {
            localStorage.removeItem('ppdb_form_data');
        }
    });
    
    // Enhanced file upload with drag and drop
    const fileInputs = form.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        const container = input.closest('.ppdb-form-field');
        if (container) {
            container.classList.add('ppdb-file-upload');
            
            container.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });
            
            container.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });
            
            container.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    input.files = files;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }
    });
});

// Session Status Indicator
function showSessionStatus(status, message) {
    const statusEl = document.getElementById('session-status');
    if (statusEl) {
        statusEl.className = `session-status ${status}`;
        statusEl.innerHTML = `<i class="fas fa-circle mr-1"></i><span>${message}</span>`;
        statusEl.style.display = 'block';
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            statusEl.style.display = 'none';
        }, 3000);
    }
}

// Show initial session status
showSessionStatus('success', 'Session Aktif');
</script>

<!-- Session Status Indicator -->
<div class="session-status" id="session-status">
    <i class="fas fa-circle mr-1"></i>
    <span>Session Aktif</span>
</div>
@endsection
