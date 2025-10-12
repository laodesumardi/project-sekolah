@extends('admin.layouts.app')

@section('page-title', 'Tulis Berita Baru')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tulis Berita Baru</h1>
        <p class="text-gray-600">Buat artikel berita untuk website sekolah</p>
    </div>

    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" id="newsForm">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Berita <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                           placeholder="Masukkan judul berita..."
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Konten Berita <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" 
                              name="content" 
                              rows="15"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror"
                              placeholder="Tulis konten berita di sini..."
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                        Ringkasan (Excerpt)
                    </label>
                    <textarea id="excerpt" 
                              name="excerpt" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('excerpt') border-red-500 @enderror"
                              placeholder="Ringkasan singkat berita (akan otomatis dibuat jika dikosongkan)...">{{ old('excerpt') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Kosongkan untuk auto-generate dari konten</p>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Options -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Opsi Publikasi</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Publikasi</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="publish_status" value="draft" class="mr-2" {{ old('publish_status', 'draft') === 'draft' ? 'checked' : '' }}>
                                    <span class="text-sm">Simpan sebagai Draft</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="publish_status" value="publish" class="mr-2" {{ old('publish_status') === 'publish' ? 'checked' : '' }}>
                                    <span class="text-sm">Publish Sekarang</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="publish_status" value="schedule" class="mr-2" {{ old('publish_status') === 'schedule' ? 'checked' : '' }}>
                                    <span class="text-sm">Jadwalkan Publikasi</span>
                                </label>
                            </div>
                        </div>

                        <div id="scheduleDate" style="display: none;">
                            <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">Tanggal & Waktu</label>
                            <input type="datetime-local" 
                                   id="scheduled_at" 
                                   name="scheduled_at" 
                                   value="{{ old('scheduled_at') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Featured Image</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar</label>
                            <input type="file" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror">
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div id="imagePreview" class="hidden">
                            <img id="previewImg" src="" alt="Preview" class="w-full h-48 object-cover rounded-lg">
                        </div>
                    </div>
                </div>

                <!-- Category & Tags -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Kategori & Tags</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select id="category_id" 
                                    name="category_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('category_id') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                            <select id="tags" 
                                    name="tags[]" 
                                    multiple
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Pilih atau buat tags baru</p>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                            <input type="text" 
                                   id="meta_title" 
                                   name="meta_title" 
                                   value="{{ old('meta_title') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="Meta title untuk SEO...">
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                            <textarea id="meta_description" 
                                      name="meta_description" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                      placeholder="Meta description untuk SEO...">{{ old('meta_description') }}</textarea>
                        </div>

                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                            <input type="text" 
                                   id="meta_keywords" 
                                   name="meta_keywords" 
                                   value="{{ old('meta_keywords') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="keyword1, keyword2, keyword3...">
                        </div>
                    </div>
                </div>

                <!-- Additional Options -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Opsi Tambahan</h3>
                    
                    <div class="space-y-4">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1" 
                                   class="mr-2 rounded border-gray-300 text-primary-600 focus:ring-primary-500" 
                                   {{ old('is_featured') ? 'checked' : '' }}>
                            <span class="text-sm">Jadikan Featured News</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="allow_comments" 
                                   value="1" 
                                   class="mr-2 rounded border-gray-300 text-primary-600 focus:ring-primary-500" 
                                   {{ old('allow_comments', true) ? 'checked' : '' }}>
                            <span class="text-sm">Izinkan Komentar</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.news.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors duration-200">
                Simpan Berita
            </button>
        </div>
    </form>
</div>

<script>
// Schedule date toggle
document.querySelectorAll('input[name="publish_status"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const scheduleDate = document.getElementById('scheduleDate');
        if (this.value === 'schedule') {
            scheduleDate.style.display = 'block';
        } else {
            scheduleDate.style.display = 'none';
        }
    });
});

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
    }
});

// Auto-generate excerpt from content
document.getElementById('content').addEventListener('input', function() {
    const excerpt = document.getElementById('excerpt');
    if (!excerpt.value.trim()) {
        const content = this.value;
        const plainText = content.replace(/<[^>]*>/g, ''); // Remove HTML tags
        const excerptText = plainText.substring(0, 150);
        excerpt.value = excerptText;
    }
});

// Auto-generate meta title from title
document.getElementById('title').addEventListener('input', function() {
    const metaTitle = document.getElementById('meta_title');
    if (!metaTitle.value.trim()) {
        metaTitle.value = this.value;
    }
});

// Auto-generate meta description from excerpt
document.getElementById('excerpt').addEventListener('input', function() {
    const metaDescription = document.getElementById('meta_description');
    if (!metaDescription.value.trim()) {
        metaDescription.value = this.value;
    }
});
</script>
@endsection

