@extends('admin.layouts.app')

@section('title', 'Tambah Fasilitas Baru')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Page Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Tambah Fasilitas Baru</h1>
                    <nav class="flex mt-2" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <a href="{{ route('admin.facilities.index') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">Fasilitas</a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-gray-500 md:ml-2">Tambah Baru</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="POST" action="{{ route('admin.facilities.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="bg-white rounded-lg shadow p-8">
                <!-- Nama Fasilitas -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Fasilitas <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#13315c] focus:border-[#13315c] @error('name') border-red-500 @enderror"
                        placeholder="Contoh: Laboratorium Komputer"
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-6">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        Slug (URL)
                    </label>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        value="{{ old('slug') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#13315c] focus:border-[#13315c] @error('slug') border-red-500 @enderror"
                        readonly
                    >
                    <p class="mt-1 text-sm text-gray-500">URL: <span id="slug-preview">{{ url('/fasilitas/') }}/<span id="slug-value">-</span></span></p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="category" 
                        name="category" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#13315c] focus:border-[#13315c] @error('category') border-red-500 @enderror"
                        required
                    >
                        <option value="">Pilih Kategori</option>
                        <option value="ruang_kelas" {{ old('category') == 'ruang_kelas' ? 'selected' : '' }}>Ruang Kelas</option>
                        <option value="laboratorium" {{ old('category') == 'laboratorium' ? 'selected' : '' }}>Laboratorium</option>
                        <option value="olahraga" {{ old('category') == 'olahraga' ? 'selected' : '' }}>Olahraga</option>
                        <option value="perpustakaan" {{ old('category') == 'perpustakaan' ? 'selected' : '' }}>Perpustakaan</option>
                        <option value="mushola" {{ old('category') == 'mushola' ? 'selected' : '' }}>Mushola</option>
                        <option value="kantin" {{ old('category') == 'kantin' ? 'selected' : '' }}>Kantin</option>
                        <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar Utama -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Fasilitas <span class="text-red-500">*</span>
                    </label>
                    <p class="text-sm text-gray-500 mb-4">Format: JPG, JPEG, PNG | Ukuran Maksimal: 2MB | Rekomendasi: 1200x675px (16:9)</p>
                    
                    <!-- Dropzone Area -->
                    <div id="dropzone-area" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-[#13315c] hover:bg-gray-50 transition-colors cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Klik untuk upload atau drag & drop</p>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                    </div>

                    <!-- Preview Container (Initially Hidden) -->
                    <div id="preview-container" class="hidden border border-gray-300 rounded-lg p-4 relative">
                        <img id="image-preview" src="" alt="Preview" class="max-w-full max-h-96 object-contain rounded-lg">
                        <div class="mt-2 text-sm text-gray-700">
                            <div id="file-name" class="font-medium"></div>
                            <div id="file-size" class="text-gray-500"></div>
                        </div>
                        <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <input 
                        type="file" 
                        name="image" 
                        id="image" 
                        accept="image/jpeg,image/jpg,image/png"
                        class="hidden"
                        onchange="handleImageUpload(event)"
                        required
                    >
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="8" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#13315c] focus:border-[#13315c] @error('description') border-red-500 @enderror"
                        placeholder="Jelaskan detail fasilitas ini..."
                        required
                    >{{ old('description') }}</textarea>
                    <div class="flex justify-between mt-1">
                        <p class="text-sm text-gray-500">Maksimal 5000 karakter</p>
                        <span id="char-count" class="text-sm text-gray-500">0/5000</span>
                    </div>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kapasitas -->
                <div class="mb-6">
                    <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                        Kapasitas
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="capacity" 
                            name="capacity" 
                            value="{{ old('capacity') }}"
                            min="1"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-16 focus:ring-[#13315c] focus:border-[#13315c] @error('capacity') border-red-500 @enderror"
                            placeholder="Contoh: 50"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-sm">Orang</span>
                        </div>
                    </div>
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div class="mb-6">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi
                    </label>
                    <input 
                        type="text" 
                        id="location" 
                        name="location" 
                        value="{{ old('location') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#13315c] focus:border-[#13315c] @error('location') border-red-500 @enderror"
                        placeholder="Contoh: Gedung A"
                    >
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lantai -->
                <div class="mb-6">
                    <label for="floor" class="block text-sm font-medium text-gray-700 mb-2">
                        Lantai
                    </label>
                    <input 
                        type="text" 
                        id="floor" 
                        name="floor" 
                        value="{{ old('floor') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#13315c] focus:border-[#13315c] @error('floor') border-red-500 @enderror"
                        placeholder="Contoh: Lantai 1"
                    >
                    @error('floor')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Spesifikasi & Fasilitas -->
                <div class="mb-6">
                    <label for="facilities_spec" class="block text-sm font-medium text-gray-700 mb-2">
                        Spesifikasi & Fasilitas
                    </label>
                    <p class="text-sm text-gray-500 mb-2">Pisahkan dengan koma. Contoh: AC, Proyektor, Sound System</p>
                    <input 
                        type="text" 
                        id="facilities_spec" 
                        name="facilities_spec" 
                        value="{{ old('facilities_spec') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#13315c] focus:border-[#13315c] @error('facilities_spec') border-red-500 @enderror"
                        placeholder="AC, Proyektor, Sound System, WiFi"
                    >
                    @error('facilities_spec')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Urutan Tampilan -->
                <div class="mb-6">
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan Tampilan
                    </label>
                    <input 
                        type="number" 
                        id="sort_order" 
                        name="sort_order" 
                        value="{{ old('sort_order', 0) }}"
                        min="0"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#13315c] focus:border-[#13315c] @error('sort_order') border-red-500 @enderror"
                    >
                    <p class="mt-1 text-sm text-gray-500">Angka lebih kecil akan tampil lebih dulu</p>
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Ketersediaan -->
                <div class="mb-8">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="is_available" 
                            value="1"
                            {{ old('is_available', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-[#13315c] focus:ring-[#13315c]"
                        >
                        <span class="ml-2 text-sm font-medium text-gray-700">Fasilitas Tersedia</span>
                    </label>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between">
                    <button type="submit" class="bg-[#13315c] hover:bg-[#1e4d8b] text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan
                    </button>
                    
                    <button type="button" onclick="saveAndAddMore()" class="bg-white border border-[#13315c] text-[#13315c] hover:bg-[#13315c] hover:text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Simpan & Tambah Lagi
                    </button>
                    
                    <a href="{{ route('admin.facilities.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg flex items-center transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
        .trim();
    
    document.getElementById('slug').value = slug;
    document.getElementById('slug-value').textContent = slug;
});

// Character counter for description
document.getElementById('description').addEventListener('input', function() {
    const length = this.value.length;
    document.getElementById('char-count').textContent = `${length}/5000`;
    
    if (length > 5000) {
        document.getElementById('char-count').classList.add('text-red-500');
    } else {
        document.getElementById('char-count').classList.remove('text-red-500');
    }
});

// Image upload handling
document.getElementById('dropzone-area').addEventListener('click', function() {
    document.getElementById('image').click();
});

document.getElementById('dropzone-area').addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('border-[#13315c]', 'bg-blue-50');
});

document.getElementById('dropzone-area').addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('border-[#13315c]', 'bg-blue-50');
});

document.getElementById('dropzone-area').addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('border-[#13315c]', 'bg-blue-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('image').files = files;
        handleImageUpload({ target: { files: files } });
    }
});

function handleImageUpload(event) {
    const file = event.target.files[0];
    
    if (!file) return;
    
    // Validation
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!allowedTypes.includes(file.type)) {
        alert('Format tidak didukung. Hanya file JPG, JPEG, dan PNG yang diperbolehkan.');
        event.target.value = '';
        return;
    }
    
    if (file.size > 2097152) { // 2MB
        alert('File terlalu besar. Ukuran file maksimal adalah 2MB.');
        event.target.value = '';
        return;
    }
    
    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('dropzone-area').classList.add('hidden');
        document.getElementById('preview-container').classList.remove('hidden');
        document.getElementById('image-preview').src = e.target.result;
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-size').textContent = formatFileSize(file.size);
    };
    reader.readAsDataURL(file);
}

function removeImage() {
    if (confirm('Yakin ingin menghapus gambar?')) {
        document.getElementById('image').value = '';
        document.getElementById('preview-container').classList.add('hidden');
        document.getElementById('dropzone-area').classList.remove('hidden');
    }
}

function formatFileSize(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(2) + ' KB';
    return (bytes / 1048576).toFixed(2) + ' MB';
}

function saveAndAddMore() {
    // Add hidden input to indicate save and add more
    const form = document.querySelector('form');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'save_and_add_more';
    input.value = '1';
    form.appendChild(input);
    form.submit();
}
</script>
@endpush
@endsection