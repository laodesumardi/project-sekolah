@extends('layouts.app')

@section('title', 'PPDB - Penerimaan Peserta Didik Baru')
@section('description', 'Pendaftaran PPDB SMP Negeri 01 Namrole Tahun Ajaran ' . $setting->academicYear->year)

@section('content')
<!-- Hero Section -->
<x-background-section 
    section="ppdb"
    title="PPDB {{ $setting->academicYear->year }}" 
    subtitle="Penerimaan Peserta Didik Baru SMP Negeri 01 Namrole" 
>
    @php
        $status = $setting->getRegistrationStatus();
    @endphp

    @if($status === 'open')
                <!-- Registration Status Cards -->
                <div class="status-cards-container mb-8 max-w-4xl mx-auto">
                    <div class="status-cards-grid">
                        <!-- Status Card -->
                        <div class="status-card status-card-green">
                            <div class="card-content">
                                <div class="card-dot card-dot-green"></div>
                                <div class="card-text">
                                    <h3 class="card-title">Pendaftaran Sedang Berlangsung</h3>
                                    <p class="card-subtitle">Berakhir dalam {{ $setting->getDaysUntilEnd() }} hari</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Period Card -->
                        <div class="status-card status-card-blue">
                            <div class="card-content">
                                <div class="card-dot card-dot-blue"></div>
                                <div class="card-text">
                                    <h3 class="card-title">Periode Pendaftaran</h3>
                                    <p class="card-subtitle">{{ $setting->start_date->format('d M Y') }} - {{ $setting->end_date->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('ppdb.form') }}" 
                   class="inline-flex items-center px-8 py-4 bg-yellow-500 hover:bg-yellow-600 text-black font-bold text-xl rounded-lg transition-colors duration-200 shadow-lg">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    MULAI PENDAFTARAN
                </a>
            @elseif($status === 'not_started')
                <div class="bg-yellow-500/20 backdrop-blur-sm rounded-lg p-6 mb-8 max-w-2xl mx-auto">
                    <h3 class="text-2xl font-semibold mb-2">Pendaftaran Belum Dimulai</h3>
                    <p class="text-lg">Pendaftaran akan dibuka pada {{ $setting->start_date->format('d F Y, H:i') }}</p>
                    <p class="text-sm mt-2">Dimulai dalam {{ $setting->getDaysUntilStart() }} hari</p>
                </div>
            @elseif($status === 'ended')
                <div class="bg-red-500/20 backdrop-blur-sm rounded-lg p-6 mb-8 max-w-2xl mx-auto">
                    <h3 class="text-2xl font-semibold mb-2">Pendaftaran Sudah Berakhir</h3>
                    <p class="text-lg">Pendaftaran telah ditutup pada {{ $setting->end_date->format('d F Y, H:i') }}</p>
                    <p class="text-sm mt-2">Sudah berakhir {{ $setting->end_date->diffInDays(now()) }} hari yang lalu</p>
                </div>
            @elseif($status === 'inactive')
                <div class="bg-gray-500/20 backdrop-blur-sm rounded-lg p-6 mb-8 max-w-2xl mx-auto">
                    <h3 class="text-2xl font-semibold mb-2">Pendaftaran Tidak Aktif</h3>
                    <p class="text-lg">Pendaftaran PPDB saat ini tidak aktif</p>
                </div>
            @else
                <div class="bg-gray-500/20 backdrop-blur-sm rounded-lg p-6 mb-8 max-w-2xl mx-auto">
                    <h3 class="text-2xl font-semibold mb-2">Status Tidak Diketahui</h3>
                    <p class="text-lg">Status pendaftaran tidak dapat ditentukan</p>
                </div>
    @endif
</x-background-section>

<!-- Statistics Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">{{ number_format($totalRegistrations) }}</div>
                <div class="text-gray-600">Total Pendaftar</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-yellow-600 mb-2">{{ number_format($pendingCount) }}</div>
                <div class="text-gray-600">Menunggu Verifikasi</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-green-600 mb-2">{{ number_format($acceptedCount) }}</div>
                <div class="text-gray-600">Diterima</div>
            </div>
        </div>
    </div>
</section>

<!-- Registration Paths Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Jalur Pendaftaran</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Pilih jalur pendaftaran yang sesuai dengan kondisi dan kemampuan Anda
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Jalur Prestasi -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center border-2 border-yellow-200 hover:border-yellow-400 transition-colors duration-200">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Jalur Prestasi</h3>
                <p class="text-gray-600 mb-6">
                    Untuk siswa yang memiliki prestasi akademik atau non-akademik yang membanggakan
                </p>
                <div class="text-sm text-gray-500 mb-6">
                    <div>Kuota: {{ number_format($setting->quota_achievement) }} siswa</div>
                    <div>Biaya: Rp {{ number_format($setting->registration_fee, 0, ',', '.') }}</div>
                </div>
                @if($setting->isRegistrationOpen())
                    <a href="{{ route('ppdb.form') }}?path=achievement" 
                       class="inline-flex items-center px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-lg transition-colors duration-200">
                        Daftar Sekarang
                    </a>
                @else
                    <button disabled class="inline-flex items-center px-6 py-3 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed">
                        Belum Dibuka
                    </button>
                @endif
            </div>

            <!-- Jalur Reguler -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center border-2 border-blue-200 hover:border-blue-400 transition-colors duration-200">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Jalur Reguler</h3>
                <p class="text-gray-600 mb-6">
                    Jalur pendaftaran umum untuk semua calon siswa yang memenuhi persyaratan
                </p>
                <div class="text-sm text-gray-500 mb-6">
                    <div>Kuota: {{ number_format($setting->quota_regular) }} siswa</div>
                    <div>Biaya: Rp {{ number_format($setting->registration_fee, 0, ',', '.') }}</div>
                </div>
                @if($setting->isRegistrationOpen())
                    <a href="{{ route('ppdb.form') }}?path=regular" 
                       class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition-colors duration-200">
                        Daftar Sekarang
                    </a>
                @else
                    <button disabled class="inline-flex items-center px-6 py-3 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed">
                        Belum Dibuka
                    </button>
                @endif
            </div>

            <!-- Jalur Afirmasi -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center border-2 border-green-200 hover:border-green-400 transition-colors duration-200">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Jalur Afirmasi</h3>
                <p class="text-gray-600 mb-6">
                    Jalur khusus untuk siswa dari keluarga kurang mampu dan daerah terpencil
                </p>
                <div class="text-sm text-gray-500 mb-6">
                    <div>Kuota: {{ number_format($setting->quota_affirmation) }} siswa</div>
                    <div>Biaya: Rp {{ number_format($setting->registration_fee, 0, ',', '.') }}</div>
                </div>
                @if($setting->isRegistrationOpen())
                    <a href="{{ route('ppdb.form') }}?path=affirmation" 
                       class="inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors duration-200">
                        Daftar Sekarang
                    </a>
                @else
                    <button disabled class="inline-flex items-center px-6 py-3 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed">
                        Belum Dibuka
                    </button>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Requirements Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Persyaratan Pendaftaran</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Pastikan Anda memenuhi semua persyaratan sebelum melakukan pendaftaran
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Persyaratan Umum -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Persyaratan Umum</h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Usia maksimal 15 tahun pada 1 Juli {{ $setting->academicYear->year }}</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Lulus dari SD/MI atau sederajat</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Memiliki NIK dan NISN yang valid</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Sehat jasmani dan rohani</span>
                    </li>
                </ul>
            </div>

            <!-- Dokumen yang Diperlukan -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Dokumen yang Diperlukan</h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Foto siswa 3x4 (latar belakang merah)</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Scan ijazah/SKHUN SD/MI</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Scan kartu keluarga</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Scan akta kelahiran</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Sertifikat prestasi (jika ada)</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Timeline Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Alur Pendaftaran</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Ikuti langkah-langkah pendaftaran dengan benar untuk memastikan kelancaran proses
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">1</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Daftar Online</h3>
                    <p class="text-gray-600 text-sm">Isi formulir pendaftaran dengan data yang benar</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">2</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Upload Dokumen</h3>
                    <p class="text-gray-600 text-sm">Upload semua dokumen yang diperlukan</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">3</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Verifikasi</h3>
                    <p class="text-gray-600 text-sm">Admin akan memverifikasi dokumen Anda</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">4</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Pengumuman</h3>
                    <p class="text-gray-600 text-sm">Lihat hasil seleksi pada tanggal yang ditentukan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Schedule Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Jadwal & Timeline</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Perhatikan jadwal penting dalam proses pendaftaran PPDB
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Jadwal Pendaftaran</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-4"></div>
                                <div>
                                    <div class="font-semibold text-gray-900">Pembukaan Pendaftaran</div>
                                    <div class="text-sm text-gray-600">{{ $setting->start_date->format('d F Y, H:i') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-4"></div>
                                <div>
                                    <div class="font-semibold text-gray-900">Penutupan Pendaftaran</div>
                                    <div class="text-sm text-gray-600">{{ $setting->end_date->format('d F Y, H:i') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-4"></div>
                                <div>
                                    <div class="font-semibold text-gray-900">Pengumuman Hasil</div>
                                    <div class="text-sm text-gray-600">{{ $setting->announcement_date->format('d F Y, H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-8 bg-primary-50">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Penting</h3>
                        <div class="space-y-4 text-sm text-gray-600">
                            <p>• Pastikan semua dokumen sudah lengkap sebelum upload</p>
                            <p>• Simpan nomor pendaftaran untuk tracking status</p>
                            <p>• Periksa email secara berkala untuk notifikasi</p>
                            <p>• Hubungi admin jika mengalami kendala teknis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- CTA Section -->
<section class="py-16 bg-primary-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Siap Mendaftar?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">
            Jangan lewatkan kesempatan untuk bergabung dengan SMP Negeri 01 Namrole
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if($setting->isRegistrationOpen())
                <a href="{{ route('ppdb.form') }}" 
                   class="inline-flex items-center px-8 py-4 bg-yellow-500 hover:bg-yellow-600 text-black font-bold text-xl rounded-lg transition-colors duration-200 shadow-lg">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    MULAI PENDAFTARAN SEKARANG
                </a>
            @else
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-6 max-w-2xl mx-auto">
                    <h3 class="text-2xl font-semibold mb-2">Pendaftaran Belum Dibuka</h3>
                    <p class="text-lg">Pendaftaran akan dibuka pada {{ $setting->start_date->format('d F Y, H:i') }}</p>
                </div>
            @endif
            
            <a href="{{ route('ppdb.status') }}" 
               class="inline-flex items-center px-8 py-4 bg-white/20 hover:bg-white/30 text-white font-bold text-xl rounded-lg transition-colors duration-200 shadow-lg border-2 border-white/30">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                CEK STATUS PENDAFTARAN
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* FAQ Dropdown Styles */
.faq-content {
    transition: all 0.3s ease-in-out;
}

.faq-icon {
    transition: transform 0.3s ease-in-out;
}

/* Ensure dropdown visibility */
.group:hover .group-hover\:opacity-100 {
    opacity: 1 !important;
    visibility: visible !important;
}

/* Mobile dropdown improvements */
@media (max-width: 768px) {
    .group:hover .group-hover\:opacity-100 {
        opacity: 0;
        visibility: hidden;
    }
}

/* Card-based Registration Status Styles - Exact Match */
.status-cards-container {
    margin: 0 auto;
}

.status-cards-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    align-items: stretch;
}

.status-card {
    border-radius: 12px;
    padding: 1.25rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.status-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.status-card-green {
    background: #f0fff0;
    border: 1px solid rgba(34, 197, 94, 0.1);
    box-shadow: 0 2px 8px rgba(34, 197, 94, 0.05);
}

.status-card-blue {
    background: #e0f2ff;
    border: 1px solid rgba(59, 130, 246, 0.1);
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.05);
}

.card-content {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.card-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 0.5rem;
}

.card-dot-green {
    background: #22c55e;
}

.card-dot-blue {
    background: #3b82f6;
}

.card-text {
    flex: 1;
}

.card-title {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.25rem;
    line-height: 1.3;
}

.card-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
}

/* Simple Hover Effects */
.status-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .status-cards-container {
        margin: 0 1rem;
    }
    
    .status-cards-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .status-card {
        padding: 1rem;
    }
    
    .card-content {
        gap: 0.5rem;
    }
    
    .card-dot {
        width: 6px;
        height: 6px;
        margin-top: 0.4rem;
    }
    
    .card-title {
        font-size: 0.9rem;
    }
    
    .card-subtitle {
        font-size: 0.8rem;
    }
}
</style>
@endpush




