@extends('teacher.layouts.app')

@section('title', 'Tambah Penilaian')
@section('description', 'Tambah penilaian baru untuk siswa')

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
                    <h1 class="text-3xl font-bold text-gray-900 mt-2">Tambah Penilaian</h1>
                    <p class="mt-2 text-gray-600">Buat penilaian baru untuk siswa</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form id="gradeForm" action="{{ route('teacher.penilaian.store') }}" method="POST">
                @csrf
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
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }} - {{ $class->subject }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                            <select id="subject_id" name="subject_id" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select id="category" name="category" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $key => $category)
                                <option value="{{ $key }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="max_score" class="block text-sm font-medium text-gray-700">Nilai Maksimal</label>
                            <input type="number" id="max_score" name="max_score" required min="1" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="100">
                        </div>
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Penilaian</label>
                        <input type="text" id="title" name="title" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Contoh: Ujian Tengah Semester">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                        <textarea id="description" name="description" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                  placeholder="Deskripsi penilaian..."></textarea>
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Tanggal Penilaian</label>
                        <input type="date" id="date" name="date" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Students Section -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Nilai Siswa</h3>
                    <p class="mt-1 text-sm text-gray-500">Masukkan nilai untuk setiap siswa</p>
                </div>

                <div class="px-6 pb-6">
                    <div id="students-container">
                        <!-- Students will be loaded here via AJAX -->
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Pilih Kelas Terlebih Dahulu</h3>
                            <p class="mt-1 text-sm text-gray-500">Pilih kelas untuk melihat daftar siswa</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end space-x-3">
                    <a href="{{ route('teacher.penilaian.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('class_id');
    const studentsContainer = document.getElementById('students-container');
    
    // Load students when class is selected
    classSelect.addEventListener('change', function() {
        const classId = this.value;
        if (classId) {
            loadStudents(classId);
        } else {
            studentsContainer.innerHTML = `
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Pilih Kelas Terlebih Dahulu</h3>
                    <p class="mt-1 text-sm text-gray-500">Pilih kelas untuk melihat daftar siswa</p>
                </div>
            `;
        }
    });
    
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
                alert('Penilaian berhasil disimpan!');
                window.location.href = data.redirect;
            } else {
                alert('Gagal menyimpan penilaian: ' + (data.message || 'Terjadi kesalahan'));
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan penilaian');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    });
});

function loadStudents(classId) {
    // Placeholder students data
    const students = [
        { id: 1, name: 'Ahmad Rizki', nis: '2024001' },
        { id: 2, name: 'Siti Nurhaliza', nis: '2024002' },
        { id: 3, name: 'Budi Santoso', nis: '2024003' },
        { id: 4, name: 'Maria Santos', nis: '2024004' },
        { id: 5, name: 'John Doe', nis: '2024005' }
    ];
    
    let html = '<div class="space-y-4">';
    students.forEach(student => {
        html += `
            <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <span class="text-sm font-medium text-gray-700">${student.name.substring(0, 2)}</span>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-medium text-gray-900">${student.name}</div>
                    <div class="text-sm text-gray-500">NIS: ${student.nis}</div>
                </div>
                <div class="flex items-center space-x-3">
                    <div>
                        <label class="block text-xs text-gray-500">Nilai</label>
                        <input type="number" name="students[${student.id}][score]" 
                               class="w-20 px-2 py-1 border border-gray-300 rounded text-sm focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="0" min="0" step="0.1">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500">Catatan</label>
                        <input type="text" name="students[${student.id}][note]" 
                               class="w-32 px-2 py-1 border border-gray-300 rounded text-sm focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Opsional">
                    </div>
                    <input type="hidden" name="students[${student.id}][student_id]" value="${student.id}">
                </div>
            </div>
        `;
    });
    html += '</div>';
    
    document.getElementById('students-container').innerHTML = html;
}

// Set today's date as default
document.getElementById('date').value = new Date().toISOString().split('T')[0];
</script>
@endsection

