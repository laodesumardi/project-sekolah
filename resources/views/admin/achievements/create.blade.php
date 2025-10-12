@extends('admin.layouts.app')

@section('page-title', 'Tambah Prestasi')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Prestasi</h1>
            <p class="text-gray-600">Tambahkan prestasi baru ke sistem</p>
        </div>
        <a href="{{ route('admin.achievements.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('admin.achievements.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul Prestasi -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Prestasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('title') border-red-500 @enderror"
                           placeholder="Masukkan judul prestasi"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="category" 
                            name="category" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('category') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tingkat Prestasi -->
                <div>
                    <label for="achievement_level" class="block text-sm font-medium text-gray-700 mb-2">
                        Tingkat Prestasi <span class="text-red-500">*</span>
                    </label>
                    <select id="achievement_level" 
                            name="achievement_level" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('achievement_level') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Tingkat</option>
                        @foreach($levels as $level)
                            <option value="{{ $level }}" {{ old('achievement_level') === $level ? 'selected' : '' }}>{{ $level }}</option>
                        @endforeach
                    </select>
                    @error('achievement_level')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Peringkat -->
                <div>
                    <label for="rank" class="block text-sm font-medium text-gray-700 mb-2">
                        Peringkat <span class="text-red-500">*</span>
                    </label>
                    <select id="rank" 
                            name="rank" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('rank') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Peringkat</option>
                        @foreach($ranks as $rank)
                            <option value="{{ $rank }}" {{ old('rank') === $rank ? 'selected' : '' }}>{{ $rank }}</option>
                        @endforeach
                    </select>
                    @error('rank')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipe Peserta -->
                <div>
                    <label for="participant_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe Peserta <span class="text-red-500">*</span>
                    </label>
                    <select id="participant_type" 
                            name="participant_type" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('participant_type') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Tipe Peserta</option>
                        <option value="individual" {{ old('participant_type') === 'individual' ? 'selected' : '' }}>Individu</option>
                        <option value="team" {{ old('participant_type') === 'team' ? 'selected' : '' }}>Tim</option>
                    </select>
                    @error('participant_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Peserta -->
                <div class="md:col-span-2">
                    <label for="participant_names" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Peserta <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="participant_names" 
                           name="participant_names" 
                           value="{{ old('participant_names') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('participant_names') border-red-500 @enderror"
                           placeholder="Masukkan nama peserta (pisahkan dengan koma jika lebih dari satu)"
                           required>
                    @error('participant_names')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="date" 
                           name="date" 
                           value="{{ old('date') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('date') border-red-500 @enderror"
                           required>
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lomba -->
                <div>
                    <label for="competition_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lomba/Kompetisi
                    </label>
                    <input type="text" 
                           id="competition_name" 
                           name="competition_name" 
                           value="{{ old('competition_name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('competition_name') border-red-500 @enderror"
                           placeholder="Masukkan nama lomba/kompetisi">
                    @error('competition_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penyelenggara -->
                <div>
                    <label for="organizer" class="block text-sm font-medium text-gray-700 mb-2">
                        Penyelenggara
                    </label>
                    <input type="text" 
                           id="organizer" 
                           name="organizer" 
                           value="{{ old('organizer') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('organizer') border-red-500 @enderror"
                           placeholder="Masukkan nama penyelenggara">
                    @error('organizer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Unggulan -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_featured" 
                               value="1" 
                               {{ old('is_featured') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700">Jadikan Unggulan</span>
                    </label>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Masukkan deskripsi prestasi">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Sertifikat -->
                <div class="md:col-span-2">
                    <label for="certificate_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Sertifikat/Foto
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="certificate_image" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Upload file</span>
                                    <input id="certificate_image" 
                                           name="certificate_image" 
                                           type="file" 
                                           accept="image/*"
                                           class="sr-only"
                                           onchange="previewCertificate(this)">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                        </div>
                    </div>
                    @error('certificate_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 mt-6">
                <a href="{{ route('admin.achievements.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                    Simpan Prestasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewCertificate(input) {
    const file = input.files[0];
    if (file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        
        // Update the upload area to show file info
        const uploadArea = input.closest('.border-dashed');
        uploadArea.innerHTML = `
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-900">${fileName}</p>
                <p class="text-xs text-gray-500">${fileSize} MB</p>
                <button type="button" onclick="resetCertificateInput(this)" class="mt-2 text-sm text-red-600 hover:text-red-500">
                    Hapus file
                </button>
            </div>
        `;
    }
}

function resetCertificateInput(button) {
    const input = document.getElementById('certificate_image');
    input.value = '';
    
    // Reset upload area
    const uploadArea = input.closest('.border-dashed');
    uploadArea.innerHTML = `
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-gray-600">
                <label for="certificate_image" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                    <span>Upload file</span>
                    <input id="certificate_image" name="certificate_image" type="file" accept="image/*" class="sr-only" onchange="previewCertificate(this)">
                </label>
                <p class="pl-1">atau drag and drop</p>
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
        </div>
    `;
}
</script>
@endsection

