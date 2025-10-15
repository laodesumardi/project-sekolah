@extends('admin.layouts.app')

@section('page-title', 'Edit Pengaturan Halaman Tentang Kami')

@section('content')
<div class="p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-6 lg:mb-8">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Edit Pengaturan Halaman Tentang Kami</h1>
        <p class="text-gray-600">Ubah konten dan pengaturan halaman Tentang Kami</p>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.about-page-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Dasar</h2>
            
            <div class="space-y-6">
                <div>
                    <label for="page_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Halaman</label>
                    <input type="text" id="page_title" name="page_title" value="{{ old('page_title', $aboutPageSetting->page_title ?? '') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('page_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Sekolah</label>
                    <textarea id="description" name="description" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('description', $aboutPageSetting->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="vision" class="block text-sm font-medium text-gray-700 mb-2">Visi Sekolah</label>
                        <textarea id="vision" name="vision" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('vision', $aboutPageSetting->vision ?? '') }}</textarea>
                        @error('vision')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mission" class="block text-sm font-medium text-gray-700 mb-2">Misi Sekolah</label>
                        <textarea id="mission" name="mission" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('mission', $aboutPageSetting->mission ?? '') }}</textarea>
                        @error('mission')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="history" class="block text-sm font-medium text-gray-700 mb-2">Sejarah Sekolah</label>
                    <textarea id="history" name="history" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('history', $aboutPageSetting->history ?? '') }}</textarea>
                    @error('history')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Principal Information Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Kepala Sekolah</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label for="principal_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kepala Sekolah</label>
                        <input type="text" id="principal_name" name="principal_name" value="{{ old('principal_name', $aboutPageSetting->principal_name ?? '') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('principal_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="principal_title" class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                        <input type="text" id="principal_title" name="principal_title" value="{{ old('principal_title', $aboutPageSetting->principal_title ?? '') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('principal_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="principal_photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Kepala Sekolah</label>
                        
                        <!-- Current Photo Preview -->
                        @if($aboutPageSetting && $aboutPageSetting->principal_photo)
                            <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $aboutPageSetting->principal_photo_url }}" alt="Foto Kepala Sekolah Saat Ini" 
                                             class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">Foto Saat Ini</h4>
                                        <p class="text-sm text-gray-500">{{ $aboutPageSetting->principal_photo }}</p>
                                        <div class="mt-2 flex space-x-2">
                                            <button type="button" onclick="removeCurrentPhoto()" 
                                                    class="text-sm text-red-600 hover:text-red-800 font-medium">
                                                Hapus Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Upload Area -->
                        <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200" 
                             id="principal-photo-upload-area">
                            <div class="upload-content">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="mt-4">
                                    <label for="principal_photo" class="cursor-pointer">
                                        <span class="mt-2 block text-sm font-medium text-gray-900">
                                            Upload Foto Kepala Sekolah
                                        </span>
                                        <span class="mt-1 block text-sm text-gray-500">
                                            PNG, JPG, GIF hingga 2MB
                                        </span>
                                    </label>
                                    <input type="file" id="principal_photo" name="principal_photo" accept="image/*" 
                                           class="sr-only" onchange="previewPrincipalPhoto(this)">
                                </label>
                            </div>
                        </div>
                        
                        <!-- New Photo Preview -->
                        <div id="principal-photo-preview" class="hidden mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img id="principal-photo-preview-img" src="" alt="Preview Foto Baru" 
                                         class="w-20 h-20 rounded-full object-cover border-2 border-blue-300">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-blue-900">Foto Baru</h4>
                                    <p id="principal-photo-preview-name" class="text-sm text-blue-700"></p>
                                    <div class="mt-2">
                                        <button type="button" onclick="removeNewPhoto()" 
                                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                                            Batalkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @error('principal_photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="principal_message" class="block text-sm font-medium text-gray-700 mb-2">Pesan Kepala Sekolah</label>
                    <textarea id="principal_message" name="principal_message" rows="8" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('principal_message', $aboutPageSetting->principal_message ?? '') }}</textarea>
                    @error('principal_message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Images & Documents Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Gambar & Dokumen</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="school_photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Sekolah</label>
                    <input type="file" id="school_photo" name="school_photo" accept="image/*" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('school_photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($aboutPageSetting && $aboutPageSetting->school_photo)
                        <p class="mt-2 text-sm text-gray-600">Foto sekolah saat ini: {{ $aboutPageSetting->school_photo }}</p>
                    @endif
                </div>

                <div>
                    <label for="organization_chart" class="block text-sm font-medium text-gray-700 mb-2">Bagan Organisasi</label>
                    <input type="file" id="organization_chart" name="organization_chart" accept="image/*" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('organization_chart')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($aboutPageSetting && $aboutPageSetting->organization_chart)
                        <p class="mt-2 text-sm text-gray-600">Bagan organisasi saat ini: {{ $aboutPageSetting->organization_chart }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Tambahan</h2>
            
            <div class="space-y-6">
                <div>
                    <label for="achievements" class="block text-sm font-medium text-gray-700 mb-2">Prestasi & Pencapaian</label>
                    <textarea id="achievements" name="achievements" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('achievements', $aboutPageSetting->achievements ?? '') }}</textarea>
                    @error('achievements')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="facilities_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Fasilitas</label>
                    <textarea id="facilities_description" name="facilities_description" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('facilities_description', $aboutPageSetting->facilities_description ?? '') }}</textarea>
                    @error('facilities_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Kontak</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $aboutPageSetting->contact_phone ?? '') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('contact_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $aboutPageSetting->contact_email ?? '') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('contact_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                    <input type="url" id="website" name="website" value="{{ old('website', $aboutPageSetting->website ?? '') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('website')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <textarea id="contact_address" name="contact_address" rows="3" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('contact_address', $aboutPageSetting->contact_address ?? '') }}</textarea>
                @error('contact_address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row gap-4 pt-6">
            <button type="submit" 
                    class="inline-flex items-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Pengaturan
            </button>
            
            <a href="{{ route('admin.about-page-settings.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Batal
            </a>
        </div>
    </form>
</div>

@push('styles')
<style>
.upload-area {
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-area:hover {
    border-color: #3B82F6;
    background-color: #EFF6FF;
}

.upload-area.dragover {
    border-color: #3B82F6;
    background-color: #EFF6FF;
    transform: scale(1.02);
}

.upload-content {
    pointer-events: none;
}

.upload-area:hover .upload-content svg {
    color: #3B82F6;
}

.photo-preview {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.photo-preview img {
    transition: transform 0.2s ease;
}

.photo-preview img:hover {
    transform: scale(1.05);
}
</style>
@endpush

@push('scripts')
<script>
// Principal Photo Upload Functions
function previewPrincipalPhoto(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('principal-photo-preview');
            const previewImg = document.getElementById('principal-photo-preview-img');
            const previewName = document.getElementById('principal-photo-preview-name');
            
            previewImg.src = e.target.result;
            previewName.textContent = file.name;
            preview.classList.remove('hidden');
            preview.classList.add('photo-preview');
            
            // Hide upload area
            document.getElementById('principal-photo-upload-area').style.display = 'none';
        };
        
        reader.readAsDataURL(file);
    }
}

function removeNewPhoto() {
    const preview = document.getElementById('principal-photo-preview');
    const uploadArea = document.getElementById('principal-photo-upload-area');
    const fileInput = document.getElementById('principal_photo');
    
    preview.classList.add('hidden');
    uploadArea.style.display = 'block';
    fileInput.value = '';
}

function removeCurrentPhoto() {
    if (confirm('Apakah Anda yakin ingin menghapus foto kepala sekolah saat ini?')) {
        // Add hidden input to indicate photo should be removed
        const form = document.querySelector('form');
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'remove_principal_photo';
        hiddenInput.value = '1';
        form.appendChild(hiddenInput);
        
        // Hide current photo section
        const currentPhotoSection = document.querySelector('.mb-4.p-4.bg-gray-50');
        if (currentPhotoSection) {
            currentPhotoSection.style.display = 'none';
        }
        
        // Show upload area
        document.getElementById('principal-photo-upload-area').style.display = 'block';
    }
}

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('principal-photo-upload-area');
    const fileInput = document.getElementById('principal_photo');
    
    if (uploadArea) {
        // Drag and drop events
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                previewPrincipalPhoto(fileInput);
            }
        });
        
        // Click to upload
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('principal_photo');
    const file = fileInput.files[0];
    
    if (file) {
        // Check file size (2MB limit)
        if (file.size > 2 * 1024 * 1024) {
            e.preventDefault();
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            return;
        }
        
        // Check file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            e.preventDefault();
            alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
            return;
        }
    }
});
</script>
@endpush
@endsection
