@extends('layouts.app')

@section('title', 'Galeri - SMP Negeri 01 Namrole')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Galeri', 'url' => null]
]" />

<!-- Page Header -->
<x-page-header 
    title="Galeri Sekolah" 
    subtitle="Koleksi foto kegiatan, prestasi, dan momen berharga di SMP Negeri 01 Namrole" 
/>

<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filter Pills -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-2 justify-center">
                <a href="{{ route('gallery') }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ !request('category') || request('category') === 'all' ? 'bg-primary-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Semua
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('gallery', ['category' => $category->category]) }}" 
                       class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ request('category') === $category->category ? 'bg-primary-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                        {{ ucfirst($category->category) }} ({{ $category->count }})
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Sort Options -->
        <div class="mb-8 flex justify-center">
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">Urutkan:</span>
                <select id="sortSelect" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nama</option>
                </select>
            </div>
        </div>

        @if($galleries->count() > 0)
            <!-- Gallery Grid -->
            <div id="galleryGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($galleries as $gallery)
                    <div class="gallery-item bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 cursor-pointer group"
                         data-gallery-id="{{ $gallery->id }}"
                         data-title="{{ $gallery->title }}"
                         data-description="{{ $gallery->description }}"
                         data-image="{{ $gallery->image_url }}"
                         data-category="{{ $gallery->category }}"
                         data-file-size="{{ $gallery->formatted_file_size }}"
                         data-dimensions="{{ $gallery->dimensions }}">
                        
                        <!-- Image -->
                        <div class="relative overflow-hidden">
                            <img src="{{ $gallery->thumbnail_url }}" 
                                 alt="{{ $gallery->alt_text ?: $gallery->title }}"
                                 class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-white text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <p class="text-sm font-medium">Lihat Detail</p>
                                </div>
                            </div>

                            <!-- Category Badge -->
                            <div class="absolute top-2 left-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-white bg-opacity-90 text-gray-700">
                                    {{ ucfirst($gallery->category) }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $gallery->title }}</h3>
                            @if($gallery->description)
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $gallery->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $galleries->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Galeri</h3>
                <p class="text-gray-600">Galeri sekolah akan segera ditambahkan.</p>
            </div>
        @endif
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="max-w-4xl w-full">
            <!-- Close Button -->
            <button id="closeLightbox" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Navigation -->
            <button id="prevImage" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button id="nextImage" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Image -->
            <div class="text-center">
                <img id="lightboxImage" src="" alt="" class="max-w-full max-h-[80vh] object-contain mx-auto rounded-lg">
            </div>

            <!-- Info -->
            <div class="mt-6 text-center text-white">
                <h3 id="lightboxTitle" class="text-xl font-semibold mb-2"></h3>
                <p id="lightboxDescription" class="text-gray-300 mb-4"></p>
                <div class="flex justify-center space-x-4 text-sm text-gray-400">
                    <span id="lightboxCategory"></span>
                    <span id="lightboxFileSize"></span>
                    <span id="lightboxDimensions"></span>
                </div>
            </div>

            <!-- Download Button -->
            <div class="mt-4 text-center">
                <a id="downloadButton" href="#" download class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxTitle = document.getElementById('lightboxTitle');
    const lightboxDescription = document.getElementById('lightboxDescription');
    const lightboxCategory = document.getElementById('lightboxCategory');
    const lightboxFileSize = document.getElementById('lightboxFileSize');
    const lightboxDimensions = document.getElementById('lightboxDimensions');
    const downloadButton = document.getElementById('downloadButton');
    const closeLightbox = document.getElementById('closeLightbox');
    const prevImage = document.getElementById('prevImage');
    const nextImage = document.getElementById('nextImage');
    
    let currentIndex = 0;
    let galleryData = [];

    // Collect gallery data
    galleryItems.forEach((item, index) => {
        galleryData.push({
            id: item.dataset.galleryId,
            title: item.dataset.title,
            description: item.dataset.description,
            image: item.dataset.image,
            category: item.dataset.category,
            fileSize: item.dataset.fileSize,
            dimensions: item.dataset.dimensions
        });
    });

    // Open lightbox
    galleryItems.forEach((item, index) => {
        item.addEventListener('click', function() {
            currentIndex = index;
            showLightbox(index);
        });
    });

    function showLightbox(index) {
        const data = galleryData[index];
        lightboxImage.src = data.image;
        lightboxImage.alt = data.title;
        lightboxTitle.textContent = data.title;
        lightboxDescription.textContent = data.description || '';
        lightboxCategory.textContent = data.category;
        lightboxFileSize.textContent = data.fileSize;
        lightboxDimensions.textContent = data.dimensions;
        downloadButton.href = `/galeri/${data.id}/download`;
        
        lightbox.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function hideLightbox() {
        lightbox.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function showPrev() {
        currentIndex = (currentIndex - 1 + galleryData.length) % galleryData.length;
        showLightbox(currentIndex);
    }

    function showNext() {
        currentIndex = (currentIndex + 1) % galleryData.length;
        showLightbox(currentIndex);
    }

    // Event listeners
    closeLightbox.addEventListener('click', hideLightbox);
    prevImage.addEventListener('click', showPrev);
    nextImage.addEventListener('click', showNext);

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideLightbox();
        } else if (e.key === 'ArrowLeft') {
            showPrev();
        } else if (e.key === 'ArrowRight') {
            showNext();
        }
    });

    // Close on background click
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            hideLightbox();
        }
    });

    // Sort functionality
    const sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const url = new URL(window.location);
            url.searchParams.set('sort', this.value);
            window.location.href = url.toString();
        });
    }
});
</script>
@endsection

