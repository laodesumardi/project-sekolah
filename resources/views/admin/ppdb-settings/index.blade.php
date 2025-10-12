@extends('admin.layouts.app')

@section('title', 'Pengaturan PPDB')

@section('content')
<div class="p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Pengaturan PPDB</h1>
                <p class="text-gray-600 mt-1">Konfigurasi pengaturan Penerimaan Peserta Didik Baru</p>
            </div>
            <div class="mt-4 lg:mt-0">
                <a href="{{ route('admin.ppdb.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Pendaftar
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
        <div class="flex items-center mb-2">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            Terjadi kesalahan:
        </div>
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- PPDB Settings Form -->
            <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfigurasi PPDB</h3>
                
                <form method="POST" action="{{ route('admin.ppdb-settings.store') }}">
                    @csrf
                    
                    <!-- Academic Year -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Akademik</label>
                        <select name="academic_year_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Tahun Akademik</option>
                            @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ ($setting && $setting->academic_year_id == $year->id) ? 'selected' : '' }}>
                                {{ $year->name }} ({{ $year->start_date->format('Y') }} - {{ $year->end_date->format('Y') }})
                            </option>
                            @endforeach
                        </select>
                        @if(!$currentYear)
                        <p class="text-sm text-red-600 mt-1">⚠️ Tidak ada tahun akademik aktif. Silakan aktifkan tahun akademik terlebih dahulu.</p>
                        @endif
                    </div>

                    <!-- Registration Period -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai Pendaftaran</label>
                            <input type="date" name="start_date" 
                                   value="{{ $setting && $setting->start_date ? $setting->start_date->format('Y-m-d') : now()->format('Y-m-d') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai Pendaftaran</label>
                            <input type="date" name="end_date" 
                                   value="{{ $setting && $setting->end_date ? $setting->end_date->format('Y-m-d') : now()->addDays(30)->format('Y-m-d') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Quick Date Buttons -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pengaturan Cepat Tanggal</label>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" onclick="setToday()" 
                                    class="px-3 py-1 bg-green-500 text-white rounded text-sm hover:bg-green-600 transition-colors">
                                Mulai Hari Ini
                            </button>
                            <button type="button" onclick="setTomorrow()" 
                                    class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 transition-colors">
                                Mulai Besok
                            </button>
                            <button type="button" onclick="setNextWeek()" 
                                    class="px-3 py-1 bg-purple-500 text-white rounded text-sm hover:bg-purple-600 transition-colors">
                                Mulai Minggu Depan
                            </button>
                            <button type="button" onclick="setNextMonth()" 
                                    class="px-3 py-1 bg-orange-500 text-white rounded text-sm hover:bg-orange-600 transition-colors">
                                Mulai Bulan Depan
                            </button>
                        </div>
                    </div>

                    <!-- Quota Settings -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Kuota Pendaftaran</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jalur Reguler</label>
                                <input type="number" name="quota_regular" 
                                       value="{{ $setting ? $setting->quota_regular : '' }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jalur Prestasi</label>
                                <input type="number" name="quota_achievement" 
                                       value="{{ $setting ? $setting->quota_achievement : '' }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jalur Afirmasi</label>
                                <input type="number" name="quota_affirmation" 
                                       value="{{ $setting ? $setting->quota_affirmation : '' }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Registration Fee -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Biaya Pendaftaran (Rp)</label>
                        <input type="number" name="registration_fee" step="0.01" min="0"
                               value="{{ $setting ? $setting->registration_fee : '' }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Announcement Date -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengumuman</label>
                        <input type="date" name="announcement_date" 
                               value="{{ $setting && $setting->announcement_date ? $setting->announcement_date->format('Y-m-d') : '' }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Status Toggle -->
                    <div class="mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                   {{ ($setting && $setting->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Aktifkan PPDB
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Centang untuk mengaktifkan pendaftaran PPDB</p>
                        @if(!$setting)
                        <p class="text-sm text-yellow-600 mt-2">💡 Status akan tersedia setelah pengaturan disimpan.</p>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi PPDB</label>
                        <textarea name="information" id="information" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Masukkan deskripsi atau informasi tambahan..." 
                                  maxlength="2000" 
                                  oninput="updateCharCount()">{{ $setting ? $setting->information : '' }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-xs text-gray-500">Maksimal 2000 karakter</span>
                            <span id="charCount" class="text-xs text-gray-500">0/2000</span>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="resetForm()" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            Reset
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quick Registration Form (Only when registration is open) -->
            @if($setting && $setting->isRegistrationOpen())
            <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Formulir Pendaftaran Cepat</h3>
                <p class="text-sm text-gray-600 mb-6">Formulir pendaftaran langsung untuk admin. Data akan tersimpan sesuai dengan pengaturan tanggal yang telah ditentukan.</p>
                
                <form id="quickRegistrationForm" method="POST" action="{{ route('admin.ppdb.quick-register') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Registration Path Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jalur Pendaftaran *</label>
                        <select name="registration_path" id="registration_path" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Pilih Jalur Pendaftaran</option>
                            <option value="regular">Reguler</option>
                            <option value="achievement">Prestasi</option>
                            <option value="affirmation">Afirmasi</option>
                        </select>
                    </div>

                    <!-- Student Data -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap Siswa *</label>
                            <input type="text" name="full_name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NIK *</label>
                            <input type="text" name="nik" required maxlength="16"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NISN *</label>
                            <input type="text" name="nisn" required maxlength="10"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                            <input type="text" name="birth_place" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                            <input type="date" name="birth_date" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                            <select name="gender" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Parent Data -->
                    <div class="mb-6">
                        <h4 class="text-md font-semibold text-gray-900 mb-4">Data Orang Tua/Wali</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ayah *</label>
                                <input type="text" name="father_name" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu *</label>
                                <input type="text" name="mother_name" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ayah</label>
                                <input type="text" name="father_occupation"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ibu</label>
                                <input type="text" name="mother_occupation"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No. HP Orang Tua *</label>
                                <input type="text" name="parent_phone" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                                <textarea name="address" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Achievement Data (for achievement path) -->
                    <div id="achievementSection" class="mb-6" style="display: none;">
                        <h4 class="text-md font-semibold text-gray-900 mb-4">Data Prestasi</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Prestasi</label>
                                <input type="text" name="achievement_name"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Prestasi</label>
                                <select name="achievement_level"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option value="">Pilih Tingkat</option>
                                    <option value="sekolah">Sekolah</option>
                                    <option value="kecamatan">Kecamatan</option>
                                    <option value="kabupaten">Kabupaten</option>
                                    <option value="provinsi">Provinsi</option>
                                    <option value="nasional">Nasional</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Prestasi</label>
                                <input type="number" name="achievement_year" min="2010" max="2025"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Peringkat</label>
                                <input type="text" name="achievement_rank"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="resetQuickForm()" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            Reset Form
                        </button>
                        <button type="submit" 
                                class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            Daftarkan Siswa
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- Current Statistics -->
            @if($setting)
            <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Pendaftaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $statistics['total_registrations'] }}</div>
                        <div class="text-sm text-gray-600">Total Pendaftar</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $statistics['accepted_count'] }}</div>
                        <div class="text-sm text-gray-600">Diterima</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">{{ $statistics['pending_count'] }}</div>
                        <div class="text-sm text-gray-600">Menunggu</div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-2">
                    <button onclick="togglePPDBStatus()" 
                            class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        Toggle Status PPDB
                    </button>
                    <a href="{{ route('admin.ppdb.export') }}" 
                       class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Data
                    </a>
                    <button onclick="sendAnnouncement()" 
                            class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Kirim Pengumuman
                    </button>
                </div>
            </div>

            <!-- Quota Progress -->
            @if($setting)
            <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Progress Kuota</h3>
                <div class="space-y-4">
                    <!-- Regular Path -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Reguler</span>
                            <span class="text-sm text-gray-500">{{ $statistics['regular_count'] }} / {{ $setting->quota_regular }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ $setting->quota_regular > 0 ? ($statistics['regular_count'] / $setting->quota_regular) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Achievement Path -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Prestasi</span>
                            <span class="text-sm text-gray-500">{{ $statistics['achievement_count'] }} / {{ $setting->quota_achievement }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ $setting->quota_achievement > 0 ? ($statistics['achievement_count'] / $setting->quota_achievement) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Affirmation Path -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Afirmasi</span>
                            <span class="text-sm text-gray-500">{{ $statistics['affirmation_count'] }} / {{ $setting->quota_affirmation }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ $setting->quota_affirmation > 0 ? ($statistics['affirmation_count'] / $setting->quota_affirmation) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form?')) {
        document.querySelector('form').reset();
    }
}

function togglePPDBStatus() {
    @if(!$setting)
    alert('Silakan simpan pengaturan PPDB terlebih dahulu sebelum mengubah status.');
    return;
    @endif
    
    if (confirm('Apakah Anda yakin ingin mengubah status PPDB?')) {
        fetch('{{ route("admin.ppdb-settings.toggle-status") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status PPDB berhasil diubah!');
                location.reload();
            } else {
                alert('Gagal mengubah status PPDB: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah status PPDB');
        });
    }
}

function sendAnnouncement() {
    alert('Fitur kirim pengumuman akan segera tersedia.');
}

function updateCharCount() {
    const textarea = document.getElementById('information');
    const charCount = document.getElementById('charCount');
    const currentLength = textarea.value.length;
    const maxLength = 2000;
    
    charCount.textContent = `${currentLength}/${maxLength}`;
    
    if (currentLength > maxLength * 0.9) {
        charCount.classList.add('text-red-500');
        charCount.classList.remove('text-gray-500');
    } else {
        charCount.classList.add('text-gray-500');
        charCount.classList.remove('text-red-500');
    }
}

// Initialize character count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCharCount();
    
    // Handle registration path change
    const registrationPath = document.getElementById('registration_path');
    const achievementSection = document.getElementById('achievementSection');
    
    if (registrationPath && achievementSection) {
        registrationPath.addEventListener('change', function() {
            if (this.value === 'achievement') {
                achievementSection.style.display = 'block';
            } else {
                achievementSection.style.display = 'none';
            }
        });
    }
});

function resetQuickForm() {
    if (confirm('Apakah Anda yakin ingin mereset form pendaftaran?')) {
        document.getElementById('quickRegistrationForm').reset();
        document.getElementById('achievementSection').style.display = 'none';
    }
}

// Quick date setting functions
function setToday() {
    const today = new Date().toISOString().split('T')[0];
    const endDate = new Date();
    endDate.setDate(endDate.getDate() + 30);
    const endDateStr = endDate.toISOString().split('T')[0];
    
    document.querySelector('input[name="start_date"]').value = today;
    document.querySelector('input[name="end_date"]').value = endDateStr;
    document.querySelector('input[name="announcement_date"]').value = new Date(endDate.getTime() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
}

function setTomorrow() {
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowStr = tomorrow.toISOString().split('T')[0];
    
    const endDate = new Date(tomorrow);
    endDate.setDate(endDate.getDate() + 30);
    const endDateStr = endDate.toISOString().split('T')[0];
    
    document.querySelector('input[name="start_date"]').value = tomorrowStr;
    document.querySelector('input[name="end_date"]').value = endDateStr;
    document.querySelector('input[name="announcement_date"]').value = new Date(endDate.getTime() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
}

function setNextWeek() {
    const nextWeek = new Date();
    nextWeek.setDate(nextWeek.getDate() + 7);
    const nextWeekStr = nextWeek.toISOString().split('T')[0];
    
    const endDate = new Date(nextWeek);
    endDate.setDate(endDate.getDate() + 30);
    const endDateStr = endDate.toISOString().split('T')[0];
    
    document.querySelector('input[name="start_date"]').value = nextWeekStr;
    document.querySelector('input[name="end_date"]').value = endDateStr;
    document.querySelector('input[name="announcement_date"]').value = new Date(endDate.getTime() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
}

function setNextMonth() {
    const nextMonth = new Date();
    nextMonth.setMonth(nextMonth.getMonth() + 1);
    const nextMonthStr = nextMonth.toISOString().split('T')[0];
    
    const endDate = new Date(nextMonth);
    endDate.setDate(endDate.getDate() + 30);
    const endDateStr = endDate.toISOString().split('T')[0];
    
    document.querySelector('input[name="start_date"]').value = nextMonthStr;
    document.querySelector('input[name="end_date"]').value = endDateStr;
    document.querySelector('input[name="announcement_date"]').value = new Date(endDate.getTime() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
}
</script>
@endpush
