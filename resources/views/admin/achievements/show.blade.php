@extends('admin.layouts.app')

@section('page-title', 'Detail Prestasi')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Prestasi</h1>
            <p class="text-gray-600">Informasi lengkap prestasi</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.achievements.edit', $achievement) }}" 
               class="inline-flex items-center px-4 py-2 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.achievements.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Achievement Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <!-- Header with Certificate -->
                <div class="flex items-start space-x-6 mb-6">
                    <div class="flex-shrink-0">
                        @if($achievement->certificate_image)
                            <img src="{{ $achievement->certificate_url }}" alt="{{ $achievement->title }}" class="w-32 h-32 object-cover rounded-lg">
                        @else
                            <div class="w-32 h-32 bg-gray-300 rounded-lg flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $achievement->title }}</h2>
                            @if($achievement->is_featured)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Unggulan
                                </span>
                            @endif
                        </div>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                {{ $achievement->category }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tingkat Prestasi</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $achievement->formatted_level }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Peringkat</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $achievement->rank }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tipe Peserta</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $achievement->formatted_participant_type }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $achievement->date->format('d M Y') }}</p>
                    </div>

                    @if($achievement->competition_name)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lomba</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $achievement->competition_name }}</p>
                        </div>
                    @endif

                    @if($achievement->organizer)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Penyelenggara</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $achievement->organizer }}</p>
                        </div>
                    @endif
                </div>

                <!-- Participants -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-500 mb-2">Nama Peserta</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $achievement->participant_names }}</p>
                </div>

                @if($achievement->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Deskripsi</label>
                        <div class="prose max-w-none">
                            <p class="text-gray-700">{{ $achievement->description }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.achievements.edit', $achievement) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-secondary-500 text-white rounded-lg hover:bg-secondary-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Prestasi
                    </a>
                    
                    <button onclick="toggleFeatured({{ $achievement->id }})" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 {{ $achievement->is_featured ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-gray-500 hover:bg-gray-600' }} text-white rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        {{ $achievement->is_featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}
                    </button>
                    
                    <button onclick="deleteAchievement({{ $achievement->id }})" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Prestasi
                    </button>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Dibuat</span>
                        <span class="text-sm font-medium text-gray-900">{{ $achievement->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Diupdate</span>
                        <span class="text-sm font-medium text-gray-900">{{ $achievement->updated_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Status</span>
                        <span class="text-sm font-medium {{ $achievement->is_featured ? 'text-yellow-600' : 'text-gray-600' }}">
                            {{ $achievement->is_featured ? 'Unggulan' : 'Biasa' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Kategori</span>
                        <span class="text-sm font-medium text-gray-900">{{ $achievement->category }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Tingkat</span>
                        <span class="text-sm font-medium text-gray-900">{{ $achievement->formatted_level }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Tahun</span>
                        <span class="text-sm font-medium text-gray-900">{{ $achievement->year }}</span>
                    </div>
                </div>
            </div>

            <!-- Certificate -->
            @if($achievement->certificate_image)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Sertifikat</h3>
                    <div class="text-center">
                        <img src="{{ $achievement->certificate_url }}" alt="{{ $achievement->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
                        <a href="{{ $achievement->certificate_url }}" 
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Sertifikat
                        </a>
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
// Toggle featured status
function toggleFeatured(achievementId) {
    fetch(`/admin/achievements/${achievementId}/toggle-featured`, {
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

// Delete achievement
function deleteAchievement(achievementId) {
    if (confirm('Apakah Anda yakin ingin menghapus prestasi ini? Tindakan ini tidak dapat dibatalkan.')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/achievements/${achievementId}`;
        form.submit();
    }
}
</script>
@endsection

