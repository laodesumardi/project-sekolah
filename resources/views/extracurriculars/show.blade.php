@extends('layouts.app')

@section('title', $extracurricular->name . ' - Ekstrakurikuler')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('extracurriculars.index') }}" class="ml-1 text-gray-700 hover:text-blue-600">Ekstrakurikuler</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500">{{ $extracurricular->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="relative h-96 overflow-hidden">
        <img src="{{ $extracurricular->cover_image_url }}" 
             alt="{{ $extracurricular->name }}"
             class="w-full h-full object-cover"
             onerror="this.src='{{ asset('images/default-extracurricular-cover.jpg') }}'">
        
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 right-0 p-8">
            <div class="container mx-auto">
                <div class="flex items-end space-x-6">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <img src="{{ $extracurricular->logo_url }}" 
                             alt="{{ $extracurricular->name }} Logo"
                             class="w-24 h-24 rounded-lg shadow-lg object-cover"
                             onerror="this.src='{{ asset('images/default-extracurricular.svg') }}'">
                    </div>
                    
                    <!-- Title & Meta -->
                    <div class="flex-1 text-white">
                        <h1 class="text-4xl font-bold mb-2">{{ $extracurricular->name }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-lg">
                            <span class="px-3 py-1 bg-blue-600 rounded-full text-sm font-medium">
                                {{ $extracurricular->category_name }}
                            </span>
                            @if($extracurricular->is_featured)
                            <span class="px-3 py-1 bg-yellow-500 rounded-full text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Unggulan
                            </span>
                            @endif
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $extracurricular->view_count }} dilihat
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Tab Navigation -->
                <div class="bg-white rounded-lg shadow-md mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="flex space-x-8 px-6" aria-label="Tabs">
                            <button class="tab-button active py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600" data-tab="about">
                                Tentang
                            </button>
                            <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="schedule">
                                Jadwal
                            </button>
                            <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="gallery">
                                Galeri
                            </button>
                            <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="achievements">
                                Prestasi
                            </button>
                            <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="registration">
                                Pendaftaran
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- About Tab -->
                        <div id="about-tab" class="tab-content">
                            <div class="prose max-w-none">
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi</h3>
                                <div class="text-gray-700 leading-relaxed">
                                    {!! nl2br(e($extracurricular->description)) !!}
                                </div>

                                @if($extracurricular->requirements && count($extracurricular->requirements) > 0)
                                <div class="mt-8">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Persyaratan</h4>
                                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                                        @foreach($extracurricular->requirements as $requirement)
                                        <li>{{ $requirement }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                @if($extracurricular->benefits && count($extracurricular->benefits) > 0)
                                <div class="mt-8">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Manfaat</h4>
                                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                                        @foreach($extracurricular->benefits as $benefit)
                                        <li>{{ $benefit }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Schedule Tab -->
                        <div id="schedule-tab" class="tab-content hidden">
                            <div class="bg-blue-50 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">Jadwal Kegiatan</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-2">Hari</h4>
                                        <p class="text-gray-700">{{ $extracurricular->schedule_day_name }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-2">Waktu</h4>
                                        <p class="text-gray-700">{{ $extracurricular->schedule_time_start }} - {{ $extracurricular->schedule_time_end }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-2">Lokasi</h4>
                                        <p class="text-gray-700">{{ $extracurricular->location }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-2">Pembina</h4>
                                        <p class="text-gray-700">{{ $extracurricular->instructor_name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Tab -->
                        <div id="gallery-tab" class="tab-content hidden">
                            @if($extracurricular->images->count() > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($extracurricular->images as $image)
                                <div class="aspect-square overflow-hidden rounded-lg cursor-pointer" onclick="openLightbox('{{ $image->image_url }}')">
                                    <img src="{{ $image->thumbnail_url }}" 
                                         alt="{{ $image->title }}"
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                         onerror="this.src='{{ asset('images/default-image.jpg') }}'">
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500">Belum ada foto galeri</p>
                            </div>
                            @endif
                        </div>

                        <!-- Achievements Tab -->
                        <div id="achievements-tab" class="tab-content hidden">
                            @if($extracurricular->achievements->count() > 0)
                            <div class="space-y-6">
                                @foreach($extracurricular->achievements as $achievement)
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $achievement->title }}</h4>
                                            <p class="text-gray-700 mt-1">{{ $achievement->description }}</p>
                                            <div class="mt-2 flex items-center text-sm text-gray-600">
                                                <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs font-medium">
                                                    {{ $achievement->achievement_level_name }}
                                                </span>
                                                @if($achievement->rank)
                                                <span class="ml-2">Peringkat: {{ $achievement->rank }}</span>
                                                @endif
                                                <span class="ml-2">{{ $achievement->formatted_date }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <p class="text-gray-500">Belum ada prestasi</p>
                            </div>
                            @endif
                        </div>

                        <!-- Registration Tab -->
                        <div id="registration-tab" class="tab-content hidden">
                            <div class="bg-green-50 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">Status Pendaftaran</h3>
                                
                                @if($extracurricular->is_registration_open)
                                    @if($extracurricular->is_full)
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="font-medium">Kuota Penuh</span>
                                        </div>
                                        <p class="mt-1">Maaf, kuota untuk ekstrakurikuler ini sudah penuh.</p>
                                    </div>
                                    @else
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="font-medium">Pendaftaran Dibuka</span>
                                        </div>
                                        <p class="mt-1">Pendaftaran masih dibuka. Silakan daftar sekarang!</p>
                                    </div>
                                    @endif
                                @else
                                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-medium">Pendaftaran Ditutup</span>
                                    </div>
                                    <p class="mt-1">Pendaftaran untuk ekstrakurikuler ini sudah ditutup.</p>
                                </div>
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-2">Kuota Peserta</h4>
                                        <div class="flex items-center space-x-2">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ round(($extracurricular->current_participants / $extracurricular->max_participants) * 100) }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600">{{ $extracurricular->current_participants }}/{{ $extracurricular->max_participants }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($extracurricular->registration_start && $extracurricular->registration_end)
                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-2">Periode Pendaftaran</h4>
                                        <p class="text-gray-700">
                                            {{ \Carbon\Carbon::parse($extracurricular->registration_start)->format('d M Y') }} - 
                                            {{ \Carbon\Carbon::parse($extracurricular->registration_end)->format('d M Y') }}
                                        </p>
                                    </div>
                                    @endif
                                </div>

                                @if($extracurricular->is_registration_open && !$extracurricular->is_full)
                                <div class="mt-6">
                                    <a href="{{ route('extracurriculars.register', $extracurricular->slug) }}" 
                                       class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Daftar Sekarang
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Cepat</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Peserta</p>
                                <p class="font-medium">{{ $extracurricular->current_participants }}/{{ $extracurricular->max_participants }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM5 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Lokasi</p>
                                <p class="font-medium">{{ $extracurricular->location }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-purple-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Jadwal</p>
                                <p class="font-medium">{{ $extracurricular->formatted_schedule }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-orange-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Pembina</p>
                                <p class="font-medium">{{ $extracurricular->instructor_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                @if($extracurricular->facebook_url || $extracurricular->instagram_url || $extracurricular->youtube_url)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Media Sosial</h3>
                    <div class="flex space-x-3">
                        @if($extracurricular->facebook_url)
                        <a href="{{ $extracurricular->facebook_url }}" target="_blank" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if($extracurricular->instagram_url)
                        <a href="{{ $extracurricular->instagram_url }}" target="_blank" class="p-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.418-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.244c-.875.807-2.026 1.297-3.323 1.297zm7.718-1.297c-.875.807-2.026 1.297-3.323 1.297s-2.448-.49-3.323-1.297c-.928-.875-1.418-2.026-1.418-3.323s.49-2.448 1.418-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.244z"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if($extracurricular->youtube_url)
                        <a href="{{ $extracurricular->youtube_url }}" target="_blank" class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Related Extracurriculars -->
                @if($relatedExtracurriculars->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ekstrakurikuler Lainnya</h3>
                    <div class="space-y-4">
                        @foreach($relatedExtracurriculars as $related)
                        <a href="{{ route('extracurriculars.show', $related->slug) }}" class="block group">
                            <div class="flex space-x-3">
                                <img src="{{ $related->logo_url }}" 
                                     alt="{{ $related->name }}"
                                     class="w-12 h-12 rounded-lg object-cover flex-shrink-0"
                                     onerror="this.src='{{ asset('images/default-extracurricular.svg') }}'">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 truncate">{{ $related->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $related->category_name }}</p>
                                    <p class="text-xs text-gray-400">{{ $related->current_participants }}/{{ $related->max_participants }} peserta</p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden">
    <div class="flex items-center justify-center h-full">
        <div class="relative max-w-4xl max-h-full p-4">
            <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="lightboxImage" src="" alt="" class="max-w-full max-h-full object-contain">
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
                btn.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Add active class to clicked button
            this.classList.add('active', 'border-blue-500', 'text-blue-600');
            this.classList.remove('border-transparent', 'text-gray-500');
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show target tab content
            const targetContent = document.getElementById(targetTab + '-tab');
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    });
});

function openLightbox(imageSrc) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    
    lightboxImage.src = imageSrc;
    lightbox.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close lightbox on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});

// Close lightbox on background click
document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});
</script>
@endpush
@endsection



