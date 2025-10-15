@extends('admin.layouts.app')

@section('title', 'Edit Prestasi')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Page Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[#13315c]">Edit Prestasi</h1>
                    <nav class="flex items-center space-x-2 text-sm text-gray-600 mt-1">
                        <a href="{{ route('admin.achievements.index') }}" class="hover:text-[#13315c]">Prestasi</a>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <a href="{{ route('admin.achievements.index') }}" class="hover:text-[#13315c]">Prestasi</a>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="text-gray-500">Edit</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6">
        <form id="achievement-form" action="{{ route('admin.achievements.update', $achievement) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8" onsubmit="return validateForm()">
            @csrf
            @method('PUT')
            
            <!-- Main Form (70%) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Section 1: Informasi Dasar -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Dasar</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Judul Prestasi -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Prestasi *</label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $achievement->title) }}"
                                   placeholder="Contoh: Juara 1 Olimpiade Matematika Nasional"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent"
                                   required>
                            <div class="mt-1 text-xs text-gray-500">
                                <span id="char-count">{{ strlen($achievement->title) }}</span>/255 karakter
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="md:col-span-2">
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug (URL)</label>
                            <input type="text" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug', $achievement->slug) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent"
                                   readonly>
                            <div class="mt-1 text-xs text-gray-500">
                                URL: <span id="slug-preview">{{ url('/prestasi/') }}/</span>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                            <select id="category" 
                                    name="category" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent"
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $key => $value)
                                <option value="{{ $key }}" {{ old('category', $achievement->category) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tingkat Prestasi -->
                        <div>
                            <label for="achievement_level" class="block text-sm font-medium text-gray-700 mb-2">Tingkat Prestasi *</label>
                            <select id="achievement_level" 
                                    name="achievement_level" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent"
                                    required>
                                <option value="">Pilih Tingkat</option>
                                @foreach($levels as $key => $value)
                                <option value="{{ $key }}" {{ old('achievement_level', $achievement->achievement_level) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Peringkat -->
                        <div>
                            <label for="rank" class="block text-sm font-medium text-gray-700 mb-2">Peringkat yang Diraih *</label>
                            <input type="text" 
                                   id="rank" 
                                   name="rank" 
                                   value="{{ old('rank', $achievement->rank) }}"
                                   placeholder="Contoh: Juara 1, Medali Emas, Peringkat 3"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Detail Event/Lomba -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Detail Event/Lomba</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Event/Lomba -->
                        <div class="md:col-span-2">
                            <label for="event_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Event/Lomba/Kompetisi *</label>
                            <input type="text" 
                                   id="event_name" 
                                   name="event_name" 
                                   value="{{ old('event_name', $achievement->event_name) }}"
                                   placeholder="Contoh: Olimpiade Sains Nasional (OSN)"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent"
                                   required>
                        </div>

                        <!-- Penyelenggara -->
                        <div>
                            <label for="organizer" class="block text-sm font-medium text-gray-700 mb-2">Penyelenggara</label>
                            <input type="text" 
                                   id="organizer" 
                                   name="organizer" 
                                   value="{{ old('organizer', $achievement->organizer) }}"
                                   placeholder="Contoh: Kementerian Pendidikan dan Kebudayaan"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                        </div>

                        <!-- Tanggal Prestasi -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Prestasi Diraih *</label>
                            <input type="date" 
                                   id="date" 
                                   name="date" 
                                   value="{{ old('date', $achievement->date ? $achievement->date->format('Y-m-d') : '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent"
                                   required>
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                            <input type="text" 
                                   id="location" 
                                   name="location" 
                                   value="{{ old('location', $achievement->location) }}"
                                   placeholder="Contoh: Jakarta, Bandung, Surabaya"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                        </div>

                        <!-- Tahun -->
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                            <input type="number" 
                                   id="year" 
                                   name="year" 
                                   value="{{ old('year', $achievement->year) }}"
                                   placeholder="2024"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Deskripsi -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Deskripsi</h3>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Prestasi *</label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="10"
                                  placeholder="Ceritakan detail tentang prestasi ini..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent"
                                  required>{{ old('description', $achievement->description) }}</textarea>
                        <div class="mt-1 text-xs text-gray-500">
                            <span id="desc-char-count">{{ strlen($achievement->description) }}</span>/10000 karakter
                        </div>
                    </div>
                </div>


                <!-- Section 4: Informasi Tambahan -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Tambahan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hadiah/Prize -->
                        <div>
                            <label for="prize" class="block text-sm font-medium text-gray-700 mb-2">Hadiah & Penghargaan</label>
                            <textarea id="prize" 
                                      name="prize" 
                                      rows="3"
                                      placeholder="Contoh: Piala, Medali Emas, Uang Pembinaan Rp 10.000.000"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent">{{ old('prize', $achievement->prize) }}</textarea>
                        </div>

                        <!-- Skor/Nilai -->
                        <div>
                            <label for="score" class="block text-sm font-medium text-gray-700 mb-2">Skor/Nilai (jika applicable)</label>
                            <input type="text" 
                                   id="score" 
                                   name="score" 
                                   value="{{ old('score', $achievement->score) }}"
                                   placeholder="Contoh: 95.5, 450 poin"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                        </div>

                        <!-- Video URL -->
                        <div>
                            <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">Link Video (YouTube/Vimeo)</label>
                            <input type="url" 
                                   id="video_url" 
                                   name="video_url" 
                                   value="{{ old('video_url', $achievement->video_url) }}"
                                   placeholder="https://youtube.com/watch?v=..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                        </div>

                        <!-- Link Berita -->
                        <div>
                            <label for="news_url" class="block text-sm font-medium text-gray-700 mb-2">Link Berita/Artikel</label>
                            <input type="url" 
                                   id="news_url" 
                                   name="news_url" 
                                   value="{{ old('news_url', $achievement->news_url) }}"
                                   placeholder="https://..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sidebar (30%) -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Publish Settings -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Publikasi</h4>
                    
                    <div class="space-y-4">
                        <!-- Status Published -->
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Publikasikan</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_published" 
                                       value="1" 
                                       {{ old('is_published', $achievement->is_published) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#13315c]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#13315c]"></div>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">Prestasi akan ditampilkan di website</p>

                        <!-- Featured -->
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Unggulan</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       value="1" 
                                       {{ old('is_featured', $achievement->is_featured) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#13315c]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#13315c]"></div>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">Tampilkan di bagian unggulan</p>

                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $achievement->sort_order ?? 0) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Angka lebih kecil tampil lebih dulu</p>
                        </div>
                    </div>
                </div>
                    
                    <!-- Certificate Upload -->
                <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Foto Sertifikat</h4>
                        <p class="text-sm text-gray-500 mb-4">Format: JPG, PNG, PDF | Max: 5MB</p>
                        
                        @if($achievement->certificate_image)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                <div class="relative inline-block">
                                    <img src="{{ asset('storage/achievements/certificates/' . $achievement->certificate_image) }}" 
                                         alt="Current Certificate" 
                                         class="w-32 h-32 object-cover rounded-lg border"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-32 h-32 bg-gray-100 rounded-lg border flex items-center justify-center" style="display: none;">
                                        <i class="fas fa-certificate text-2xl text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div id="certificate-upload-area" 
                             class="w-full h-48 border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-[#13315c] hover:bg-blue-50 transition-colors"
                             onclick="document.getElementById('certificate_image').click()">
                            <i class="fas fa-certificate text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Upload Sertifikat</p>
                            <p class="text-xs text-gray-500">Klik atau drag & drop</p>
                        </div>
                        
                        <input type="file" 
                               id="certificate_image" 
                               name="certificate_image"
                               accept="image/jpeg,image/jpg,image/png,application/pdf"
                               class="hidden"
                               onchange="handleCertificateUpload(event)">
                        
                        <div id="certificate-preview-container" class="hidden w-full h-48 border border-gray-300 rounded-lg flex items-center justify-center">
                            <!-- Preview will be shown here -->
                        </div>
                    </div>

                    <!-- Trophy Upload -->
                <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Foto Piala/Medali</h4>
                        <p class="text-sm text-gray-500 mb-4">Format: JPG, PNG | Max: 5MB</p>
                        
                        @if($achievement->trophy_image)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                <div class="relative inline-block">
                                    <img src="{{ asset('storage/achievements/trophies/' . $achievement->trophy_image) }}" 
                                         alt="Current Trophy" 
                                         class="w-32 h-32 object-cover rounded-lg border"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-32 h-32 bg-gray-100 rounded-lg border flex items-center justify-center" style="display: none;">
                                        <i class="fas fa-trophy text-2xl text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div id="trophy-upload-area" 
                             class="w-full h-48 border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-[#13315c] hover:bg-blue-50 transition-colors"
                             onclick="document.getElementById('trophy_image').click()">
                            <i class="fas fa-trophy text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Upload Piala/Medali</p>
                            <p class="text-xs text-gray-500">Klik atau drag & drop</p>
                        </div>
                        
                        <input type="file" 
                               id="trophy_image" 
                               name="trophy_image" 
                               accept="image/jpeg,image/jpg,image/png"
                               class="hidden"
                               onchange="handleTrophyUpload(event)">
                        
                        <div id="trophy-preview-container" class="hidden w-full h-48 border border-gray-300 rounded-lg flex items-center justify-center">
                            <!-- Preview will be shown here -->
                        </div>
                    </div>

                <!-- Documentation Images -->
                <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Foto Dokumentasi</h4>
                    <p class="text-sm text-gray-500 mb-4">Upload multiple foto kegiatan | Max 10 foto | Max 3MB per foto</p>
                    
                    @php
                        $documentationImages = $achievement->getDocumentationImagesArray();
                    @endphp
                    
                    @if(!empty($documentationImages))
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                @foreach($documentationImages as $index => $image)
                                        <div class="relative">
                                            <img src="{{ asset('storage/achievements/documentation/' . $image) }}" 
                                                 alt="Documentation {{ $index + 1 }}" 
                                                 class="w-20 h-20 object-cover rounded-lg border"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="w-20 h-20 bg-gray-100 rounded-lg border flex items-center justify-center" style="display: none;">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <div id="documentation-upload-area" 
                             class="w-full h-32 border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-[#13315c] hover:bg-blue-50 transition-colors"
                             onclick="document.getElementById('documentation_images').click()">
                            <i class="fas fa-images text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm font-medium text-gray-700">Upload Multiple Foto</p>
                        <p class="text-xs text-gray-500">Drag & drop atau klik</p>
                        </div>
                        
                        <input type="file" 
                               id="documentation_images" 
                               name="documentation_images[]"
                               accept="image/jpeg,image/jpg,image/png"
                           multiple
                               class="hidden"
                               onchange="handleDocumentationUpload(event)">
                        
                        <div id="documentation-preview-container" class="hidden mt-4">
                            <!-- Preview will be shown here -->
                </div>
            </div>

                <!-- Save Buttons -->
                    <div class="space-y-3">
                    <button type="submit" 
                            class="w-full bg-[#13315c] text-white px-4 py-3 rounded-lg hover:bg-[#1e4d8b] transition-colors font-semibold">
                            <i class="fas fa-save mr-2"></i>Update Prestasi
                        </button>
                    
                    <button type="button" 
                            onclick="saveDraft()" 
                            class="w-full bg-gray-200 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-300 transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan sebagai Draft
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    
    document.getElementById('slug').value = slug;
    document.getElementById('slug-preview').textContent = '{{ url('/prestasi/') }}/' + slug;
    
    // Update character count
    document.getElementById('char-count').textContent = e.target.value.length;
});

// Update description character count
document.getElementById('description').addEventListener('input', function(e) {
    document.getElementById('desc-char-count').textContent = e.target.value.length;
});


// Form validation
function validateForm() {
    console.log('Validating form...');
    
    // Check if certificate file is selected
    const certificateFile = document.getElementById('certificate_image').files[0];
    if (certificateFile) {
        console.log('Certificate file:', certificateFile.name);
    }
    
    // Check if trophy file is selected
    const trophyFile = document.getElementById('trophy_image').files[0];
    if (trophyFile) {
        console.log('Trophy file:', trophyFile.name);
    }
    
    // Check documentation files
    const docFiles = document.getElementById('documentation_images').files;
    if (docFiles.length > 0) {
        console.log('Documentation files:', docFiles.length);
    }
    
    return true;
}

// File upload handlers
function handleCertificateUpload(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    console.log('Certificate file selected:', file.name, file.type, file.size);
    
    // Validate type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
    if (!allowedTypes.includes(file.type)) {
        alert('Format tidak didukung. Hanya JPG, PNG, dan PDF yang diperbolehkan.');
        event.target.value = '';
        return;
    }
    
    // Validate size (5MB)
    if (file.size > 5242880) {
        alert('File terlalu besar. Ukuran file maksimal 5MB.');
        event.target.value = '';
        return;
    }
    
    showFilePreview(file, 'certificate');
}

function handleTrophyUpload(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    console.log('Trophy file selected:', file.name, file.type, file.size);
    
    // Validate type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!allowedTypes.includes(file.type)) {
        alert('Format tidak didukung. Hanya JPG dan PNG yang diperbolehkan.');
        event.target.value = '';
        return;
    }
    
    // Validate size (5MB)
    if (file.size > 5242880) {
        alert('File terlalu besar. Ukuran file maksimal 5MB.');
        event.target.value = '';
        return;
    }
    
    showFilePreview(file, 'trophy');
}

function handleDocumentationUpload(event) {
    const files = Array.from(event.target.files);
    
    // Validate files
    for (let file of files) {
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert(`File ${file.name} tidak didukung. Hanya JPG dan PNG yang diperbolehkan.`);
            return;
        }
        
        if (file.size > 3145728) { // 3MB
            alert(`File ${file.name} terlalu besar. Ukuran file maksimal 3MB.`);
            return;
        }
    }
    
    if (files.length > 10) {
        alert('Maksimal 10 foto dokumentasi.');
        return;
    }
    
    showDocumentationPreview(files);
}

function showFilePreview(file, type) {
    console.log('Showing preview for:', type, file.name, file.type, file.size);
    const reader = new FileReader();
    
    reader.onload = function(e) {
        console.log('FileReader loaded, hiding upload area and showing preview');
        console.log('File result length:', e.target.result.length);
        
        // Hide upload area
        const uploadArea = document.getElementById(`${type}-upload-area`);
        if (uploadArea) {
            uploadArea.classList.add('hidden');
            console.log('Upload area hidden');
        }
        
        // Show preview container
        const previewContainer = document.getElementById(`${type}-preview-container`);
        if (previewContainer) {
        previewContainer.classList.remove('hidden');
            console.log('Preview container shown');
        
        if (file.type === 'application/pdf') {
            previewContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full p-4">
                    <i class="fas fa-file-pdf text-6xl text-red-500 mb-4"></i>
                    <p class="text-sm font-semibold text-gray-700 text-center">${file.name}</p>
                    <p class="text-xs text-gray-500">${formatFileSize(file.size)}</p>
                    <div class="mt-4 space-y-2">
                        <button type="button" onclick="viewPDF('${e.target.result}')" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                            <i class="fas fa-eye mr-2"></i>Lihat PDF
                        </button>
                        <button type="button" onclick="removeFile('${type}')" class="w-full px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </div>
                </div>
            `;
        } else {
            previewContainer.innerHTML = `
                <div class="relative w-full h-full p-2">
                    <img src="${e.target.result}" alt="Preview" class="w-full h-full object-contain rounded-lg border">
                    <div class="absolute top-2 right-2">
                        <button type="button" onclick="removeFile('${type}')" class="bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition-colors shadow-lg">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                    <div class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                        ${file.name} (${formatFileSize(file.size)})
                    </div>
                </div>
            `;
            }
        } else {
            console.error('Preview container not found:', `${type}-preview-container`);
        }
    };
    
    reader.onerror = function() {
        console.error('FileReader error');
        alert('Error membaca file. Silakan coba lagi.');
    };
    
    reader.readAsDataURL(file);
}

function showDocumentationPreview(files) {
    const container = document.getElementById('documentation-preview-container');
    container.classList.remove('hidden');
    
    let html = '<div class="grid grid-cols-2 md:grid-cols-4 gap-4">';
    
    files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            html += `
                <div class="relative">
                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-24 object-cover rounded-lg">
                    <button type="button" onclick="removeDocumentationImage(this)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            `;
            
            if (index === files.length - 1) {
                html += '</div>';
                container.innerHTML = html;
            }
        };
        reader.readAsDataURL(file);
    });
}

function removeFile(type) {
    console.log('Removing file for type:', type);
    
    // Clear file input
    const fileInput = document.getElementById(`${type}_image`);
    if (fileInput) {
        fileInput.value = '';
        console.log('File input cleared');
    }
    
    // Show upload area
    const uploadArea = document.getElementById(`${type}-upload-area`);
    if (uploadArea) {
        uploadArea.classList.remove('hidden');
        console.log('Upload area shown');
    }
    
    // Hide preview container
    const previewContainer = document.getElementById(`${type}-preview-container`);
    if (previewContainer) {
        previewContainer.classList.add('hidden');
        console.log('Preview container hidden');
    }
}

function removeDocumentationImage(button) {
    button.closest('.relative').remove();
}

function viewPDF(dataUrl) {
    const newWindow = window.open();
    newWindow.document.write(`
        <html>
            <head><title>PDF Preview</title></head>
            <body style="margin:0; padding:0;">
                <embed src="${dataUrl}" type="application/pdf" width="100%" height="100%">
            </body>
        </html>
    `);
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function saveDraft() {
    document.querySelector('input[name="is_published"]').checked = false;
    document.getElementById('achievement-form').submit();
}

// Initialize participant section
updateParticipantSection();
</script>
@endsection

