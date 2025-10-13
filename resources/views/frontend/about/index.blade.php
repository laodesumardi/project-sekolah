@extends('layouts.app')

@section('title', 'Tentang Kami - SMP Negeri 01 Namrole')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Tentang Kami', 'url' => null]
]" />

<!-- Page Header -->
<x-page-header 
    title="{{ $homepageSetting->about_page_title ?? 'Tentang Kami' }}" 
    subtitle="{{ $homepageSetting->about_page_description ? Str::limit($homepageSetting->about_page_description, 100) : 'Mengenal lebih dekat SMP Negeri 01 Namrole' }}" 
/>

<!-- Visi & Misi Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Visi & Misi</h2>
            <p class="text-lg text-gray-600">Dasar pemikiran dan tujuan pendidikan di SMP Negeri 01 Namrole</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Visi -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-500 text-white rounded-full mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi</h3>
                <p class="text-gray-600 leading-relaxed">
                    "{{ $homepageSetting->about_page_vision ?? 'Menjadi sekolah unggulan yang menghasilkan lulusan berkarakter, berprestasi, dan berdaya saing global' }}"
                </p>
            </div>
            
            <!-- Misi -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-secondary text-white rounded-full mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Misi</h3>
                <div class="text-gray-600 leading-relaxed">
                    @if($homepageSetting && $homepageSetting->about_page_mission)
                        {!! nl2br(e($homepageSetting->about_page_mission)) !!}
                    @else
                        "Menyelenggarakan pendidikan berkualitas tinggi, membentuk karakter siswa yang unggul, dan mengembangkan potensi siswa secara optimal"
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sejarah Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Sejarah Sekolah</h2>
            <p class="text-lg text-gray-600">Perjalanan panjang SMP Negeri 01 Namrole dalam dunia pendidikan</p>
        </div>
        
        @if($homepageSetting && $homepageSetting->about_page_history)
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($homepageSetting->about_page_history)) !!}
                </div>
            </div>
        </div>
        @else
        
        <div class="relative">
            <!-- Timeline Line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 w-1 bg-primary-500 h-full"></div>
            
            <!-- Timeline Items -->
            <div class="space-y-12">
                <x-timeline-item 
                    year="1985" 
                    title="Pendirian Sekolah" 
                    description="SMP Negeri 01 Namrole didirikan sebagai sekolah menengah pertama pertama di wilayah Namrole dengan tujuan memberikan pendidikan berkualitas kepada masyarakat setempat."
                />
                
                <x-timeline-item 
                    year="1990" 
                    title="Akreditasi Pertama" 
                    description="Sekolah memperoleh akreditasi pertama dengan predikat baik, menandai kualitas pendidikan yang telah diakui secara resmi."
                />
                
                <x-timeline-item 
                    year="2000" 
                    title="Ekspansi Fasilitas" 
                    description="Pembangunan laboratorium komputer dan laboratorium IPA untuk mendukung pembelajaran sains dan teknologi."
                />
                
                <x-timeline-item 
                    year="2010" 
                    title="Akreditasi A" 
                    description="Sekolah berhasil memperoleh akreditasi A, menandai pencapaian tertinggi dalam standar pendidikan nasional."
                />
                
                <x-timeline-item 
                    year="2020" 
                    title="Digitalisasi Pembelajaran" 
                    description="Implementasi sistem pembelajaran digital dan e-learning untuk mengikuti perkembangan teknologi pendidikan."
                />
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Struktur Organisasi Section -->
@if($homepageSetting && $homepageSetting->organization_structure_title)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $homepageSetting->organization_structure_title ?? 'Struktur Organisasi' }}</h2>
            @if($homepageSetting->organization_structure_description)
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">{{ $homepageSetting->organization_structure_description }}</p>
            @else
                <p class="text-lg text-gray-600">Tim kepemimpinan yang berdedikasi untuk kemajuan sekolah</p>
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
        @else
        <!-- Fallback: Show individual team members if no organization chart image -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Kepala Sekolah -->
            <div class="text-center bg-gray-50 rounded-lg p-6">
                @if($homepageSetting && $homepageSetting->about_page_principal_photo)
                    <img src="{{ $homepageSetting->about_page_principal_photo_url }}" alt="Kepala Sekolah" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                @else
                    <div class="w-24 h-24 bg-primary-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">KS</span>
                    </div>
                @endif
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $homepageSetting->about_page_principal_title ?? 'Kepala Sekolah' }}</h3>
                <p class="text-gray-600">{{ $homepageSetting->about_page_principal_name ?? 'Dr. Ahmad Wijaya, M.Pd' }}</p>
                @if($homepageSetting && $homepageSetting->about_page_principal_message)
                    <p class="text-sm text-gray-500 mt-2 italic">"{{ Str::limit($homepageSetting->about_page_principal_message, 100) }}"</p>
                @endif
            </div>
            
            <!-- Wakil Kepala Sekolah -->
            <div class="text-center bg-gray-50 rounded-lg p-6">
                <div class="w-24 h-24 bg-secondary rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">WKS</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Wakil Kepala Sekolah</h3>
                <p class="text-gray-600">Siti Rahayu, S.Pd</p>
            </div>
            
            <!-- Koordinator Kurikulum -->
            <div class="text-center bg-gray-50 rounded-lg p-6">
                <div class="w-24 h-24 bg-accent rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">KK</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Koordinator Kurikulum</h3>
                <p class="text-gray-600">Budi Santoso, S.Pd</p>
            </div>
        </div>
        @endif
    </div>
</section>
@endif

<!-- Akreditasi Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Akreditasi Sekolah</h2>
            <p class="text-lg text-gray-600">Pengakuan kualitas pendidikan yang telah diraih</p>
        </div>
        
        @if($homepageSetting && $homepageSetting->accreditation_grade)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Badge Akreditasi -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-32 h-32 bg-green-500 text-white rounded-full mb-6">
                    <span class="text-4xl font-bold">{{ $homepageSetting->accreditation_grade ?? 'A' }}</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Akreditasi {{ $homepageSetting->accreditation_grade ?? 'A' }}</h3>
                <p class="text-gray-600">{{ $homepageSetting->accreditation_description ?? 'Predikat sangat baik dalam standar pendidikan nasional' }}</p>
            </div>
            
            <!-- Sertifikat -->
            <div class="text-center">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    @if($homepageSetting->accreditation_certificate)
                        <div class="w-24 h-24 bg-yellow-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                    @else
                        <div class="w-24 h-24 bg-yellow-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                    @endif
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Sertifikat Akreditasi</h3>
                    <p class="text-gray-600">Berlaku hingga {{ $homepageSetting->accreditation_valid_until ?? '2025' }}</p>
                    @if($homepageSetting->accreditation_certificate)
                        <div class="mt-6">
                            <img src="{{ $homepageSetting->accreditation_certificate_url }}" alt="Sertifikat Akreditasi" class="w-32 h-32 object-cover rounded-lg mx-auto border-2 border-gray-200">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Badge Akreditasi -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-32 h-32 bg-green-500 text-white rounded-full mb-6">
                    <span class="text-4xl font-bold">A</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Akreditasi A</h3>
                <p class="text-gray-600">Predikat sangat baik dalam standar pendidikan nasional</p>
            </div>
            
            <!-- Sertifikat -->
            <div class="text-center">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="w-24 h-24 bg-yellow-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Sertifikat Akreditasi</h3>
                    <p class="text-gray-600">Berlaku hingga 2025</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Fasilitas Sekolah Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Fasilitas Sekolah</h2>
            <p class="text-lg text-gray-600">Fasilitas modern untuk mendukung proses pembelajaran yang optimal</p>
        </div>
        
        @if($homepageSetting && $homepageSetting->about_page_facilities_description)
        <div class="max-w-4xl mx-auto mb-12">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($homepageSetting->about_page_facilities_description)) !!}
                </div>
            </div>
        </div>
        @endif
        
        @if($facilities->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($facilities as $facility)
            <div class="text-center bg-gray-50 rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                <!-- Facility Image -->
                <div class="relative h-32 overflow-hidden rounded-lg mb-4">
                    <img src="{{ $facility->image_url }}" 
                         alt="{{ $facility->name }}" 
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    @if($facility->category)
                        <div class="absolute top-2 left-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-white bg-opacity-90 text-blue-800 shadow-sm">
                                {{ $facility->category->name }}
                            </span>
                        </div>
                    @endif
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $facility->name }}</h3>
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($facility->description, 80) }}</p>
                
                <!-- Facility Details -->
                <div class="space-y-2">
                    @if($facility->capacity)
                        <div class="flex items-center justify-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                            Kapasitas: {{ $facility->capacity }} orang
                        </div>
                    @endif
                    
                    <div class="flex items-center justify-center text-sm {{ $facility->is_available ? 'text-green-600' : 'text-red-600' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $facility->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- View All Facilities Link -->
        <div class="text-center mt-12">
            <a href="{{ route('facilities') }}" 
               class="inline-flex items-center px-6 py-3 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 transition-colors duration-200">
                Lihat Semua Fasilitas
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Laboratorium Komputer -->
            <div class="text-center bg-gray-50 rounded-lg p-6">
                <div class="w-16 h-16 bg-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Laboratorium Komputer</h3>
                <p class="text-gray-600">40 unit komputer dengan spesifikasi modern untuk pembelajaran IT</p>
            </div>
            
            <!-- Laboratorium IPA -->
            <div class="text-center bg-gray-50 rounded-lg p-6">
                <div class="w-16 h-16 bg-green-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Laboratorium IPA</h3>
                <p class="text-gray-600">Peralatan lengkap untuk praktikum fisika, kimia, dan biologi</p>
            </div>
            
            <!-- Perpustakaan -->
            <div class="text-center bg-gray-50 rounded-lg p-6">
                <div class="w-16 h-16 bg-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Perpustakaan Digital</h3>
                <p class="text-gray-600">Koleksi buku dan akses digital untuk mendukung pembelajaran</p>
            </div>
            
            <!-- Lapangan Olahraga -->
            <div class="text-center bg-gray-50 rounded-lg p-6">
                <div class="w-16 h-16 bg-orange-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lapangan Olahraga</h3>
                <p class="text-gray-600">Lapangan basket, voli, dan futsal untuk kegiatan olahraga</p>
            </div>
            
            <!-- Ruang Multimedia -->
            <div class="text-center bg-gray-50 rounded-lg p-6">
                <div class="w-16 h-16 bg-red-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Ruang Multimedia</h3>
                <p class="text-gray-600">Ruang presentasi dengan teknologi audio visual modern</p>
            </div>
            
            <!-- Kantin Sekolah -->
            <div class="text-center bg-gray-50 rounded-lg p-6">
                <div class="w-16 h-16 bg-yellow-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kantin Sehat</h3>
                <p class="text-gray-600">Menyediakan makanan sehat dan bergizi untuk siswa</p>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Prestasi & Pencapaian Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Prestasi & Pencapaian</h2>
            <p class="text-lg text-gray-600">Berbagai prestasi yang telah diraih oleh siswa dan sekolah</p>
        </div>
        
        @if($homepageSetting && $homepageSetting->about_page_achievements)
        <div class="max-w-4xl mx-auto mb-12">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($homepageSetting->about_page_achievements)) !!}
                </div>
            </div>
        </div>
        @endif
        
        @if($achievements->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($achievements as $achievement)
            <div class="text-center bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <!-- Achievement Icon based on category -->
                <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center
                    @if($achievement->category == 'akademik') bg-yellow-400
                    @elseif($achievement->category == 'olahraga') bg-green-500
                    @elseif($achievement->category == 'seni') bg-purple-500
                    @elseif($achievement->category == 'teknologi') bg-blue-500
                    @else bg-gray-500
                    @endif">
                    @if($achievement->category == 'akademik')
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    @elseif($achievement->category == 'olahraga')
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    @elseif($achievement->category == 'seni')
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>
                    @elseif($achievement->category == 'teknologi')
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    @else
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    @endif
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $achievement->title }}</h3>
                <p class="text-3xl font-bold mb-2
                    @if($achievement->category == 'akademik') text-yellow-500
                    @elseif($achievement->category == 'olahraga') text-green-500
                    @elseif($achievement->category == 'seni') text-purple-500
                    @elseif($achievement->category == 'teknologi') text-blue-500
                    @else text-gray-500
                    @endif">
                    {{ $achievement->rank ?? '1' }}
                </p>
                <p class="text-gray-600 text-sm mb-2">{{ $achievement->formatted_level }}</p>
                <p class="text-gray-500 text-xs">{{ $achievement->date->format('M Y') }}</p>
                
                @if($achievement->certificate_image)
                <div class="mt-4">
                    <img src="{{ $achievement->certificate_url }}" 
                         alt="Sertifikat {{ $achievement->title }}" 
                         class="w-16 h-16 object-cover rounded-lg mx-auto border-2 border-gray-200">
                </div>
                @endif
            </div>
            @endforeach
        </div>
        
        <!-- View All Achievements Link -->
        <div class="text-center mt-12">
            <a href="{{ route('academic.achievements') }}" 
               class="inline-flex items-center px-6 py-3 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 transition-colors duration-200">
                Lihat Semua Prestasi
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        @else
        <!-- Fallback: Show static achievements if no database data -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Olimpiade Sains -->
            <div class="text-center bg-white rounded-lg shadow-lg p-6">
                <div class="w-16 h-16 bg-yellow-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Olimpiade Sains</h3>
                <p class="text-3xl font-bold text-yellow-500 mb-2">15</p>
                <p class="text-gray-600">Medali emas tingkat kabupaten</p>
            </div>
            
            <!-- Lomba Debat -->
            <div class="text-center bg-white rounded-lg shadow-lg p-6">
                <div class="w-16 h-16 bg-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lomba Debat</h3>
                <p class="text-3xl font-bold text-blue-500 mb-2">8</p>
                <p class="text-gray-600">Juara tingkat provinsi</p>
            </div>
            
            <!-- Olahraga -->
            <div class="text-center bg-white rounded-lg shadow-lg p-6">
                <div class="w-16 h-16 bg-green-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Olahraga</h3>
                <p class="text-3xl font-bold text-green-500 mb-2">12</p>
                <p class="text-gray-600">Kejuaraan tingkat kabupaten</p>
            </div>
            
            <!-- Seni & Budaya -->
            <div class="text-center bg-white rounded-lg shadow-lg p-6">
                <div class="w-16 h-16 bg-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Seni & Budaya</h3>
                <p class="text-3xl font-bold text-purple-500 mb-2">6</p>
                <p class="text-gray-600">Festival tingkat provinsi</p>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Kontak & Lokasi Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Kontak & Lokasi</h2>
            <p class="text-lg text-gray-600">Informasi kontak dan lokasi sekolah</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Informasi Kontak -->
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Alamat</h3>
                        <p class="text-gray-600">{{ $homepageSetting->contact_address ?? 'Jl. Pendidikan No. 123, Namrole, Kabupaten Buru Selatan, Maluku' }}</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Telepon</h3>
                        <p class="text-gray-600">{{ $homepageSetting->contact_phone ?? '(0913) 1234567' }}</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Email</h3>
                        <p class="text-gray-600">{{ $homepageSetting->contact_email ?? 'info@smpn01namrole.sch.id' }}</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Jam Operasional</h3>
                        <p class="text-gray-600">Senin - Jumat: 07:00 - 15:00 WIB</p>
                    </div>
                </div>
            </div>
            
            <!-- Peta Lokasi -->
            <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p class="text-gray-500">Peta Lokasi Sekolah</p>
                    <p class="text-sm text-gray-400">Jl. Pendidikan No. 123, Namrole</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Animation on scroll for timeline
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.timeline-item').forEach(item => {
        observer.observe(item);
    });
</script>
@endpush
