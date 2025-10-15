@extends('layouts.app')

@section('title', $facility->name . ' - SMP Negeri 01 Namrole')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Fasilitas', 'url' => route('facilities.index')],
    ['name' => $facility->name, 'url' => null]
]" />

<!-- Facility Detail -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Image -->
            <div class="space-y-6">
                <div class="aspect-w-16 aspect-h-12">
                    <img src="{{ $facility->image_url }}" 
                         alt="{{ $facility->name }}" 
                         class="w-full h-96 object-cover rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                </div>
                
                <!-- Status Badge -->
                <div class="flex items-center space-x-4">
                    @if($facility->is_available)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Tersedia
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Tidak Tersedia
                        </span>
                    @endif
                    
                    @if($facility->capacity)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                            Kapasitas: {{ $facility->capacity }} orang
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Content -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $facility->name }}</h1>
                    <div class="prose prose-lg text-gray-600">
                        {!! nl2br(e($facility->description)) !!}
                    </div>
                </div>
                
                <!-- Features -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Fitur Fasilitas</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Fasilitas lengkap dan modern
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Didukung teknologi terbaru
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Lingkungan yang nyaman dan kondusif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Facilities -->
@if($relatedFacilities->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Fasilitas Lainnya</h2>
            <p class="text-lg text-gray-600">Jelajahi fasilitas lain yang tersedia di sekolah</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedFacilities as $relatedFacility)
                <x-facility-card :facility="$relatedFacility" />
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('facilities.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                Lihat Semua Fasilitas
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif
@endsection

