@extends('admin.layouts.app')

@section('page-title', 'Tambah Mata Pelajaran')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Mata Pelajaran</h1>
            <p class="text-gray-600">Tambahkan mata pelajaran baru ke sistem</p>
        </div>
        <a href="{{ route('admin.subjects.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('admin.subjects.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Mata Pelajaran -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Mata Pelajaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama mata pelajaran"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kode Mata Pelajaran -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Mata Pelajaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="code" 
                           name="code" 
                           value="{{ old('code') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('code') border-red-500 @enderror"
                           placeholder="Contoh: MAT-10"
                           required>
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tingkat Kelas -->
                <div>
                    <label for="grade_level" class="block text-sm font-medium text-gray-700 mb-2">
                        Tingkat Kelas <span class="text-red-500">*</span>
                    </label>
                    <select id="grade_level" 
                            name="grade_level" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('grade_level') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Tingkat Kelas</option>
                        <option value="10" {{ old('grade_level') === '10' ? 'selected' : '' }}>Kelas 10</option>
                        <option value="11" {{ old('grade_level') === '11' ? 'selected' : '' }}>Kelas 11</option>
                        <option value="12" {{ old('grade_level') === '12' ? 'selected' : '' }}>Kelas 12</option>
                        <option value="all" {{ old('grade_level') === 'all' ? 'selected' : '' }}>Semua Tingkat</option>
                    </select>
                    @error('grade_level')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Per Minggu -->
                <div>
                    <label for="hours_per_week" class="block text-sm font-medium text-gray-700 mb-2">
                        Jam Per Minggu <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="hours_per_week" 
                           name="hours_per_week" 
                           value="{{ old('hours_per_week') }}"
                           min="1" 
                           max="10"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('hours_per_week') border-red-500 @enderror"
                           placeholder="Contoh: 4"
                           required>
                    @error('hours_per_week')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
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
                              placeholder="Masukkan deskripsi mata pelajaran">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Silabus -->
                <div class="md:col-span-2">
                    <label for="syllabus_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Silabus (PDF)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="syllabus_file" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Upload file</span>
                                    <input id="syllabus_file" 
                                           name="syllabus_file" 
                                           type="file" 
                                           accept=".pdf"
                                           class="sr-only"
                                           onchange="previewFile(this)">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF hingga 5MB</p>
                        </div>
                    </div>
                    @error('syllabus_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 mt-6">
                <a href="{{ route('admin.subjects.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                    Simpan Mata Pelajaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewFile(input) {
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
                <button type="button" onclick="resetFileInput(this)" class="mt-2 text-sm text-red-600 hover:text-red-500">
                    Hapus file
                </button>
            </div>
        `;
    }
}

function resetFileInput(button) {
    const input = document.getElementById('syllabus_file');
    input.value = '';
    
    // Reset upload area
    const uploadArea = input.closest('.border-dashed');
    uploadArea.innerHTML = `
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-gray-600">
                <label for="syllabus_file" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                    <span>Upload file</span>
                    <input id="syllabus_file" name="syllabus_file" type="file" accept=".pdf" class="sr-only" onchange="previewFile(this)">
                </label>
                <p class="pl-1">atau drag and drop</p>
            </div>
            <p class="text-xs text-gray-500">PDF hingga 5MB</p>
        </div>
    `;
}
</script>
@endsection

