@extends('teacher.layouts.app')

@section('title', 'Buat Profil Guru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Buat Profil Guru</h1>
                        <p class="mt-2 text-gray-600">Lengkapi informasi profil Anda untuk memulai mengajar</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-500">Progress</div>
                            <div class="text-2xl font-bold text-blue-600" id="progress-percentage">0%</div>
                        </div>
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-plus text-2xl text-blue-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-4">
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div id="progress-bar" class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500 ease-out" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="POST" action="{{ route('teacher.profile.store') }}" enctype="multipart/form-data" class="space-y-8" id="teacher-profile-form">
            @csrf
            
            <!-- Step 1: Personal Information -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Informasi Pribadi</h2>
                        <p class="text-gray-600">Data diri dan identitas pribadi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIP -->
                    <div class="space-y-2">
                        <label for="nip" class="block text-sm font-semibold text-gray-700">
                            NIP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="nip" 
                               name="nip" 
                               value="{{ old('nip') }}"
                               maxlength="20"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('nip') border-red-500 @enderror"
                               placeholder="Masukkan NIP Anda (maks. 20 karakter)"
                               required>
                        @error('nip')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div class="space-y-2">
                        <label for="nik" class="block text-sm font-semibold text-gray-700">
                            NIK <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="nik" 
                               name="nik" 
                               value="{{ old('nik') }}"
                               maxlength="16"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('nik') border-red-500 @enderror"
                               placeholder="Masukkan NIK Anda (maks. 16 karakter)"
                               required>
                        @error('nik')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Birth Place -->
                    <div class="space-y-2">
                        <label for="birth_place" class="block text-sm font-semibold text-gray-700">
                            Tempat Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="birth_place" 
                               name="birth_place" 
                               value="{{ old('birth_place') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('birth_place') border-red-500 @enderror"
                               placeholder="Kota tempat lahir"
                               required>
                        @error('birth_place')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Birth Date -->
                    <div class="space-y-2">
                        <label for="birth_date" class="block text-sm font-semibold text-gray-700">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="birth_date" 
                               name="birth_date" 
                               value="{{ old('birth_date') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('birth_date') border-red-500 @enderror"
                               required>
                        @error('birth_date')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" 
                                       name="gender" 
                                       value="L" 
                                       {{ old('gender') == 'L' ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" 
                                       name="gender" 
                                       value="P" 
                                       {{ old('gender') == 'P' ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Perempuan</span>
                            </label>
                        </div>
                        @error('gender')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Religion -->
                    <div class="space-y-2">
                        <label for="religion" class="block text-sm font-semibold text-gray-700">
                            Agama <span class="text-red-500">*</span>
                        </label>
                        <select id="religion" 
                                name="religion"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('religion') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                        @error('religion')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="address" class="block text-sm font-semibold text-gray-700">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('address') border-red-500 @enderror"
                                  placeholder="Masukkan alamat lengkap Anda"
                                  required>{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-semibold text-gray-700">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('phone') border-red-500 @enderror"
                               placeholder="08xxxxxxxxxx"
                               required>
                        @error('phone')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Step 2: Professional Information -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-briefcase text-green-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Informasi Profesional</h2>
                        <p class="text-gray-600">Data kepegawaian dan pendidikan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Employment Status -->
                    <div class="space-y-2">
                        <label for="employment_status" class="block text-sm font-semibold text-gray-700">
                            Status Kepegawaian <span class="text-red-500">*</span>
                        </label>
                        <select id="employment_status" 
                                name="employment_status"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('employment_status') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Status</option>
                            <option value="PNS" {{ old('employment_status') == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="CPNS" {{ old('employment_status') == 'CPNS' ? 'selected' : '' }}>CPNS</option>
                            <option value="Guru Honorer" {{ old('employment_status') == 'Guru Honorer' ? 'selected' : '' }}>Guru Honorer</option>
                            <option value="Guru Kontrak" {{ old('employment_status') == 'Guru Kontrak' ? 'selected' : '' }}>Guru Kontrak</option>
                        </select>
                        @error('employment_status')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Join Date -->
                    <div class="space-y-2">
                        <label for="join_date" class="block text-sm font-semibold text-gray-700">
                            Tanggal Bergabung <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="join_date" 
                               name="join_date" 
                               value="{{ old('join_date') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('join_date') border-red-500 @enderror"
                               required>
                        @error('join_date')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Education Level -->
                    <div class="space-y-2">
                        <label for="education_level" class="block text-sm font-semibold text-gray-700">
                            Pendidikan Terakhir <span class="text-red-500">*</span>
                        </label>
                        <select id="education_level" 
                                name="education_level"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('education_level') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Pendidikan</option>
                            <option value="SMA/SMK" {{ old('education_level') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D1" {{ old('education_level') == 'D1' ? 'selected' : '' }}>D1</option>
                            <option value="D2" {{ old('education_level') == 'D2' ? 'selected' : '' }}>D2</option>
                            <option value="D3" {{ old('education_level') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="D4" {{ old('education_level') == 'D4' ? 'selected' : '' }}>D4</option>
                            <option value="S1" {{ old('education_level') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('education_level') == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('education_level') == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                        @error('education_level')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Major -->
                    <div class="space-y-2">
                        <label for="major" class="block text-sm font-semibold text-gray-700">
                            Jurusan
                        </label>
                        <input type="text" 
                               id="major" 
                               name="major" 
                               value="{{ old('major') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('major') border-red-500 @enderror"
                               placeholder="Contoh: Pendidikan Matematika">
                        @error('major')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- University -->
                    <div class="space-y-2">
                        <label for="university" class="block text-sm font-semibold text-gray-700">
                            Universitas
                        </label>
                        <input type="text" 
                               id="university" 
                               name="university" 
                               value="{{ old('university') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('university') border-red-500 @enderror"
                               placeholder="Nama universitas">
                        @error('university')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Graduation Year -->
                    <div class="space-y-2">
                        <label for="graduation_year" class="block text-sm font-semibold text-gray-700">
                            Tahun Lulus
                        </label>
                        <input type="number" 
                               id="graduation_year" 
                               name="graduation_year" 
                               value="{{ old('graduation_year') }}"
                               min="1950" 
                               max="{{ date('Y') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('graduation_year') border-red-500 @enderror"
                               placeholder="Tahun lulus">
                        @error('graduation_year')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Step 3: Teaching Information -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-chalkboard-teacher text-purple-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Informasi Mengajar</h2>
                        <p class="text-gray-600">Mata pelajaran dan kelas yang Anda ajarkan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Subjects -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-semibold text-gray-700">
                                Mata Pelajaran yang Diajarkan <span class="text-red-500">*</span>
                            </label>
                            <button type="button" 
                                    id="select-all-subjects"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-check-square mr-1"></i>Pilih Semua
                            </button>
                        </div>
                        
                        <div class="max-h-60 overflow-y-auto border border-gray-200 rounded-xl p-4 space-y-3">
                            @php
                                $subjects = [
                                    'Matematika' => 'Matematika',
                                    'Bahasa Indonesia' => 'Bahasa Indonesia',
                                    'Bahasa Inggris' => 'Bahasa Inggris',
                                    'IPA' => 'Ilmu Pengetahuan Alam (IPA)',
                                    'IPS' => 'Ilmu Pengetahuan Sosial (IPS)',
                                    'PKN' => 'Pendidikan Kewarganegaraan (PKN)',
                                    'Agama' => 'Pendidikan Agama',
                                    'Olahraga' => 'Pendidikan Jasmani dan Olahraga',
                                    'Seni' => 'Seni dan Budaya',
                                    'TIK' => 'Teknologi Informasi dan Komunikasi (TIK)',
                                    'Bahasa Daerah' => 'Bahasa Daerah',
                                    'Prakarya' => 'Prakarya',
                                    'Bimbingan Konseling' => 'Bimbingan Konseling',
                                ];
                            @endphp
                            @foreach($subjects as $key => $subject)
                                <label class="flex items-center p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                    <input id="subject_{{ $key }}" 
                                           name="subjects[]" 
                                           type="checkbox" 
                                           value="{{ $key }}"
                                           {{ in_array($key, old('subjects', [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-700 font-medium">{{ $subject }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('subjects')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pilih minimal satu mata pelajaran yang Anda ajarkan
                        </p>
                    </div>
                    
                    <!-- Classes -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-semibold text-gray-700">
                                Kelas yang Diampu
                            </label>
                            <button type="button" 
                                    id="select-all-classes"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-check-square mr-1"></i>Pilih Semua
                            </button>
                        </div>
                        
                        <div class="max-h-60 overflow-y-auto border border-gray-200 rounded-xl p-4 space-y-3">
                            @php
                                $classes = [
                                    'VII A' => 'VII A',
                                    'VII B' => 'VII B',
                                    'VII C' => 'VII C',
                                    'VIII A' => 'VIII A',
                                    'VIII B' => 'VIII B',
                                    'VIII C' => 'VIII C',
                                    'IX A' => 'IX A',
                                    'IX B' => 'IX B',
                                    'IX C' => 'IX C',
                                ];
                            @endphp
                            @foreach($classes as $key => $class)
                                <label class="flex items-center p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                    <input id="class_{{ $key }}" 
                                           name="classes[]" 
                                           type="checkbox" 
                                           value="{{ $key }}"
                                           {{ in_array($key, old('classes', [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm text-gray-700 font-medium">{{ $class }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('classes')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pilih kelas yang Anda ampu (dapat dipilih lebih dari satu)
                        </p>
                    </div>
                </div>
            </div>

            <!-- Step 4: Photo Upload -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-camera text-pink-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Foto Profil</h2>
                        <p class="text-gray-600">Upload foto profil Anda</p>
                    </div>
                </div>

                <div class="flex items-center space-x-8">
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <img id="photo-preview" 
                                 src="{{ asset('images/default-avatar.png') }}" 
                                 alt="Preview" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 shadow-lg">
                            <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 rounded-full transition-all duration-200 flex items-center justify-center">
                                <i class="fas fa-camera text-white text-xl opacity-0 hover:opacity-100 transition-opacity duration-200"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="space-y-4">
                            <div>
                                <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Upload Foto Profil
                                </label>
                                <input type="file" 
                                       id="photo" 
                                       name="photo" 
                                       accept="image/*"
                                       class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('photo') border-red-500 @enderror">
                                @error('photo')
                                    <p class="text-sm text-red-600 flex items-center mt-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-500 mt-1 mr-2"></i>
                                    <div class="text-sm text-blue-700">
                                        <p class="font-medium">Format yang didukung:</p>
                                        <p>JPG, PNG, GIF (maksimal 2MB)</p>
                                        <p class="text-xs text-blue-600 mt-1">Rekomendasi: Foto persegi dengan resolusi minimal 300x300px</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 5: Bio -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-edit text-indigo-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Tentang Saya</h2>
                        <p class="text-gray-600">Ceritakan tentang diri dan pengalaman Anda</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <label for="bio" class="block text-sm font-semibold text-gray-700">
                        Bio
                    </label>
                    <div class="relative">
                        <textarea id="bio" 
                                  name="bio" 
                                  rows="5"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('bio') border-red-500 @enderror"
                                  placeholder="Ceritakan sedikit tentang diri Anda, pengalaman mengajar, keahlian khusus, dan motivasi dalam mengajar...">{{ old('bio') }}</textarea>
                        <div id="bio-counter" class="absolute bottom-3 right-3 text-xs text-gray-500 bg-white px-2 py-1 rounded">
                            0/1000 karakter
                        </div>
                    </div>
                    @error('bio')
                        <p class="text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Submit Section -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg p-8">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-white mb-2">Siap untuk memulai?</h3>
                    <p class="text-blue-100 mb-6">Pastikan semua informasi sudah benar sebelum menyimpan</p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('teacher.dashboard') }}" 
                           class="px-8 py-3 bg-white text-blue-600 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200 shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-white text-blue-600 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200 shadow-lg">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Profil
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('teacher-profile-form');
    const progressBar = document.getElementById('progress-bar');
    const progressPercentage = document.getElementById('progress-percentage');
    const subjectsCheckboxes = document.querySelectorAll('input[name="subjects[]"]');
    const classesCheckboxes = document.querySelectorAll('input[name="classes[]"]');
    const bioTextarea = document.getElementById('bio');
    const bioCounter = document.getElementById('bio-counter');
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo-preview');
    
    // Progress tracking
    function updateProgress() {
        const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
        let filledFields = 0;
        
        requiredFields.forEach(field => {
            if (field.type === 'checkbox' || field.type === 'radio') {
                if (field.type === 'checkbox') {
                    const name = field.name;
                    const checked = document.querySelectorAll(`input[name="${name}"]:checked`);
                    if (checked.length > 0) filledFields++;
                } else {
                    if (field.checked) filledFields++;
                }
            } else {
                if (field.value.trim() !== '') filledFields++;
            }
        });
        
        const progress = Math.round((filledFields / requiredFields.length) * 100);
        progressBar.style.width = progress + '%';
        progressPercentage.textContent = progress + '%';
        
        // Update progress bar color based on completion
        if (progress < 30) {
            progressBar.className = 'bg-red-500 h-3 rounded-full transition-all duration-500 ease-out';
        } else if (progress < 70) {
            progressBar.className = 'bg-yellow-500 h-3 rounded-full transition-all duration-500 ease-out';
        } else {
            progressBar.className = 'bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500 ease-out';
        }
    }
    
    // Add progress tracking to all form fields
    form.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('input', updateProgress);
        field.addEventListener('change', updateProgress);
    });
    
    // Subject validation
    function validateSubjects() {
        const checkedSubjects = document.querySelectorAll('input[name="subjects[]"]:checked');
        const subjectError = document.getElementById('subject-error');
        
        if (checkedSubjects.length === 0) {
            if (!subjectError) {
                const errorDiv = document.createElement('div');
                errorDiv.id = 'subject-error';
                errorDiv.className = 'text-sm text-red-600 flex items-center mt-2';
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Pilih minimal satu mata pelajaran';
                document.querySelector('input[name="subjects[]"]').closest('.space-y-4').appendChild(errorDiv);
            }
            return false;
        } else {
            if (subjectError) {
                subjectError.remove();
            }
            return true;
        }
    }
    
    // Add event listeners to subject checkboxes
    subjectsCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', validateSubjects);
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (!validateSubjects()) {
            e.preventDefault();
            showNotification('Pilih minimal satu mata pelajaran yang Anda ajarkan', 'error');
            return false;
        }
    });
    
    // Select all subjects
    document.getElementById('select-all-subjects').addEventListener('click', function() {
        subjectsCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        validateSubjects();
        updateProgress();
    });
    
    // Select all classes
    document.getElementById('select-all-classes').addEventListener('click', function() {
        classesCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateProgress();
    });
    
    // Bio character counter
    bioTextarea.addEventListener('input', function() {
        const length = this.value.length;
        bioCounter.textContent = `${length}/1000 karakter`;
        
        if (length > 1000) {
            bioCounter.className = 'absolute bottom-3 right-3 text-xs text-red-500 bg-white px-2 py-1 rounded';
        } else if (length > 800) {
            bioCounter.className = 'absolute bottom-3 right-3 text-xs text-yellow-500 bg-white px-2 py-1 rounded';
        } else {
            bioCounter.className = 'absolute bottom-3 right-3 text-xs text-gray-500 bg-white px-2 py-1 rounded';
        }
    });
    
    // Photo preview
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Auto-save draft functionality
    let autoSaveTimeout;
    form.addEventListener('input', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(function() {
            const formData = new FormData(form);
            const draftData = {};
            formData.forEach((value, key) => {
                if (key.includes('[]')) {
                    if (!draftData[key]) draftData[key] = [];
                    draftData[key].push(value);
                } else {
                    draftData[key] = value;
                }
            });
            localStorage.setItem('teacher_profile_draft', JSON.stringify(draftData));
        }, 2000);
    });
    
    // Load draft on page load
    const savedDraft = localStorage.getItem('teacher_profile_draft');
    if (savedDraft) {
        try {
            const draftData = JSON.parse(savedDraft);
            Object.keys(draftData).forEach(key => {
                const elements = form.querySelectorAll(`[name="${key}"]`);
                elements.forEach(element => {
                    if (element.type === 'checkbox' || element.type === 'radio') {
                        element.checked = draftData[key].includes(element.value);
                    } else {
                        element.value = draftData[key];
                    }
                });
            });
            updateProgress();
        } catch (e) {
            console.log('Error loading draft:', e);
        }
    }
    
    // Clear draft on successful submission
    form.addEventListener('submit', function() {
        localStorage.removeItem('teacher_profile_draft');
    });
    
    // Character counter for NIP and NIK
    const nipInput = document.getElementById('nip');
    const nikInput = document.getElementById('nik');
    
    // Create character counter elements
    const nipCounter = document.createElement('div');
    nipCounter.className = 'text-xs text-gray-500 mt-1';
    nipCounter.textContent = '0/20 karakter';
    nipInput.parentNode.appendChild(nipCounter);
    
    const nikCounter = document.createElement('div');
    nikCounter.className = 'text-xs text-gray-500 mt-1';
    nikCounter.textContent = '0/16 karakter';
    nikInput.parentNode.appendChild(nikCounter);
    
    // NIP character counter and validation
    nipInput.addEventListener('input', function() {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
        
        const length = this.value.length;
        nipCounter.textContent = `${length}/20 karakter`;
        
        if (length > 20) {
            nipCounter.className = 'text-xs text-red-500 mt-1';
            this.value = this.value.substring(0, 20);
            nipCounter.textContent = '20/20 karakter';
        } else if (length > 18) {
            nipCounter.className = 'text-xs text-yellow-500 mt-1';
        } else if (length < 8 && length > 0) {
            nipCounter.className = 'text-xs text-orange-500 mt-1';
        } else {
            nipCounter.className = 'text-xs text-gray-500 mt-1';
        }
        updateProgress();
    });
    
    // NIK character counter and validation
    nikInput.addEventListener('input', function() {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
        
        const length = this.value.length;
        nikCounter.textContent = `${length}/16 karakter`;
        
        if (length > 16) {
            nikCounter.className = 'text-xs text-red-500 mt-1';
            this.value = this.value.substring(0, 16);
            nikCounter.textContent = '16/16 karakter';
        } else if (length > 14) {
            nikCounter.className = 'text-xs text-yellow-500 mt-1';
        } else if (length < 16 && length > 0) {
            nikCounter.className = 'text-xs text-orange-500 mt-1';
        } else {
            nikCounter.className = 'text-xs text-gray-500 mt-1';
        }
        updateProgress();
    });
    
    // Initial progress check
    updateProgress();
    
    // Add smooth scrolling to form sections
    const sections = document.querySelectorAll('.bg-white.rounded-2xl');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            section.style.transition = 'all 0.6s ease-out';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection