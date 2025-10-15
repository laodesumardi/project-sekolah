@extends('layouts.app')

@section('title', 'Fasilitas Sekolah')
@section('description', 'Berbagai fasilitas lengkap untuk mendukung kegiatan belajar mengajar di SMP Negeri 01 Namrole')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
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
                            <span class="ml-1 text-gray-500 md:ml-2">Fasilitas</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="text-center">
                <h1 class="text-4xl font-bold text-[#13315c] mb-4">Fasilitas Sekolah</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Berbagai fasilitas lengkap untuk mendukung kegiatan belajar mengajar
                </p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <!-- Category Filter -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kategori Fasilitas</h3>
                <div class="flex flex-wrap gap-2" id="category-filters">
                    <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-[#1e4d8b] hover:text-white transition-all duration-300 active" data-category="all">
                        Semua
                    </button>
                    <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-[#1e4d8b] hover:text-white transition-all duration-300" data-category="ruang_kelas">
                        Ruang Kelas
                    </button>
                    <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-[#1e4d8b] hover:text-white transition-all duration-300" data-category="laboratorium">
                        Laboratorium
                    </button>
                    <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-[#1e4d8b] hover:text-white transition-all duration-300" data-category="olahraga">
                        Olahraga
                    </button>
                    <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-[#1e4d8b] hover:text-white transition-all duration-300" data-category="perpustakaan">
                        Perpustakaan
                    </button>
                    <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-[#1e4d8b] hover:text-white transition-all duration-300" data-category="mushola">
                        Mushola
                    </button>
                    <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-[#1e4d8b] hover:text-white transition-all duration-300" data-category="kantin">
                        Kantin
                    </button>
                    <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-[#1e4d8b] hover:text-white transition-all duration-300" data-category="lainnya">
                        Lainnya
                    </button>
                </div>
            </div>

            <!-- Search Box -->
            <div class="flex justify-end">
                <div class="relative w-full max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="search-input" class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-[#13315c] focus:border-[#13315c]" placeholder="Cari fasilitas...">
                    <button type="button" id="clear-search" class="absolute inset-y-0 right-0 pr-3 flex items-center hidden">
                        <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loading-state" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @for($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-xl shadow-md overflow-hidden animate-pulse">
                    <div class="h-48 bg-gray-300"></div>
                    <div class="p-6">
                        <div class="h-4 bg-gray-300 rounded mb-2"></div>
                        <div class="h-3 bg-gray-300 rounded mb-4"></div>
                        <div class="h-3 bg-gray-300 rounded w-2/3"></div>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Facilities Grid -->
        <div id="facilities-container">
            @include('facilities.partials.facilities-grid', ['facilities' => $facilities])
        </div>

        <!-- Empty State -->
        <div id="empty-state" class="hidden text-center py-12">
            <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada fasilitas ditemukan</h3>
            <p class="text-gray-500 mb-4">Coba ubah filter atau kata kunci pencarian</p>
            <button id="reset-filters" class="bg-[#13315c] text-white px-4 py-2 rounded-lg hover:bg-[#1e4d8b] transition-colors">
                Reset Filter
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilters = document.querySelectorAll('.category-filter');
    const searchInput = document.getElementById('search-input');
    const clearSearchBtn = document.getElementById('clear-search');
    const facilitiesContainer = document.getElementById('facilities-container');
    const loadingState = document.getElementById('loading-state');
    const emptyState = document.getElementById('empty-state');
    const resetFiltersBtn = document.getElementById('reset-filters');

    let currentCategory = 'all';
    let currentSearch = '';
    let searchTimeout;

    // Category filter functionality
    categoryFilters.forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            categoryFilters.forEach(btn => btn.classList.remove('active', 'bg-[#13315c]', 'text-white'));
            this.classList.add('active', 'bg-[#13315c]', 'text-white');
            
            currentCategory = this.dataset.category;
            loadFacilities();
        });
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        currentSearch = this.value;
        
        // Show/hide clear button
        if (currentSearch.length > 0) {
            clearSearchBtn.classList.remove('hidden');
        } else {
            clearSearchBtn.classList.add('hidden');
        }
        
        // Debounce search
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadFacilities();
        }, 500);
    });

    // Clear search
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        currentSearch = '';
        this.classList.add('hidden');
        loadFacilities();
    });

    // Reset filters
    resetFiltersBtn.addEventListener('click', function() {
        // Reset category
        categoryFilters.forEach(btn => btn.classList.remove('active', 'bg-[#13315c]', 'text-white'));
        document.querySelector('[data-category="all"]').classList.add('active', 'bg-[#13315c]', 'text-white');
        currentCategory = 'all';
        
        // Reset search
        searchInput.value = '';
        currentSearch = '';
        clearSearchBtn.classList.add('hidden');
        
        loadFacilities();
    });

    // Load facilities function
    function loadFacilities() {
        loadingState.classList.remove('hidden');
        facilitiesContainer.classList.add('hidden');
        emptyState.classList.add('hidden');

        const params = new URLSearchParams();
        if (currentCategory !== 'all') {
            params.append('category', currentCategory);
        }
        if (currentSearch) {
            params.append('search', currentSearch);
        }

        fetch(`{{ route('facilities.filter') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            loadingState.classList.add('hidden');
            facilitiesContainer.classList.remove('hidden');
            
            if (data.html.trim() === '') {
                facilitiesContainer.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                facilitiesContainer.innerHTML = data.html;
                emptyState.classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loadingState.classList.add('hidden');
            facilitiesContainer.classList.remove('hidden');
        });
    }
});
</script>
@endpush
@endsection



