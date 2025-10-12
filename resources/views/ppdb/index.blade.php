@extends('layouts.app')

@section('title', 'PPDB - Penerimaan Peserta Didik Baru')
@section('description', 'Pendaftaran PPDB SMP Negeri 01 Namrole Tahun Ajaran ' . $setting->academicYear->year)

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-primary-600 to-primary-800 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                PPDB {{ $setting->academicYear->year }}
            </h1>
            <p class="text-xl md:text-2xl mb-8">
                Penerimaan Peserta Didik Baru SMP Negeri 01 Namrole
            </p>
            
            @if($setting->isRegistrationOpen())
                <!-- Countdown Timer -->
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-6 mb-8 max-w-2xl mx-auto">
                    <h3 class="text-2xl font-semibold mb-4">Pendaftaran Berakhir Dalam:</h3>
                    <div id="countdown" class="flex justify-center space-x-4 text-3xl font-bold">
                        <div class="bg-white/30 rounded-lg p-4 min-w-[80px]">
                            <div id="days" class="text-4xl">00</div>
                            <div class="text-sm">Hari</div>
                        </div>
                        <div class="bg-white/30 rounded-lg p-4 min-w-[80px]">
                            <div id="hours" class="text-4xl">00</div>
                            <div class="text-sm">Jam</div>
                        </div>
                        <div class="bg-white/30 rounded-lg p-4 min-w-[80px]">
                            <div id="minutes" class="text-4xl">00</div>
                            <div class="text-sm">Menit</div>
                        </div>
                        <div class="bg-white/30 rounded-lg p-4 min-w-[80px]">
                            <div id="seconds" class="text-4xl">00</div>
                            <div class="text-sm">Detik</div>
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
            @else
                <div class="bg-red-500/20 backdrop-blur-sm rounded-lg p-6 mb-8 max-w-2xl mx-auto">
                    <h3 class="text-2xl font-semibold mb-2">Pendaftaran Belum Dibuka</h3>
                    <p class="text-lg">Pendaftaran akan dibuka pada {{ $setting->start_date->format('d F Y, H:i') }}</p>
                </div>
            @endif
        </div>
    </div>
</section>

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

<!-- FAQ Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan jawaban untuk pertanyaan yang sering diajukan
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="space-y-4">
                <!-- FAQ 1: Cara Mendaftar -->
                <div class="bg-white rounded-lg shadow-lg">
                    <button class="w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none hover:bg-gray-50 transition-colors duration-200" data-faq="1">
                        <span class="font-semibold text-gray-900">Bagaimana cara mendaftar PPDB?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" data-icon="1">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 text-gray-600 hidden" data-content="1">
                        <div class="space-y-3">
                            <p>Pendaftaran PPDB dilakukan secara online melalui website ini dengan langkah-langkah berikut:</p>
                            <ol class="list-decimal list-inside space-y-2 ml-4">
                                <li>Klik tombol "Mulai Pendaftaran" di halaman ini</li>
                                <li>Pilih jalur pendaftaran yang sesuai (Reguler, Prestasi, atau Afirmasi)</li>
                                <li>Isi formulir pendaftaran dengan data yang benar dan lengkap</li>
                                <li>Upload semua dokumen yang diperlukan</li>
                                <li>Submit pendaftaran dan tunggu konfirmasi</li>
                                <li>Simpan nomor pendaftaran untuk tracking status</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- FAQ 2: Dokumen yang Diperlukan -->
                <div class="bg-white rounded-lg shadow-lg">
                    <button class="w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none hover:bg-gray-50 transition-colors duration-200" data-faq="2">
                        <span class="font-semibold text-gray-900">Dokumen apa saja yang diperlukan?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" data-icon="2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 text-gray-600 hidden" data-content="2">
                        <div class="space-y-3">
                            <p>Dokumen yang harus disiapkan dan diupload:</p>
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li><strong>Foto siswa 3x4</strong> - latar belakang merah, format JPG/PNG, maksimal 2MB</li>
                                <li><strong>Scan ijazah/SKHUN SD/MI</strong> - format PDF, maksimal 5MB</li>
                                <li><strong>Scan kartu keluarga</strong> - format PDF, maksimal 5MB</li>
                                <li><strong>Scan akta kelahiran</strong> - format PDF, maksimal 5MB</li>
                                <li><strong>Sertifikat prestasi</strong> - format PDF, maksimal 5MB (jika ada)</li>
                                <li><strong>Surat keterangan tidak mampu</strong> - format PDF, maksimal 5MB (untuk jalur afirmasi)</li>
                            </ul>
                            <p class="text-sm text-gray-500 mt-3">Pastikan semua dokumen dalam kondisi jelas dan dapat dibaca.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 3: Pengumuman Hasil -->
                <div class="bg-white rounded-lg shadow-lg">
                    <button class="w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none hover:bg-gray-50 transition-colors duration-200" data-faq="3">
                        <span class="font-semibold text-gray-900">Kapan pengumuman hasil seleksi?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" data-icon="3">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 text-gray-600 hidden" data-content="3">
                        <div class="space-y-3">
                            <p>Pengumuman hasil seleksi akan dilakukan pada:</p>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="font-semibold text-blue-800">{{ $setting->announcement_date->format('d F Y, H:i') }}</p>
                            </div>
                            <p>Hasil dapat dilihat melalui:</p>
                            <ul class="list-disc list-inside space-y-1 ml-4">
                                <li>Halaman pengumuman di website ini</li>
                                <li>Email yang terdaftar saat pendaftaran</li>
                                <li>Pengumuman di papan sekolah</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQ 4: Cek Status Pendaftaran -->
                <div class="bg-white rounded-lg shadow-lg">
                    <button class="w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none hover:bg-gray-50 transition-colors duration-200" data-faq="4">
                        <span class="font-semibold text-gray-900">Bagaimana cara cek status pendaftaran?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" data-icon="4">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 text-gray-600 hidden" data-content="4">
                        <div class="space-y-3">
                            <p>Untuk mengecek status pendaftaran:</p>
                            <ol class="list-decimal list-inside space-y-2 ml-4">
                                <li>Klik menu "Cek Status" di halaman ini</li>
                                <li>Masukkan nomor pendaftaran yang Anda terima</li>
                                <li>Masukkan email yang digunakan saat pendaftaran</li>
                                <li>Klik "Cek Status" untuk melihat informasi terkini</li>
                            </ol>
                            <p class="text-sm text-gray-500 mt-3">Status yang mungkin muncul: Menunggu Verifikasi, Terverifikasi, Diterima, Ditolak, atau Cadangan.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 5: Biaya Pendaftaran -->
                <div class="bg-white rounded-lg shadow-lg">
                    <button class="w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none hover:bg-gray-50 transition-colors duration-200" data-faq="5">
                        <span class="font-semibold text-gray-900">Berapa biaya pendaftaran PPDB?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" data-icon="5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 text-gray-600 hidden" data-content="5">
                        <div class="space-y-3">
                            <p>Biaya pendaftaran PPDB adalah:</p>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="font-semibold text-green-800">Rp {{ number_format($setting->registration_fee, 0, ',', '.') }}</p>
                            </div>
                            <p>Biaya ini berlaku untuk semua jalur pendaftaran (Reguler, Prestasi, dan Afirmasi).</p>
                            <p class="text-sm text-gray-500">Pembayaran dapat dilakukan melalui transfer bank atau langsung ke sekolah.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 6: Kuota Pendaftaran -->
                <div class="bg-white rounded-lg shadow-lg">
                    <button class="w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none hover:bg-gray-50 transition-colors duration-200" data-faq="6">
                        <span class="font-semibold text-gray-900">Berapa kuota pendaftaran untuk setiap jalur?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" data-icon="6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 text-gray-600 hidden" data-content="6">
                        <div class="space-y-3">
                            <p>Kuota pendaftaran untuk tahun ajaran {{ $setting->academicYear->year }}:</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-blue-50 p-4 rounded-lg text-center">
                                    <p class="font-semibold text-blue-800">Jalur Reguler</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ number_format($setting->quota_regular) }}</p>
                                    <p class="text-sm text-blue-600">siswa</p>
                                </div>
                                <div class="bg-yellow-50 p-4 rounded-lg text-center">
                                    <p class="font-semibold text-yellow-800">Jalur Prestasi</p>
                                    <p class="text-2xl font-bold text-yellow-600">{{ number_format($setting->quota_achievement) }}</p>
                                    <p class="text-sm text-yellow-600">siswa</p>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg text-center">
                                    <p class="font-semibold text-green-800">Jalur Afirmasi</p>
                                    <p class="text-2xl font-bold text-green-600">{{ number_format($setting->quota_affirmation) }}</p>
                                    <p class="text-sm text-green-600">siswa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ 7: Persyaratan Umur -->
                <div class="bg-white rounded-lg shadow-lg">
                    <button class="w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none hover:bg-gray-50 transition-colors duration-200" data-faq="7">
                        <span class="font-semibold text-gray-900">Berapa batas usia untuk mendaftar?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" data-icon="7">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 text-gray-600 hidden" data-content="7">
                        <div class="space-y-3">
                            <p>Batas usia untuk mendaftar PPDB:</p>
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li><strong>Usia maksimal:</strong> 15 tahun pada 1 Juli {{ $setting->academicYear->year }}</li>
                                <li><strong>Usia minimal:</strong> 12 tahun pada 1 Juli {{ $setting->academicYear->year }}</li>
                                <li>Usia dihitung berdasarkan akta kelahiran</li>
                                <li>Untuk siswa yang lahir di luar negeri, usia dihitung berdasarkan dokumen resmi</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQ 8: Kontak Bantuan -->
                <div class="bg-white rounded-lg shadow-lg">
                    <button class="w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none hover:bg-gray-50 transition-colors duration-200" data-faq="8">
                        <span class="font-semibold text-gray-900">Bagaimana jika mengalami kendala teknis?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" data-icon="8">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="px-6 pb-4 text-gray-600 hidden" data-content="8">
                        <div class="space-y-3">
                            <p>Jika mengalami kendala teknis, Anda dapat menghubungi:</p>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="space-y-2">
                                    <p><strong>Telepon:</strong> (0913) 1234567</p>
                                    <p><strong>Email:</strong> ppdb@smpn01namrole.sch.id</p>
                                    <p><strong>WhatsApp:</strong> +62 812-3456-7890</p>
                                    <p><strong>Jam Layanan:</strong> Senin - Jumat, 08:00 - 15:00 WIB</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Tim support akan membantu mengatasi kendala yang Anda alami.</p>
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Countdown Timer
    function updateCountdown() {
        const endDate = new Date('{{ $setting->end_date->format('Y-m-d H:i:s') }}').getTime();
        const now = new Date().getTime();
        const distance = endDate - now;

        if (distance < 0) {
            const countdownElement = document.getElementById('countdown');
            if (countdownElement) {
                countdownElement.innerHTML = '<div class="text-2xl font-bold">Pendaftaran Sudah Ditutup</div>';
            }
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        const daysElement = document.getElementById('days');
        const hoursElement = document.getElementById('hours');
        const minutesElement = document.getElementById('minutes');
        const secondsElement = document.getElementById('seconds');

        if (daysElement) daysElement.innerHTML = days.toString().padStart(2, '0');
        if (hoursElement) hoursElement.innerHTML = hours.toString().padStart(2, '0');
        if (minutesElement) minutesElement.innerHTML = minutes.toString().padStart(2, '0');
        if (secondsElement) secondsElement.innerHTML = seconds.toString().padStart(2, '0');
    }

    // Update countdown every second
    setInterval(updateCountdown, 1000);
    updateCountdown();

    // FAQ Toggle - Ultra Simple Version
    function initFAQ() {
        console.log('Initializing FAQ...');
        
        // Add click listeners to all FAQ buttons
        const faqButtons = document.querySelectorAll('[data-faq]');
        console.log('Found FAQ buttons:', faqButtons.length);
        
        faqButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const faqId = this.getAttribute('data-faq');
                console.log('FAQ clicked:', faqId);
                
                const content = document.querySelector(`[data-content="${faqId}"]`);
                const icon = document.querySelector(`[data-icon="${faqId}"]`);
                
                if (!content || !icon) {
                    console.error('FAQ elements not found for id:', faqId);
                    return;
                }
                
                // Close all other FAQs
                document.querySelectorAll('[data-content]').forEach(item => {
                    if (item.getAttribute('data-content') !== faqId) {
                        item.classList.add('hidden');
                    }
                });
                
                document.querySelectorAll('[data-icon]').forEach(item => {
                    if (item.getAttribute('data-icon') !== faqId) {
                        item.style.transform = 'rotate(0deg)';
                    }
                });
                
                // Toggle current FAQ
                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    icon.style.transform = 'rotate(180deg)';
                    console.log('FAQ opened:', faqId);
                } else {
                    content.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                    console.log('FAQ closed:', faqId);
                }
            });
        });
    }
    
    // Initialize FAQ
    initFAQ();
});
</script>
@endpush

