@extends('layouts.app')

@section('title', 'Galeri Sekolah')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 transition-colors">
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Galeri</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl xl:text-5xl font-bold text-gray-900 mb-4" style="color: #13315c;">
                    Galeri Sekolah
                </h1>
                <p class="text-lg xl:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Dokumentasi kegiatan dan prestasi siswa-siswi SMP Negeri 01 Namrole
                </p>
            </div>
        </div>
    </div>

    <!-- Featured Albums Carousel -->
    @if($featuredGalleries->count() > 0)
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl xl:text-4xl font-bold text-gray-900 mb-4" style="color: #13315c;">
                    ⭐ Album Unggulan
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Koleksi foto terbaik dari berbagai kegiatan sekolah
                </p>
            </div>
            <div class="relative">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach($featuredGalleries as $gallery)
                    <div class="group relative overflow-hidden rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 bg-white">
                        <div class="relative" style="aspect-ratio: 16/9;">
                            <img 
                                src="{{ $gallery->cover_image_url }}" 
                                alt="{{ $gallery->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                loading="lazy"
                            >
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-6 left-6 right-6">
                                    <h3 class="text-white font-bold text-xl mb-3 line-clamp-2">
                                        {{ $gallery->title }}
                                    </h3>
                                    <div class="flex items-center justify-between text-white text-sm">
                                        <span class="flex items-center bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $gallery->total_photos }} Foto
                                        </span>
                                        <span class="flex items-center bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $gallery->view_count }} views
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white shadow-lg" style="background-color: #13315c;">
                                {{ $gallery->category_name }}
                            </span>
                        </div>
                        <!-- Featured Badge -->
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white bg-yellow-500 shadow-lg">
                                ⭐ Unggulan
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Filter & Search Section -->
    <div class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">
                <!-- Category Filter -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#13315c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter Kategori
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        <button 
                            onclick="filterByCategory('all')" 
                            class="category-filter active px-6 py-3 rounded-full text-sm font-medium transition-all duration-300 border-2 border-gray-300 text-gray-700 hover:border-[#13315c] hover:text-[#13315c] hover:shadow-md"
                            data-category="all"
                        >
                            Semua
                        </button>
                        @foreach($categories as $key => $label)
                            @if($key !== 'all')
                            <button 
                                onclick="filterByCategory('{{ $key }}')" 
                                class="category-filter px-6 py-3 rounded-full text-sm font-medium transition-all duration-300 border-2 border-gray-300 text-gray-700 hover:border-[#13315c] hover:text-[#13315c] hover:shadow-md"
                                data-category="{{ $key }}"
                            >
                                {{ $label }}
                            </button>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Search & Sort -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search Box -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="search-input"
                            placeholder="Cari galeri..." 
                            class="block w-full sm:w-80 pl-12 pr-12 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-[#13315c] focus:border-[#13315c] text-sm transition-all duration-300"
                            onkeyup="debounceSearch()"
                        >
                        <button 
                            onclick="clearSearch()" 
                            id="clear-search"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center hidden"
                        >
                            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="relative">
                        <select 
                            id="sort-select"
                            onchange="handleSort()"
                            class="block w-full sm:w-auto px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-[#13315c] focus:border-[#13315c] text-sm transition-all duration-300 appearance-none bg-white pr-10"
                        >
                            <option value="recent">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="views">Paling Banyak Dilihat</option>
                            <option value="title_asc">Judul (A-Z)</option>
                            <option value="title_desc">Judul (Z-A)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div id="gallery-container">
            @include('gallery.partials.gallery-grid', ['galleries' => $galleries])
        </div>
    </div>
</div>

<!-- Loading State -->
<div id="loading-state" class="hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @for($i = 0; $i < 6; $i++)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden animate-pulse">
                <div class="h-72 bg-gray-300"></div>
                <div class="p-6">
                    <div class="h-5 bg-gray-300 rounded mb-3"></div>
                    <div class="h-4 bg-gray-300 rounded w-3/4 mb-4"></div>
                    <div class="flex justify-between">
                        <div class="h-3 bg-gray-300 rounded w-1/4"></div>
                        <div class="h-3 bg-gray-300 rounded w-1/4"></div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

<script>
let searchTimeout;

// Category Filter
function filterByCategory(category) {
    // Update active state
    document.querySelectorAll('.category-filter').forEach(btn => {
        btn.classList.remove('active', 'bg-primary-500', 'text-white', 'border-primary-500');
        btn.classList.add('border-gray-300', 'text-gray-700');
    });
    
    document.querySelector(`[data-category="${category}"]`).classList.add('active', 'bg-primary-500', 'text-white', 'border-primary-500');
    document.querySelector(`[data-category="${category}"]`).classList.remove('border-gray-300', 'text-gray-700');
    
    // Filter galleries
    filterGalleries();
}

// Search with debounce
function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        filterGalleries();
    }, 500);
}

// Clear search
function clearSearch() {
    document.getElementById('search-input').value = '';
    document.getElementById('clear-search').classList.add('hidden');
    filterGalleries();
}

// Handle sort
function handleSort() {
    filterGalleries();
}

// Filter galleries
function filterGalleries() {
    const category = document.querySelector('.category-filter.active').dataset.category;
    const search = document.getElementById('search-input').value;
    const sort = document.getElementById('sort-select').value;
    
    // Show loading
    document.getElementById('gallery-container').innerHTML = '';
    document.getElementById('loading-state').classList.remove('hidden');
    
    // Fetch filtered results
    fetch(`{{ route('gallery.filter') }}?category=${category}&search=${encodeURIComponent(search)}&sort=${sort}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('gallery-container').innerHTML = html;
            document.getElementById('loading-state').classList.add('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('loading-state').classList.add('hidden');
        });
}

// Show/hide clear button
document.getElementById('search-input').addEventListener('input', function() {
    const clearBtn = document.getElementById('clear-search');
    if (this.value) {
        clearBtn.classList.remove('hidden');
    } else {
        clearBtn.classList.add('hidden');
    }
});
</script>

<style>
.category-filter.active {
    background-color: #13315c;
    color: white;
    border-color: #13315c;
    box-shadow: 0 4px 12px rgba(19, 49, 92, 0.3);
}

.category-filter:hover {
    border-color: #13315c;
    color: #13315c;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(19, 49, 92, 0.2);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Desktop optimizations */
@media (min-width: 1280px) {
    .category-filter {
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
    }
    
    .category-filter:hover {
        transform: translateY(-3px);
    }
}

/* Enhanced hover effects for desktop */
@media (min-width: 1024px) {
    .gallery-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
}
</style>
@endsection
