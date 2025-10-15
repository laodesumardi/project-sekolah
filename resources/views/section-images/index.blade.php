@extends('layouts.app')

@section('title', 'Gambar Section Website - SMP Negeri 01 Namrole')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Gambar Section', 'url' => null]
]" />

<!-- Page Header -->
<x-page-header 
    title="Gambar Section Website" 
    subtitle="Koleksi gambar yang digunakan di berbagai section website SMP Negeri 01 Namrole"
/>

<!-- Section Images Display -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- All Images -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Semua Gambar Section</h2>
            <x-section-images section="all" />
        </div>
        
        <!-- Individual Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Hero Section -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Hero Section</h3>
                <x-section-images section="hero" />
            </div>
            
            <!-- About Section -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tentang Kami</h3>
                <x-section-images section="about" />
            </div>
            
            <!-- School Image -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Gambar Sekolah</h3>
                <x-section-images section="school" />
            </div>
            
            <!-- Principal -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kepala Sekolah</h3>
                <x-section-images section="principal" />
            </div>
            
            <!-- Accreditation -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Akreditasi</h3>
                <x-section-images section="accreditation" />
            </div>
            
            <!-- Organization -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Struktur Organisasi</h3>
                <x-section-images section="organization" />
            </div>
            
            <!-- Library -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Perpustakaan</h3>
                <x-section-images section="library" />
            </div>
        </div>
        
        <!-- Admin Link -->
        <div class="mt-12 text-center">
            <div class="bg-blue-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Kelola Gambar Section</h3>
                <p class="text-blue-800 mb-4">Upload dan kelola gambar section dari admin panel</p>
                <a href="{{ route('admin.homepage-settings.edit') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Kelola Gambar
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
