@extends('layouts.app')

@section('title', 'SMP Negeri 01 Namrole - Beranda')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden hero-background min-h-screen" 
         style="background-image: url('{{ $homepageSetting && $homepageSetting->hero_background_image ? $homepageSetting->hero_background_image_url : asset('images/placeholders/placeholder-hero-background.jpg') }}');">
    <!-- Background dengan gambar dari admin panel dan overlay gelap -->
    <div class="absolute inset-0 hero-background-overlay"></div>
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-white animate-fade-in">
                <h1 class="text-3xl lg:text-5xl font-bold mb-6 leading-tight">
                    {{ $homepageSetting->hero_title ?? 'Selamat Datang di' }}<br>
                    <span class="text-yellow-300">{{ $homepageSetting->hero_subtitle ?? 'SMP Negeri 01 Namrole' }}</span>
                </h1>
                <p class="text-xl lg:text-2xl mb-8 text-gray-200 leading-relaxed">
                    {{ $homepageSetting->hero_description ?? 'Menjadi sekolah unggulan yang membentuk generasi berkarakter, berprestasi, dan berakhlak mulia untuk masa depan yang gemilang.' }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    @if($homepageSetting && $homepageSetting->hero_button_1_text)
                        <a href="{{ $homepageSetting->hero_button_1_url ?? route('ppdb.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-primary-500 font-semibold px-8 py-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                            {{ $homepageSetting->hero_button_1_text }}
                        </a>
                    @else
                        <a href="{{ route('ppdb.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-primary-500 font-semibold px-8 py-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Daftar Sekarang
                        </a>
                    @endif
                    
                    @if($homepageSetting && $homepageSetting->hero_button_2_text)
                        <a href="{{ $homepageSetting->hero_button_2_url ?? route('about') }}" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 font-semibold px-8 py-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                            {{ $homepageSetting->hero_button_2_text }}
                        </a>
                    @else
                        <a href="{{ route('about') }}" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 font-semibold px-8 py-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                            Pelajari Lebih Lanjut
                        </a>
                    @endif
                </div>
                                        </div>
            <div class="animate-slide-up">
                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8 shadow-2xl">
                    <img src="{{ $homepageSetting && $homepageSetting->school_image ? $homepageSetting->school_image_url : asset('images/placeholder-school.jpg') }}" alt="Gambar Sekolah" class="w-full h-64 object-cover rounded-lg">
                    <div class="text-center mt-6">
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $homepageSetting->vision_title ?? 'Visi Sekolah' }}</h3>
                        <p class="text-gray-200">
                            "{{ $homepageSetting->vision_description ?? 'Terwujudnya sekolah yang unggul dalam prestasi, berkarakter, dan berakhlak mulia' }}"
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
</section>


<!-- Profil Singkat Section -->
<section id="tentang" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="animate-slide-up">
                <h2 class="text-4xl font-bold text-primary-500 mb-6">Tentang Kami</h2>
                <div class="text-lg text-gray-600 mb-8 leading-relaxed">
                    {!! $homepageSetting && $homepageSetting->about_description ? nl2br(e($homepageSetting->about_description)) : 'SMP Negeri 01 Namrole adalah lembaga pendidikan menengah pertama yang telah berdiri sejak tahun 1985. Kami berkomitmen untuk memberikan pendidikan berkualitas tinggi yang mengintegrasikan aspek akademik, karakter, dan keterampilan hidup.<br><br>Dengan fasilitas modern, tenaga pendidik yang berpengalaman, dan kurikulum yang disesuaikan dengan perkembangan zaman, kami siap membimbing setiap siswa untuk meraih prestasi terbaik mereka.' !!}
                </div>
                <a href="{{ route('about') }}" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold px-8 py-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Selengkapnya
                </a>
            </div>
            <div class="animate-fade-in">
                <div class="relative">
                    <img src="{{ $homepageSetting && $homepageSetting->school_image ? $homepageSetting->school_image_url : asset('images/placeholder-school.jpg') }}" alt="Gambar Sekolah" class="w-full h-96 object-cover rounded-2xl shadow-2xl" onerror="this.src='{{ asset('images/placeholder-school.jpg') }}'">
                    <div class="absolute inset-0 bg-primary-500 bg-opacity-20 rounded-2xl"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Informasi Kepala Sekolah Section -->
@if($homepageSetting && $homepageSetting->principal_name)
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-primary-500 mb-4">Kepala Sekolah</h2>
            <p class="text-xl text-gray-600">Pemimpin yang berdedikasi untuk kemajuan pendidikan</p>
        </div>
        
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-8">
                    <!-- Foto Kepala Sekolah -->
                    <div class="lg:col-span-1 flex justify-center">
                        <div class="relative">
                            @if($homepageSetting->principal_photo)
                                <img src="{{ $homepageSetting->principal_photo_url }}" alt="{{ $homepageSetting->principal_name }}" class="w-64 h-64 object-cover rounded-2xl shadow-lg">
                            @else
                                <div class="w-64 h-64 bg-primary-500 rounded-2xl shadow-lg flex items-center justify-center">
                                    <div class="text-center text-white">
                                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <p class="text-lg font-semibold">Foto Kepala Sekolah</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Informasi Kepala Sekolah -->
                    <div class="lg:col-span-2">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $homepageSetting->principal_name }}</h3>
                                <p class="text-xl text-primary-500 font-semibold">{{ $homepageSetting->principal_title ?? 'Kepala Sekolah' }}</p>
                            </div>
                            
                            @if($homepageSetting->principal_message)
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-primary-500 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                                    </svg>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Pesan Kepala Sekolah</h4>
                                        <p class="text-gray-600 leading-relaxed italic">"{{ $homepageSetting->principal_message }}"</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Statistik Section -->
<section class="py-20 bg-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-primary-500 mb-4">Prestasi & Pencapaian</h2>
            <p class="text-xl text-gray-600">Data dan statistik yang membanggakan</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <x-stat-card 
                :number="$statistics['total_students']" 
                label="Total Siswa"
                description="Siswa aktif"
            >
                <svg class="h-8 w-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </x-stat-card>

            <x-stat-card 
                :number="$statistics['total_teachers']" 
                label="Tenaga Pendidik"
                description="Guru & staff"
            >
                <svg class="h-8 w-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </x-stat-card>

            <x-stat-card 
                :number="$statistics['total_achievements']" 
                label="Prestasi"
                description="Penghargaan"
            >
                <svg class="h-8 w-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </x-stat-card>

            <x-stat-card 
                :number="$statistics['years_experience']" 
                label="Tahun Berdiri"
                description="Pengalaman"
            >
                <svg class="h-8 w-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </x-stat-card>
        </div>
        
        <!-- Data Source Information -->
        <div class="mt-12 bg-blue-50 rounded-lg p-6">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-blue-900">Informasi Data</h3>
            </div>
            <div class="text-center text-blue-800">
                <p class="mb-2">Data statistik diambil dari database sekolah secara real-time</p>
                <p class="text-sm">Terakhir diperbarui: {{ $statistics['last_updated'] ?? 'Belum tersedia' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Accreditation Section -->
@if($homepageSetting && $homepageSetting->accreditation_grade)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-primary-500 mb-4">Akreditasi Sekolah</h2>
            <p class="text-xl text-gray-600">Pengakuan kualitas pendidikan yang telah diraih</p>
        </div>
        
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Accreditation Grade -->
                <div class="text-center bg-white rounded-lg shadow-lg p-8 border-2 border-gray-100">
                    <div class="w-24 h-24 bg-green-500 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <span class="text-white text-4xl font-bold">{{ $homepageSetting->accreditation_grade ?? 'A' }}</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Akreditasi {{ $homepageSetting->accreditation_grade ?? 'A' }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $homepageSetting->accreditation_description ?? 'Predikat sangat baik dalam standar pendidikan nasional' }}
                    </p>
                </div>

                <!-- Accreditation Certificate -->
                <div class="text-center bg-white rounded-lg shadow-lg p-8 border-2 border-gray-100">
                    @if($homepageSetting->accreditation_certificate)
                        <div class="w-24 h-24 bg-yellow-400 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                    @else
                        <div class="w-24 h-24 bg-yellow-400 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                    @endif
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Sertifikat Akreditasi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Berlaku hingga {{ $homepageSetting->accreditation_valid_until ?? '2025' }}
                    </p>
                    @if($homepageSetting->accreditation_certificate)
                        <div class="mt-6">
                            <img src="{{ $homepageSetting->accreditation_certificate_url }}" alt="Sertifikat Akreditasi" class="w-32 h-32 object-cover rounded-lg mx-auto border-2 border-gray-200">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Berita Terbaru Section -->
<section id="berita" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-primary-500 mb-4">Berita Terbaru</h2>
            <p class="text-xl text-gray-600">Informasi dan berita terkini dari sekolah</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($latestNews as $news)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $news->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $news->excerpt }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">{{ $news->published_at->format('d M Y') }}</span>
                        <a href="{{ route('news.show', $news->slug) }}" class="text-primary-500 hover:text-primary-600 font-medium">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Fallback content when no news available -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <img src="{{ asset('Screenshot 2025-10-08 152932.png') }}" alt="Berita 1" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Pembukaan PPDB 2025</h3>
                    <p class="text-gray-600 text-sm mb-4">Pendaftaran Peserta Didik Baru (PPDB) tahun 2024 telah dibuka. Segera daftarkan putra-putri Anda...</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">12 Oktober 2024</span>
                        <a href="#" class="text-primary-500 hover:text-primary-600 font-medium">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <img src="{{ asset('Screenshot 2025-10-08 152954.png') }}" alt="Berita 2" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Prestasi Siswa di Olimpiade</h3>
                    <p class="text-gray-600 text-sm mb-4">Siswa SMP Negeri 01 Namrole berhasil meraih prestasi membanggakan dalam olimpiade sains...</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">10 Oktober 2024</span>
                        <a href="#" class="text-primary-500 hover:text-primary-600 font-medium">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <img src="{{ asset('logo.png') }}" alt="Berita 3" class="w-full h-48 object-contain bg-gray-100">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Kegiatan Ekstrakurikuler</h3>
                    <p class="text-gray-600 text-sm mb-4">Berbagai kegiatan ekstrakurikuler menarik tersedia untuk mengembangkan bakat dan minat siswa...</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">8 Oktober 2024</span>
                        <a href="#" class="text-primary-500 hover:text-primary-600 font-medium">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('news') }}" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold px-8 py-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                Lihat Semua Berita
            </a>
        </div>
    </div>
</section>


<!-- Kontak Section -->
<section id="kontak" class="py-20 bg-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-primary-500 mb-4">Hubungi Kami</h2>
            <p class="text-xl text-gray-600">Kami siap membantu dan menjawab pertanyaan Anda</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Informasi Kontak -->
            <div class="space-y-8">
                <div class="flex items-start space-x-4">
                    <div class="bg-primary-500 p-3 rounded-full">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Alamat</h3>
                        <p class="text-gray-600">{{ $homepageSetting->contact_address ?? 'Jl. Pendidikan No. 123, Namrole, Maluku' }}</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="bg-primary-500 p-3 rounded-full">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Telepon</h3>
                        <p class="text-gray-600">{{ $homepageSetting->contact_phone ?? '(0910) 123456' }}</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="bg-primary-500 p-3 rounded-full">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Email</h3>
                        <p class="text-gray-600">{{ $homepageSetting->contact_email ?? 'info@smpn01namrole.sch.id' }}</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="bg-primary-500 p-3 rounded-full">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Jam Operasional</h3>
                        <p class="text-gray-600">Senin - Jumat: 07:00 - 16:00<br>Sabtu: 07:00 - 12:00</p>
                    </div>
                </div>
            </div>
            
            <!-- Form Kontak -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Kirim Pesan</h3>
                <form class="space-y-6">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Masukkan nama lengkap">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Masukkan email">
                    </div>
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                        <input type="tel" id="telepon" name="telepon" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Masukkan nomor telepon">
                    </div>
                    <div>
                        <label for="pesan" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <textarea id="pesan" name="pesan" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Tuliskan pesan Anda"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-semibold px-6 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Organization Structure Section -->
@if($homepageSetting && $homepageSetting->organization_structure_title)
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-primary-500 mb-4">{{ $homepageSetting->organization_structure_title ?? 'Struktur Organisasi' }}</h2>
            @if($homepageSetting->organization_structure_description)
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ $homepageSetting->organization_structure_description }}</p>
            @endif
        </div>
        
        @if($homepageSetting->organization_structure_image)
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center">
                <img src="{{ $homepageSetting->organization_structure_image_url }}" 
                     alt="{{ $homepageSetting->organization_structure_title ?? 'Struktur Organisasi' }}" 
                     class="w-full max-w-4xl mx-auto object-contain rounded-lg border-2 border-gray-200 shadow-lg">
            </div>
        </div>
        @endif
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 bg-primary-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">Bergabunglah dengan Kami</h2>
        <p class="text-xl text-gray-200 mb-8 max-w-3xl mx-auto">
            Daftarkan putra-putri Anda untuk menjadi bagian dari keluarga besar SMP Negeri 01 Namrole 
            dan wujudkan impian pendidikan terbaik untuk masa depan mereka.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('ppdb.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-primary-500 font-semibold px-8 py-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                Daftar PPDB 2025
            </a>
        </div>
    </div>
</section>
@endsection