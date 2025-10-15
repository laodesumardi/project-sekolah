@extends('layouts.app')

@section('title', 'Ekstrakurikuler - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <x-background-section 
        section="extracurricular"
        title="Ekstrakurikuler" 
        subtitle="Temukan kegiatan ekstrakurikuler yang sesuai dengan minat dan bakat Anda" 
    />

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <!-- Filter & Search Section -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Search Box -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Cari ekstrakurikuler..." 
                               class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Category Filters -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Kategori</h3>
                    <div class="flex flex-wrap gap-2" id="categoryFilters">
                        <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-blue-50 hover:border-blue-500 transition-colors active" data-category="all">
                            Semua
                        </button>
                        <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-blue-50 hover:border-blue-500 transition-colors" data-category="olahraga">
                            Olahraga
                        </button>
                        <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-blue-50 hover:border-blue-500 transition-colors" data-category="seni">
                            Seni
                        </button>
                        <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-blue-50 hover:border-blue-500 transition-colors" data-category="akademik">
                            Akademik
                        </button>
                        <button class="category-filter px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-blue-50 hover:border-blue-500 transition-colors" data-category="teknologi">
                            Teknologi
                        </button>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="flex flex-wrap gap-4 items-center">
                    <div class="flex items-center space-x-2">
                        <label for="sortSelect" class="text-sm font-medium text-gray-700">Urutkan:</label>
                        <select id="sortSelect" class="px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="name">Nama A-Z</option>
                            <option value="name_desc">Nama Z-A</option>
                            <option value="participants">Peserta Terbanyak</option>
                            <option value="participants_desc">Peserta Tersedikit</option>
                            <option value="created_at">Terbaru</option>
                            <option value="created_at_desc">Terlama</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @for($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-lg shadow-md overflow-hidden animate-pulse">
                    <div class="h-48 bg-gray-300"></div>
                    <div class="p-6">
                        <div class="h-4 bg-gray-300 rounded mb-2"></div>
                        <div class="h-4 bg-gray-300 rounded mb-4 w-3/4"></div>
                        <div class="h-3 bg-gray-300 rounded mb-2"></div>
                        <div class="h-3 bg-gray-300 rounded w-1/2"></div>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Extracurriculars Grid -->
        <div id="extracurricularsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($extracurriculars as $extracurricular)
            <div class="extracurricular-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300" 
                 data-category="{{ $extracurricular->category }}" 
                 data-name="{{ strtolower($extracurricular->name) }}">
                <!-- Cover Image -->
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $extracurricular->cover_image_url }}" 
                         alt="{{ $extracurricular->name }}"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                         onerror="this.src='{{ asset('images/default-extracurricular-cover.jpg') }}'">
                    
                    <!-- Category Badge -->
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-full">
                            {{ $extracurricular->category_name }}
                        </span>
                    </div>

                    <!-- Featured Badge -->
                    @if($extracurricular->is_featured)
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 bg-yellow-500 text-white text-sm font-medium rounded-full flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Unggulan
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Title -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                        {{ $extracurricular->name }}
                    </h3>

                    <!-- Short Description -->
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ $extracurricular->short_description }}
                    </p>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                            <span>{{ $extracurricular->current_participants }}/{{ $extracurricular->max_participants }} peserta</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $extracurricular->location }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $extracurricular->formatted_schedule }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $extracurricular->instructor_name }}</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Kuota</span>
                            <span>{{ round(($extracurricular->current_participants / $extracurricular->max_participants) * 100) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ round(($extracurricular->current_participants / $extracurricular->max_participants) * 100) }}%"></div>
                        </div>
                    </div>

                    <!-- View Counter -->
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $extracurricular->view_count }} dilihat</span>
                        </div>
                        @if($extracurricular->achievements->count() > 0)
                        <div class="flex items-center text-yellow-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span>{{ $extracurricular->achievements->count() }} prestasi</span>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <a href="{{ route('extracurriculars.show', $extracurricular->slug) }}" 
                           class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg text-center font-medium hover:bg-blue-700 transition-colors">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="col-span-full text-center py-12">
                <div class="max-w-md mx-auto">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Ekstrakurikuler</h3>
                    <p class="text-gray-600 mb-6">Saat ini belum ada ekstrakurikuler yang tersedia. Silakan kembali lagi nanti.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($extracurriculars->hasPages())
        <div class="mt-12">
            {{ $extracurriculars->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilters = document.querySelectorAll('.category-filter');
    const sortSelect = document.getElementById('sortSelect');
    const loadingState = document.getElementById('loadingState');
    const extracurricularsGrid = document.getElementById('extracurricularsGrid');
    const extracurricularCards = document.querySelectorAll('.extracurricular-card');

    let currentCategory = 'all';
    let currentSort = 'name';
    let currentSearch = '';

    // Search functionality
    searchInput.addEventListener('input', debounce(function() {
        currentSearch = this.value.toLowerCase();
        filterAndSort();
    }, 300));

    // Category filter functionality
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            categoryFilters.forEach(f => f.classList.remove('active', 'bg-blue-600', 'text-white'));
            categoryFilters.forEach(f => f.classList.add('border-gray-300', 'text-gray-700'));
            
            this.classList.add('active', 'bg-blue-600', 'text-white');
            this.classList.remove('border-gray-300', 'text-gray-700');
            
            currentCategory = this.dataset.category;
            filterAndSort();
        });
    });

    // Sort functionality
    sortSelect.addEventListener('change', function() {
        currentSort = this.value;
        filterAndSort();
    });

    function filterAndSort() {
        showLoading();
        
        setTimeout(() => {
            let visibleCards = Array.from(extracurricularCards);
            
            // Filter by category
            if (currentCategory !== 'all') {
                visibleCards = visibleCards.filter(card => 
                    card.dataset.category === currentCategory
                );
            }
            
            // Filter by search
            if (currentSearch) {
                visibleCards = visibleCards.filter(card => 
                    card.dataset.name.includes(currentSearch)
                );
            }
            
            // Sort cards
            visibleCards.sort((a, b) => {
                const nameA = a.dataset.name;
                const nameB = b.dataset.name;
                
                switch(currentSort) {
                    case 'name':
                        return nameA.localeCompare(nameB);
                    case 'name_desc':
                        return nameB.localeCompare(nameA);
                    default:
                        return 0;
                }
            });
            
            // Hide all cards
            extracurricularCards.forEach(card => {
                card.style.display = 'none';
            });
            
            // Show filtered cards
            visibleCards.forEach(card => {
                card.style.display = 'block';
            });
            
            hideLoading();
        }, 500);
    }

    function showLoading() {
        loadingState.classList.remove('hidden');
        extracurricularsGrid.classList.add('hidden');
    }

    function hideLoading() {
        loadingState.classList.add('hidden');
        extracurricularsGrid.classList.remove('hidden');
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
});
</script>
@endpush
@endsection