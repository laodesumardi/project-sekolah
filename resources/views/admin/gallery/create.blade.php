@extends('admin.layouts.app')

@section('title', 'Buat Album Galeri Baru')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Album Galeri Baru</h1>
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Buat Album Baru</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
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
                           value="{{ old('title') }}"
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
                           value="{{ old('slug') }}"
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
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
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
                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
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
                           value="{{ old('date') }}"
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
                           value="{{ old('location') }}"
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
                           value="{{ old('photographer') }}"
                           placeholder="Nama fotografer"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('photographer') border-red-500 @enderror">
                    @error('photographer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Foto -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Foto <span class="text-red-500">*</span>
                    </label>
                    <p class="text-sm text-gray-500 mb-4">Format: JPG, JPEG, PNG, WebP | Max per file: 5MB | Min: 1 foto</p>
                    
                    <!-- Dropzone Area -->
                    <div id="dropzone-area" 
                         class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-primary-500 hover:bg-blue-50 transition-colors cursor-pointer"
                         onclick="document.getElementById('images').click()">
                        <div class="space-y-4">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <div>
                                <p class="text-lg font-medium text-gray-900">Klik untuk upload atau drag & drop</p>
                                <p class="text-sm text-gray-500">Anda dapat memilih multiple file sekaligus</p>
                                <p class="text-xs text-gray-400">JPG, JPEG, PNG, WebP | Max 5MB per file</p>
                            </div>
                            <button type="button" 
                                    class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors"
                                    style="background-color: #13315c;">
                                Pilih File
                            </button>
                        </div>
                    </div>

                    <input type="file" 
                           id="images" 
                           name="images[]" 
                           multiple 
                           accept="image/jpeg,image/jpg,image/png,image/webp"
                           class="hidden"
                           onchange="handleMultipleImageUpload(event)">

                    <!-- Preview Grid -->
                    <div id="preview-grid" class="mt-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 hidden">
                        <!-- Preview items will be added here -->
                    </div>

                    @error('images')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
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
                                   {{ old('is_published', true) ? 'checked' : '' }}
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
                                   {{ old('is_featured') ? 'checked' : '' }}
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
                    <div id="cover-preview" class="text-center text-gray-500">
                        <p class="text-sm">Cover akan otomatis diatur dari foto pertama</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700 transition-colors font-medium"
                                style="background-color: #13315c;">
                            Simpan Album
                        </button>
                        
                        <button type="submit" 
                                name="save_and_add" 
                                value="1"
                                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium">
                            Simpan & Tambah Lagi
                        </button>
                        
                        <a href="{{ route('admin.gallery.index') }}" 
                           class="block w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors font-medium text-center">
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

// Handle multiple image upload
function handleMultipleImageUpload(event) {
    const files = Array.from(event.target.files);
    
    if (files.length === 0) return;
    
    // Validate files
    const validFiles = [];
    const errors = [];
    
    files.forEach((file, index) => {
        // Check file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            errors.push(`File ${index + 1}: Format tidak didukung. Hanya JPG, JPEG, PNG, WebP yang diperbolehkan.`);
            return;
        }
        
        // Check file size (5MB = 5242880 bytes)
        if (file.size > 5242880) {
            errors.push(`File ${index + 1}: Ukuran file terlalu besar. Maksimal 5MB.`);
            return;
        }
        
        validFiles.push(file);
    });
    
    if (errors.length > 0) {
        alert('Error:\n' + errors.join('\n'));
        event.target.value = ''; // Reset input
        return;
    }
    
    if (validFiles.length === 0) {
        alert('Tidak ada file yang valid untuk diupload.');
        event.target.value = '';
        return;
    }
    
    // Hide dropzone
    document.getElementById('dropzone-area').classList.add('hidden');
    
    // Show preview grid
    const previewGrid = document.getElementById('preview-grid');
    previewGrid.classList.remove('hidden');
    previewGrid.innerHTML = '';
    
    // Create preview items
    validFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewItem = createPreviewItem(file, e.target.result, index);
            previewGrid.appendChild(previewItem);
        };
        reader.readAsDataURL(file);
    });
}

function createPreviewItem(file, imageSrc, index) {
    const div = document.createElement('div');
    div.className = 'relative bg-white border border-gray-200 rounded-lg p-3 shadow-sm hover:shadow-md transition-shadow';
    div.innerHTML = `
        <div class="aspect-square mb-3 overflow-hidden rounded-lg">
            <img src="${imageSrc}" alt="${file.name}" class="w-full h-full object-cover">
        </div>
        
        <div class="space-y-2">
            <input type="text" 
                   name="image_titles[]" 
                   placeholder="Judul foto (optional)" 
                   class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
            
            <textarea name="image_captions[]" 
                      placeholder="Caption (optional)" 
                      rows="2" 
                      class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-primary-500 focus:border-primary-500"></textarea>
        </div>
        
        <div class="absolute top-2 left-2 bg-primary-500 text-white text-xs font-semibold px-2 py-1 rounded" style="background-color: #13315c;">
            #${index + 1}
        </div>
        
        <button type="button" 
                onclick="removePreviewItem(this)" 
                class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    return div;
}

function removePreviewItem(button) {
    button.parentElement.remove();
    
    // Show dropzone if no previews left
    if (document.querySelectorAll('#preview-grid > div').length === 0) {
        document.getElementById('dropzone-area').classList.remove('hidden');
        document.getElementById('preview-grid').classList.add('hidden');
        document.getElementById('images').value = '';
    }
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const category = document.getElementById('category').value;
    const images = document.getElementById('images').files;
    
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
    
    if (images.length === 0) {
        alert('Minimal 1 foto harus diupload.');
        e.preventDefault();
        return;
    }
});
</script>
@endsection










