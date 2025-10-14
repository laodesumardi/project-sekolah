@extends('teacher.layouts.app')

@section('title', 'Edit Diskusi')
@section('description', 'Edit diskusi: ' . $discussion->title)

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('teacher.forum.show', $discussion->id) }}" 
                           class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Diskusi
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mt-2">Edit Diskusi</h1>
                    <p class="mt-2 text-gray-600">Perbarui diskusi Anda</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form id="discussionForm" action="{{ route('teacher.forum.update', $discussion->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Diskusi</h2>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Diskusi</label>
                        <input type="text" id="title" name="title" required 
                               value="{{ $discussion->title }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Masukkan judul diskusi yang menarik...">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select id="category_id" name="category_id" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->name === $discussion->category ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Class (Optional) -->
                    <div>
                        <label for="class_id" class="block text-sm font-medium text-gray-700">Kelas (Opsional)</label>
                        <select id="class_id" name="class_id" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Kelas (Opsional)</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Isi Diskusi</label>
                        <textarea id="content" name="content" rows="8" required 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                  placeholder="Tulis isi diskusi Anda di sini...">{{ $discussion->content }}</textarea>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700">Tag (Opsional)</label>
                        <input type="text" id="tags" name="tags" 
                               value="{{ implode(', ', $discussion->tags) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="pembelajaran, teknologi, tips (pisahkan dengan koma)">
                    </div>

                    <!-- Options -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_pinned" name="is_pinned" 
                                   {{ $discussion->is_pinned ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_pinned" class="ml-2 block text-sm text-gray-700">
                                Pasang diskusi di bagian atas
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="is_anonymous" name="is_anonymous" 
                                   {{ $discussion->is_anonymous ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_anonymous" class="ml-2 block text-sm text-gray-700">
                                Kirim sebagai anonim
                            </label>
                        </div>
                    </div>

                    <!-- Preview -->
                    <div id="preview" class="hidden">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Preview:</h3>
                        <div class="border border-gray-200 rounded-md p-4 bg-gray-50">
                            <h4 id="preview-title" class="text-lg font-medium text-gray-900"></h4>
                            <p id="preview-content" class="mt-2 text-sm text-gray-600"></p>
                            <div id="preview-tags" class="mt-3 flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-between">
                    <div class="flex space-x-3">
                        <button type="button" onclick="togglePreview()" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Preview
                        </button>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('teacher.forum.show', $discussion->id) }}" 
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
    document.getElementById('discussionForm').addEventListener('submit', function(e) {
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
                alert('Diskusi berhasil diperbarui!');
                window.location.href = data.redirect;
            } else {
                alert('Gagal memperbarui diskusi: ' + (data.message || 'Terjadi kesalahan'));
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui diskusi');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    });
});

function togglePreview() {
    const preview = document.getElementById('preview');
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;
    const tags = document.getElementById('tags').value;
    
    if (preview.classList.contains('hidden')) {
        // Show preview
        document.getElementById('preview-title').textContent = title || 'Judul diskusi...';
        document.getElementById('preview-content').textContent = content || 'Isi diskusi...';
        
        // Update tags
        const tagsContainer = document.getElementById('preview-tags');
        tagsContainer.innerHTML = '';
        if (tags) {
            const tagArray = tags.split(',').map(tag => tag.trim()).filter(tag => tag);
            tagArray.forEach(tag => {
                const tagElement = document.createElement('span');
                tagElement.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                tagElement.textContent = '#' + tag;
                tagsContainer.appendChild(tagElement);
            });
        }
        
        preview.classList.remove('hidden');
    } else {
        // Hide preview
        preview.classList.add('hidden');
    }
}

// Character counter for content
document.getElementById('content').addEventListener('input', function() {
    const content = this.value;
    const maxLength = 5000;
    const remaining = maxLength - content.length;
    
    // Create or update counter
    let counter = document.getElementById('char-counter');
    if (!counter) {
        counter = document.createElement('div');
        counter.id = 'char-counter';
        counter.className = 'mt-1 text-sm text-gray-500';
        this.parentNode.appendChild(counter);
    }
    
    counter.textContent = `${content.length}/${maxLength} karakter`;
    
    if (remaining < 100) {
        counter.className = 'mt-1 text-sm text-yellow-600';
    } else if (remaining < 0) {
        counter.className = 'mt-1 text-sm text-red-600';
    } else {
        counter.className = 'mt-1 text-sm text-gray-500';
    }
});
</script>
@endsection

