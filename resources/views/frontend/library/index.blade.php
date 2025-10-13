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


<!-- Organizational Structure Image -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Gambar Struktur Organisasi Perpustakaan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Visualisasi lengkap struktur organisasi perpustakaan SMP Negeri 01 Namrole
            </p>
        </div>
        
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center">
                    <img src="{{ asset($libraryStructureImage) }}" 
                         alt="Struktur Organisasi Perpustakaan SMP Negeri 01 Namrole" 
                         class="w-full max-w-5xl mx-auto object-contain rounded-lg border-2 border-gray-200 shadow-lg hover:shadow-xl transition-shadow duration-300">
                </div>
                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm">
                        <i class="fas fa-info-circle mr-2"></i>
                        Klik gambar untuk melihat dalam ukuran penuh
                    </p>
                </div>
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
                <div class="text-4xl mb-4 text-primary-600">
                    <i class="{{ $service['icon'] }}"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">{{ $service['title'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $service['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Contact Information -->
<section class="py-16 bg-primary-600 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-4">Informasi Perpustakaan</h2>
            <div class="grid md:grid-cols-3 gap-8 mt-8">
                <div>
                    <h3 class="text-xl font-semibold mb-2">Jam Operasional</h3>
                    @if($homepageSetting && $homepageSetting->library_operational_hours_weekdays)
                        <p class="text-primary-100">{{ $homepageSetting->library_operational_hours_weekdays }}</p>
                    @else
                        <p class="text-primary-100">Senin - Jumat: 07.00 - 15.00 WIT</p>
                    @endif
                    
                    @if($homepageSetting && $homepageSetting->library_operational_hours_saturday)
                        <p class="text-primary-100">{{ $homepageSetting->library_operational_hours_saturday }}</p>
                    @else
                        <p class="text-primary-100">Sabtu: 08.00 - 12.00 WIT</p>
                    @endif
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">Lokasi</h3>
                    @if($homepageSetting && $homepageSetting->library_location)
                        <p class="text-primary-100">{{ $homepageSetting->library_location }}</p>
                    @else
                        <p class="text-primary-100">Gedung Perpustakaan</p>
                        <p class="text-primary-100">SMP Negeri 01 Namrole</p>
                    @endif
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">Kontak</h3>
                    @if($homepageSetting && $homepageSetting->library_email)
                        <p class="text-primary-100">Email: {{ $homepageSetting->library_email }}</p>
                    @else
                        <p class="text-primary-100">Email: perpustakaan@smpn01namrole.sch.id</p>
                    @endif
                    
                    @if($homepageSetting && $homepageSetting->library_phone)
                        <p class="text-primary-100">Telp: {{ $homepageSetting->library_phone }}</p>
                    @else
                        <p class="text-primary-100">Telp: (0913) 123456</p>
                    @endif
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
