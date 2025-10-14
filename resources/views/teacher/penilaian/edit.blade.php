@extends('teacher.layouts.app')

@section('title', 'Edit Penilaian')
@section('description', 'Edit penilaian yang sudah ada')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('teacher.penilaian.index') }}" 
                           class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Penilaian
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mt-2">Edit Penilaian</h1>
                    <p class="mt-2 text-gray-600">{{ $grade->title }} - {{ $grade->class }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form id="gradeForm" action="{{ route('teacher.penilaian.update', $grade->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Penilaian</h2>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="class_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                            <select id="class_id" name="class_id" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $class->name === $grade->class ? 'selected' : '' }}>
                                    {{ $class->name }} - {{ $class->subject }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                            <select id="subject_id" name="subject_id" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $subject->name === $grade->subject ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select id="category" name="category" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @foreach($categories as $key => $category)
                                <option value="{{ $key }}" {{ $key === $grade->category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="max_score" class="block text-sm font-medium text-gray-700">Nilai Maksimal</label>
                            <input type="number" id="max_score" name="max_score" required min="1" 
                                   value="{{ $grade->max_score }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Penilaian</label>
                        <input type="text" id="title" name="title" required 
                               value="{{ $grade->title }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea id="description" name="description" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ $grade->description }}</textarea>
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Tanggal Penilaian</label>
                        <input type="date" id="date" name="date" required 
                               value="{{ $grade->date }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Students Section -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Nilai Siswa</h3>
                    <p class="mt-1 text-sm text-gray-500">Edit nilai untuk setiap siswa</p>
                </div>

                <div class="px-6 pb-6">
                    <div class="space-y-4">
                        @foreach($grade->students as $student)
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700">{{ substr($student->name, 0, 2) }}</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                <div class="text-sm text-gray-500">ID: {{ $student->id }}</div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <label class="block text-xs text-gray-500">Nilai</label>
                                    <input type="number" name="students[{{ $student->id }}][score]" 
                                           value="{{ $student->score }}"
                                           class="w-20 px-2 py-1 border border-gray-300 rounded text-sm focus:ring-blue-500 focus:border-blue-500" 
                                           min="0" step="0.1">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500">Catatan</label>
                                    <input type="text" name="students[{{ $student->id }}][note]" 
                                           value="{{ $student->note }}"
                                           class="w-32 px-2 py-1 border border-gray-300 rounded text-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <input type="hidden" name="students[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-between">
                    <div class="flex space-x-3">
                        <button type="button" onclick="deleteGrade()" 
                                class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Penilaian
                        </button>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('teacher.penilaian.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission
    document.getElementById('gradeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.innerHTML;
        
        // Show loading state
        button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyimpan...';
        button.disabled = true;
        
        // Submit form
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Penilaian berhasil diperbarui!');
                window.location.href = data.redirect;
            } else {
                alert('Gagal memperbarui penilaian: ' + (data.message || 'Terjadi kesalahan'));
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui penilaian');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    });
});

function deleteGrade() {
    if (confirm('Apakah Anda yakin ingin menghapus penilaian ini? Tindakan ini tidak dapat dibatalkan.')) {
        fetch('{{ route("teacher.penilaian.destroy", $grade->id) }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Penilaian berhasil dihapus!');
                window.location.href = '{{ route("teacher.penilaian.index") }}';
            } else {
                alert('Gagal menghapus penilaian: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus penilaian');
        });
    }
}
</script>
@endsection

