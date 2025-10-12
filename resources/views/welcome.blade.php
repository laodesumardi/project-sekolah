@extends('layouts.app')

@section('title', 'SMP Negeri 01 Namrole - Beranda')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden" style="background: linear-gradient(135deg, #0a1628 0%, #13315c 100%); min-height: 100vh; background-attachment: fixed;">
    <div class="absolute inset-0" style="background: rgba(0, 0, 0, 0.2);"></div>
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-white animate-fade-in">
                <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                    Selamat Datang di<br>
                    <span class="text-yellow-300">SMP Negeri 01 Namrole</span>
                </h1>
                <p class="text-xl lg:text-2xl mb-8 text-gray-200 leading-relaxed">
                    Menjadi sekolah unggulan yang membentuk generasi berkarakter, 
                    berprestasi, dan berakhlak mulia untuk masa depan yang gemilang.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('ppdb.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-primary-500 font-semibold px-8 py-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('about') }}" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 font-semibold px-8 py-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
                                        </div>
            <div class="animate-slide-up">
                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8 shadow-2xl">
                    <img src="{{ asset('logo.png') }}" alt="Sekolah Illustration" class="w-full h-64 object-contain">
                    <div class="text-center mt-6">
                        <h3 class="text-2xl font-bold text-white mb-2">Visi Sekolah</h3>
                        <p class="text-gray-200">
                            "Terwujudnya sekolah yang unggul dalam prestasi, 
                            berkarakter, dan berakhlak mulia"
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
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    SMP Negeri 01 Namrole adalah lembaga pendidikan menengah pertama yang telah berdiri sejak tahun 1985. 
                    Kami berkomitmen untuk memberikan pendidikan berkualitas tinggi yang mengintegrasikan aspek akademik, 
                    karakter, dan keterampilan hidup.
                </p>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Dengan fasilitas modern, tenaga pendidik yang berpengalaman, dan kurikulum yang disesuaikan dengan 
                    perkembangan zaman, kami siap membimbing setiap siswa untuk meraih prestasi terbaik mereka.
                </p>
                <a href="{{ route('academic.curriculum') }}" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold px-8 py-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Selengkapnya
                </a>
            </div>
            <div class="animate-fade-in">
                <div class="relative">
                    <img src="{{ asset('Screenshot 2025-10-08 152932.png') }}" alt="Sekolah Building" class="w-full h-96 object-cover rounded-2xl shadow-2xl">
                    <div class="absolute inset-0 bg-primary-500 bg-opacity-20 rounded-2xl"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Section -->
<section class="py-20 bg-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-primary-500 mb-4">Prestasi & Pencapaian</h2>
            <p class="text-xl text-gray-600">Data dan statistik yang membanggakan</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <x-stat-card 
                :number="1234" 
                label="Total Siswa"
                description="Siswa aktif"
            >
                <svg class="h-8 w-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </x-stat-card>

            <x-stat-card 
                :number="87" 
                label="Tenaga Pendidik"
                description="Guru & staff"
            >
                <svg class="h-8 w-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </x-stat-card>

            <x-stat-card 
                :number="156" 
                label="Prestasi"
                description="Penghargaan"
            >
                <svg class="h-8 w-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </x-stat-card>

            <x-stat-card 
                :number="1985" 
                label="Tahun Berdiri"
                description="Pengalaman"
            >
                <svg class="h-8 w-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </x-stat-card>
        </div>
    </div>
</section>

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
                Daftar PPDB 2024
            </a>
            <a href="{{ route('kontak') }}" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 font-semibold px-8 py-4 rounded-lg transition-all duration-300 transform hover:scale-105">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection