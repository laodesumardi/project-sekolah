@extends('admin.layouts.app')

@section('title', 'Edit Album Galeri')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Album Galeri</h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('admin.gallery.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2">Galeri</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit Album</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form (Left Column - 70%) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Judul Album -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Album <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $gallery->title) }}"
                           placeholder="Contoh: Lomba 17 Agustus 2024"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('title') border-red-500 @enderror"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maksimal 255 karakter</p>
                </div>

                <!-- Slug -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        Slug (URL)
                    </label>
                    <input type="text" 
                           id="slug" 
                           name="slug" 
                           value="{{ old('slug', $gallery->slug) }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('slug') border-red-500 @enderror"
                           readonly>
                    <p class="mt-1 text-sm text-gray-500">URL: <span id="slug-preview">yoursite.com/galeri/[slug]</span></p>
                </div>

                <!-- Deskripsi -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Album
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="6" 
                              placeholder="Jelaskan tentang album ini..."
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('description') border-red-500 @enderror">{{ old('description', $gallery->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maksimal 2000 karakter</p>
                </div>

                <!-- Kategori -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="category" 
                            name="category" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('category') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ old('category', $gallery->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Kegiatan -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Kegiatan
                    </label>
                    <input type="date" 
                           id="date" 
                           name="date" 
                           value="{{ old('date', $gallery->date?->format('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('date') border-red-500 @enderror">
                    @error('date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi Kegiatan
                    </label>
                    <input type="text" 
                           id="location" 
                           name="location" 
                           value="{{ old('location', $gallery->location) }}"
                           placeholder="Contoh: Lapangan Sekolah"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('location') border-red-500 @enderror">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fotografer -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label for="photographer" class="block text-sm font-medium text-gray-700 mb-2">
                        Fotografer / Sumber
                    </label>
                    <input type="text" 
                           id="photographer" 
                           name="photographer" 
                           value="{{ old('photographer', $gallery->photographer) }}"
                           placeholder="Nama fotografer"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('photographer') border-red-500 @enderror">
                    @error('photographer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Images -->
                @if($gallery->images->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Foto Saat Ini ({{ $gallery->images->count() }} foto)
                        </label>
                        <button type="button" 
                                onclick="toggleImageManagement()" 
                                class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                            Kelola Foto
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($gallery->images as $index => $image)
                        <div class="relative group" id="image-{{ $image->id }}">
                            <div class="aspect-square overflow-hidden rounded-lg border border-gray-200">
                                <img src="{{ $image->thumbnail_url }}" 
                                     alt="{{ $image->title ?? $gallery->title }}"
                                     class="w-full h-full object-cover"
                                     onerror="this.src='{{ asset('images/placeholder-gallery.jpg') }}'">
                            </div>
                            
                            <!-- Image Info -->
                            <div class="mt-2 text-xs text-gray-600">
                                <p class="font-medium truncate">{{ $image->title ?? 'Tanpa judul' }}</p>
                                <p class="text-gray-500">{{ $image->formatted_size }}</p>
                            </div>
                            
                            <!-- Cover Badge -->
                            @if($image->is_cover)
                            <div class="absolute top-2 left-2 bg-yellow-400 text-white text-xs font-semibold px-2 py-1 rounded">
                                Cover
                            </div>
                            @endif
                            
                            <!-- Sort Order -->
                            <div class="absolute top-2 right-2 bg-primary-500 text-white text-xs font-semibold px-2 py-1 rounded" style="background-color: #13315c;">
                                #{{ $index + 1 }}
                            </div>
                            
                            <!-- Delete Button (Hidden by default) -->
                            <div id="delete-button-{{ $image->id }}" class="hidden absolute top-2 left-2 bg-red-500 text-white p-1 rounded hover:bg-red-600 transition-colors cursor-pointer z-10"
                                 onclick="deleteExistingImage({{ $image->id }})"
                                 title="Hapus Foto">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-2-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            <!-- Sidebar (Right Column - 30%) -->
            <div class="space-y-6">
                <!-- Publish Settings -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Publikasi</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_published" 
                                   name="is_published" 
                                   value="1"
                                   {{ old('is_published', $gallery->is_published) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_published" class="ml-2 text-sm text-gray-700">
                                Publikasikan album
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_featured" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured', $gallery->is_featured) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_featured" class="ml-2 text-sm text-gray-700">
                                Jadikan featured
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Cover Image -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Cover Album</h3>
                    @if($gallery->cover_image)
                    <div class="aspect-square overflow-hidden rounded-lg border border-gray-200">
                        <img src="{{ $gallery->cover_image_url }}" 
                             alt="{{ $gallery->title }}"
                             class="w-full h-full object-cover"
                             onerror="this.src='{{ asset('images/placeholder-gallery.jpg') }}'">
                    </div>
                    <p class="mt-2 text-sm text-gray-600">Cover saat ini</p>
                    @else
                    <div class="text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm">Tidak ada cover</p>
                    </div>
                    @endif
                </div>

                <!-- Album Stats -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Album</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total Foto:</span>
                            <span class="text-sm font-medium">{{ $gallery->total_photos }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total Views:</span>
                            <span class="text-sm font-medium">{{ $gallery->view_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Dibuat:</span>
                            <span class="text-sm font-medium">{{ $gallery->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Diupdate:</span>
                            <span class="text-sm font-medium">{{ $gallery->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.gallery.create') }}" 
                           class="block w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium text-center">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat Album Baru
                        </a>
                        
                        <a href="{{ route('admin.gallery.index') }}" 
                           class="block w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors font-medium text-center">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar
                        </a>
                        
                        <a href="{{ route('gallery.show', $gallery->slug) }}" 
                           target="_blank"
                           class="block w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium text-center">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Lihat di Frontend
                        </a>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700 transition-colors font-medium"
                                style="background-color: #13315c;">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Album
                        </button>
                        
                        <a href="{{ route('admin.gallery.index') }}" 
                           class="block w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors font-medium text-center">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single
        .trim();
    
    document.getElementById('slug').value = slug;
    document.getElementById('slug-preview').textContent = `yoursite.com/galeri/${slug}`;
});

// Toggle image management mode
function toggleImageManagement() {
    const deleteButtons = document.querySelectorAll('[id^="delete-button-"]');
    const toggleBtn = document.querySelector('button[onclick="toggleImageManagement()"]');
    
    if (deleteButtons.length === 0) {
        console.log('No delete buttons found');
        return;
    }
    
    const isVisible = !deleteButtons[0].classList.contains('hidden');
    
    deleteButtons.forEach(button => {
        if (isVisible) {
            button.classList.add('hidden');
        } else {
            button.classList.remove('hidden');
        }
    });
    
    // Update button text
    if (toggleBtn) {
        toggleBtn.textContent = isVisible ? 'Kelola Foto' : 'Selesai Kelola';
    }
}

// Delete existing image
function deleteExistingImage(imageId) {
    if (confirm('Yakin ingin menghapus foto ini?')) {
        const imageContainer = document.getElementById(`image-${imageId}`);
        if (imageContainer) {
            // Add visual feedback
            imageContainer.style.opacity = '0.5';
            imageContainer.style.transform = 'scale(0.95)';
            
            // Add hidden input to mark for deletion
            const form = document.querySelector('form');
            if (form) {
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'deleted_images[]';
                deleteInput.value = imageId;
                form.appendChild(deleteInput);
            }
            
            // Remove from DOM after animation
            setTimeout(() => {
                imageContainer.remove();
                
                // Update photo count
                const remainingImages = document.querySelectorAll('[id^="image-"]');
                const countLabel = document.querySelector('label[class*="text-sm font-medium text-gray-700"]');
                if (countLabel) {
                    const currentText = countLabel.textContent;
                    const newCount = remainingImages.length;
                    countLabel.textContent = currentText.replace(/\(\d+ foto\)/, `(${newCount} foto)`);
                }
                
                // Hide management mode if no images left
                if (remainingImages.length === 0) {
                    const toggleBtn = document.querySelector('button[onclick="toggleImageManagement()"]');
                    if (toggleBtn) {
                        toggleBtn.textContent = 'Kelola Foto';
                    }
                }
            }, 300);
            
            alert('Foto berhasil dihapus!');
        } else {
            console.error('Image container not found for ID:', imageId);
        }
    }
}


// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const category = document.getElementById('category').value;
    
    if (!title) {
        alert('Judul album harus diisi.');
        e.preventDefault();
        return;
    }
    
    if (!category) {
        alert('Kategori harus dipilih.');
        e.preventDefault();
        return;
    }
});
</script>
@endsection