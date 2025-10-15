@extends('admin.layouts.app')

@section('title', 'Detail Ekstrakurikuler')

@section('content')
<div class="p-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-[#13315c]">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('admin.extracurriculars.index') }}" class="ml-1 text-gray-700 hover:text-[#13315c] md:ml-2">Ekstrakurikuler</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-gray-500 md:ml-2">{{ $extracurricular->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $extracurricular->name }}</h1>
                <p class="text-gray-600 mt-1">{{ $extracurricular->category_name }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.extracurriculars.edit', $extracurricular->id) }}" 
                   class="bg-[#13315c] text-white px-4 py-2 rounded-lg hover:bg-[#1e4d8b] transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('extracurriculars.show', $extracurricular->slug) }}" 
                   target="_blank"
                   class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Lihat di Website
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content (Left Column - 70%) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Dasar -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Ekstrakurikuler</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kategori</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $extracurricular->category_name }}
                        </span>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi Singkat</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->short_description ?: 'Tidak ada deskripsi singkat' }}</p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi Lengkap</label>
                        <div class="text-sm text-gray-900 prose max-w-none">
                            {!! nl2br(e($extracurricular->description)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jadwal & Lokasi -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Jadwal & Lokasi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Hari Kegiatan</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->schedule_day_name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Lokasi</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->location }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Waktu Mulai</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->schedule_time_start ? $extracurricular->schedule_time_start->format('H:i') : 'Tidak ditentukan' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Waktu Selesai</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->schedule_time_end ? $extracurricular->schedule_time_end->format('H:i') : 'Tidak ditentukan' }}</p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jadwal Lengkap</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->formatted_schedule }}</p>
                    </div>
                </div>
            </div>

            <!-- Pembina/Pelatih -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Pembina/Pelatih</h3>
                
                <div class="flex items-center space-x-4">
                    @if($extracurricular->instructor)
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" 
                                 src="{{ $extracurricular->instructor->user->profile_photo_url }}" 
                                 alt="{{ $extracurricular->instructor->user->name }}">
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $extracurricular->instructor->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $extracurricular->instructor->nip }}</p>
                            <p class="text-sm text-gray-500">Guru Internal</p>
                        </div>
                    @else
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $extracurricular->instructor_name }}</p>
                            <p class="text-sm text-gray-500">Pelatih Eksternal</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Peserta & Pendaftaran -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Peserta & Pendaftaran</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kuota Maksimal</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->max_participants ?: 'Tidak terbatas' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Peserta Saat Ini</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->current_participants }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Slot Tersedia</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->available_slots }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status Pendaftaran</label>
                        @if($extracurricular->is_registration_open)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Dibuka
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Ditutup
                            </span>
                        @endif
                    </div>
                    
                    @if($extracurricular->registration_start)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Buka</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->registration_start->format('d F Y') }}</p>
                    </div>
                    @endif
                    
                    @if($extracurricular->registration_end)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Tutup</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->registration_end->format('d F Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Media Sosial -->
            @if($extracurricular->facebook_url || $extracurricular->instagram_url || $extracurricular->youtube_url)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Media Sosial</h3>
                
                <div class="flex space-x-4">
                    @if($extracurricular->facebook_url)
                    <a href="{{ $extracurricular->facebook_url }}" 
                       target="_blank"
                       class="flex items-center space-x-2 text-blue-600 hover:text-blue-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="text-sm">Facebook</span>
                    </a>
                    @endif
                    
                    @if($extracurricular->instagram_url)
                    <a href="{{ $extracurricular->instagram_url }}" 
                       target="_blank"
                       class="flex items-center space-x-2 text-pink-600 hover:text-pink-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323c-.875.807-2.026 1.297-3.323 1.297zm7.83-9.297H9.297v6.62h6.982v-6.62z"/>
                        </svg>
                        <span class="text-sm">Instagram</span>
                    </a>
                    @endif
                    
                    @if($extracurricular->youtube_url)
                    <a href="{{ $extracurricular->youtube_url }}" 
                       target="_blank"
                       class="flex items-center space-x-2 text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                        <span class="text-sm">YouTube</span>
                    </a>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar (Right Column - 30%) -->
        <div class="space-y-6">
            <!-- Status & Pengaturan -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Status & Pengaturan</h4>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Status Aktif</span>
                        @if($extracurricular->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Tidak Aktif
                            </span>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Unggulan</span>
                        @if($extracurricular->is_featured)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Unggulan
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Biasa
                            </span>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Urutan</span>
                        <span class="text-sm text-gray-900">{{ $extracurricular->sort_order }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Total Views</span>
                        <span class="text-sm text-gray-900">{{ $extracurricular->view_count }}</span>
                    </div>
                </div>
            </div>

            <!-- Logo & Cover -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Logo & Cover</h4>
                
                <div class="space-y-4">
                    @if($extracurricular->logo)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Logo</label>
                        <img src="{{ $extracurricular->logo_url }}" 
                             alt="Logo" 
                             class="w-20 h-20 object-cover rounded-lg border">
                    </div>
                    @endif
                    
                    @if($extracurricular->cover_image)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Cover Image</label>
                        <img src="{{ $extracurricular->cover_image_url }}" 
                             alt="Cover" 
                             class="w-full h-32 object-cover rounded-lg border">
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Sistem -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Sistem</h4>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat Oleh</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->creator?->name ?: 'Sistem' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat Pada</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    
                    @if($extracurricular->updater)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Diperbarui Oleh</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->updater->name }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Terakhir Diperbarui</label>
                        <p class="text-sm text-gray-900">{{ $extracurricular->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h4>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.extracurriculars.edit', $extracurricular->id) }}" 
                       class="w-full bg-[#13315c] text-white px-4 py-2 rounded-lg hover:bg-[#1e4d8b] transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Ekstrakurikuler
                    </a>
                    
                    <a href="#" 
                       class="w-full bg-green-100 text-green-800 px-4 py-2 rounded-lg hover:bg-green-200 transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Kelola Foto
                    </a>
                    
                    <a href="#" 
                       class="w-full bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg hover:bg-yellow-200 transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        Kelola Prestasi
                    </a>
                    
                    <a href="#" 
                       class="w-full bg-purple-100 text-purple-800 px-4 py-2 rounded-lg hover:bg-purple-200 transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Kelola Anggota
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection