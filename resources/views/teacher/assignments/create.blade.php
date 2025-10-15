@extends('teacher.layouts.app')

@section('title', 'Buat Tugas Baru')
@section('subtitle', 'Buat tugas untuk siswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Form Tugas Baru</h3>
            <p class="text-sm text-gray-600">Lengkapi informasi tugas untuk siswa</p>
        </div>
        
        <form method="POST" action="{{ route('teacher.assignments.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Class Selection -->
                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">Kelas *</label>
                    <select id="class_id" 
                            name="class_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('class_id') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Subject Selection -->
                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran *</label>
                    <select id="subject_id" 
                            name="subject_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('subject_id') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Title -->
            <div class="mt-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Tugas *</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                       placeholder="Masukkan judul tugas"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                          placeholder="Deskripsikan tugas yang akan diberikan...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Instructions -->
            <div class="mt-6">
                <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">Instruksi</label>
                <textarea id="instructions" 
                          name="instructions" 
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('instructions') border-red-500 @enderror"
                          placeholder="Berikan instruksi khusus untuk siswa...">{{ old('instructions') }}</textarea>
                @error('instructions')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Batas Waktu *</label>
                    <input type="datetime-local" 
                           id="due_date" 
                           name="due_date" 
                           value="{{ old('due_date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('due_date') border-red-500 @enderror"
                           required>
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Max Score -->
                <div>
                    <label for="max_score" class="block text-sm font-medium text-gray-700 mb-2">Nilai Maksimal</label>
                    <input type="number" 
                           id="max_score" 
                           name="max_score" 
                           value="{{ old('max_score', 100) }}"
                           min="1" 
                           max="1000"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('max_score') border-red-500 @enderror">
                    @error('max_score')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- File Upload -->
            <div class="mt-6">
                <label for="file" class="block text-sm font-medium text-gray-700 mb-2">File Tugas (Opsional)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200">
                    <div class="space-y-1 text-center">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                        <div class="flex text-sm text-gray-600">
                            <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>Upload file</span>
                                <input id="file" 
                                       name="file" 
                                       type="file" 
                                       class="sr-only"
                                       accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF, DOC, DOCX, PPT, PPTX, TXT (maks. 10MB)</p>
                    </div>
                </div>
                @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Publish Option -->
            <div class="mt-6">
                <div class="flex items-center">
                    <input id="is_published" 
                           name="is_published" 
                           type="checkbox" 
                           value="1"
                           {{ old('is_published') ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_published" class="ml-2 block text-sm text-gray-900">
                        Publikasikan tugas ini sekarang
                    </label>
                </div>
                <p class="mt-1 text-xs text-gray-500">Jika tidak dicentang, tugas akan disimpan sebagai draft</p>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('teacher.assignments.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Tugas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// File upload preview
document.getElementById('file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        
        // Update the upload area to show file info
        const uploadArea = document.querySelector('.border-dashed');
        uploadArea.innerHTML = `
            <div class="space-y-1 text-center">
                <i class="fas fa-file text-3xl text-blue-500"></i>
                <div class="text-sm text-gray-900 font-medium">${fileName}</div>
                <div class="text-xs text-gray-500">${fileSize} MB</div>
                <button type="button" onclick="clearFile()" class="text-red-600 hover:text-red-800 text-sm">
                    <i class="fas fa-times mr-1"></i>Hapus
                </button>
            </div>
        `;
    }
});

function clearFile() {
    document.getElementById('file').value = '';
    location.reload();
}

// Set minimum date to today
document.getElementById('due_date').min = new Date().toISOString().slice(0, 16);
</script>
@endsection
