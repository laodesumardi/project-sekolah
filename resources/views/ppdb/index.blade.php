@extends('layouts.app')

@section('title', 'PPDB 2025 - SMP Negeri 01 Namrole')

@section('content')
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
            <a href="{{ route('ppdb.status') }}" 
               class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 backdrop-blur-sm border border-white border-opacity-30">
                <i class="fas fa-search mr-2"></i>
                Cek Status Pendaftaran
            </a>
            <a href="#form" 
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
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
                <h2 class="text-2xl font-bold text-white mb-2">Formulir Pendaftaran PPDB 2025</h2>
                <p class="text-primary-100">Isi data dengan lengkap dan benar sesuai dokumen resmi</p>
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

                <form id="form" method="POST" action="{{ route('ppdb.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Data Pribadi -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user text-blue-600 mr-2"></i>
                            Data Pribadi
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Masukkan nama lengkap sesuai KTP/Akta" required>
        </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="contoh@email.com" required>
                </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor HP/WhatsApp <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="08xxxxxxxxxx" required>
        </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    NIK (Nomor Induk Kependudukan)
                                </label>
                                <input type="text" name="nik" value="{{ old('nik') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="16 digit NIK KTP" maxlength="16">
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
                        
                        <a href="{{ route('ppdb.status') }}" 
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
                <a href="{{ route('ppdb.status') }}" 
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
</script>
@endsection
