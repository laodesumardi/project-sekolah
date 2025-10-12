@extends('admin.layouts.app')

@section('page-title', 'Detail Ekstrakurikuler')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Ekstrakurikuler</h1>
            <p class="text-gray-600">Informasi lengkap ekstrakurikuler</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.extracurriculars.edit', $extracurricular) }}" 
               class="inline-flex items-center px-4 py-2 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.extracurriculars.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Extracurricular Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <!-- Header with Image -->
                <div class="flex items-start space-x-6 mb-6">
                    <div class="flex-shrink-0">
                        @if($extracurricular->icon)
                            <img src="{{ $extracurricular->icon_url }}" alt="{{ $extracurricular->name }}" class="w-20 h-20 object-cover rounded-lg">
                        @else
                            <div class="w-20 h-20 bg-gray-300 rounded-lg flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $extracurricular->name }}</h2>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $extracurricular->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $extracurricular->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                {{ $extracurricular->category }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    @if($extracurricular->instructor)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Pembina/Pelatih</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $extracurricular->instructor->user->name }}</p>
                        </div>
                    @endif

                    @if($extracurricular->schedule_day && $extracurricular->schedule_time)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Jadwal</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $extracurricular->formatted_schedule }}</p>
                        </div>
                    @endif

                    @if($extracurricular->max_participants)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kuota Maksimal</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $extracurricular->max_participants }} peserta</p>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $extracurricular->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                @if($extracurricular->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Deskripsi</label>
                        <div class="prose max-w-none">
                            <p class="text-gray-700">{{ $extracurricular->description }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Gallery -->
            @if($extracurricular->images->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Galeri Foto</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($extracurricular->images as $image)
                            <div class="relative group">
                                <img src="{{ $image->image_url }}" alt="{{ $image->caption }}" class="w-full h-32 object-cover rounded-lg">
                                @if($image->caption)
                                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 rounded-b-lg">
                                        <p class="text-xs">{{ $image->caption }}</p>
                                    </div>
                                @endif
                                <button type="button" 
                                        onclick="deleteImage({{ $image->id }})"
                                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.extracurriculars.edit', $extracurricular) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Ekstrakurikuler
                    </a>
                    
                    <button onclick="toggleActive({{ $extracurricular->id }})" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 {{ $extracurricular->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                        </svg>
                        {{ $extracurricular->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                    
                    <button onclick="deleteExtracurricular({{ $extracurricular->id }})" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Ekstrakurikuler
                    </button>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Dibuat</span>
                        <span class="text-sm font-medium text-gray-900">{{ $extracurricular->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Diupdate</span>
                        <span class="text-sm font-medium text-gray-900">{{ $extracurricular->updated_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Status</span>
                        <span class="text-sm font-medium {{ $extracurricular->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $extracurricular->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Kategori</span>
                        <span class="text-sm font-medium text-gray-900">{{ $extracurricular->category }}</span>
                    </div>
                    @if($extracurricular->max_participants)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Kuota</span>
                            <span class="text-sm font-medium text-gray-900">{{ $extracurricular->max_participants }} peserta</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Galeri</span>
                        <span class="text-sm font-medium text-gray-900">{{ $extracurricular->images->count() }} foto</span>
                    </div>
                </div>
            </div>

            <!-- Instructor Info -->
            @if($extracurricular->instructor)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembina</h3>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            @if($extracurricular->instructor->user->avatar)
                                <img src="{{ asset('storage/avatars/' . $extracurricular->instructor->user->avatar) }}" alt="{{ $extracurricular->instructor->user->name }}" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $extracurricular->instructor->user->name }}</p>
                            @if($extracurricular->instructor->subject)
                                <p class="text-sm text-gray-500">{{ $extracurricular->instructor->subject }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
// Toggle active status
function toggleActive(extracurricularId) {
    fetch(`/admin/extracurriculars/${extracurricularId}/toggle-active`, {
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
    .catch(error => {
        console.error('Error:', error);
    });
}

// Delete extracurricular
function deleteExtracurricular(extracurricularId) {
    if (confirm('Apakah Anda yakin ingin menghapus ekstrakurikuler ini? Tindakan ini tidak dapat dibatalkan.')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/extracurriculars/${extracurricularId}`;
        form.submit();
    }
}

// Delete image
function deleteImage(imageId) {
    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
        fetch(`/admin/extracurricular-images/${imageId}`, {
            method: 'DELETE',
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
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
</script>
@endsection

