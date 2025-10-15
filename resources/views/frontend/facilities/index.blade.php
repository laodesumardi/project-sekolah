@extends('layouts.app')

@section('title', 'Fasilitas - SMP Negeri 01 Namrole')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Fasilitas', 'url' => null]
]" />

<!-- Page Header -->
<x-page-header 
    title="Fasilitas Sekolah" 
    subtitle="Fasilitas lengkap untuk mendukung proses pembelajaran yang optimal" 
/>

<!-- Filter Section -->
<section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('facilities.index') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-64">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Filter Kategori:</label>
                <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors duration-200">
                    Filter
                </button>
                @if(request('category'))
                    <a href="{{ route('facilities.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-200">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</section>

<!-- Facilities Grid -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($facilities->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($facilities as $facility)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <!-- Facility Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $facility->image_url }}" 
                                 alt="{{ $facility->name }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            @if($facility->category)
                                <div class="absolute top-4 left-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white bg-opacity-90 text-blue-800 shadow-sm">
                                        {{ $facility->category_name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Facility Content -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $facility->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($facility->description, 100) }}</p>
                            
                            <!-- Facility Details -->
                            <div class="space-y-2">
                                @if($facility->capacity)
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                        </svg>
                                        Kapasitas: {{ $facility->capacity }} orang
                                    </div>
                                @endif
                                
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $facility->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                </div>
                            </div>
                            
                            <!-- View Details Button -->
                            <div class="mt-4">
                                <a href="{{ route('facilities.show', $facility) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-primary-500 text-white text-sm font-medium rounded-md hover:bg-primary-600 transition-colors duration-200">
                                    Lihat Detail
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $facilities->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Fasilitas</h3>
                <p class="text-gray-600">Fasilitas sekolah akan segera ditambahkan.</p>
            </div>
        @endif
    </div>
</section>

@endsection
