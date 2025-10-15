@extends('admin.layouts.app')

@section('page-title', 'Edit Pengaturan Beranda')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* Gentle smooth scroll behavior */
    html {
        scroll-behavior: smooth;
        scroll-padding-top: 100px;
    }
    
    /* Ensure proper scrolling for admin pages */
    body {
        overflow-x: hidden;
        scroll-behavior: smooth;
    }
    
    /* Fix for navigation tabs */
    .nav-tab {
        transition: all 0.3s ease;
    }
    
    /* Better spacing for sections with gentle scroll */
    .admin-section {
        scroll-margin-top: 120px;
        scroll-snap-align: start;
    }
    
    /* Fix for form elements */
    .form-container {
        min-height: 100vh;
    }
    
    /* Gentle scroll animation */
    * {
        scroll-behavior: smooth;
    }
    
    /* Reduce scroll speed */
    @media (prefers-reduced-motion: no-preference) {
        html {
            scroll-behavior: smooth;
        }
    }
</style>
@endpush

@section('content')
<div class="p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-6 lg:mb-8">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Edit Pengaturan Beranda</h1>
        <p class="text-gray-600">Ubah konten dan pengaturan halaman beranda website</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="#hero-section" class="px-4 py-2 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors duration-200 text-sm font-medium">
                Hero Section
            </a>
            <a href="#contact-info" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm font-medium">
                Kontak
            </a>
            <a href="#principal-info" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm font-medium">
                Kepala Sekolah
            </a>
            <a href="#accreditation" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm font-medium">
                Akreditasi
            </a>
            <a href="#about-page" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm font-medium">
                Tentang Kami
            </a>
            <a href="#organization-structure" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm font-medium">
                Struktur Organisasi
            </a>
            <a href="#library-structure" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm font-medium">
                Struktur Perpustakaan
            </a>
        </div>
    </div>

    <!-- Live Preview Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <h2 class="text-xl font-semibold text-gray-900">Live Preview</h2>
                <div id="auto-save-status" class="flex items-center space-x-2 text-sm">
                    <div class="w-2 h-2 bg-gray-400 rounded-full" id="status-indicator"></div>
                    <span id="status-text" class="text-gray-500">Siap untuk mengedit</span>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button type="button" id="toggle-preview" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 text-sm">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Toggle Preview
                </button>
                <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200 text-sm">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    View Live Site
                </a>
            </div>
        </div>
        
        <div id="preview-container" class="hidden">
            <div class="border-2 border-gray-200 rounded-lg overflow-hidden" style="max-height: 600px; overflow-y: auto;">
                <iframe id="preview-iframe" src="{{ route('home') }}" width="100%" height="600" frameborder="0" style="transform: scale(0.5); transform-origin: top left; width: 200%; height: 1200px;"></iframe>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.homepage-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Hero Section -->
        <div id="hero-section" class="admin-section bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Hero Section</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label for="hero_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Utama</label>
                        <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', $homepageSetting->hero_title ?? '') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('hero_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hero_subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                        <input type="text" id="hero_subtitle" name="hero_subtitle" value="{{ old('hero_subtitle', $homepageSetting->hero_subtitle ?? '') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('hero_subtitle')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hero_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea id="hero_description" name="hero_description" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('hero_description', $homepageSetting->hero_description ?? '') }}</textarea>
                        @error('hero_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="hero_button_1_text" class="block text-sm font-medium text-gray-700 mb-2">Teks Tombol 1</label>
                        <input type="text" id="hero_button_1_text" name="hero_button_1_text" value="{{ old('hero_button_1_text', $homepageSetting->hero_button_1_text ?? '') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('hero_button_1_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hero_button_1_url" class="block text-sm font-medium text-gray-700 mb-2">URL Tombol 1</label>
                        <input type="url" id="hero_button_1_url" name="hero_button_1_url" value="{{ old('hero_button_1_url', $homepageSetting->hero_button_1_url ?? '') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('hero_button_1_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hero_button_2_text" class="block text-sm font-medium text-gray-700 mb-2">Teks Tombol 2</label>
                        <input type="text" id="hero_button_2_text" name="hero_button_2_text" value="{{ old('hero_button_2_text', $homepageSetting->hero_button_2_text ?? '') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('hero_button_2_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hero_button_2_url" class="block text-sm font-medium text-gray-700 mb-2">URL Tombol 2</label>
                        <input type="url" id="hero_button_2_url" name="hero_button_2_url" value="{{ old('hero_button_2_url', $homepageSetting->hero_button_2_url ?? '') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('hero_button_2_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- File Uploads -->
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Hero Background Image Upload -->
                <div>
                    <label for="hero_background_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Background Hero</label>
                    
                    <!-- Current Image Preview -->
                    @if($homepageSetting && $homepageSetting->hero_background_image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ $homepageSetting->hero_background_image_url }}" alt="Background Hero Saat Ini" 
                                         class="w-20 h-20 rounded-lg object-cover border-2 border-gray-300">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">Background Hero Saat Ini</h4>
                                    <p class="text-sm text-gray-500">{{ $homepageSetting->hero_background_image }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        <button type="button" onclick="removeCurrentHeroBackground()" 
                                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                                            Hapus Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Upload Area -->
                    <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200" 
                         id="hero-background-upload-area">
                        <div class="upload-content">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4">
                                <label for="hero_background_image" class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">
                                        Upload Gambar Background Hero
                                    </span>
                                    <span class="mt-1 block text-sm text-gray-500">
                                        PNG, JPG, GIF hingga 2MB
                                    </span>
                                </label>
                                <input type="file" id="hero_background_image" name="hero_background_image" accept="image/*" 
                                       class="sr-only" onchange="previewHeroBackground(this)">
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="hero-background-preview" class="hidden mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img id="hero-background-preview-img" src="" alt="Preview Background Baru" 
                                     class="w-20 h-20 rounded-lg object-cover border-2 border-blue-300">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-blue-900">Background Baru</h4>
                                <p id="hero-background-preview-name" class="text-sm text-blue-700"></p>
                                <div class="mt-2">
                                    <button type="button" onclick="removeNewHeroBackground()" 
                                            class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('hero_background_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Logo Sekolah</label>
                    <input type="file" id="logo" name="logo" accept="image/*" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($homepageSetting && $homepageSetting->logo)
                        <p class="mt-2 text-sm text-gray-600">Logo saat ini: {{ $homepageSetting->logo }}</p>
                    @endif
                </div>

                <div>
                    <label for="school_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Sekolah</label>
                    <input type="file" id="school_image" name="school_image" accept="image/*" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('school_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($homepageSetting && $homepageSetting->school_image)
                        <p class="mt-2 text-sm text-gray-600">Gambar sekolah saat ini: {{ $homepageSetting->school_image }}</p>
                    @endif
                </div>
            </div>
        </div>


        <!-- Contact Information -->
        <div id="contact-info" class="admin-section bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Kontak</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $homepageSetting->contact_phone ?? '') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('contact_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $homepageSetting->contact_email ?? '') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('contact_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <input type="text" id="contact_address" name="contact_address" value="{{ old('contact_address', $homepageSetting->contact_address ?? '') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('contact_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Principal Information -->
        <div id="principal-info" class="admin-section bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Kepala Sekolah</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label for="principal_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kepala Sekolah</label>
                        <input type="text" id="principal_name" name="principal_name" value="{{ old('principal_name', $homepageSetting->principal_name ?? '') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('principal_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="principal_title" class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                        <input type="text" id="principal_title" name="principal_title" value="{{ old('principal_title', $homepageSetting->principal_title ?? '') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('principal_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="principal_message" class="block text-sm font-medium text-gray-700 mb-2">Pesan Kepala Sekolah</label>
                        <textarea id="principal_message" name="principal_message" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('principal_message', $homepageSetting->principal_message ?? '') }}</textarea>
                        @error('principal_message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="principal_photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Kepala Sekolah</label>
                    <input type="file" id="principal_photo" name="principal_photo" accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           onchange="console.log('File selected:', this.files[0])">
                    @error('principal_photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($homepageSetting && $homepageSetting->principal_photo)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                            <img src="{{ $homepageSetting->principal_photo_url }}" alt="Foto Kepala Sekolah" class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Accreditation Information -->
        <div id="accreditation" class="admin-section bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Akreditasi Sekolah</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label for="accreditation_grade" class="block text-sm font-medium text-gray-700 mb-2">Grade Akreditasi</label>
                        <input type="text" id="accreditation_grade" name="accreditation_grade" value="{{ old('accreditation_grade', $homepageSetting->accreditation_grade ?? '') }}" 
                               placeholder="A" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('accreditation_grade')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="accreditation_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Akreditasi</label>
                        <textarea id="accreditation_description" name="accreditation_description" rows="3" 
                                  placeholder="Predikat sangat baik dalam standar pendidikan nasional"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('accreditation_description', $homepageSetting->accreditation_description ?? '') }}</textarea>
                        @error('accreditation_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="accreditation_valid_until" class="block text-sm font-medium text-gray-700 mb-2">Berlaku Hingga</label>
                        <input type="text" id="accreditation_valid_until" name="accreditation_valid_until" value="{{ old('accreditation_valid_until', $homepageSetting->accreditation_valid_until ?? '') }}" 
                               placeholder="2025" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('accreditation_valid_until')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="accreditation_certificate" class="block text-sm font-medium text-gray-700 mb-2">Sertifikat Akreditasi</label>
                    <input type="file" id="accreditation_certificate" name="accreditation_certificate" accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('accreditation_certificate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($homepageSetting && $homepageSetting->accreditation_certificate)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Sertifikat saat ini:</p>
                            <img src="{{ $homepageSetting->accreditation_certificate_url }}" alt="Sertifikat Akreditasi" class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- About Page Information -->
        <div id="about-page" class="admin-section bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Halaman Tentang Kami</h2>
            
            <div class="space-y-8">
                <!-- Page Header -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="about_page_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Halaman</label>
                        <input type="text" id="about_page_title" name="about_page_title" value="{{ old('about_page_title', $homepageSetting->about_page_title ?? '') }}" 
                               placeholder="Tentang Kami" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('about_page_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="about_page_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                        <textarea id="about_page_description" name="about_page_description" rows="3" 
                                  placeholder="Deskripsi singkat tentang sekolah"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('about_page_description', $homepageSetting->about_page_description ?? '') }}</textarea>
                        @error('about_page_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- About Page Background Image -->
                <div>
                    <label for="about_page_background_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Background Halaman Tentang Kami</label>
                    
                    <!-- Current Image Preview -->
                    @if($homepageSetting && $homepageSetting->about_page_background_image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ $homepageSetting->about_page_background_image_url }}" alt="Background Tentang Kami Saat Ini" 
                                         class="w-20 h-20 rounded-lg object-cover border-2 border-gray-300">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">Background Tentang Kami Saat Ini</h4>
                                    <p class="text-sm text-gray-500">{{ $homepageSetting->about_page_background_image }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        <button type="button" onclick="removeCurrentAboutBackground()" 
                                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                                            Hapus Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Upload Area -->
                    <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200" 
                         id="about-background-upload-area">
                        <div class="upload-content">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4">
                                <label for="about_page_background_image" class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">
                                        Upload Gambar Background Tentang Kami
                                    </span>
                                    <span class="mt-1 block text-sm text-gray-500">
                                        PNG, JPG, GIF hingga 2MB
                                    </span>
                                </label>
                                <input type="file" id="about_page_background_image" name="about_page_background_image" accept="image/*" 
                                       class="sr-only" onchange="previewAboutBackground(this)">
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="about-background-preview" class="hidden mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img id="about-background-preview-img" src="" alt="Preview Background Baru" 
                                     class="w-20 h-20 rounded-lg object-cover border-2 border-blue-300">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-blue-900">Background Baru</h4>
                                <p id="about-background-preview-name" class="text-sm text-blue-700"></p>
                                <div class="mt-2">
                                    <button type="button" onclick="removeNewAboutBackground()" 
                                            class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('about_page_background_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Curriculum Page Background Image -->
                <div>
                    <label for="curriculum_page_background_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Background Halaman Kurikulum</label>
                    
                    <!-- Current Image Preview -->
                    @if($homepageSetting && $homepageSetting->curriculum_page_background_image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ $homepageSetting->curriculum_page_background_image_url }}" alt="Background Kurikulum Saat Ini" 
                                         class="w-20 h-20 rounded-lg object-cover border-2 border-gray-300">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">Background Kurikulum Saat Ini</h4>
                                    <p class="text-sm text-gray-500">{{ $homepageSetting->curriculum_page_background_image }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        <button type="button" onclick="removeCurrentCurriculumBackground()" 
                                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                                            Hapus Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Upload Area -->
                    <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200" 
                         id="curriculum-background-upload-area">
                        <div class="upload-content">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4">
                                <label for="curriculum_page_background_image" class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">
                                        Upload Gambar Background Kurikulum
                                    </span>
                                    <span class="mt-1 block text-sm text-gray-500">
                                        PNG, JPG, GIF hingga 2MB
                                    </span>
                                </label>
                                <input type="file" id="curriculum_page_background_image" name="curriculum_page_background_image" accept="image/*" 
                                       class="sr-only" onchange="previewCurriculumBackground(this)">
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="curriculum-background-preview" class="hidden mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img id="curriculum-background-preview-img" src="" alt="Preview Background Baru" 
                                     class="w-20 h-20 rounded-lg object-cover border-2 border-blue-300">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-blue-900">Background Baru</h4>
                                <p id="curriculum-background-preview-name" class="text-sm text-blue-700"></p>
                                <div class="mt-2">
                                    <button type="button" onclick="removeNewCurriculumBackground()" 
                                            class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('curriculum_page_background_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Extracurricular Page Background Image -->
                <div>
                    <label for="extracurricular_page_background_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Background Halaman Ekstrakurikuler</label>
                    
                    <!-- Current Image Preview -->
                    @if($homepageSetting && $homepageSetting->extracurricular_page_background_image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ $homepageSetting->extracurricular_page_background_image_url }}" alt="Background Ekstrakurikuler Saat Ini" 
                                         class="w-20 h-20 rounded-lg object-cover border-2 border-gray-300">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">Background Ekstrakurikuler Saat Ini</h4>
                                    <p class="text-sm text-gray-500">{{ $homepageSetting->extracurricular_page_background_image }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        <button type="button" onclick="removeCurrentExtracurricularBackground()" 
                                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                                            Hapus Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Upload Area -->
                    <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200" 
                         id="extracurricular-background-upload-area">
                        <div class="upload-content">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4">
                                <label for="extracurricular_page_background_image" class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">
                                        Upload Gambar Background Ekstrakurikuler
                                    </span>
                                    <span class="mt-1 block text-sm text-gray-500">
                                        PNG, JPG, GIF hingga 2MB
                                    </span>
                                </label>
                                <input type="file" id="extracurricular_page_background_image" name="extracurricular_page_background_image" accept="image/*" 
                                       class="sr-only" onchange="previewExtracurricularBackground(this)">
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="extracurricular-background-preview" class="hidden mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img id="extracurricular-background-preview-img" src="" alt="Preview Background Baru" 
                                     class="w-20 h-20 rounded-lg object-cover border-2 border-blue-300">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-blue-900">Background Baru</h4>
                                <p id="extracurricular-background-preview-name" class="text-sm text-blue-700"></p>
                                <div class="mt-2">
                                    <button type="button" onclick="removeNewExtracurricularBackground()" 
                                            class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('extracurricular_page_background_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gallery Page Background Image -->
                <div>
                    <label for="gallery_page_background_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Background Halaman Galeri</label>
                    
                    <!-- Current Image Preview -->
                    @if($homepageSetting && $homepageSetting->gallery_page_background_image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ $homepageSetting->gallery_page_background_image_url }}" alt="Background Galeri Saat Ini" 
                                         class="w-20 h-20 rounded-lg object-cover border-2 border-gray-300">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">Background Galeri Saat Ini</h4>
                                    <p class="text-sm text-gray-500">{{ $homepageSetting->gallery_page_background_image }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        <button type="button" onclick="removeCurrentGalleryBackground()" 
                                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                                            Hapus Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Upload Area -->
                    <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200" 
                         id="gallery-background-upload-area">
                        <div class="upload-content">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4">
                                <label for="gallery_page_background_image" class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">
                                        Upload Gambar Background Galeri
                                    </span>
                                    <span class="mt-1 block text-sm text-gray-500">
                                        PNG, JPG, GIF hingga 2MB
                                    </span>
                                </label>
                                <input type="file" id="gallery_page_background_image" name="gallery_page_background_image" accept="image/*" 
                                       class="sr-only" onchange="previewGalleryBackground(this)">
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="gallery-background-preview" class="hidden mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img id="gallery-background-preview-img" src="" alt="Preview Background Baru" 
                                     class="w-20 h-20 rounded-lg object-cover border-2 border-blue-300">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-blue-900">Background Baru</h4>
                                <p id="gallery-background-preview-name" class="text-sm text-blue-700"></p>
                                <div class="mt-2">
                                    <button type="button" onclick="removeNewGalleryBackground()" 
                                            class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('gallery_page_background_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PPDB Page Background Image -->
                <div>
                    <label for="ppdb_page_background_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Background Halaman PPDB</label>
                    
                    <!-- Current Image Preview -->
                    @if($homepageSetting && $homepageSetting->ppdb_page_background_image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ $homepageSetting->ppdb_page_background_image_url }}" alt="Background PPDB Saat Ini" 
                                         class="w-20 h-20 rounded-lg object-cover border-2 border-gray-300">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">Background PPDB Saat Ini</h4>
                                    <p class="text-sm text-gray-500">{{ $homepageSetting->ppdb_page_background_image }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        <button type="button" onclick="removeCurrentPpdbBackground()" 
                                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                                            Hapus Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Upload Area -->
                    <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200" 
                         id="ppdb-background-upload-area">
                        <div class="upload-content">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4">
                                <label for="ppdb_page_background_image" class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">
                                        Upload Gambar Background PPDB
                                    </span>
                                    <span class="mt-1 block text-sm text-gray-500">
                                        PNG, JPG, GIF hingga 2MB
                                    </span>
                                </label>
                                <input type="file" id="ppdb_page_background_image" name="ppdb_page_background_image" accept="image/*" 
                                       class="sr-only" onchange="previewPpdbBackground(this)">
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="ppdb-background-preview" class="hidden mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img id="ppdb-background-preview-img" src="" alt="Preview Background Baru" 
                                     class="w-20 h-20 rounded-lg object-cover border-2 border-blue-300">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-blue-900">Background Baru</h4>
                                <p id="ppdb-background-preview-name" class="text-sm text-blue-700"></p>
                                <div class="mt-2">
                                    <button type="button" onclick="removeNewPpdbBackground()" 
                                            class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('ppdb_page_background_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- News Page Background Image -->
                <div>
                    <label for="news_page_background_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Background Halaman Berita</label>
                    
                    <!-- Current Image Preview -->
                    @if($homepageSetting && $homepageSetting->news_page_background_image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ $homepageSetting->news_page_background_image_url }}" alt="Background Berita Saat Ini" 
                                         class="w-20 h-20 rounded-lg object-cover border-2 border-gray-300">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">Background Berita Saat Ini</h4>
                                    <p class="text-sm text-gray-500">{{ $homepageSetting->news_page_background_image }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        <button type="button" onclick="removeCurrentNewsBackground()" 
                                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                                            Hapus Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Upload Area -->
                    <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200" 
                         id="news-background-upload-area">
                        <div class="upload-content">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4">
                                <label for="news_page_background_image" class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">
                                        Upload Gambar Background Berita
                                    </span>
                                    <span class="mt-1 block text-sm text-gray-500">
                                        PNG, JPG, GIF hingga 2MB
                                    </span>
                                </label>
                                <input type="file" id="news_page_background_image" name="news_page_background_image" accept="image/*" 
                                       class="sr-only" onchange="previewNewsBackground(this)">
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="news-background-preview" class="hidden mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img id="news-background-preview-img" src="" alt="Preview Background Baru" 
                                     class="w-20 h-20 rounded-lg object-cover border-2 border-blue-300">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-blue-900">Background Baru</h4>
                                <p id="news-background-preview-name" class="text-sm text-blue-700"></p>
                                <div class="mt-2">
                                    <button type="button" onclick="removeNewNewsBackground()" 
                                            class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('news_page_background_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vision & Mission -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="about_page_vision" class="block text-sm font-medium text-gray-700 mb-2">Visi Sekolah</label>
                        <textarea id="about_page_vision" name="about_page_vision" rows="4" 
                                  placeholder="Visi sekolah"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('about_page_vision', $homepageSetting->about_page_vision ?? '') }}</textarea>
                        @error('about_page_vision')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="about_page_mission" class="block text-sm font-medium text-gray-700 mb-2">Misi Sekolah</label>
                        <textarea id="about_page_mission" name="about_page_mission" rows="4" 
                                  placeholder="Misi sekolah"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('about_page_mission', $homepageSetting->about_page_mission ?? '') }}</textarea>
                        @error('about_page_mission')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- History -->
                <div>
                    <label for="about_page_history" class="block text-sm font-medium text-gray-700 mb-2">Sejarah Sekolah</label>
                    <textarea id="about_page_history" name="about_page_history" rows="6" 
                              placeholder="Sejarah dan perkembangan sekolah"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('about_page_history', $homepageSetting->about_page_history ?? '') }}</textarea>
                    @error('about_page_history')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Principal Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label for="about_page_principal_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kepala Sekolah</label>
                            <input type="text" id="about_page_principal_name" name="about_page_principal_name" value="{{ old('about_page_principal_name', $homepageSetting->about_page_principal_name ?? '') }}" 
                                   placeholder="Nama kepala sekolah" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('about_page_principal_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="about_page_principal_title" class="block text-sm font-medium text-gray-700 mb-2">Jabatan Kepala Sekolah</label>
                            <input type="text" id="about_page_principal_title" name="about_page_principal_title" value="{{ old('about_page_principal_title', $homepageSetting->about_page_principal_title ?? '') }}" 
                                   placeholder="Kepala Sekolah" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('about_page_principal_title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="about_page_principal_message" class="block text-sm font-medium text-gray-700 mb-2">Pesan Kepala Sekolah</label>
                            <textarea id="about_page_principal_message" name="about_page_principal_message" rows="4" 
                                      placeholder="Pesan dari kepala sekolah"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('about_page_principal_message', $homepageSetting->about_page_principal_message ?? '') }}</textarea>
                            @error('about_page_principal_message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="about_page_principal_photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Kepala Sekolah</label>
                            <input type="file" id="about_page_principal_photo" name="about_page_principal_photo" accept="image/*"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('about_page_principal_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if($homepageSetting && $homepageSetting->about_page_principal_photo)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                                    <img src="{{ $homepageSetting->about_page_principal_photo_url }}" alt="Foto Kepala Sekolah" class="w-32 h-32 object-cover rounded-lg border">
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="about_page_school_photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Sekolah</label>
                            <input type="file" id="about_page_school_photo" name="about_page_school_photo" accept="image/*"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('about_page_school_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if($homepageSetting && $homepageSetting->about_page_school_photo)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                                    <img src="{{ $homepageSetting->about_page_school_photo_url }}" alt="Foto Sekolah" class="w-32 h-32 object-cover rounded-lg border">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Organization Chart -->
                <div>
                    <label for="about_page_organization_chart" class="block text-sm font-medium text-gray-700 mb-2">Struktur Organisasi</label>
                    <input type="file" id="about_page_organization_chart" name="about_page_organization_chart" accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('about_page_organization_chart')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($homepageSetting && $homepageSetting->about_page_organization_chart)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Struktur organisasi saat ini:</p>
                            <img src="{{ $homepageSetting->about_page_organization_chart_url }}" alt="Struktur Organisasi" class="w-64 h-64 object-cover rounded-lg border">
                        </div>
                    @endif
                </div>

                <!-- Achievements -->
                <div>
                    <label for="about_page_achievements" class="block text-sm font-medium text-gray-700 mb-2">Prestasi & Pencapaian</label>
                    <textarea id="about_page_achievements" name="about_page_achievements" rows="6" 
                              placeholder="Daftar prestasi dan pencapaian sekolah"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('about_page_achievements', $homepageSetting->about_page_achievements ?? '') }}</textarea>
                    @error('about_page_achievements')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Facilities Description -->
                <div>
                    <label for="about_page_facilities_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Fasilitas</label>
                    <textarea id="about_page_facilities_description" name="about_page_facilities_description" rows="4" 
                              placeholder="Deskripsi fasilitas sekolah"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('about_page_facilities_description', $homepageSetting->about_page_facilities_description ?? '') }}</textarea>
                    @error('about_page_facilities_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Organization Structure -->
        <div id="organization-structure" class="admin-section bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Struktur Organisasi</h2>
            
            <div class="space-y-6">
                <!-- Organization Structure Title -->
                <div>
                    <label for="organization_structure_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Struktur Organisasi</label>
                    <input type="text" id="organization_structure_title" name="organization_structure_title" value="{{ old('organization_structure_title', $homepageSetting->organization_structure_title ?? '') }}" 
                           placeholder="Struktur Organisasi SMP Negeri 01 Namrole" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('organization_structure_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Organization Structure Description -->
                <div>
                    <label for="organization_structure_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Struktur Organisasi</label>
                    <textarea id="organization_structure_description" name="organization_structure_description" rows="4" 
                              placeholder="Deskripsi struktur organisasi sekolah"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('organization_structure_description', $homepageSetting->organization_structure_description ?? '') }}</textarea>
                    @error('organization_structure_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Organization Structure Image -->
                <div>
                    <label for="organization_structure_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Struktur Organisasi</label>
                    <input type="file" id="organization_structure_image" name="organization_structure_image" accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('organization_structure_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($homepageSetting && $homepageSetting->organization_structure_image)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                            <img src="{{ $homepageSetting->organization_structure_image_url }}" alt="Struktur Organisasi" class="w-full max-w-md object-cover rounded-lg border">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Library Structure -->
        <div id="library-structure" class="admin-section bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Struktur Organisasi Perpustakaan</h2>
            
            <div class="space-y-6">
                <!-- Library Structure Image -->
                <div>
                    <label for="library_structure_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Struktur Organisasi Perpustakaan</label>
                    <input type="file" id="library_structure_image" name="library_structure_image" accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('library_structure_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($homepageSetting && $homepageSetting->library_structure_image)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                            <img src="{{ $homepageSetting->library_structure_image_url }}" alt="Struktur Organisasi Perpustakaan" class="w-full max-w-md object-cover rounded-lg border">
                        </div>
                    @else
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Gambar default:</p>
                            <img src="{{ asset('images/STRUKTUR ORGANISASI PERPUSTAKAAN.png') }}" alt="Struktur Organisasi Perpustakaan" class="w-full max-w-md object-cover rounded-lg border">
                        </div>
                    @endif
                </div>

                <!-- Library Information -->
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Perpustakaan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jam Operasional -->
                        <div>
                            <label for="library_operational_hours_weekdays" class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional (Senin-Jumat)</label>
                            <input type="text" id="library_operational_hours_weekdays" name="library_operational_hours_weekdays" 
                                   value="{{ old('library_operational_hours_weekdays', $homepageSetting->library_operational_hours_weekdays ?? 'Senin - Jumat: 07.00 - 15.00 WIT') }}" 
                                   placeholder="Senin - Jumat: 07.00 - 15.00 WIT"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('library_operational_hours_weekdays')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="library_operational_hours_saturday" class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional (Sabtu)</label>
                            <input type="text" id="library_operational_hours_saturday" name="library_operational_hours_saturday" 
                                   value="{{ old('library_operational_hours_saturday', $homepageSetting->library_operational_hours_saturday ?? 'Sabtu: 08.00 - 12.00 WIT') }}" 
                                   placeholder="Sabtu: 08.00 - 12.00 WIT"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('library_operational_hours_saturday')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <label for="library_location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi Perpustakaan</label>
                            <input type="text" id="library_location" name="library_location" 
                                   value="{{ old('library_location', $homepageSetting->library_location ?? 'Gedung Perpustakaan, SMP Negeri 01 Namrole') }}" 
                                   placeholder="Gedung Perpustakaan, SMP Negeri 01 Namrole"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('library_location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="library_email" class="block text-sm font-medium text-gray-700 mb-2">Email Perpustakaan</label>
                            <input type="email" id="library_email" name="library_email" 
                                   value="{{ old('library_email', $homepageSetting->library_email ?? 'perpustakaan@smpn01namrole.sch.id') }}" 
                                   placeholder="perpustakaan@smpn01namrole.sch.id"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('library_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="library_phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon Perpustakaan</label>
                            <input type="text" id="library_phone" name="library_phone" 
                                   value="{{ old('library_phone', $homepageSetting->library_phone ?? '(0913) 123456') }}" 
                                   placeholder="(0913) 123456"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('library_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row gap-4 pt-6">
            <button type="submit" 
                    class="inline-flex items-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Pengaturan
            </button>
            
            <a href="{{ route('admin.homepage-settings.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Batal
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for navigation tabs
    const navLinks = document.querySelectorAll('a[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                // Smooth scroll with gentle animation
                const offset = 100; // Account for fixed header
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - offset;

                // Use requestAnimationFrame for smoother scroll
                const startPosition = window.pageYOffset;
                const distance = offsetPosition - startPosition;
                const duration = 800; // Slower, more gentle scroll
                let start = null;

                function step(timestamp) {
                    if (!start) start = timestamp;
                    const progress = Math.min((timestamp - start) / duration, 1);
                    
                    // Easing function for smooth deceleration
                    const ease = 1 - Math.pow(1 - progress, 3);
                    
                    window.scrollTo(0, startPosition + distance * ease);
                    
                    if (progress < 1) {
                        requestAnimationFrame(step);
                    }
                }
                
                requestAnimationFrame(step);
                
                // Update active tab
                updateActiveTab(this);
            }
        });
    });

    // Update active tab based on scroll position
    function updateActiveTab(activeLink) {
        // Remove active class from all tabs
        document.querySelectorAll('.nav-tab').forEach(tab => {
            tab.classList.remove('bg-primary-100', 'text-primary-700');
            tab.classList.add('bg-gray-100', 'text-gray-700');
        });
        
        // Add active class to clicked tab
        activeLink.classList.remove('bg-gray-100', 'text-gray-700');
        activeLink.classList.add('bg-primary-100', 'text-primary-700');
    }

    // Add nav-tab class to navigation links
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.classList.add('nav-tab');
    });

    // Live Preview Toggle
    const togglePreviewBtn = document.getElementById('toggle-preview');
    const previewContainer = document.getElementById('preview-container');
    const previewIframe = document.getElementById('preview-iframe');
    let previewVisible = false;

    togglePreviewBtn.addEventListener('click', function() {
        previewVisible = !previewVisible;
        
        if (previewVisible) {
            previewContainer.classList.remove('hidden');
            togglePreviewBtn.innerHTML = `
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                </svg>
                Hide Preview
            `;
            togglePreviewBtn.classList.remove('bg-blue-500', 'hover:bg-blue-600');
            togglePreviewBtn.classList.add('bg-red-500', 'hover:bg-red-600');
        } else {
            previewContainer.classList.add('hidden');
            togglePreviewBtn.innerHTML = `
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Toggle Preview
            `;
            togglePreviewBtn.classList.remove('bg-red-500', 'hover:bg-red-600');
            togglePreviewBtn.classList.add('bg-blue-500', 'hover:bg-blue-600');
        }
    });

    // Auto-refresh preview when form changes
    const formInputs = document.querySelectorAll('input, textarea, select');
    let refreshTimeout;

    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (previewVisible) {
                clearTimeout(refreshTimeout);
                refreshTimeout = setTimeout(() => {
                    refreshPreview();
                }, 1000); // Refresh after 1 second of no typing
            }
        });
    });

    function refreshPreview() {
        if (previewVisible) {
            const currentSrc = previewIframe.src;
            previewIframe.src = '';
            setTimeout(() => {
                previewIframe.src = currentSrc;
            }, 100);
        }
    }

    // Form submission with preview update
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        `;
        submitBtn.disabled = true;

        // After successful submission, refresh preview
        setTimeout(() => {
            if (previewVisible) {
                refreshPreview();
            }
        }, 2000);
    });

    // Real-time preview updates for text fields
    const textInputs = document.querySelectorAll('input[type="text"], textarea');
    let autoSaveTimeout;
    let isAutoSaving = false;

    textInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Update status to show user is typing
            updateStatusIndicator('saving', 'Mengedit...');
            
            if (previewVisible) {
                // Auto-save changes via AJAX
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(() => {
                    autoSaveChanges();
                }, 2000); // Auto-save after 2 seconds of no typing
            }
        });
    });

    function autoSaveChanges() {
        if (isAutoSaving) return;
        
        isAutoSaving = true;
        updateStatusIndicator('saving', 'Menyimpan perubahan...');
        
        const formData = new FormData();
        
        // Collect all form data
        textInputs.forEach(input => {
            if (input.value.trim() !== '') {
                formData.append(input.name, input.value);
            }
        });

        // Add CSRF token
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        fetch('{{ route("admin.homepage-settings.ajax-update") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success indicator
                updateStatusIndicator('saved', 'Perubahan tersimpan');
                showAutoSaveIndicator('Perubahan tersimpan otomatis');
                // Refresh preview
                refreshPreview();
            }
        })
        .catch(error => {
            console.error('Auto-save error:', error);
            updateStatusIndicator('error', 'Gagal menyimpan');
            showAutoSaveIndicator('Gagal menyimpan perubahan', 'error');
        })
        .finally(() => {
            isAutoSaving = false;
            // Reset status after 3 seconds
            setTimeout(() => {
                updateStatusIndicator('ready', 'Siap untuk mengedit');
            }, 3000);
        });
    }

    function updateStatusIndicator(status, text) {
        const indicator = document.getElementById('status-indicator');
        const statusText = document.getElementById('status-text');
        
        // Remove existing classes
        indicator.classList.remove('bg-gray-400', 'bg-yellow-400', 'bg-green-500', 'bg-red-500', 'animate-pulse');
        
        switch(status) {
            case 'ready':
                indicator.classList.add('bg-gray-400');
                break;
            case 'saving':
                indicator.classList.add('bg-yellow-400', 'animate-pulse');
                break;
            case 'saved':
                indicator.classList.add('bg-green-500');
                break;
            case 'error':
                indicator.classList.add('bg-red-500');
                break;
        }
        
        statusText.textContent = text;
    }

    function showAutoSaveIndicator(message, type = 'success') {
        // Remove existing indicator
        const existingIndicator = document.querySelector('.auto-save-indicator');
        if (existingIndicator) {
            existingIndicator.remove();
        }

        // Create new indicator
        const indicator = document.createElement('div');
        indicator.className = `auto-save-indicator fixed top-4 right-4 px-4 py-2 rounded-lg text-white text-sm z-50 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        indicator.textContent = message;
        
        document.body.appendChild(indicator);

        // Remove after 3 seconds
        setTimeout(() => {
            if (indicator.parentNode) {
                indicator.parentNode.removeChild(indicator);
            }
        }, 3000);
    }

    function updatePreviewContent(fieldName, value) {
        // This would require a more complex setup with iframe communication
        // For now, we'll just refresh the iframe
        if (previewVisible) {
            clearTimeout(refreshTimeout);
            refreshTimeout = setTimeout(() => {
                refreshPreview();
            }, 500);
        }
    }

    // Hero Background Image Upload Functions
    function previewHeroBackground(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.getElementById('hero-background-preview');
                const previewImg = document.getElementById('hero-background-preview-img');
                const previewName = document.getElementById('hero-background-preview-name');
                
                previewImg.src = e.target.result;
                previewName.textContent = file.name;
                preview.classList.remove('hidden');
                preview.classList.add('photo-preview');
                
                // Hide upload area
                document.getElementById('hero-background-upload-area').style.display = 'none';
            };
            
            reader.readAsDataURL(file);
        }
    }

    function removeNewHeroBackground() {
        const preview = document.getElementById('hero-background-preview');
        const uploadArea = document.getElementById('hero-background-upload-area');
        const fileInput = document.getElementById('hero_background_image');
        
        preview.classList.add('hidden');
        uploadArea.style.display = 'block';
        fileInput.value = '';
    }

    function removeCurrentHeroBackground() {
        if (confirm('Apakah Anda yakin ingin menghapus gambar background hero saat ini?')) {
            // Add hidden input to indicate image should be removed
            const form = document.querySelector('form');
            
            // Remove existing hidden input if any
            const existingInput = document.querySelector('input[name="remove_hero_background"]');
            if (existingInput) {
                existingInput.remove();
            }
            
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_hero_background';
            hiddenInput.value = '1';
            form.appendChild(hiddenInput);
            
            // Hide current image section
            const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
            if (currentImageSection) {
                currentImageSection.style.display = 'none';
            }
            
            // Show upload area
            const uploadArea = document.getElementById('hero-background-upload-area');
            if (uploadArea) {
                uploadArea.style.display = 'block';
            }
            
            // Clear file input
            const fileInput = document.getElementById('hero_background_image');
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Show visual feedback
            const uploadArea = document.getElementById('hero-background-upload-area');
            if (uploadArea) {
                uploadArea.innerHTML = `
                    <div class="text-center p-8">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-red-600 mb-2">Gambar Akan Dihapus</h3>
                        <p class="text-sm text-gray-600 mb-4">Gambar background hero akan dihapus saat Anda menyimpan perubahan.</p>
                        <button type="button" onclick="cancelRemoveHeroBackground()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm">
                            Batalkan
                        </button>
                    </div>
                `;
            }
        }
    }

    function cancelRemoveHeroBackground() {
        // Remove hidden input
        const existingInput = document.querySelector('input[name="remove_hero_background"]');
        if (existingInput) {
            existingInput.remove();
        }
        
        // Show current image section again
        const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
        if (currentImageSection) {
            currentImageSection.style.display = 'block';
        }
        
        // Reset upload area
        const uploadArea = document.getElementById('hero-background-upload-area');
        if (uploadArea) {
            uploadArea.innerHTML = `
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Upload Gambar Baru</h3>
                    <p class="text-sm text-gray-600 mb-4">Klik atau drag & drop gambar untuk mengganti background hero</p>
                    <p class="text-xs text-gray-500">Format: JPG, PNG, GIF (Maksimal 2MB)</p>
                </div>
            `;
            uploadArea.style.display = 'block';
        }
    }

    // About Page Background Functions
    function previewAboutBackground(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('about-background-preview-img').src = e.target.result;
                document.getElementById('about-background-preview-name').textContent = input.files[0].name;
                document.getElementById('about-background-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeNewAboutBackground() {
        document.getElementById('about-background-preview').classList.add('hidden');
        document.getElementById('about_page_background_image').value = '';
    }

    function removeCurrentAboutBackground() {
        if (confirm('Apakah Anda yakin ingin menghapus gambar background tentang kami saat ini?')) {
            // Add hidden input to indicate image should be removed
            const form = document.querySelector('form');
            
            // Remove existing hidden input if any
            const existingInput = document.querySelector('input[name="remove_about_background"]');
            if (existingInput) {
                existingInput.remove();
            }
            
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_about_background';
            hiddenInput.value = '1';
            form.appendChild(hiddenInput);
            
            // Hide current image section
            const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
            if (currentImageSection) {
                currentImageSection.style.display = 'none';
            }
            
            // Show upload area
            const uploadArea = document.getElementById('about-background-upload-area');
            if (uploadArea) {
                uploadArea.style.display = 'block';
            }
            
            // Clear file input
            const fileInput = document.getElementById('about_page_background_image');
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Show visual feedback
            const uploadArea = document.getElementById('about-background-upload-area');
            if (uploadArea) {
                uploadArea.innerHTML = `
                    <div class="text-center p-8">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-red-600 mb-2">Gambar Akan Dihapus</h3>
                        <p class="text-sm text-gray-600 mb-4">Gambar background tentang kami akan dihapus saat Anda menyimpan perubahan.</p>
                        <button type="button" onclick="cancelRemoveAboutBackground()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm">
                            Batalkan
                        </button>
                    </div>
                `;
            }
        }
    }

    function cancelRemoveAboutBackground() {
        // Remove hidden input
        const existingInput = document.querySelector('input[name="remove_about_background"]');
        if (existingInput) {
            existingInput.remove();
        }
        
        // Show current image section again
        const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
        if (currentImageSection) {
            currentImageSection.style.display = 'block';
        }
        
        // Reset upload area
        const uploadArea = document.getElementById('about-background-upload-area');
        if (uploadArea) {
            uploadArea.innerHTML = `
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Upload Gambar Baru</h3>
                    <p class="text-sm text-gray-600 mb-4">Klik atau drag & drop gambar untuk mengganti background tentang kami</p>
                    <p class="text-xs text-gray-500">Format: JPG, PNG, GIF (Maksimal 2MB)</p>
                </div>
            `;
            uploadArea.style.display = 'block';
        }
    }

    // Curriculum Background Functions
    function previewCurriculumBackground(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                input.value = '';
                return;
            }
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                input.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('curriculum-background-preview-img').src = e.target.result;
                document.getElementById('curriculum-background-preview-name').textContent = file.name;
                document.getElementById('curriculum-background-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    function removeNewCurriculumBackground() {
        document.getElementById('curriculum-background-preview').classList.add('hidden');
        document.getElementById('curriculum_page_background_image').value = '';
    }

    function removeCurrentCurriculumBackground() {
        if (confirm('Apakah Anda yakin ingin menghapus gambar background kurikulum saat ini?')) {
            // Add hidden input to indicate image should be removed
            const form = document.querySelector('form');
            
            // Remove existing hidden input if any
            const existingInput = document.querySelector('input[name="remove_curriculum_background"]');
            if (existingInput) {
                existingInput.remove();
            }
            
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_curriculum_background';
            hiddenInput.value = '1';
            form.appendChild(hiddenInput);
            
            // Hide current image section
            const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
            if (currentImageSection) {
                currentImageSection.style.display = 'none';
            }
            
            // Show upload area
            const uploadArea = document.getElementById('curriculum-background-upload-area');
            if (uploadArea) {
                uploadArea.style.display = 'block';
            }
            
            // Clear file input
            const fileInput = document.getElementById('curriculum_page_background_image');
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Show visual feedback
            const uploadArea = document.getElementById('curriculum-background-upload-area');
            if (uploadArea) {
                uploadArea.innerHTML = `
                    <div class="text-center p-8">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-red-600 mb-2">Gambar Akan Dihapus</h3>
                        <p class="text-sm text-gray-600 mb-4">Gambar background kurikulum akan dihapus saat Anda menyimpan perubahan.</p>
                        <button type="button" onclick="cancelRemoveCurriculumBackground()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm">
                            Batalkan
                        </button>
                    </div>
                `;
            }
        }
    }

    function cancelRemoveCurriculumBackground() {
        // Remove hidden input
        const existingInput = document.querySelector('input[name="remove_curriculum_background"]');
        if (existingInput) {
            existingInput.remove();
        }
        
        // Show current image section again
        const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
        if (currentImageSection) {
            currentImageSection.style.display = 'block';
        }
        
        // Reset upload area
        const uploadArea = document.getElementById('curriculum-background-upload-area');
        if (uploadArea) {
            uploadArea.innerHTML = `
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Upload Gambar Baru</h3>
                    <p class="text-sm text-gray-600 mb-4">Klik atau drag & drop gambar untuk mengganti background kurikulum</p>
                    <p class="text-xs text-gray-500">Format: JPG, PNG, GIF (Maksimal 2MB)</p>
                </div>
            `;
            uploadArea.style.display = 'block';
        }
    }

    // Extracurricular Background Functions
    function previewExtracurricularBackground(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                input.value = '';
                return;
            }
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                input.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('extracurricular-background-preview-img').src = e.target.result;
                document.getElementById('extracurricular-background-preview-name').textContent = file.name;
                document.getElementById('extracurricular-background-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    function removeNewExtracurricularBackground() {
        document.getElementById('extracurricular-background-preview').classList.add('hidden');
        document.getElementById('extracurricular_page_background_image').value = '';
    }

    function removeCurrentExtracurricularBackground() {
        if (confirm('Apakah Anda yakin ingin menghapus gambar background ekstrakurikuler saat ini?')) {
            // Add hidden input to indicate image should be removed
            const form = document.querySelector('form');
            
            // Remove existing hidden input if any
            const existingInput = document.querySelector('input[name="remove_extracurricular_background"]');
            if (existingInput) {
                existingInput.remove();
            }
            
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_extracurricular_background';
            hiddenInput.value = '1';
            form.appendChild(hiddenInput);
            
            // Hide current image section
            const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
            if (currentImageSection) {
                currentImageSection.style.display = 'none';
            }
            
            // Show upload area
            const uploadArea = document.getElementById('extracurricular-background-upload-area');
            if (uploadArea) {
                uploadArea.style.display = 'block';
            }
            
            // Clear file input
            const fileInput = document.getElementById('extracurricular_page_background_image');
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Show visual feedback
            const uploadArea = document.getElementById('extracurricular-background-upload-area');
            if (uploadArea) {
                uploadArea.innerHTML = `
                    <div class="text-center p-8">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-red-600 mb-2">Gambar Akan Dihapus</h3>
                        <p class="text-sm text-gray-600 mb-4">Gambar background ekstrakurikuler akan dihapus saat Anda menyimpan perubahan.</p>
                        <button type="button" onclick="cancelRemoveExtracurricularBackground()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm">
                            Batalkan
                        </button>
                    </div>
                `;
            }
        }
    }

    function cancelRemoveExtracurricularBackground() {
        // Remove hidden input
        const existingInput = document.querySelector('input[name="remove_extracurricular_background"]');
        if (existingInput) {
            existingInput.remove();
        }
        
        // Show current image section again
        const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
        if (currentImageSection) {
            currentImageSection.style.display = 'block';
        }
        
        // Reset upload area
        const uploadArea = document.getElementById('extracurricular-background-upload-area');
        if (uploadArea) {
            uploadArea.innerHTML = `
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Upload Gambar Baru</h3>
                    <p class="text-sm text-gray-600 mb-4">Klik atau drag & drop gambar untuk mengganti background ekstrakurikuler</p>
                    <p class="text-xs text-gray-500">Format: JPG, PNG, GIF (Maksimal 2MB)</p>
                </div>
            `;
            uploadArea.style.display = 'block';
        }
    }

    // Gallery Background Functions
    function previewGalleryBackground(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                input.value = '';
                return;
            }
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                input.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('gallery-background-preview-img').src = e.target.result;
                document.getElementById('gallery-background-preview-name').textContent = file.name;
                document.getElementById('gallery-background-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    function removeNewGalleryBackground() {
        document.getElementById('gallery-background-preview').classList.add('hidden');
        document.getElementById('gallery_page_background_image').value = '';
    }

    function removeCurrentGalleryBackground() {
        if (confirm('Apakah Anda yakin ingin menghapus gambar background galeri saat ini?')) {
            // Add hidden input to indicate image should be removed
            const form = document.querySelector('form');
            
            // Remove existing hidden input if any
            const existingInput = document.querySelector('input[name="remove_gallery_background"]');
            if (existingInput) {
                existingInput.remove();
            }
            
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_gallery_background';
            hiddenInput.value = '1';
            form.appendChild(hiddenInput);
            
            // Hide current image section
            const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
            if (currentImageSection) {
                currentImageSection.style.display = 'none';
            }
            
            // Show upload area
            const uploadArea = document.getElementById('gallery-background-upload-area');
            if (uploadArea) {
                uploadArea.style.display = 'block';
            }
            
            // Clear file input
            const fileInput = document.getElementById('gallery_page_background_image');
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Show visual feedback
            const uploadArea = document.getElementById('gallery-background-upload-area');
            if (uploadArea) {
                uploadArea.innerHTML = `
                    <div class="text-center p-8">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-red-600 mb-2">Gambar Akan Dihapus</h3>
                        <p class="text-sm text-gray-600 mb-4">Gambar background galeri akan dihapus saat Anda menyimpan perubahan.</p>
                        <button type="button" onclick="cancelRemoveGalleryBackground()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm">
                            Batalkan
                        </button>
                    </div>
                `;
            }
        }
    }

    function cancelRemoveGalleryBackground() {
        // Remove hidden input
        const existingInput = document.querySelector('input[name="remove_gallery_background"]');
        if (existingInput) {
            existingInput.remove();
        }
        
        // Show current image section again
        const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
        if (currentImageSection) {
            currentImageSection.style.display = 'block';
        }
        
        // Reset upload area
        const uploadArea = document.getElementById('gallery-background-upload-area');
        if (uploadArea) {
            uploadArea.innerHTML = `
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Upload Gambar Baru</h3>
                    <p class="text-sm text-gray-600 mb-4">Klik atau drag & drop gambar untuk mengganti background galeri</p>
                    <p class="text-xs text-gray-500">Format: JPG, PNG, GIF (Maksimal 2MB)</p>
                </div>
            `;
            uploadArea.style.display = 'block';
        }
    }

    // PPDB Background Functions
    function previewPpdbBackground(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('ppdb-background-preview-img').src = e.target.result;
                document.getElementById('ppdb-background-preview-name').textContent = file.name;
                document.getElementById('ppdb-background-preview').classList.remove('hidden');
            };
            
            reader.readAsDataURL(file);
        }
    }

    function removeNewPpdbBackground() {
        document.getElementById('ppdb_page_background_image').value = '';
        document.getElementById('ppdb-background-preview').classList.add('hidden');
    }

    function removeCurrentPpdbBackground() {
        // Add hidden input to indicate removal
        const existingInput = document.querySelector('input[name="remove_ppdb_background"]');
        if (existingInput) {
            existingInput.remove();
        }
        
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'remove_ppdb_background';
        hiddenInput.value = '1';
        document.querySelector('form').appendChild(hiddenInput);
        
        // Hide current image section
        const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
        if (currentImageSection) {
            currentImageSection.style.display = 'none';
        }
        
        // Show upload area
        const uploadArea = document.getElementById('ppdb-background-upload-area');
        if (uploadArea) {
            uploadArea.style.display = 'block';
        }
    }

    function cancelRemovePpdbBackground() {
        // Remove hidden input
        const existingInput = document.querySelector('input[name="remove_ppdb_background"]');
        if (existingInput) {
            existingInput.remove();
        }
        
        // Show current image section again
        const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
        if (currentImageSection) {
            currentImageSection.style.display = 'block';
        }
        
        // Reset upload area
        const uploadArea = document.getElementById('ppdb-background-upload-area');
        if (uploadArea) {
            uploadArea.innerHTML = `
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Upload Gambar Baru</h3>
                    <p class="text-sm text-gray-600 mb-4">Klik atau drag & drop gambar untuk mengganti background PPDB</p>
                    <p class="text-xs text-gray-500">Format: JPG, PNG, GIF (Maksimal 2MB)</p>
                </div>
            `;
            uploadArea.style.display = 'block';
        }
    }

    // News Background Functions
    function previewNewsBackground(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('news-background-preview-img').src = e.target.result;
                document.getElementById('news-background-preview-name').textContent = file.name;
                document.getElementById('news-background-preview').classList.remove('hidden');
            };
            
            reader.readAsDataURL(file);
        }
    }

    function removeNewNewsBackground() {
        document.getElementById('news_page_background_image').value = '';
        document.getElementById('news-background-preview').classList.add('hidden');
    }

    function removeCurrentNewsBackground() {
        // Add hidden input to indicate removal
        const existingInput = document.querySelector('input[name="remove_news_background"]');
        if (existingInput) {
            existingInput.remove();
        }
        
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'remove_news_background';
        hiddenInput.value = '1';
        document.querySelector('form').appendChild(hiddenInput);
        
        // Hide current image section
        const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
        if (currentImageSection) {
            currentImageSection.style.display = 'none';
        }
        
        // Show upload area
        const uploadArea = document.getElementById('news-background-upload-area');
        if (uploadArea) {
            uploadArea.style.display = 'block';
        }
    }

    function cancelRemoveNewsBackground() {
        // Remove hidden input
        const existingInput = document.querySelector('input[name="remove_news_background"]');
        if (existingInput) {
            existingInput.remove();
        }
        
        // Show current image section again
        const currentImageSection = document.querySelector('.mb-4.p-4.bg-gray-50');
        if (currentImageSection) {
            currentImageSection.style.display = 'block';
        }
        
        // Reset upload area
        const uploadArea = document.getElementById('news-background-upload-area');
        if (uploadArea) {
            uploadArea.innerHTML = `
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Upload Gambar Baru</h3>
                    <p class="text-sm text-gray-600 mb-4">Klik atau drag & drop gambar untuk mengganti background berita</p>
                    <p class="text-xs text-gray-500">Format: JPG, PNG, GIF (Maksimal 2MB)</p>
                </div>
            `;
            uploadArea.style.display = 'block';
        }
    }

    // Drag and drop functionality for hero background
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.getElementById('hero-background-upload-area');
        const fileInput = document.getElementById('hero_background_image');
        
        if (uploadArea) {
            // Drag and drop events
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });
            
            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
            });
            
            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    previewHeroBackground(fileInput);
                }
            });
            
            // Click to upload
            uploadArea.addEventListener('click', function() {
                fileInput.click();
            });
        }
    });

    // Form validation for hero background
    document.querySelector('form').addEventListener('submit', function(e) {
        const fileInput = document.getElementById('hero_background_image');
        const file = fileInput.files[0];
        
        if (file) {
            // Check file size (2MB limit)
            if (file.size > 2 * 1024 * 1024) {
                e.preventDefault();
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                return;
            }
            
            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                e.preventDefault();
                alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                return;
            }
        }
    });
});
</script>

@push('styles')
<style>
.upload-area {
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-area:hover {
    border-color: #3B82F6;
    background-color: #EFF6FF;
}

.upload-area.dragover {
    border-color: #3B82F6;
    background-color: #EFF6FF;
    transform: scale(1.02);
}

.upload-content {
    pointer-events: none;
}

.upload-area:hover .upload-content svg {
    color: #3B82F6;
}

.photo-preview {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.photo-preview img {
    transition: transform 0.2s ease;
}

.photo-preview img:hover {
    transform: scale(1.05);
}
</style>
@endpush
@endsection
