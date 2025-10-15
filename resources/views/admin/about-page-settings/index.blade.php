@extends('admin.layouts.app')

@section('page-title', 'Pengaturan Halaman Tentang Kami')

@section('content')
<div class="p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-6 lg:mb-8">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Pengaturan Halaman Tentang Kami</h1>
        <p class="text-gray-600">Kelola konten dan pengaturan halaman Tentang Kami</p>
    </div>

    <!-- Current Settings Preview -->
    @if($aboutPageSetting)
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Pengaturan Saat Ini</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Informasi Dasar</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Judul Halaman:</span> {{ $aboutPageSetting->page_title ?? 'Belum diatur' }}</p>
                    <p><span class="font-medium">Deskripsi:</span> {{ Str::limit($aboutPageSetting->description ?? 'Belum diatur', 100) }}</p>
                    <p><span class="font-medium">Visi:</span> {{ Str::limit($aboutPageSetting->vision ?? 'Belum diatur', 100) }}</p>
                    <p><span class="font-medium">Misi:</span> {{ Str::limit($aboutPageSetting->mission ?? 'Belum diatur', 100) }}</p>
                </div>
            </div>

            <!-- Principal Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Kepala Sekolah</h3>
                <div class="flex items-start space-x-4">
                    @if($aboutPageSetting && $aboutPageSetting->principal_photo)
                        <div class="flex-shrink-0">
                            <img src="{{ $aboutPageSetting->principal_photo_url }}" alt="Foto Kepala Sekolah" 
                                 class="w-16 h-16 rounded-full object-cover border-2 border-gray-300">
                        </div>
                    @else
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    @endif
                    <div class="flex-1 space-y-2">
                        <p><span class="font-medium">Nama:</span> {{ $aboutPageSetting->principal_name ?? 'Belum diatur' }}</p>
                        <p><span class="font-medium">Jabatan:</span> {{ $aboutPageSetting->principal_title ?? 'Belum diatur' }}</p>
                        <p><span class="font-medium">Pesan:</span> {{ Str::limit($aboutPageSetting->principal_message ?? 'Belum diatur', 100) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Images -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Gambar & Dokumen</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Principal Photo -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="flex-shrink-0">
                            @if($aboutPageSetting && $aboutPageSetting->principal_photo)
                                <img src="{{ $aboutPageSetting->principal_photo_url }}" alt="Foto Kepala Sekolah" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-gray-300">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-gray-900">Foto Kepala Sekolah</p>
                            <p class="text-sm text-gray-500">
                                {{ $aboutPageSetting->principal_photo ? 'Sudah diupload' : 'Belum diupload' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- School Photo -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="flex-shrink-0">
                            @if($aboutPageSetting && $aboutPageSetting->school_photo)
                                <img src="{{ $aboutPageSetting->school_photo_url }}" alt="Foto Sekolah" 
                                     class="w-12 h-12 rounded-lg object-cover border-2 border-gray-300">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-gray-900">Foto Sekolah</p>
                            <p class="text-sm text-gray-500">
                                {{ $aboutPageSetting->school_photo ? 'Sudah diupload' : 'Belum diupload' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Organization Chart -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="flex-shrink-0">
                            @if($aboutPageSetting && $aboutPageSetting->organization_chart)
                                <img src="{{ $aboutPageSetting->organization_chart_url }}" alt="Bagan Organisasi" 
                                     class="w-12 h-12 rounded-lg object-cover border-2 border-gray-300">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-gray-900">Bagan Organisasi</p>
                            <p class="text-sm text-gray-500">
                                {{ $aboutPageSetting->organization_chart ? 'Sudah diupload' : 'Belum diupload' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kontak</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <p><span class="font-medium">Telepon:</span> {{ $aboutPageSetting->contact_phone ?? 'Belum diatur' }}</p>
                <p><span class="font-medium">Email:</span> {{ $aboutPageSetting->contact_email ?? 'Belum diatur' }}</p>
                <p><span class="font-medium">Website:</span> {{ $aboutPageSetting->website ?? 'Belum diatur' }}</p>
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
                <p class="text-yellow-700">Belum ada pengaturan halaman Tentang Kami yang dibuat. Klik tombol di bawah untuk membuat pengaturan baru.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('admin.about-page-settings.edit') }}" 
           class="inline-flex items-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            {{ $aboutPageSetting ? 'Edit Pengaturan' : 'Buat Pengaturan' }}
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
