@extends('layouts.app')

@section('title', $gallery->title . ' - Galeri Sekolah')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('gallery.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2">Galeri</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $gallery->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Album Header -->
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <!-- Title Section -->
                <div class="mb-8">
                    <h1 class="text-3xl md:text-4xl xl:text-5xl font-bold text-gray-900 mb-6 leading-tight" style="color: #13315c;">
                        {{ $gallery->title }}
                    </h1>
                    
                    <!-- Badges -->
                    <div class="flex flex-wrap justify-center gap-4">
                        <span class="inline-flex items-center px-6 py-3 rounded-full text-sm font-medium text-white shadow-lg" style="background-color: #13315c;">
                            {{ $gallery->category_name }}
                        </span>
                        
                        @if($gallery->is_featured)
                        <span class="inline-flex items-center px-6 py-3 rounded-full text-sm font-bold text-yellow-800 bg-yellow-200 shadow-lg">
                            ⭐ Featured Album
                        </span>
                        @endif
                    </div>
                </div>
                
                <!-- Meta Information -->
                <div class="flex flex-wrap justify-center gap-8 mb-8">
                    @if($gallery->date)
                    <div class="flex items-center bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full shadow-md">
                        <svg class="w-6 h-6 mr-3 text-[#13315c]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-lg font-semibold text-gray-800">{{ $gallery->formatted_date }}</span>
                    </div>
                    @endif
                    @if($gallery->location)
                    <div class="flex items-center bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full shadow-md">
                        <svg class="w-6 h-6 mr-3 text-[#13315c]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-lg font-semibold text-gray-800">{{ $gallery->location }}</span>
                    </div>
                    @endif
                    @if($gallery->photographer)
                    <div class="flex items-center bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full shadow-md">
                        <svg class="w-6 h-6 mr-3 text-[#13315c]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-lg font-semibold text-gray-800">{{ $gallery->photographer }}</span>
                    </div>
                    @endif
                    <div class="flex items-center bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full shadow-md">
                        <svg class="w-6 h-6 mr-3 text-[#13315c]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-lg font-semibold text-gray-800">{{ $gallery->total_photos }} Foto</span>
                    </div>
                    <div class="flex items-center bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full shadow-md">
                        <svg class="w-6 h-6 mr-3 text-[#13315c]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-lg font-semibold text-gray-800">{{ $gallery->view_count }} views</span>
                    </div>
                </div>
                
                <!-- Description -->
                @if($gallery->description)
                <div class="max-w-5xl mx-auto mb-8">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-[#13315c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Deskripsi Album
                        </h3>
                        <p class="text-lg text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $gallery->description }}
                        </p>
                    </div>
                </div>
                @endif
                
                <!-- Share Buttons -->
                <div class="flex flex-wrap justify-center gap-4">
                    <button onclick="shareToFacebook()" class="flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="font-semibold">Facebook</span>
                    </button>
                    <button onclick="shareToTwitter()" class="flex items-center px-6 py-3 bg-blue-400 text-white rounded-xl hover:bg-blue-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        <span class="font-semibold">Twitter</span>
                    </button>
                    <button onclick="shareToWhatsApp()" class="flex items-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        <span class="font-semibold">WhatsApp</span>
                    </button>
                    <button onclick="copyLink()" class="flex items-center px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-semibold">Copy Link</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Gallery -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- View Toggle -->
        <div class="flex justify-center mb-10">
            <div class="flex bg-gray-100 rounded-xl p-2 shadow-lg">
                <button onclick="setViewMode('grid')" id="grid-view-btn" class="view-toggle active px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-300">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Grid
                </button>
                <button onclick="setViewMode('masonry')" id="masonry-view-btn" class="view-toggle px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-300">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Masonry
                </button>
                <button onclick="setViewMode('slideshow')" id="slideshow-view-btn" class="view-toggle px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-300">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Slideshow
                </button>
            </div>
        </div>

        <!-- Grid View -->
        <div id="grid-view" class="view-mode">
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-6">
                @foreach($gallery->images as $index => $image)
                <div class="group relative overflow-hidden rounded-2xl cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" onclick="openLightbox({{ $index }})" data-index="{{ $index }}">
                    <div class="relative" style="aspect-ratio: 1/1;">
                        <img 
                            src="{{ $image->thumbnail_url }}" 
                            alt="{{ $image->title ?? $gallery->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-4 left-4 right-4">
                                <h4 class="text-white font-semibold text-sm mb-2 line-clamp-2">
                                    {{ $image->title ?? 'Foto ' . ($index + 1) }}
                                </h4>
                                <div class="flex items-center justify-between text-white text-xs">
                                    <span class="flex items-center bg-white/20 backdrop-blur-sm px-2 py-1 rounded-full">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Masonry View -->
        <div id="masonry-view" class="view-mode hidden">
            <div class="masonry-container">
                @foreach($gallery->images as $index => $image)
                <div class="masonry-item group relative overflow-hidden rounded-lg cursor-pointer" onclick="openLightbox({{ $index }})">
                    <img 
                        src="{{ $image->thumbnail_url }}" 
                        alt="{{ $image->title ?? $gallery->title }}"
                        class="w-full h-auto object-cover group-hover:opacity-90 group-hover:scale-105 transition-all duration-300"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                        </svg>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Slideshow View -->
        <div id="slideshow-view" class="view-mode hidden">
            <div class="relative max-w-4xl mx-auto">
                <!-- Main Image -->
                <div class="relative">
                    <img 
                        id="slideshow-main" 
                        src="{{ $gallery->images->first()->image_url ?? '' }}" 
                        alt=""
                        class="w-full h-96 object-cover rounded-lg"
                    >
                    
                    <!-- Navigation -->
                    <button onclick="previousSlide()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-3 rounded-full hover:bg-black/70 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button onclick="nextSlide()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-3 rounded-full hover:bg-black/70 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Thumbnails -->
                <div class="flex overflow-x-auto gap-2 mt-4 pb-2">
                    @foreach($gallery->images as $index => $image)
                    <img 
                        src="{{ $image->thumbnail_url }}" 
                        alt=""
                        class="thumbnail-item w-20 h-20 object-cover rounded cursor-pointer border-2 border-transparent hover:border-primary-500 transition-colors"
                        onclick="goToSlide({{ $index }})"
                        data-index="{{ $index }}"
                    >
                    @endforeach
                </div>
                
                <!-- Photo Counter -->
                <div class="text-center mt-4">
                    <span id="photo-counter" class="text-sm text-gray-600">1 / {{ $gallery->images->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Albums -->
    @if($relatedGalleries->count() > 0)
    <div class="bg-gradient-to-br from-gray-50 to-blue-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl xl:text-4xl font-bold text-gray-900 mb-4" style="color: #13315c;">
                    Album Terkait
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Jelajahi koleksi album lainnya yang mungkin menarik untuk Anda
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($relatedGalleries as $relatedGallery)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 overflow-hidden cursor-pointer"
                     onclick="window.location.href='{{ route('gallery.show', $relatedGallery->slug) }}'">
                    <div class="relative" style="aspect-ratio: 16/9;">
                        <img 
                            src="{{ $relatedGallery->cover_image_url }}" 
                            alt="{{ $relatedGallery->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-6 left-6 right-6">
                                <h3 class="text-white font-bold text-xl mb-3 line-clamp-2">
                                    {{ $relatedGallery->title }}
                                </h3>
                                <div class="flex items-center justify-between text-white text-sm">
                                    <span class="flex items-center bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $relatedGallery->total_photos }} Foto
                                    </span>
                                    <span class="flex items-center bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $relatedGallery->view_count }} views
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-[#13315c] transition-colors" style="color: #13315c;">
                            {{ $relatedGallery->title }}
                        </h3>
                        <div class="flex justify-between items-center text-sm text-gray-500 pt-4 border-t border-gray-100">
                            <span class="flex items-center bg-gray-50 px-3 py-1 rounded-full">
                                <svg class="w-4 h-4 mr-2 text-[#13315c]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $relatedGallery->total_photos }} Foto
                            </span>
                            <span class="flex items-center bg-gray-50 px-3 py-1 rounded-full">
                                <svg class="w-4 h-4 mr-2 text-[#13315c]" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $relatedGallery->view_count }} views
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Lightbox Modal -->
<div id="lightbox-modal" class="fixed inset-0 z-50 hidden bg-black/95 backdrop-blur-sm">
    <div class="relative w-full h-full flex items-center justify-center">
        <!-- Close Button -->
        <button onclick="closeLightbox()" class="absolute top-6 right-6 text-white hover:text-gray-300 transition-colors z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <!-- Main Image -->
        <div class="relative max-w-7xl max-h-full mx-4">
            <img 
                id="lightbox-image" 
                src="" 
                alt=""
                class="max-w-full max-h-full object-contain rounded-lg shadow-2xl"
                style="max-height: 80vh;"
                onerror="this.src='{{ asset('images/placeholder-gallery.jpg') }}'"
            >
            
            <!-- Navigation -->
            <button onclick="previousImage()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-4 rounded-full hover:bg-black/70 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button onclick="nextImage()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-4 rounded-full hover:bg-black/70 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
        
        <!-- Thumbnails Strip -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 w-full max-w-4xl px-4">
            <div class="flex overflow-x-auto gap-2 bg-black/50 rounded-lg p-2">
                @foreach($gallery->images as $index => $image)
                <img 
                    src="{{ $image->thumbnail_url }}" 
                    alt=""
                    class="thumbnail-lightbox w-16 h-16 object-cover rounded cursor-pointer opacity-50 hover:opacity-80 transition-opacity"
                    onclick="goToImage({{ $index }})"
                    data-index="{{ $index }}"
                >
                @endforeach
            </div>
        </div>
        
        <!-- Image Info -->
        <div class="absolute top-4 left-4 text-white">
            <h3 id="lightbox-title" class="text-lg font-semibold"></h3>
            <p id="lightbox-counter" class="text-sm opacity-80"></p>
        </div>
    </div>
</div>

<script>
// Gallery data
const galleryImages = @json($gallery->images);
let currentImageIndex = 0;
let currentSlideIndex = 0;

// View mode functions
function setViewMode(mode) {
    // Hide all views
    document.querySelectorAll('.view-mode').forEach(view => view.classList.add('hidden'));
    document.querySelectorAll('.view-toggle').forEach(btn => {
        btn.classList.remove('active', 'bg-primary-500', 'text-white');
        btn.classList.add('text-gray-700');
    });
    
    // Show selected view
    document.getElementById(mode + '-view').classList.remove('hidden');
    document.getElementById(mode + '-view-btn').classList.add('active', 'bg-primary-500', 'text-white');
    document.getElementById(mode + '-view-btn').classList.remove('text-gray-700');
}

// Lightbox functions
function openLightbox(index) {
    console.log('Opening lightbox for index:', index);
    console.log('Gallery images:', galleryImages);
    
    if (!galleryImages || galleryImages.length === 0) {
        console.error('No gallery images found');
        alert('Tidak ada gambar yang tersedia');
        return;
    }
    
    currentImageIndex = index;
    updateLightboxImage();
    document.getElementById('lightbox-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox-modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function updateLightboxImage() {
    const image = galleryImages[currentImageIndex];
    console.log('Current image:', image); // Debug log
    
    // Set image source with fallback
    const lightboxImage = document.getElementById('lightbox-image');
    if (image && image.image_url) {
        lightboxImage.src = image.image_url;
        lightboxImage.alt = image.title || '{{ $gallery->title }}';
        
        // Add error handling
        lightboxImage.onerror = function() {
            console.error('Failed to load image:', image.image_url);
            this.src = '{{ asset("images/placeholder-gallery.jpg") }}';
        };
    } else {
        console.error('No image data found for index:', currentImageIndex);
        lightboxImage.src = '{{ asset("images/placeholder-gallery.jpg") }}';
    }
    
    // Update title and counter
    document.getElementById('lightbox-title').textContent = image.title || '{{ $gallery->title }}';
    document.getElementById('lightbox-counter').textContent = `${currentImageIndex + 1} / ${galleryImages.length}`;
    
    // Update thumbnail states
    document.querySelectorAll('.thumbnail-lightbox').forEach((thumb, index) => {
        thumb.classList.toggle('opacity-100', index === currentImageIndex);
        thumb.classList.toggle('opacity-50', index !== currentImageIndex);
    });
}

function previousImage() {
    currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : galleryImages.length - 1;
    updateLightboxImage();
}

function nextImage() {
    currentImageIndex = currentImageIndex < galleryImages.length - 1 ? currentImageIndex + 1 : 0;
    updateLightboxImage();
}

function goToImage(index) {
    currentImageIndex = index;
    updateLightboxImage();
}

// Slideshow functions
function goToSlide(index) {
    currentSlideIndex = index;
    updateSlideshowImage();
}

function updateSlideshowImage() {
    const image = galleryImages[currentSlideIndex];
    document.getElementById('slideshow-main').src = image.image_url;
    document.getElementById('photo-counter').textContent = `${currentSlideIndex + 1} / ${galleryImages.length}`;
    
    // Update thumbnail states
    document.querySelectorAll('.thumbnail-item').forEach((thumb, index) => {
        thumb.classList.toggle('border-primary-500', index === currentSlideIndex);
        thumb.classList.toggle('border-transparent', index !== currentSlideIndex);
    });
}

function previousSlide() {
    currentSlideIndex = currentSlideIndex > 0 ? currentSlideIndex - 1 : galleryImages.length - 1;
    updateSlideshowImage();
}

function nextSlide() {
    currentSlideIndex = currentSlideIndex < galleryImages.length - 1 ? currentSlideIndex + 1 : 0;
    updateSlideshowImage();
}

// Share functions
function shareToFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
}

function shareToTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('{{ $gallery->title }}');
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
}

function shareToWhatsApp() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('{{ $gallery->title }}');
    window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link berhasil disalin!');
    });
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (document.getElementById('lightbox-modal').classList.contains('hidden')) return;
    
    switch(e.key) {
        case 'Escape':
            closeLightbox();
            break;
        case 'ArrowLeft':
            previousImage();
            break;
        case 'ArrowRight':
            nextImage();
            break;
    }
});

// Touch/swipe support
let touchStartX = 0;
let touchEndX = 0;

document.getElementById('lightbox-modal').addEventListener('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
});

document.getElementById('lightbox-modal').addEventListener('touchend', function(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            nextImage(); // Swipe left
        } else {
            previousImage(); // Swipe right
        }
    }
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.aspect-w-4 {
    position: relative;
    padding-bottom: 75%; /* 4:3 aspect ratio */
}

.aspect-h-3 {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.masonry-container {
    column-count: 4;
    column-gap: 1.5rem;
}

.masonry-item {
    break-inside: avoid;
    margin-bottom: 1.5rem;
}

/* Desktop optimizations */
@media (min-width: 1280px) {
    .masonry-container {
        column-count: 5;
        column-gap: 2rem;
    }
    
    .masonry-item {
        margin-bottom: 2rem;
    }
}

@media (max-width: 768px) {
    .masonry-container {
        column-count: 2;
    }
}

@media (max-width: 480px) {
    .masonry-container {
        column-count: 1;
    }
}

/* Enhanced view toggle styles */
.view-toggle.active {
    background-color: #13315c;
    color: white;
    box-shadow: 0 4px 12px rgba(19, 49, 92, 0.3);
}

.view-toggle:hover {
    background-color: #13315c;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(19, 49, 92, 0.2);
}

/* Enhanced hover effects for desktop */
@media (min-width: 1024px) {
    .gallery-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .related-gallery-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }
}
</style>
@endsection
