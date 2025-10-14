@extends('student.layouts.app')

@section('title', 'Buat Topik Baru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('student.forum.index') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <span class="sr-only">Forum</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Buat Topik</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Buat Topik Baru
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Bagikan ide, pertanyaan, atau diskusi dengan teman-teman
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('student.forum.index') }}" 
               class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.293 9.293a1 1 0 011.414 0L12 10.586l1.293-1.293a1 1 0 111.414 1.414L13.414 12l1.293 1.293a1 1 0 01-1.414 1.414L12 13.414l-1.293 1.293a1 1 0 01-1.414-1.414L10.586 12 9.293 10.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Create Topic Form -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Formulir Topik Baru</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Isi informasi topik yang ingin Anda buat
            </p>
        </div>
        <form id="createTopicForm" class="px-4 pb-5 sm:px-6">
            @csrf
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        Judul Topik <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           required
                           maxlength="255"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                           placeholder="Masukkan judul topik yang menarik...">
                    <p class="mt-1 text-xs text-gray-500">Maksimal 255 karakter</p>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="category" 
                            name="category" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2 text-xs text-gray-500">
                        <p><strong>Akademik:</strong> Diskusi tentang pelajaran, tugas, ujian</p>
                        <p><strong>Umum:</strong> Diskusi bebas, tips, pengalaman</p>
                        <p><strong>Bantuan:</strong> Pertanyaan teknis, bantuan penggunaan</p>
                        <p><strong>Pengumuman:</strong> Informasi penting dari sekolah</p>
                    </div>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">
                        Konten Topik <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" 
                              name="content" 
                              rows="8" 
                              required
                              maxlength="5000"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                              placeholder="Tulis konten topik Anda di sini..."></textarea>
                    <p class="mt-1 text-xs text-gray-500">Maksimal 5000 karakter</p>
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700">
                        Tag (Opsional)
                    </label>
                    <input type="text" 
                           id="tags" 
                           name="tags"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                           placeholder="matematika, aljabar, kelas-7 (pisahkan dengan koma)">
                    <p class="mt-1 text-xs text-gray-500">Pisahkan tag dengan koma. Contoh: matematika, aljabar, kelas-7</p>
                </div>

                <!-- Options -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Opsi Tambahan</h4>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input id="is_pinned" 
                                   name="is_pinned" 
                                   type="checkbox" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_pinned" class="ml-2 block text-sm text-gray-900">
                                Pasang topik di bagian atas (hanya untuk topik penting)
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="is_locked" 
                                   name="is_locked" 
                                   type="checkbox" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_locked" class="ml-2 block text-sm text-gray-900">
                                Kunci topik (tidak bisa dibalas)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Guidelines -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <h4 class="text-sm font-medium text-blue-900 mb-2">Panduan Membuat Topik</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Gunakan judul yang jelas dan deskriptif</li>
                        <li>• Pilih kategori yang sesuai dengan topik Anda</li>
                        <li>• Tulis konten yang informatif dan mudah dipahami</li>
                        <li>• Gunakan tag untuk memudahkan pencarian</li>
                        <li>• Hormati teman-teman dan gunakan bahasa yang sopan</li>
                        <li>• Jangan spam atau mengirim konten yang tidak relevan</li>
                    </ul>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('student.forum.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                    </svg>
                    Buat Topik
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Character counters
document.getElementById('title').addEventListener('input', function() {
    const maxLength = 255;
    const currentLength = this.value.length;
    const remaining = maxLength - currentLength;
    
    if (remaining < 50) {
        this.style.borderColor = remaining < 10 ? '#ef4444' : '#f59e0b';
    } else {
        this.style.borderColor = '#d1d5db';
    }
});

document.getElementById('content').addEventListener('input', function() {
    const maxLength = 5000;
    const currentLength = this.value.length;
    const remaining = maxLength - currentLength;
    
    if (remaining < 500) {
        this.style.borderColor = remaining < 100 ? '#ef4444' : '#f59e0b';
    } else {
        this.style.borderColor = '#d1d5db';
    }
});

// Form submission
document.getElementById('createTopicForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const button = this.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    
    // Validate form
    const title = formData.get('title').trim();
    const content = formData.get('content').trim();
    const category = formData.get('category');
    
    if (!title || !content || !category) {
        alert('Mohon lengkapi semua field yang wajib diisi!');
        return;
    }
    
    if (title.length < 10) {
        alert('Judul topik minimal 10 karakter!');
        return;
    }
    
    if (content.length < 20) {
        alert('Konten topik minimal 20 karakter!');
        return;
    }
    
    // Show loading state
    button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Membuat Topik...';
    button.disabled = true;
    
    // Simulate creation
    setTimeout(() => {
        alert('Topik berhasil dibuat!');
        window.location.href = '{{ route("student.forum.index") }}';
    }, 2000);
});

// Auto-save draft (optional)
let draftTimer;
function autoSaveDraft() {
    clearTimeout(draftTimer);
    draftTimer = setTimeout(() => {
        const title = document.getElementById('title').value;
        const content = document.getElementById('content').value;
        const category = document.getElementById('category').value;
        const tags = document.getElementById('tags').value;
        
        if (title || content) {
            localStorage.setItem('forum_draft', JSON.stringify({
                title, content, category, tags,
                timestamp: new Date().toISOString()
            }));
        }
    }, 5000); // Auto-save every 5 seconds
}

// Load draft on page load
window.addEventListener('load', function() {
    const draft = localStorage.getItem('forum_draft');
    if (draft) {
        try {
            const data = JSON.parse(draft);
            if (data.title) document.getElementById('title').value = data.title;
            if (data.content) document.getElementById('content').value = data.content;
            if (data.category) document.getElementById('category').value = data.category;
            if (data.tags) document.getElementById('tags').value = data.tags;
        } catch (e) {
            console.log('Error loading draft:', e);
        }
    }
});

// Clear draft on successful submission
document.getElementById('createTopicForm').addEventListener('submit', function() {
    localStorage.removeItem('forum_draft');
});

// Add event listeners for auto-save
document.getElementById('title').addEventListener('input', autoSaveDraft);
document.getElementById('content').addEventListener('input', autoSaveDraft);
document.getElementById('category').addEventListener('change', autoSaveDraft);
document.getElementById('tags').addEventListener('input', autoSaveDraft);
</script>
@endsection

