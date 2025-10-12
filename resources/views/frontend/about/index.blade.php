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
    title="Tentang Kami" 
    subtitle="Mengenal lebih dekat SMP Negeri 01 Namrole" 
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
                    "Menjadi sekolah unggulan yang menghasilkan lulusan berkarakter, berprestasi, dan berdaya saing global"
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
                <p class="text-gray-600 leading-relaxed">
                    "Menyelenggarakan pendidikan berkualitas tinggi, membentuk karakter siswa yang unggul, dan mengembangkan potensi siswa secara optimal"
                </p>
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
    </div>
</section>

<!-- Struktur Organisasi Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Struktur Organisasi</h2>
            <p class="text-lg text-gray-600">Tim kepemimpinan yang berdedikasi untuk kemajuan sekolah</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Kepala Sekolah -->
            <div class="text-center bg-gray-50 rounded-lg p-6">
                <div class="w-24 h-24 bg-primary-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">KS</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kepala Sekolah</h3>
                <p class="text-gray-600">Dr. Ahmad Wijaya, M.Pd</p>
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
    </div>
</section>

<!-- Akreditasi Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Akreditasi Sekolah</h2>
            <p class="text-lg text-gray-600">Pengakuan kualitas pendidikan yang telah diraih</p>
        </div>
        
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
