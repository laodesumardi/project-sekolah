@extends('admin.layouts.app')

@section('page-title', 'Kelola Galeri')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Galeri</h1>
            <p class="text-gray-600">Kelola foto dan gambar galeri sekolah</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('admin.gallery.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Upload Gambar
            </a>
            <button onclick="openBulkUpload()" 
                    class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Bulk Upload
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.gallery.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Kategori</option>
                    <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>General</option>
                    <option value="kegiatan" {{ request('category') === 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="prestasi" {{ request('category') === 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                    <option value="fasilitas" {{ request('category') === 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                    <option value="event" {{ request('category') === 'event' ? 'selected' : '' }}>Event</option>
                </select>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       placeholder="Cari gambar..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full bg-primary-500 text-white px-4 py-2 rounded-md hover:bg-primary-600 transition-colors duration-200">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6" id="bulkActions" style="display: none;">
        <form method="POST" action="{{ route('admin.gallery.bulk-action') }}" id="bulkActionForm">
            @csrf
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600" id="selectedCount">0 item dipilih</span>
                <select name="action" id="bulkActionSelect" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Pilih Aksi</option>
                    <option value="delete">Hapus</option>
                    <option value="activate">Aktifkan</option>
                    <option value="deactivate">Nonaktifkan</option>
                </select>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors duration-200">
                    Jalankan
                </button>
                <button type="button" onclick="clearSelection()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- Gallery Grid -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        @if($galleries->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6" id="galleryGrid">
                @foreach($galleries as $gallery)
                    <div class="gallery-item bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <!-- Checkbox -->
                        <div class="absolute top-2 left-2 z-10">
                            <input type="checkbox" 
                                   name="gallery_ids[]" 
                                   value="{{ $gallery->id }}" 
                                   class="gallery-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </div>

                        <!-- Image -->
                        <div class="relative aspect-square overflow-hidden">
                            <img src="{{ $gallery->thumbnail_url }}" 
                                 alt="{{ $gallery->alt_text ?: $gallery->title }}"
                                 class="w-full h-full object-cover">
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                                <div class="opacity-0 hover:opacity-100 transition-opacity duration-300 text-white text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-2 right-2">
                                @if($gallery->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </div>

                            <!-- Category Badge -->
                            <div class="absolute bottom-2 left-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-white bg-opacity-90 text-gray-700">
                                    {{ ucfirst($gallery->category) }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $gallery->title }}</h3>
                            @if($gallery->description)
                                <p class="text-sm text-gray-600 line-clamp-2 mb-2">{{ $gallery->description }}</p>
                            @endif
                            
                            <!-- File Info -->
                            <div class="text-xs text-gray-500 space-y-1">
                                @if($gallery->formatted_file_size)
                                    <div>Size: {{ $gallery->formatted_file_size }}</div>
                                @endif
                                @if($gallery->dimensions)
                                    <div>Dimensions: {{ $gallery->dimensions }}</div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="mt-3 flex justify-between items-center">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.gallery.edit', $gallery) }}" 
                                       class="text-primary-600 hover:text-primary-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button onclick="deleteGallery({{ $gallery->id }})" 
                                            class="text-red-600 hover:text-red-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Toggle Active -->
                                <button onclick="toggleActive({{ $gallery->id }})" 
                                        class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors duration-200 {{ $gallery->is_active ? 'bg-green-600' : 'bg-gray-200' }}">
                                    <span class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform duration-200 {{ $gallery->is_active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($galleries->hasPages())
                <div class="mt-8">
                    {{ $galleries->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Galeri</h3>
                <p class="text-gray-600 mb-4">Mulai dengan mengupload gambar pertama Anda</p>
                <a href="{{ route('admin.gallery.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Upload Gambar
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Bulk Upload Modal -->
<div id="bulkUploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Bulk Upload Images</h3>
            
            <form method="POST" action="{{ route('admin.gallery.bulk-upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Pilih Gambar</label>
                        <input type="file" 
                               id="images" 
                               name="images[]" 
                               multiple 
                               accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               required>
                        <p class="mt-1 text-sm text-gray-500">Pilih multiple gambar (max 20 files)</p>
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select id="category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="general">General</option>
                            <option value="kegiatan">Kegiatan</option>
                            <option value="prestasi">Prestasi</option>
                            <option value="fasilitas">Fasilitas</option>
                            <option value="event">Event</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="title_prefix" class="block text-sm font-medium text-gray-700 mb-2">Prefix Judul (Opsional)</label>
                        <input type="text" 
                               id="title_prefix" 
                               name="title_prefix" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="Contoh: Kegiatan Sekolah">
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeBulkUpload()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Gallery checkbox functionality
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.gallery-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
    
    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.gallery-checkbox:checked');
        if (checkedBoxes.length > 0) {
            bulkActions.style.display = 'block';
            selectedCount.textContent = `${checkedBoxes.length} item dipilih`;
        } else {
            bulkActions.style.display = 'none';
        }
    }
    
    window.clearSelection = function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateBulkActions();
    };
});

function openBulkUpload() {
    document.getElementById('bulkUploadModal').classList.remove('hidden');
}

function closeBulkUpload() {
    document.getElementById('bulkUploadModal').classList.add('hidden');
}

function toggleActive(galleryId) {
    fetch(`/admin/gallery/${galleryId}/toggle-active`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteGallery(galleryId) {
    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/gallery/${galleryId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection

