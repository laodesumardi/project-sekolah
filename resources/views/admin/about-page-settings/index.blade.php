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
                <div class="space-y-2">
                    <p><span class="font-medium">Nama:</span> {{ $aboutPageSetting->principal_name ?? 'Belum diatur' }}</p>
                    <p><span class="font-medium">Jabatan:</span> {{ $aboutPageSetting->principal_title ?? 'Belum diatur' }}</p>
                    <p><span class="font-medium">Pesan:</span> {{ Str::limit($aboutPageSetting->principal_message ?? 'Belum diatur', 100) }}</p>
                </div>
            </div>
        </div>

        <!-- Images -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Gambar & Dokumen</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="font-medium text-sm text-gray-700">Foto Kepala Sekolah:</p>
                    <p class="text-sm text-gray-600">{{ $aboutPageSetting->principal_photo ? 'Sudah diupload' : 'Belum diupload' }}</p>
                </div>
                <div>
                    <p class="font-medium text-sm text-gray-700">Foto Sekolah:</p>
                    <p class="text-sm text-gray-600">{{ $aboutPageSetting->school_photo ? 'Sudah diupload' : 'Belum diupload' }}</p>
                </div>
                <div>
                    <p class="font-medium text-sm text-gray-700">Bagan Organisasi:</p>
                    <p class="text-sm text-gray-600">{{ $aboutPageSetting->organization_chart ? 'Sudah diupload' : 'Belum diupload' }}</p>
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
