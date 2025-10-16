@extends('layouts.app')

@section('title', 'Cek Status PPDB 2025 - SMP Negeri 01 Namrole')

@section('content')
<!-- Page Header -->
<section class="relative py-20 bg-primary-500">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">Cek Status PPDB 2025</h1>
        <p class="text-xl text-gray-200 mb-6">Lihat status pendaftaran Anda</p>
        <a href="{{ route('ppdb.index') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-6 py-3 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Pendaftaran
        </a>
    </div>
</section>

<!-- Main Content -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
        @if(isset($registration))
            <!-- Registration Found -->
            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Status Pendaftaran</h2>
                    <p class="text-primary-100">Data pendaftaran ditemukan</p>
                </div>

                <div class="p-8">
                    <!-- Registration Details -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pendaftaran</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Nomor Pendaftaran:</p>
                                <p class="text-lg font-bold text-blue-600">{{ $registration->registration_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Nama Lengkap:</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $registration->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Email:</p>
                                <p class="text-base text-gray-900">{{ $registration->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Status:</p>
                                {!! $registration->status_badge !!}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Tanggal Daftar:</p>
                                <p class="text-base text-gray-900">{{ $registration->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Asal Sekolah:</p>
                                <p class="text-base text-gray-900">{{ $registration->school_origin }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Information -->
                    <div class="bg-blue-50 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Informasi Status</h3>
                        @if($registration->status === 'pending')
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-800">
                                        <strong>Menunggu Verifikasi</strong> - Pendaftaran Anda sedang dalam proses verifikasi. 
                                        Silakan tunggu konfirmasi dari panitia.
                                    </p>
                                </div>
                            </div>
                        @elseif($registration->status === 'verified')
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-800">
                                        <strong>Terverifikasi</strong> - Data Anda telah diverifikasi. 
                                        Menunggu persetujuan dari panitia.
                                    </p>
                            </div>
                        </div>
                        @elseif($registration->status === 'approved')
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-thumbs-up text-green-600 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-800">
                                        <strong>Disetujui</strong> - Selamat! Pendaftaran Anda telah disetujui. 
                                        Silakan hubungi panitia untuk langkah selanjutnya.
                                    </p>
                                </div>
                            </div>
                        @elseif($registration->status === 'rejected')
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-800">
                                        <strong>Ditolak</strong> - Maaf, pendaftaran Anda ditolak. 
                                        @if($registration->rejection_reason)
                                            <br><strong>Alasan:</strong> {{ $registration->rejection_reason }}
                                        @endif
                                    </p>
                        </div>
                    </div>
                        @endif
                    </div>
                    
                    <!-- Next Steps -->
                    @if($registration->status === 'approved')
                    <div class="bg-green-50 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-green-900 mb-4">Langkah Selanjutnya</h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-800">
                                        <strong>Hubungi panitia</strong> - Untuk informasi lebih lanjut tentang proses selanjutnya
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-800">
                                        <strong>Lengkapi dokumen</strong> - Siapkan dokumen yang diperlukan
                                    </p>
                        </div>
                    </div>
                        </div>
                    </div>
                    @endif

                    <!-- Contact Info -->
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Kontak Panitia PPDB</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Telepon:</p>
                                <p class="text-base text-gray-900">(021) 1234-5678</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">WhatsApp:</p>
                                <p class="text-base text-gray-900">0812-3456-7890</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Email:</p>
                                <p class="text-base text-gray-900">ppdb@smpn01namrole.sch.id</p>
                        </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Alamat:</p>
                                <p class="text-base text-gray-900">Jl. Pendidikan No. 1, Namrole</p>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Search Form -->
            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Cek Status Pendaftaran</h2>
                    <p class="text-primary-100">Masukkan nomor pendaftaran dan email untuk melihat status</p>
        </div>

                <div class="p-8">
                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                
                <form method="POST" action="{{ route('ppdb.check-status') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Pendaftaran <span class="text-red-500">*</span>
                        </label>
                            <input type="text" name="registration_number" value="{{ old('registration_number') }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Masukkan nomor pendaftaran" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Masukkan email yang digunakan saat pendaftaran" required>
                        </div>
                        
                        <div class="flex justify-center">
                            <button type="submit" 
                                    class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-8 rounded-lg transition-colors duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Cek Status
                            </button>
                        </div>
                    </form>

                    <!-- Help Info -->
                    <div class="mt-8 bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Butuh Bantuan?</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Telepon:</p>
                                <p class="text-base text-gray-900">(021) 1234-5678</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">WhatsApp:</p>
                                <p class="text-base text-gray-900">0812-3456-7890</p>
                        </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Email:</p>
                                <p class="text-base text-gray-900">ppdb@smpn01namrole.sch.id</p>
                        </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Alamat:</p>
                                <p class="text-base text-gray-900">Jl. Pendidikan No. 1, Namrole</p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
            <a href="{{ route('ppdb.index') }}" 
               class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Daftar PPDB
            </a>
            <a href="{{ route('home') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                <i class="fas fa-home mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>
@endsection
