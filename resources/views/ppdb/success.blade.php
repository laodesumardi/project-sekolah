@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - PPDB 2025')

@section('content')
<!-- Success Page -->
<section class="py-20 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100">
                    <i class="fas fa-check-circle text-green-600 text-4xl"></i>
                </div>
            </div>

            <!-- Success Message -->
            <div class="bg-white rounded-xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Pendaftaran Berhasil!</h1>
                    <p class="text-lg text-gray-600">Terima kasih telah mendaftar di SMP Negeri 01 Namrole</p>
                </div>

                <!-- Registration Details -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Pendaftaran</h2>
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
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>
                                Menunggu Verifikasi
                            </span>
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

                <!-- Next Steps -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Langkah Selanjutnya
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-800">
                                    <strong>Simpan nomor pendaftaran</strong> - Anda akan membutuhkannya untuk cek status
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-800">
                                    <strong>Cek email</strong> - Kami akan mengirim konfirmasi dan informasi selanjutnya
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-800">
                                    <strong>Lengkapi dokumen</strong> - Siapkan dokumen yang diperlukan sesuai jadwal
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-gray-100 rounded-lg p-6 mb-8">
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

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('ppdb.status') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>
                        Cek Status Pendaftaran
                    </a>
                    <a href="{{ route('ppdb.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Daftar Lagi
                    </a>
                    <a href="{{ route('home') }}" 
                       class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                        <i class="fas fa-home mr-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

            <!-- Print Button -->
            <div class="text-center mt-6">
                <button onclick="window.print()" 
                        class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                    <i class="fas fa-print mr-2"></i>
                    Cetak Halaman
                </button>
            </div>
        </div>
    </div>
</section>

<script>
    // Auto print after 3 seconds
    setTimeout(function() {
        if (confirm('Apakah Anda ingin mencetak halaman ini?')) {
            window.print();
        }
    }, 3000);
</script>
@endsection
