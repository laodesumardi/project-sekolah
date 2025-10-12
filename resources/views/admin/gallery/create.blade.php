@extends('admin.layouts.app')

@section('page-title', 'Upload Gambar')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Upload Gambar</h1>
        <p class="text-gray-600">Tambahkan gambar baru ke galeri sekolah</p>
    </div>

    <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Main Form -->
            <div class="space-y-6">
                <!-- Image Upload -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Gambar</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Gambar <span class="text-red-500">*</span>
                            </label>
                            <input type="file" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror"
                                   required>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div id="imagePreview" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                            <img id="previewImg" src="" alt="Preview" class="w-full h-64 object-cover rounded-lg border border-gray-200">
                        </div>
                    </div>
                </div>

                <!-- Basic Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                                   placeholder="Masukkan judul gambar..."
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                                      placeholder="Deskripsi gambar (opsional)...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="alt_text" class="block text-sm font-medium text-gray-700 mb-2">Alt Text</label>
                            <input type="text" 
                                   id="alt_text" 
                                   name="alt_text" 
                                   value="{{ old('alt_text') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('alt_text') border-red-500 @enderror"
                                   placeholder="Alt text untuk SEO...">
                            <p class="mt-1 text-sm text-gray-500">Deskripsi singkat untuk accessibility dan SEO</p>
                            @error('alt_text')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Category & Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Kategori & Pengaturan</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select id="category" 
                                    name="category" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('category') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Kategori</option>
                                <option value="academic" {{ old('category') === 'academic' ? 'selected' : '' }}>Akademik</option>
                                <option value="sports" {{ old('category') === 'sports' ? 'selected' : '' }}>Olahraga</option>
                                <option value="events" {{ old('category') === 'events' ? 'selected' : '' }}>Acara</option>
                                <option value="facilities" {{ old('category') === 'facilities' ? 'selected' : '' }}>Fasilitas</option>
                                <option value="activities" {{ old('category') === 'activities' ? 'selected' : '' }}>Kegiatan</option>
                                <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', 0) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('sort_order') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Urutan tampil (0 = paling atas)</p>
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       class="mr-2 rounded border-gray-300 text-primary-600 focus:ring-primary-500" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="text-sm">Aktifkan gambar</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Image Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi File</h3>
                    
                    <div id="fileInfo" class="space-y-2 text-sm text-gray-600">
                        <p>Pilih gambar untuk melihat informasi file</p>
                    </div>
                </div>

                <!-- Tips -->
                <div class="bg-blue-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-blue-900 mb-2">Tips Upload</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Format yang didukung: JPG, PNG, WebP</li>
                        <li>• Ukuran maksimal: 10MB per file</li>
                        <li>• Resolusi disarankan: 1920x1080 atau lebih</li>
                        <li>• Gambar akan otomatis dioptimasi</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.gallery.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors duration-200">
                Upload Gambar
            </button>
        </div>
    </form>
</div>

<script>
// Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
        
        // Show file info
        const fileInfo = document.getElementById('fileInfo');
        fileInfo.innerHTML = `
            <div class="space-y-2">
                <div><strong>Nama:</strong> ${file.name}</div>
                <div><strong>Ukuran:</strong> ${(file.size / 1024 / 1024).toFixed(2)} MB</div>
                <div><strong>Tipe:</strong> ${file.type}</div>
                <div><strong>Terakhir diubah:</strong> ${new Date(file.lastModified).toLocaleDateString()}</div>
            </div>
        `;
    }
});

// Auto-generate alt text from title
document.getElementById('title').addEventListener('input', function() {
    const altText = document.getElementById('alt_text');
    if (!altText.value.trim()) {
        altText.value = this.value;
    }
});
</script>
@endsection

