@extends('layouts.app')

@section('title', 'Perpustakaan - SMP Negeri 01 Namrole')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Perpustakaan SMP Negeri 01 Namrole</h1>
            <p class="text-xl mb-8">Pusat Literasi dan Sumber Belajar Terpadu</p>
            <div class="flex flex-wrap justify-center gap-4 text-sm">
                <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full">📚 Koleksi Lengkap</span>
                <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full">👥 Layanan Profesional</span>
                <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full">🌱 Program Literasi</span>
            </div>
        </div>
    </div>
</section>

<!-- Library Introduction -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Tentang Perpustakaan Kami</h2>
            <p class="text-lg text-gray-600 mb-8">
                Perpustakaan SMP Negeri 01 Namrole merupakan pusat literasi yang menyediakan berbagai layanan 
                untuk mendukung proses pembelajaran dan pengembangan budaya membaca. Dengan struktur organisasi 
                yang terorganisir dan tim yang profesional, kami berkomitmen untuk memberikan layanan terbaik 
                kepada seluruh warga sekolah.
            </p>
            <div class="grid md:grid-cols-3 gap-6 mt-12">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">📖</div>
                    <h3 class="text-xl font-semibold mb-2">Koleksi Bervariasi</h3>
                    <p class="text-gray-600">Buku teks, fiksi, non-fiksi, dan sumber digital</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="text-xl font-semibold mb-2">Tim Profesional</h3>
                    <p class="text-gray-600">Staf terlatih dan berdedikasi</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">🌱</div>
                    <h3 class="text-xl font-semibold mb-2">Program Literasi</h3>
                    <p class="text-gray-600">Kegiatan membaca dan pengembangan budaya literasi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Organizational Structure -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Struktur Organisasi Perpustakaan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Struktur organisasi yang terorganisir untuk memberikan layanan perpustakaan yang optimal
            </p>
        </div>

        <!-- Leadership Level -->
        <div class="mb-12">
            <h3 class="text-2xl font-semibold text-center mb-8 text-primary-600">Pimpinan & Komite</h3>
            <div class="flex flex-wrap justify-center gap-8">
                <!-- Kepala Sekolah -->
                <div class="bg-primary-50 p-6 rounded-lg shadow-md text-center max-w-xs">
                    <div class="w-24 h-24 bg-primary-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user-tie text-3xl text-primary-600"></i>
                    </div>
                    <h4 class="font-semibold text-lg mb-2">{{ $libraryStructure['leadership']['kepala_sekolah']['name'] }}</h4>
                    <p class="text-primary-600 font-medium mb-3">{{ $libraryStructure['leadership']['kepala_sekolah']['position'] }}</p>
                    <p class="text-sm text-gray-600">{{ $libraryStructure['leadership']['kepala_sekolah']['description'] }}</p>
                </div>

                <!-- Komite -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md text-center max-w-xs">
                    <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-users text-3xl text-gray-600"></i>
                    </div>
                    <h4 class="font-semibold text-lg mb-2">{{ $libraryStructure['leadership']['komite']['name'] }}</h4>
                    <p class="text-gray-600 font-medium mb-3">{{ $libraryStructure['leadership']['komite']['position'] }}</p>
                    <p class="text-sm text-gray-600">{{ $libraryStructure['leadership']['komite']['description'] }}</p>
                </div>
            </div>
        </div>

        <!-- Management Level -->
        <div class="mb-12">
            <h3 class="text-2xl font-semibold text-center mb-8 text-primary-600">Manajemen Perpustakaan</h3>
            <div class="flex flex-wrap justify-center gap-8">
                <!-- Kepala Perpustakaan -->
                <div class="bg-primary-50 p-6 rounded-lg shadow-md text-center max-w-xs">
                    <div class="w-24 h-24 bg-primary-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user-cog text-3xl text-primary-600"></i>
                    </div>
                    <h4 class="font-semibold text-lg mb-2">{{ $libraryStructure['management']['kepala_perpustakaan']['name'] }}</h4>
                    <p class="text-primary-600 font-medium mb-3">{{ $libraryStructure['management']['kepala_perpustakaan']['position'] }}</p>
                    <p class="text-sm text-gray-600">{{ $libraryStructure['management']['kepala_perpustakaan']['description'] }}</p>
                </div>

                <!-- Dewan Guru -->
                <div class="bg-primary-50 p-6 rounded-lg shadow-md text-center max-w-xs">
                    <div class="w-24 h-24 bg-primary-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-3xl text-primary-600"></i>
                    </div>
                    <h4 class="font-semibold text-lg mb-2">{{ $libraryStructure['management']['dewan_guru']['name'] }}</h4>
                    <p class="text-primary-600 font-medium mb-3">{{ $libraryStructure['management']['dewan_guru']['position'] }}</p>
                    <p class="text-sm text-gray-600">{{ $libraryStructure['management']['dewan_guru']['description'] }}</p>
                </div>
            </div>
        </div>

        <!-- Services Level -->
        <div class="mb-12">
            <h3 class="text-2xl font-semibold text-center mb-8 text-primary-600">Layanan Perpustakaan</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Layanan Teknis -->
                <div class="bg-primary-50 p-6 rounded-lg shadow-md text-center">
                    <div class="w-20 h-20 bg-primary-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-cogs text-2xl text-primary-600"></i>
                    </div>
                    <h4 class="font-semibold text-lg mb-2">{{ $libraryStructure['services']['layanan_teknis']['name'] }}</h4>
                    <p class="text-primary-600 font-medium mb-3">{{ $libraryStructure['services']['layanan_teknis']['position'] }}</p>
                    <p class="text-sm text-gray-600">{{ $libraryStructure['services']['layanan_teknis']['description'] }}</p>
                </div>

                <!-- Layanan Pemustaka -->
                <div class="bg-primary-50 p-6 rounded-lg shadow-md text-center">
                    <div class="w-20 h-20 bg-primary-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user-friends text-2xl text-primary-600"></i>
                    </div>
                    <h4 class="font-semibold text-lg mb-2">{{ $libraryStructure['services']['layanan_pemustaka']['name'] }}</h4>
                    <p class="text-primary-600 font-medium mb-3">{{ $libraryStructure['services']['layanan_pemustaka']['position'] }}</p>
                    <p class="text-sm text-gray-600">{{ $libraryStructure['services']['layanan_pemustaka']['description'] }}</p>
                </div>

                <!-- Koordinator Literasi -->
                <div class="bg-primary-50 p-6 rounded-lg shadow-md text-center">
                    <div class="w-20 h-20 bg-primary-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-book-reader text-2xl text-primary-600"></i>
                    </div>
                    <h4 class="font-semibold text-lg mb-2">{{ $libraryStructure['services']['koordinator_literasi']['name'] }}</h4>
                    <p class="text-primary-600 font-medium mb-3">{{ $libraryStructure['services']['koordinator_literasi']['position'] }}</p>
                    <p class="text-sm text-gray-600">{{ $libraryStructure['services']['koordinator_literasi']['description'] }}</p>
                </div>
            </div>
        </div>

        <!-- Ambassadors Level -->
        <div class="mb-12">
            <h3 class="text-2xl font-semibold text-center mb-8 text-blue-600">Duta Literasi</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Duta Literasi Siswa -->
                <div class="bg-blue-50 p-6 rounded-lg shadow-md text-center">
                    <div class="w-20 h-20 bg-blue-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-2xl text-blue-600"></i>
                    </div>
                    <h4 class="font-semibold text-lg mb-2">{{ $libraryStructure['ambassadors']['duta_siswa']['name'] }}</h4>
                    <p class="text-blue-600 font-medium mb-3">{{ $libraryStructure['ambassadors']['duta_siswa']['position'] }}</p>
                    <p class="text-sm text-gray-600">{{ $libraryStructure['ambassadors']['duta_siswa']['description'] }}</p>
                </div>

                <!-- Duta Literasi Tenaga Kependidikan -->
                <div class="bg-blue-50 p-6 rounded-lg shadow-md text-center">
                    <div class="w-20 h-20 bg-blue-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user-tie text-2xl text-blue-600"></i>
                    </div>
                    <h4 class="font-semibold text-lg mb-2">{{ $libraryStructure['ambassadors']['duta_tendik']['name'] }}</h4>
                    <p class="text-blue-600 font-medium mb-3">{{ $libraryStructure['ambassadors']['duta_tendik']['position'] }}</p>
                    <p class="text-sm text-gray-600">{{ $libraryStructure['ambassadors']['duta_tendik']['description'] }}</p>
                </div>

                <!-- Duta Literasi Guru -->
                <div class="bg-blue-50 p-6 rounded-lg shadow-md text-center">
                    <div class="w-20 h-20 bg-blue-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-2xl text-blue-600"></i>
                    </div>
                    <h4 class="font-semibold text-lg mb-2">{{ $libraryStructure['ambassadors']['duta_guru']['name'] }}</h4>
                    <p class="text-blue-600 font-medium mb-3">{{ $libraryStructure['ambassadors']['duta_guru']['position'] }}</p>
                    <p class="text-sm text-gray-600">{{ $libraryStructure['ambassadors']['duta_guru']['description'] }}</p>
                </div>
            </div>
        </div>

        <!-- Library Users -->
        <div class="text-center">
            <div class="bg-orange-50 p-8 rounded-lg shadow-md max-w-md mx-auto">
                <div class="w-24 h-24 bg-orange-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-users text-3xl text-orange-600"></i>
                </div>
                <h4 class="font-semibold text-xl mb-2">Pengguna Perpustakaan</h4>
                <p class="text-gray-600">Siswa, Guru, dan Staf SMP Negeri 01 Namrole</p>
            </div>
        </div>
    </div>
</section>

<!-- Library Services -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Layanan Perpustakaan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Berbagai layanan yang kami sediakan untuk mendukung pembelajaran dan pengembangan literasi
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($libraryServices as $service)
            <div class="bg-white p-6 rounded-lg shadow-md text-center hover:shadow-lg transition-shadow duration-300">
                <div class="text-4xl mb-4 text-blue-600">
                    <i class="{{ $service['icon'] }}"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">{{ $service['title'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $service['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Collections -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Koleksi Perpustakaan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Berbagai jenis koleksi yang tersedia untuk mendukung pembelajaran dan pengembangan literasi
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($collections as $type => $description)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-3 text-blue-600 capitalize">{{ str_replace('_', ' ', $type) }}</h3>
                <p class="text-gray-600">{{ $description }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-16 bg-blue-600 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-4">Informasi Perpustakaan</h2>
            <div class="grid md:grid-cols-3 gap-8 mt-8">
                <div>
                    <h3 class="text-xl font-semibold mb-2">Jam Operasional</h3>
                    <p class="text-blue-100">Senin - Jumat: 07.00 - 15.00 WIT</p>
                    <p class="text-blue-100">Sabtu: 08.00 - 12.00 WIT</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">Lokasi</h3>
                    <p class="text-blue-100">Gedung Perpustakaan</p>
                    <p class="text-blue-100">SMP Negeri 01 Namrole</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">Kontak</h3>
                    <p class="text-blue-100">Email: perpustakaan@smpn01namrole.sch.id</p>
                    <p class="text-blue-100">Telp: (0913) 123456</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Custom styles for organizational chart */
.organizational-chart {
    position: relative;
}

.organizational-chart::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 2px;
    height: 100%;
    background: #e5e7eb;
    z-index: 1;
}

/* Hover effects */
.hover-lift:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
}
</style>
@endpush
