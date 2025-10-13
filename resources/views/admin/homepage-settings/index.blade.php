@extends('admin.layouts.app')

@section('page-title', 'Pengaturan Beranda')

@section('content')
<div class="p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-6 lg:mb-8">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Pengaturan Beranda</h1>
        <p class="text-gray-600">Kelola konten dan pengaturan halaman beranda website</p>
    </div>

    <!-- Current Settings Preview -->
    @if($homepageSetting)
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Pengaturan Saat Ini</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Hero Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Hero Section</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Judul:</span> {{ $homepageSetting->hero_title ?? 'Belum diatur' }}</p>
                    <p><span class="font-medium">Subtitle:</span> {{ $homepageSetting->hero_subtitle ?? 'Belum diatur' }}</p>
                    <p><span class="font-medium">Deskripsi:</span> {{ Str::limit($homepageSetting->hero_description ?? 'Belum diatur', 100) }}</p>
                    <p><span class="font-medium">Tombol 1:</span> {{ $homepageSetting->hero_button_1_text ?? 'Belum diatur' }}</p>
                    <p><span class="font-medium">Tombol 2:</span> {{ $homepageSetting->hero_button_2_text ?? 'Belum diatur' }}</p>
                </div>
            </div>

            <!-- Vision & Mission -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Visi & Misi</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Judul Visi:</span> {{ $homepageSetting->vision_title ?? 'Belum diatur' }}</p>
                    <p><span class="font-medium">Visi:</span> {{ Str::limit($homepageSetting->vision_description ?? 'Belum diatur', 100) }}</p>
                    <p><span class="font-medium">Misi:</span> {{ Str::limit($homepageSetting->mission_description ?? 'Belum diatur', 100) }}</p>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kontak</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <p><span class="font-medium">Telepon:</span> {{ $homepageSetting->contact_phone ?? 'Belum diatur' }}</p>
                <p><span class="font-medium">Email:</span> {{ $homepageSetting->contact_email ?? 'Belum diatur' }}</p>
                <p><span class="font-medium">Alamat:</span> {{ Str::limit($homepageSetting->contact_address ?? 'Belum diatur', 50) }}</p>
            </div>
        </div>
    </div>
    @else
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
                <h3 class="text-lg font-medium text-yellow-800">Belum Ada Pengaturan</h3>
                <p class="text-yellow-700">Belum ada pengaturan beranda yang dibuat. Klik tombol di bawah untuk membuat pengaturan baru.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('admin.homepage-settings.edit') }}" 
           class="inline-flex items-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            {{ $homepageSetting ? 'Edit Pengaturan' : 'Buat Pengaturan' }}
        </a>
        
        <a href="{{ route('admin.dashboard') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
