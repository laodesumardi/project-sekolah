@extends('layouts.app')

@section('title', 'Prestasi & Pencapaian - SMP Negeri 01 Namrole')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Prestasi & Pencapaian</h1>
            <p class="text-xl md:text-2xl mb-8">Data dan statistik yang membanggakan</p>
            <div class="w-24 h-1 bg-white mx-auto"></div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Statistik Sekolah</h2>
            <p class="text-lg text-gray-600">Pencapaian dan prestasi yang membanggakan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Total Siswa -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2" data-count="{{ $statistics['total_students'] ?? 324 }}">0</h3>
                <p class="text-gray-600 font-medium">Total Siswa</p>
                <p class="text-sm text-gray-500 mt-1">Siswa aktif</p>
            </div>

            <!-- Tenaga Pendidik -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2" data-count="{{ $statistics['total_teachers'] ?? 24 }}">0</h3>
                <p class="text-gray-600 font-medium">Tenaga Pendidik</p>
                <p class="text-sm text-gray-500 mt-1">Guru & staff</p>
            </div>

            <!-- Prestasi -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2" data-count="{{ $statistics['total_achievements'] ?? 45 }}">0</h3>
                <p class="text-gray-600 font-medium">Prestasi</p>
                <p class="text-sm text-gray-500 mt-1">Penghargaan</p>
            </div>

            <!-- Tahun Berdiri -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2" data-count="{{ $statistics['years_experience'] ?? 40 }}">0</h3>
                <p class="text-gray-600 font-medium">Tahun Berdiri</p>
                <p class="text-sm text-gray-500 mt-1">Pengalaman</p>
            </div>
        </div>
    </div>
</section>

<!-- Achievement Categories -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Kategori Prestasi</h2>
            <p class="text-lg text-gray-600">Prestasi berdasarkan kategori dan tingkat</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Akademik -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-8 text-center">
                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-blue-600 mb-2">{{ $statistics['academic_achievements'] ?? 89 }}</h3>
                <p class="text-gray-700 font-medium">Prestasi Akademik</p>
                <p class="text-sm text-gray-600 mt-1">Olimpiade, lomba, dan kompetisi akademik</p>
            </div>

            <!-- Olahraga -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-8 text-center">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-green-600 mb-2">{{ $statistics['sports_achievements'] ?? 34 }}</h3>
                <p class="text-gray-700 font-medium">Prestasi Olahraga</p>
                <p class="text-sm text-gray-600 mt-1">Turnamen dan kompetisi olahraga</p>
            </div>

            <!-- Seni -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-8 text-center">
                <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2M9 12h6m-6 4h6"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-purple-600 mb-2">{{ $statistics['arts_achievements'] ?? 23 }}</h3>
                <p class="text-gray-700 font-medium">Prestasi Seni</p>
                <p class="text-sm text-gray-600 mt-1">Festival dan kompetisi seni</p>
            </div>
        </div>
    </div>
</section>

<!-- Achievement Levels -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Tingkat Prestasi</h2>
            <p class="text-lg text-gray-600">Prestasi berdasarkan tingkat kompetisi</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Nasional -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-4xl font-bold text-red-600 mb-2">{{ $statistics['national_achievements'] ?? 45 }}</h3>
                <p class="text-gray-700 font-medium text-lg">Nasional</p>
                <p class="text-sm text-gray-600 mt-2">Prestasi tingkat nasional</p>
            </div>

            <!-- Provinsi -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-4xl font-bold text-orange-600 mb-2">{{ $statistics['provincial_achievements'] ?? 67 }}</h3>
                <p class="text-gray-700 font-medium text-lg">Provinsi</p>
                <p class="text-sm text-gray-600 mt-2">Prestasi tingkat provinsi</p>
            </div>

            <!-- Kabupaten -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-4xl font-bold text-blue-600 mb-2">{{ $statistics['district_achievements'] ?? 44 }}</h3>
                <p class="text-gray-700 font-medium text-lg">Kabupaten</p>
                <p class="text-sm text-gray-600 mt-2">Prestasi tingkat kabupaten</p>
            </div>
        </div>
    </div>
</section>

<!-- Recent Achievements -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Prestasi Terbaru</h2>
            <p class="text-lg text-gray-600">Prestasi yang baru saja diraih</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($recentAchievements as $achievement)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $achievement->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $achievement->achievement_level }}</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">{{ Str::limit($achievement->description, 100) }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($achievement->date)->format('d M Y') }}</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                            {{ ucfirst($achievement->category) }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada prestasi</h3>
                <p class="text-gray-600">Prestasi akan ditampilkan di sini</p>
            </div>
            @endforelse
        </div>

        @if($recentAchievements->count() > 0)
        <div class="text-center mt-12">
            <a href="{{ route('achievements.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <span>Lihat Semua Prestasi</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Additional Statistics -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Informasi Tambahan</h2>
            <p class="text-lg text-gray-600">Data dan informasi sekolah yang lebih detail</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Total Registrations -->
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $statistics['total_registrations'] ?? 0 }}</h3>
                <p class="text-gray-600 font-medium">Total Pendaftaran</p>
                <p class="text-sm text-gray-500 mt-1">PPDB</p>
            </div>

            <!-- Total Classes -->
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $statistics['total_classes'] ?? 12 }}</h3>
                <p class="text-gray-600 font-medium">Total Kelas</p>
                <p class="text-sm text-gray-500 mt-1">Kelas aktif</p>
            </div>

            <!-- This Year Achievements -->
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $statistics['this_year_achievements'] ?? 0 }}</h3>
                <p class="text-gray-600 font-medium">Prestasi Tahun Ini</p>
                <p class="text-sm text-gray-500 mt-1">{{ date('Y') }}</p>
            </div>
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counters
    const counters = document.querySelectorAll('[data-count]');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current);
        }, 16);
    });
});
</script>
@endpush
