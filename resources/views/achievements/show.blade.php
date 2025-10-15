@extends('layouts.app')

@section('title', $achievement->title)
@section('description', $achievement->description)

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    @media (max-width: 640px) {
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    }
    
    /* Ensure proper contrast for achievement info cards */
    .achievement-info-card {
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }
    
    .achievement-info-card .text-white {
        color: #ffffff !important;
        font-weight: 500;
    }
    
    /* Specific fixes for yellow/green backgrounds */
    .bg-yellow-500 .text-white,
    .bg-green-500 .text-white {
        color: #1f2937 !important;
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
    }
    
    .bg-yellow-500 .text-white i,
    .bg-green-500 .text-white i {
        color: #1f2937 !important;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
            <nav class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm">
                <a href="{{ route('home') }}" class="text-[#13315c] hover:text-[#1e4d8b] flex items-center">
                    <i class="fas fa-home mr-1"></i>
                    <span class="hidden sm:inline">Home</span>
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="{{ route('achievements') }}" class="text-[#13315c] hover:text-[#1e4d8b]">Prestasi</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-600 truncate">{{ Str::limit($achievement->title, 30) }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-3 sm:px-4 py-4 sm:py-6 lg:py-8">
        <!-- Hero Section -->
        <div class="bg-white rounded-lg shadow-2xl p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 border-l-4 sm:border-l-8 border-{{ $achievement->level_color_name }}-500">
            <div class="flex flex-col lg:flex-row gap-4 sm:gap-6 lg:gap-8">
                <!-- Left Side (60%) -->
                <div class="flex-1">
                    <!-- Level Badge -->
                    <div class="mb-3 sm:mb-4">
                        <span class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 rounded-lg text-sm sm:text-lg font-bold text-white bg-{{ $achievement->level_color_name }}-500">
                            <i class="fas fa-trophy mr-2 sm:mr-3"></i>
                            <span class="hidden sm:inline">PRESTASI </span>{{ strtoupper($achievement->achievement_level) }}
                        </span>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-[#13315c] mb-3 sm:mb-4 leading-tight">{{ $achievement->title }}</h1>
                    
                    <!-- Event Name -->
                    <h2 class="text-lg sm:text-xl lg:text-2xl xl:text-3xl font-semibold text-gray-700 mb-4 sm:mb-6">{{ $achievement->event_name }}</h2>
                    
                    <!-- Meta Row -->
                    <div class="flex flex-col sm:flex-row sm:flex-wrap gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
                        <div class="flex items-center text-sm sm:text-base text-gray-600">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>{{ $achievement->formatted_date }}</span>
                        </div>
                        @if($achievement->organizer)
                        <div class="flex items-center text-sm sm:text-base text-gray-600">
                            <i class="fas fa-building mr-2"></i>
                            <span class="truncate">{{ $achievement->organizer }}</span>
                        </div>
                        @endif
                        @if($achievement->location)
                        <div class="flex items-center text-sm sm:text-base text-gray-600">
                            <i class="fas fa-map-pin mr-2"></i>
                            <span class="truncate">{{ $achievement->location }}</span>
                        </div>
                        @endif
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-{{ $achievement->level_color_name }}-100 text-{{ $achievement->level_color_name }}-800">
                                {{ $achievement->category_name }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side (40%) -->
                <div class="w-full lg:w-96">
                    <!-- Rank Display Card -->
                    <div class="bg-{{ $achievement->level_color_name }}-500 text-white rounded-2xl p-4 sm:p-6 lg:p-8 text-center shadow-xl mb-4 sm:mb-6">
                        <i class="fas fa-trophy text-4xl sm:text-5xl lg:text-6xl mb-3 sm:mb-4"></i>
                        <div class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">{{ $achievement->rank }}</div>
                        @if($achievement->score)
                        <div class="text-sm sm:text-base lg:text-lg opacity-90">Skor: {{ $achievement->score }}</div>
                        @endif
                    </div>
                    
                    <!-- Share Buttons -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-2 xl:grid-cols-4 gap-2">
                        <button onclick="shareOnFacebook()" class="bg-blue-600 text-white px-2 sm:px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors text-xs sm:text-sm">
                            <i class="fab fa-facebook-f mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">Facebook</span>
                        </button>
                        <button onclick="shareOnTwitter()" class="bg-blue-400 text-white px-2 sm:px-3 py-2 rounded-lg hover:bg-blue-500 transition-colors text-xs sm:text-sm">
                            <i class="fab fa-twitter mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">Twitter</span>
                        </button>
                        <button onclick="shareOnWhatsApp()" class="bg-green-500 text-white px-2 sm:px-3 py-2 rounded-lg hover:bg-green-600 transition-colors text-xs sm:text-sm">
                            <i class="fab fa-whatsapp mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">WhatsApp</span>
                        </button>
                        <button onclick="copyLink()" class="bg-gray-600 text-white px-2 sm:px-3 py-2 rounded-lg hover:bg-gray-700 transition-colors text-xs sm:text-sm">
                            <i class="fas fa-link mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">Copy</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            <!-- Main Content (65%) -->
            <div class="lg:col-span-2">
                <!-- Gallery Section -->
                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-[#13315c] mb-4 sm:mb-6">Dokumentasi</h3>
                    
                    <!-- Main Image Display -->
                    <div class="relative mb-4 sm:mb-6">
                        <div id="main-image" class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                            @if($achievement->certificate_image)
                            <img id="main-image-src" src="{{ $achievement->certificate_url }}" alt="{{ $achievement->title }}" class="w-full h-full object-contain cursor-pointer" onclick="openLightbox(this.src)">
                            @elseif($achievement->trophy_image)
                            <img id="main-image-src" src="{{ $achievement->trophy_url }}" alt="{{ $achievement->title }}" class="w-full h-full object-contain cursor-pointer" onclick="openLightbox(this.src)">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image text-4xl sm:text-6xl text-gray-400"></i>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    <div class="flex gap-2 sm:gap-3 overflow-x-auto pb-2">
                        @if($achievement->certificate_image)
                        <div class="flex-shrink-0">
                            <img src="{{ $achievement->certificate_url }}" alt="Sertifikat" class="w-20 h-16 sm:w-24 sm:h-18 object-cover rounded-lg cursor-pointer border-2 border-[#13315c] opacity-100" onclick="changeMainImage(this.src)">
                        </div>
                        @endif
                        @if($achievement->trophy_image)
                        <div class="flex-shrink-0">
                            <img src="{{ $achievement->trophy_url }}" alt="Piala" class="w-20 h-16 sm:w-24 sm:h-18 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-[#13315c] opacity-80" onclick="changeMainImage(this.src)">
                        </div>
                        @endif
                        @if($achievement->getDocumentationImagesArray())
                        @foreach($achievement->getDocumentationImagesArray() as $image)
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/achievements/documentation/' . $image) }}" alt="Dokumentasi" class="w-20 h-16 sm:w-24 sm:h-18 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-[#13315c] opacity-80" onclick="changeMainImage(this.src)">
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                
                <!-- Description Section -->
                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-[#13315c] mb-3 sm:mb-4">Tentang Prestasi Ini</h3>
                    <div class="prose max-w-none text-sm sm:text-base">
                        {!! $achievement->description !!}
                    </div>
                </div>
                
                <!-- Participants Section -->
                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-[#13315c] mb-3 sm:mb-4">
                        <i class="fas fa-users mr-2"></i>Peserta
                    </h3>
                    
                    <!-- Participant Type Badge -->
                    <div class="mb-4 sm:mb-6">
                        <span class="inline-flex items-center px-3 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $achievement->participant_type === 'individu' ? 'Individu' : ucfirst($achievement->participant_type) }}
                        </span>
                    </div>
                    
                    <!-- Participant Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                        @foreach($achievement->participants() as $participant)
                        <div class="bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-200">
                            <div class="flex items-center space-x-3">
                                @if($participant->student && $participant->student->photo)
                                <img src="{{ asset('storage/profiles/' . $participant->student->photo) }}" alt="{{ $participant->participant_name }}" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border-2 border-{{ $achievement->level_color_name }}-500">
                                @else
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-{{ $achievement->level_color_name }}-500 flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm sm:text-base"></i>
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 text-sm sm:text-base truncate">{{ $participant->participant_name }}</h4>
                                    @if($participant->class_name)
                                    <p class="text-xs sm:text-sm text-gray-600 truncate">{{ $participant->class_name }}</p>
                                    @endif
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-{{ $achievement->level_color_name }}-100 text-{{ $achievement->level_color_name }}-800">
                                        {{ ucfirst($participant->role) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Teachers Section -->
                @if($achievement->teachers->count() > 0)
                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-[#13315c] mb-3 sm:mb-4">
                        <i class="fas fa-chalkboard-teacher mr-2"></i>Pembimbing & Pelatih
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        @foreach($achievement->teachers() as $teacherAchievement)
                        <div class="bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-200">
                            <div class="flex items-center space-x-3">
                                @if($teacherAchievement->teacher && $teacherAchievement->teacher->user && $teacherAchievement->teacher->user->photo)
                                <img src="{{ asset('storage/profiles/' . $teacherAchievement->teacher->user->photo) }}" alt="{{ $teacherAchievement->teacher->user->name }}" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border-2 border-{{ $achievement->level_color_name }}-500">
                                @else
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-{{ $achievement->level_color_name }}-500 flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm sm:text-base"></i>
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 text-sm sm:text-base truncate">
                                        {{ $teacherAchievement->teacher ? $teacherAchievement->teacher->user->name : 'N/A' }}
                                    </h4>
                                    <p class="text-xs sm:text-sm text-gray-600 truncate">
                                        {{ $teacherAchievement->teacher ? $teacherAchievement->teacher->subject : 'Guru' }}
                                    </p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-{{ $achievement->level_color_name }}-100 text-{{ $achievement->level_color_name }}-800">
                                        {{ ucfirst($teacherAchievement->role) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Video Section -->
                @if($achievement->video_url)
                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-[#13315c] mb-3 sm:mb-4">
                        <i class="fab fa-youtube mr-2"></i>Video
                    </h3>
                    <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                        @if(str_contains($achievement->video_url, 'youtube.com') || str_contains($achievement->video_url, 'youtu.be'))
                        <iframe src="{{ str_replace(['youtube.com/watch?v=', 'youtu.be/'], 'youtube.com/embed/', $achievement->video_url) }}" 
                                class="w-full h-full" 
                                frameborder="0" 
                                allowfullscreen></iframe>
                        @elseif(str_contains($achievement->video_url, 'vimeo.com'))
                        <iframe src="{{ str_replace('vimeo.com/', 'player.vimeo.com/video/', $achievement->video_url) }}" 
                                class="w-full h-full" 
                                frameborder="0" 
                                allowfullscreen></iframe>
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <a href="{{ $achievement->video_url }}" target="_blank" class="text-[#13315c] hover:text-[#1e4d8b] text-center">
                                <i class="fas fa-external-link-alt text-3xl sm:text-4xl mb-2"></i>
                                <p class="text-sm sm:text-base">Buka Video</p>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Sidebar (35%) -->
            <div class="lg:col-span-1">
                <!-- Quick Info Card -->
                <div class="bg-{{ $achievement->level_color_name }}-500 text-white rounded-2xl p-4 sm:p-6 shadow-xl mb-4 sm:mb-6 achievement-info-card">
                    <h4 class="text-base sm:text-lg font-bold mb-3 sm:mb-4 text-white">Informasi Prestasi</h4>
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-trophy w-4 sm:w-5 mr-2 sm:mr-3 text-white"></i>
                            <span class="text-xs sm:text-sm text-white font-medium">Tingkat: {{ $achievement->level_name }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar w-4 sm:w-5 mr-2 sm:mr-3 text-white"></i>
                            <span class="text-xs sm:text-sm text-white font-medium">Tanggal: {{ $achievement->formatted_date }}</span>
                        </div>
                        @if($achievement->organizer)
                        <div class="flex items-center">
                            <i class="fas fa-building w-4 sm:w-5 mr-2 sm:mr-3 text-white"></i>
                            <span class="text-xs sm:text-sm text-white font-medium truncate">Penyelenggara: {{ $achievement->organizer }}</span>
                        </div>
                        @endif
                        @if($achievement->location)
                        <div class="flex items-center">
                            <i class="fas fa-map-pin w-4 sm:w-5 mr-2 sm:mr-3 text-white"></i>
                            <span class="text-xs sm:text-sm text-white font-medium truncate">Lokasi: {{ $achievement->location }}</span>
                        </div>
                        @endif
                        <div class="flex items-center">
                            <i class="fas fa-tag w-4 sm:w-5 mr-2 sm:mr-3 text-white"></i>
                            <span class="text-xs sm:text-sm text-white font-medium">Kategori: {{ $achievement->category_name }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-users w-4 sm:w-5 mr-2 sm:mr-3 text-white"></i>
                            <span class="text-xs sm:text-sm text-white font-medium">Tipe: {{ $achievement->participant_type === 'individu' ? 'Individu' : ucfirst($achievement->participant_type) }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-eye w-4 sm:w-5 mr-2 sm:mr-3 text-white"></i>
                            <span class="text-xs sm:text-sm text-white font-medium">Views: {{ $achievement->view_count }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Prize/Hadiah -->
                @if($achievement->prize)
                <div class="bg-white border-2 border-{{ $achievement->level_color_name }}-500 rounded-2xl p-4 sm:p-6 shadow-lg mb-4 sm:mb-6">
                    <h4 class="text-base sm:text-lg font-bold text-[#13315c] mb-3 sm:mb-4">
                        <i class="fas fa-gift text-xl sm:text-2xl text-{{ $achievement->level_color_name }}-500 mr-2"></i>Hadiah & Penghargaan
                    </h4>
                    <p class="text-gray-700 text-sm sm:text-base">{{ $achievement->prize }}</p>
                </div>
                @endif
                
                <!-- News Link -->
                @if($achievement->news_url)
                <div class="bg-white border border-gray-200 rounded-lg p-4 sm:p-5 shadow-lg mb-4 sm:mb-6">
                    <h4 class="text-base sm:text-lg font-bold text-[#13315c] mb-3 sm:mb-4">
                        <i class="fas fa-newspaper mr-2"></i>Liputan Media
                    </h4>
                    <a href="{{ $achievement->news_url }}" target="_blank" 
                       class="inline-flex items-center w-full px-3 sm:px-4 py-2 sm:py-3 bg-{{ $achievement->level_color_name }}-500 text-white rounded-lg hover:bg-{{ $achievement->level_color_name }}-600 transition-colors text-sm sm:text-base">
                        <i class="fas fa-external-link-alt mr-2"></i>Baca Berita
                    </a>
                </div>
                @endif
                
                <!-- Share This -->
                <div class="bg-white border border-gray-200 rounded-lg p-4 sm:p-5 shadow-lg">
                    <h4 class="text-base sm:text-lg font-bold text-[#13315c] mb-3 sm:mb-4">Bagikan Prestasi Ini</h4>
                    <div class="space-y-2">
                        <button onclick="shareOnFacebook()" class="w-full flex items-center px-3 sm:px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-colors text-sm sm:text-base">
                            <i class="fab fa-facebook-f mr-2 sm:mr-3"></i>Facebook
                        </button>
                        <button onclick="shareOnTwitter()" class="w-full flex items-center px-3 sm:px-4 py-2 border border-blue-400 text-blue-400 rounded-lg hover:bg-blue-400 hover:text-white transition-colors text-sm sm:text-base">
                            <i class="fab fa-twitter mr-2 sm:mr-3"></i>Twitter
                        </button>
                        <button onclick="shareOnWhatsApp()" class="w-full flex items-center px-3 sm:px-4 py-2 border border-green-500 text-green-500 rounded-lg hover:bg-green-500 hover:text-white transition-colors text-sm sm:text-base">
                            <i class="fab fa-whatsapp mr-2 sm:mr-3"></i>WhatsApp
                        </button>
                        <button onclick="shareOnLinkedIn()" class="w-full flex items-center px-3 sm:px-4 py-2 border border-blue-700 text-blue-700 rounded-lg hover:bg-blue-700 hover:text-white transition-colors text-sm sm:text-base">
                            <i class="fab fa-linkedin mr-2 sm:mr-3"></i>LinkedIn
                        </button>
                        <button onclick="copyLink()" class="w-full flex items-center px-3 sm:px-4 py-2 border border-gray-600 text-gray-600 rounded-lg hover:bg-gray-600 hover:text-white transition-colors text-sm sm:text-base">
                            <i class="fas fa-link mr-2 sm:mr-3"></i>Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Achievements -->
        @if($related->count() > 0)
        <div class="mt-8 sm:mt-12">
            <h2 class="text-xl sm:text-2xl font-bold text-[#13315c] mb-4 sm:mb-6">Prestasi Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach($related as $relatedAchievement)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 sm:hover:-translate-y-2 border-t-4 border-{{ $relatedAchievement->level_color_name }}-500">
                    <div class="relative h-40 sm:h-48 overflow-hidden">
                        @if($relatedAchievement->certificate_image)
                        <img src="{{ $relatedAchievement->certificate_url }}" alt="{{ $relatedAchievement->title }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-[#13315c] to-[#1e4d8b] flex items-center justify-center">
                            <i class="fas fa-trophy text-3xl sm:text-4xl text-white/50"></i>
                        </div>
                        @endif
                        
                        <div class="absolute top-2 sm:top-4 left-2 sm:left-4">
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-bold text-white bg-{{ $relatedAchievement->level_color_name }}-500/95">
                                <i class="fas fa-trophy mr-1"></i>{{ strtoupper($relatedAchievement->achievement_level) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-3 sm:p-4">
                        <h3 class="text-base sm:text-lg font-bold text-[#13315c] mb-2 line-clamp-2">{{ $relatedAchievement->title }}</h3>
                        <p class="text-gray-600 text-xs sm:text-sm mb-3">{{ $relatedAchievement->event_name }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">{{ $relatedAchievement->formatted_date }}</span>
                            <a href="{{ route('achievements.show', $relatedAchievement->slug) }}" 
                               class="text-[#13315c] hover:text-[#1e4d8b] font-semibold text-xs sm:text-sm">
                                Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-95 z-50 hidden flex items-center justify-center p-2 sm:p-4">
    <div class="relative max-w-4xl sm:max-w-6xl max-h-full">
        <button onclick="closeLightbox()" class="absolute top-2 sm:top-4 right-2 sm:right-4 text-white text-xl sm:text-2xl hover:text-gray-300 z-10 bg-black/50 rounded-full p-2">
            <i class="fas fa-times"></i>
        </button>
        <img id="lightbox-image" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
    </div>
</div>

<script>
function changeMainImage(src) {
    document.getElementById('main-image-src').src = src;
    
    // Update thumbnail borders
    document.querySelectorAll('img[onclick="changeMainImage(this.src)"]').forEach(thumb => {
        thumb.classList.remove('border-[#13315c]', 'opacity-100');
        thumb.classList.add('border-transparent', 'opacity-80');
    });
    
    event.target.classList.add('border-[#13315c]', 'opacity-100');
    event.target.classList.remove('border-transparent', 'opacity-80');
}

function openLightbox(src) {
    document.getElementById('lightbox-image').src = src;
    document.getElementById('lightbox').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Share functions
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
}

function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('{{ $achievement->title }}');
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
}

function shareOnWhatsApp() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('{{ $achievement->title }}');
    window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
}

function shareOnLinkedIn() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link berhasil disalin!');
    });
}

// Close lightbox on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});

// Close lightbox on click outside
document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});
</script>
@endsection
