@extends('admin.layouts.app')

@section('title', 'Pengaturan PPDB')

@section('content')
<div class="p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pengaturan PPDB</h1>
                <p class="text-gray-600">Konfigurasi pengaturan Penerimaan Peserta Didik Baru</p>
            </div>
            <div class="mt-4 lg:mt-0 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.ppdb-registrations.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <i class="fas fa-users mr-2"></i>
                    Data Pendaftar
                </a>
                <a href="{{ route('admin.ppdb-registrations.export') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    Export Data
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
        </div>
    </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
        </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

    <!-- Status Toggle -->
    <div class="bg-gradient-to-r from-primary-50 to-blue-50 rounded-xl shadow-sm border border-primary-200 p-6 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="p-3 bg-primary-100 rounded-full mr-4">
                    <i class="fas fa-toggle-on text-primary-600 text-xl"></i>
                        </div>
                        <div>
                    <h3 class="text-xl font-semibold text-gray-900">Status Pendaftaran PPDB</h3>
                    <p class="text-gray-600">Buka atau tutup pendaftaran PPDB untuk siswa baru</p>
                        </div>
                    </div>
            <div class="flex items-center">
                <span class="text-sm font-medium text-gray-700 mr-4">Status:</span>
                <form id="toggle-form" method="POST" action="{{ route('admin.ppdb-settings.toggle-status') }}" style="display: inline;">
                    @csrf
                    <input type="hidden" name="is_open" value="{{ $settings['is_open'] ? '0' : '1' }}">
                    <button type="submit" id="toggle-status" 
                            class="relative inline-flex h-8 w-14 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 {{ $settings['is_open'] ? 'bg-primary-600' : 'bg-gray-300' }}">
                        <span class="inline-block h-6 w-6 transform rounded-full bg-white transition-transform shadow-lg {{ $settings['is_open'] ? 'translate-x-7' : 'translate-x-1' }}"></span>
                            </button>
                </form>
                <span class="ml-4 text-lg font-semibold {{ $settings['is_open'] ? 'text-green-600' : 'text-red-600' }}">
                    {{ $settings['is_open'] ? 'Terbuka' : 'Tertutup' }}
                </span>
            </div>
                        </div>
                    </div>

    <!-- Settings Form -->
    <form method="POST" action="{{ route('admin.ppdb-settings.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="flex items-center mb-6">
                <div class="p-3 bg-primary-100 rounded-full mr-4">
                    <i class="fas fa-cog text-primary-600 text-xl"></i>
                            </div>
                            <div>
                    <h3 class="text-xl font-semibold text-gray-900">Pengaturan Dasar</h3>
                    <p class="text-gray-600">Konfigurasi periode dan kuota pendaftaran</p>
                        </div>
                    </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-calendar-alt text-primary-600 mr-2"></i>
                        Tanggal Mulai Pendaftaran <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="registration_period_start" 
                           value="{{ old('registration_period_start', $settings['registration_period_start']) }}"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                           required>
                    </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-calendar-check text-primary-600 mr-2"></i>
                        Tanggal Akhir Pendaftaran <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="registration_period_end" 
                           value="{{ old('registration_period_end', $settings['registration_period_end']) }}"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                           required>
                    </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-users text-primary-600 mr-2"></i>
                        Kuota Siswa <span class="text-red-500">*</span>
                            </label>
                    <input type="number" name="quota" 
                           value="{{ old('quota', $settings['quota']) }}"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                           required min="1" placeholder="Masukkan kuota siswa">
                    </div>

                        </div>
                    </div>

        <!-- Content Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="flex items-center mb-6">
                <div class="p-3 bg-primary-100 rounded-full mr-4">
                    <i class="fas fa-edit text-primary-600 text-xl"></i>
                        </div>
                        <div>
                    <h3 class="text-xl font-semibold text-gray-900">Konten & Informasi</h3>
                    <p class="text-gray-600">Atur deskripsi, persyaratan, dan informasi kontak</p>
                        </div>
                    </div>

            <div class="space-y-6">
                            <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left text-primary-600 mr-2"></i>
                        Deskripsi PPDB <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" rows="4" 
                              class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                              placeholder="Masukkan deskripsi PPDB...">{{ old('description', $settings['description']) }}</textarea>
                            </div>

                            <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-list-check text-primary-600 mr-2"></i>
                        Persyaratan Pendaftaran <span class="text-red-500">*</span>
                    </label>
                    <textarea name="requirements" rows="6" 
                              class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                              placeholder="Masukkan persyaratan pendaftaran (satu per baris)...">{{ old('requirements', $settings['requirements']) }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Gunakan bullet point (•) untuk setiap persyaratan</p>
                            </div>
                        </div>
                    </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="flex items-center mb-6">
                <div class="p-3 bg-primary-100 rounded-full mr-4">
                    <i class="fas fa-phone text-primary-600 text-xl"></i>
                            </div>
                            <div>
                    <h3 class="text-xl font-semibold text-gray-900">Informasi Kontak</h3>
                    <p class="text-gray-600">Kontak untuk informasi PPDB</p>
                        </div>
                    </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-phone text-primary-600 mr-2"></i>
                        Nomor Telepon
                    </label>
                    <input type="tel" name="contact_phone" 
                           value="{{ old('contact_phone', $settings['contact_phone']) }}"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                           placeholder="Contoh: (021) 1234-5678">
                    </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-envelope text-primary-600 mr-2"></i>
                        Email Kontak
                    </label>
                    <input type="email" name="contact_email" 
                           value="{{ old('contact_email', $settings['contact_email']) }}"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                           placeholder="Contoh: ppdb@smpn01namrole.sch.id">
            </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fab fa-whatsapp text-primary-600 mr-2"></i>
                        WhatsApp
                    </label>
                    <input type="tel" name="contact_whatsapp" 
                           value="{{ old('contact_whatsapp', $settings['contact_whatsapp']) }}"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                           placeholder="Contoh: 0812-3456-7890">
                    </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-map-marker-alt text-primary-600 mr-2"></i>
                        Alamat
                    </label>
                    <input type="text" name="contact_address" 
                           value="{{ old('contact_address', $settings['contact_address']) }}"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                           placeholder="Contoh: Jl. Pendidikan No. 1, Namrole">
                    </div>
                </div>
            </div>

        <!-- Hero Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="flex items-center mb-6">
                <div class="p-3 bg-primary-100 rounded-full mr-4">
                    <i class="fas fa-image text-primary-600 text-xl"></i>
        </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Hero Section</h3>
                    <p class="text-gray-600">Atur tampilan utama halaman PPDB</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-heading text-primary-600 mr-2"></i>
                            Judul Utama
                        </label>
                        <input type="text" name="hero_title" 
                               value="{{ old('hero_title', $settings['hero_title']) }}"
                               class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                               placeholder="Contoh: PPDB 2025">
                        </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-subscript text-primary-600 mr-2"></i>
                            Sub Judul
                        </label>
                        <input type="text" name="hero_subtitle" 
                               value="{{ old('hero_subtitle', $settings['hero_subtitle']) }}"
                               class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                               placeholder="Contoh: Penerimaan Peserta Didik Baru">
                        </div>
                    </div>

                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-center text-primary-600 mr-2"></i>
                        Deskripsi Hero
                    </label>
                    <textarea name="hero_description" rows="3" 
                              class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                              placeholder="Masukkan deskripsi untuk hero section...">{{ old('hero_description', $settings['hero_description']) }}</textarea>
                    </div>

                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-image text-primary-600 mr-2"></i>
                        Banner Image
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="banner_image" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Upload banner</span>
                                    <input id="banner_image" name="banner_image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                        </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 10MB</p>
                        </div>
                    </div>
                    @if($settings['banner_image'])
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Banner saat ini:</p>
                            <img src="{{ Storage::url($settings['banner_image']) }}" alt="Current Banner" class="h-32 w-full object-cover rounded-lg">
            </div>
            @endif
        </div>
    </div>
</div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4">
            <button type="button" onclick="window.location.reload()" 
                    class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-undo mr-2"></i>
                Reset
            </button>
            <button type="submit" 
                    class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium">
                <i class="fas fa-save mr-2"></i>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

<script>

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const startDate = new Date(document.querySelector('input[name="registration_period_start"]').value);
    const endDate = new Date(document.querySelector('input[name="registration_period_end"]').value);
    
    if (startDate >= endDate) {
        e.preventDefault();
        alert('Tanggal akhir harus lebih besar dari tanggal mulai');
        return false;
    }
    
    const quota = parseInt(document.querySelector('input[name="quota"]').value);
    if (quota <= 0) {
        e.preventDefault();
        alert('Kuota harus lebih besar dari 0');
        return false;
    }
});

// File upload preview
document.getElementById('banner_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('div');
            preview.className = 'mt-4';
            preview.innerHTML = `
                <p class="text-sm text-gray-600 mb-2">Preview:</p>
                <img src="${e.target.result}" alt="Preview" class="h-32 w-full object-cover rounded-lg">
            `;
            e.target.parentNode.parentNode.appendChild(preview);
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection