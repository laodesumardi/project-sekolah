@extends('layouts.app')

@section('title', $extracurricular->name . ' - Ekstrakurikuler')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                <span class="sr-only">Home</span>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z"></path>
                                </svg>
                                <a href="{{ route('academic.extracurriculars') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Ekstrakurikuler</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z"></path>
                                </svg>
                                <span class="ml-4 text-sm font-medium text-gray-500">{{ $extracurricular->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Header -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $extracurricular->category }}
                                </span>
                                @if($extracurricular->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </div>
                            
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $extracurricular->name }}</h1>
                            
                            <div class="flex items-center space-x-6 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ ucfirst($extracurricular->schedule_day) }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $extracurricular->schedule_time->format('H:i') }}
                                </div>
                                @if($extracurricular->max_participants)
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Maks {{ $extracurricular->max_participants }} peserta
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($extracurricular->icon)
                            <div class="ml-6">
                                <img src="{{ asset('storage/' . $extracurricular->icon) }}" 
                                     alt="{{ $extracurricular->name }}" 
                                     class="w-20 h-20 rounded-lg object-cover">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($extracurricular->description)) !!}
                    </div>
                </div>

                <!-- Gallery -->
                @if($extracurricular->images->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Galeri</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($extracurricular->images as $image)
                                <div class="relative group cursor-pointer" onclick="openLightbox('{{ $image->image_url }}', '{{ $image->caption }}')">
                                    <img src="{{ $image->thumbnail_url }}" 
                                         alt="{{ $image->caption }}" 
                                         class="w-full h-32 object-cover rounded-lg group-hover:opacity-75 transition-opacity">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Related Extracurriculars -->
                @if($relatedExtracurriculars->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Ekstrakurikuler Lainnya</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($relatedExtracurriculars as $related)
                                <a href="{{ route('academic.extracurricular-detail', $related) }}" 
                                   class="block p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:shadow-md transition-all">
                                    <div class="flex items-center space-x-3">
                                        @if($related->icon)
                                            <img src="{{ asset('storage/' . $related->icon) }}" 
                                                 alt="{{ $related->name }}" 
                                                 class="w-12 h-12 rounded-lg object-cover">
                                        @endif
                                        <div class="flex-1">
                                            <h3 class="font-medium text-gray-900">{{ $related->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $related->category }}</p>
                                            <p class="text-xs text-gray-500">{{ ucfirst($related->schedule_day) }} - {{ $related->schedule_time->format('H:i') }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Instructor Info -->
                @if($extracurricular->instructor)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pembina</h3>
                        <div class="flex items-center space-x-4">
                            @if($extracurricular->instructor->photo)
                                <img src="{{ asset('storage/' . $extracurricular->instructor->photo) }}" 
                                     alt="{{ $extracurricular->instructor->name }}" 
                                     class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $extracurricular->instructor->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $extracurricular->instructor->subject }}</p>
                                @if($extracurricular->instructor->email)
                                    <p class="text-xs text-gray-500">{{ $extracurricular->instructor->email }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quick Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Kategori</span>
                            <span class="text-sm font-medium text-gray-900">{{ $extracurricular->category }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Hari</span>
                            <span class="text-sm font-medium text-gray-900">{{ ucfirst($extracurricular->schedule_day) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Waktu</span>
                            <span class="text-sm font-medium text-gray-900">{{ $extracurricular->schedule_time->format('H:i') }}</span>
                        </div>
                        @if($extracurricular->max_participants)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Kuota</span>
                                <span class="text-sm font-medium text-gray-900">{{ $extracurricular->max_participants }} peserta</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Status</span>
                            <span class="text-sm font-medium {{ $extracurricular->is_active ? 'text-green-600' : 'text-gray-600' }}">
                                {{ $extracurricular->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4">Informasi Pendaftaran</h3>
                    <p class="text-sm text-blue-800 mb-4">
                        Untuk mendaftar ekstrakurikuler ini, silakan hubungi pembina atau datang langsung ke sekolah.
                    </p>
                    <div class="space-y-2">
                        <p class="text-sm text-blue-700">
                            <strong>Waktu Pendaftaran:</strong><br>
                            Senin - Jumat, 07:00 - 15:00
                        </p>
                        <p class="text-sm text-blue-700">
                            <strong>Lokasi:</strong><br>
                            Ruang Ekstrakurikuler SMP Negeri 01 Namrole
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="lightbox-image" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        <p id="lightbox-caption" class="text-white text-center mt-4"></p>
    </div>
</div>

<script>
function openLightbox(imageSrc, caption) {
    document.getElementById('lightbox-image').src = imageSrc;
    document.getElementById('lightbox-caption').textContent = caption;
    document.getElementById('lightbox').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close lightbox when clicking outside
document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});

// Close lightbox with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});
</script>
@endsection

