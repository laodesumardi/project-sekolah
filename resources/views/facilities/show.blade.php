@extends('layouts.app')

@section('title', $facility->name . ' - Fasilitas Sekolah')
@section('description', Str::limit($facility->description, 160))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Breadcrumb -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('facilities.index') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">Fasilitas</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">{{ $facility->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <!-- Left Column - Image & Gallery -->
            <div class="xl:col-span-3">
                <!-- Main Image -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                    <div class="relative w-full" style="aspect-ratio: 16/9;">
                        <img 
                            id="main-image"
                            src="{{ $facility->image_url }}" 
                            alt="{{ $facility->name }}" 
                            class="w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform duration-300"
                            onclick="openLightbox()"
                            loading="lazy"
                        >
                        <!-- Image Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-300 cursor-pointer" onclick="openLightbox()">
                            <div class="absolute bottom-4 right-4 bg-white bg-opacity-90 rounded-full p-2 transform hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Lightbox Modal -->
                <div id="lightbox-modal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4">
                    <div class="relative max-w-7xl max-h-full">
                        <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <img 
                            id="lightbox-image"
                            src="{{ $facility->image_url }}" 
                            alt="{{ $facility->name }}" 
                            class="max-w-full max-h-full object-contain"
                        >
                    </div>
                </div>
            </div>

            <!-- Right Column - Detail Information -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-2xl xl:text-3xl font-bold text-[#13315c] mb-3 leading-tight">{{ $facility->name }}</h1>
                        
                        <!-- Category Badge -->
                        <span class="inline-block bg-[#13315c] text-white text-sm uppercase px-4 py-2 rounded-full mb-4 font-medium">
                            {{ $facility->category_name }}
                        </span>
                        
                        <!-- Status Badge -->
                        <div class="mb-6">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $facility->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    @if($facility->is_available)
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    @else
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    @endif
                                </svg>
                                {{ $facility->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                    </div>

                    <!-- Quick Info Cards -->
                    <div class="grid grid-cols-1 gap-4 mb-8">
                        @if($facility->capacity)
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-5 border border-blue-200">
                            <div class="flex items-center">
                                <div class="p-3 bg-blue-500 rounded-xl mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-600 font-medium">Kapasitas</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $facility->getFormattedCapacity() }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($facility->location)
                        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-5 border border-green-200">
                            <div class="flex items-center">
                                <div class="p-3 bg-green-500 rounded-xl mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-green-600 font-medium">Lokasi</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $facility->location }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($facility->floor)
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-5 border border-purple-200">
                            <div class="flex items-center">
                                <div class="p-3 bg-purple-500 rounded-xl mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-purple-600 font-medium">Lantai</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $facility->floor }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Description Section -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#13315c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Deskripsi
                        </h2>
                        <div class="text-gray-700 leading-relaxed text-sm xl:text-base">
                            {!! nl2br(e($facility->description)) !!}
                        </div>
                    </div>

                    <!-- Specifications Section -->
                    @if($facility->facilities_spec)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#13315c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Spesifikasi & Fasilitas
                        </h2>
                        <div class="space-y-3">
                            @foreach($facility->getSpecificationsArray() as $spec)
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700 text-sm xl:text-base">{{ trim($spec) }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Share Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#13315c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                            </svg>
                            Bagikan
                        </h3>
                        <div class="grid grid-cols-2 gap-2">
                            <button onclick="shareOnFacebook()" class="flex items-center justify-center px-3 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-colors text-sm">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </button>
                            <button onclick="shareOnTwitter()" class="flex items-center justify-center px-3 py-2 border border-blue-400 text-blue-400 rounded-lg hover:bg-blue-400 hover:text-white transition-colors text-sm">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                                Twitter
                            </button>
                            <button onclick="shareOnWhatsApp()" class="flex items-center justify-center px-3 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors text-sm">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                                WhatsApp
                            </button>
                            <button onclick="copyLink()" class="flex items-center justify-center px-3 py-2 border border-gray-600 text-gray-600 rounded-lg hover:bg-gray-600 hover:text-white transition-colors text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Salin Link
                            </button>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <a href="{{ route('facilities.index') }}" class="w-full flex items-center justify-center px-4 py-3 border-2 border-[#13315c] text-[#13315c] rounded-xl hover:bg-[#13315c] hover:text-white transition-all duration-300 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar Fasilitas
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Facilities -->
        @if($relatedFacilities->count() > 0)
        <div class="mt-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#13315c] mb-4">Fasilitas Terkait</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Temukan fasilitas lain yang mungkin menarik untuk Anda</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($relatedFacilities as $relatedFacility)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 cursor-pointer group" onclick="window.location.href='{{ route('facilities.show', $relatedFacility->slug) }}'">
                    <div class="relative w-full overflow-hidden rounded-t-2xl" style="aspect-ratio: 16/9;">
                        <img 
                            src="{{ $relatedFacility->image_url }}" 
                            alt="{{ $relatedFacility->name }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[#13315c] mb-3 group-hover:text-blue-600 transition-colors">{{ $relatedFacility->name }}</h3>
                        <p class="text-gray-600 line-clamp-2 leading-relaxed">{{ Str::limit($relatedFacility->description, 120) }}</p>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Detail
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function openLightbox() {
    document.getElementById('lightbox-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox-modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close lightbox on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});

// Close lightbox on click outside image
document.getElementById('lightbox-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});

// Share functions
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
}

function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('{{ $facility->name }} - Fasilitas Sekolah');
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
}

function shareOnWhatsApp() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('{{ $facility->name }} - Fasilitas Sekolah');
    window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Copied!';
        button.classList.add('bg-green-600', 'text-white');
        button.classList.remove('border-gray-600', 'text-gray-600');
        
        setTimeout(function() {
            button.innerHTML = originalText;
            button.classList.remove('bg-green-600', 'text-white');
            button.classList.add('border-gray-600', 'text-gray-600');
        }, 2000);
    });
}
</script>
@endpush
@endsection
