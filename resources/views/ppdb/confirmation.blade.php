@extends('layouts.app')

@section('title', 'Konfirmasi Pendaftaran PPDB')
@section('description', 'Konfirmasi pendaftaran PPDB SMP Negeri 01 Namrole')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Success Message -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <!-- Success Icon -->
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">🎉 Pendaftaran Berhasil!</h1>
                <p class="text-lg text-gray-600 mb-8">
                    Terima kasih telah mendaftar PPDB SMP Negeri 01 Namrole. 
                    <strong>Silakan simpan nomor pendaftaran Anda</strong> untuk keperluan tracking status dan download form pendaftaran.
                </p>
                
                <!-- Success Notification -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-green-800">Pendaftaran Berhasil Dikirim!</h3>
                            <p class="text-sm text-green-700">Data pendaftaran Anda telah tersimpan dan akan segera diproses oleh tim admin.</p>
                        </div>
                    </div>
                </div>

                <!-- Registration Details -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">📋 Detail Pendaftaran</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        <div class="md:col-span-2">
                            <span class="font-medium text-gray-700">Nomor Pendaftaran:</span>
                            <div class="mt-2 p-4 bg-white border-2 border-blue-300 rounded-lg">
                                <p class="text-3xl font-bold text-blue-600 text-center">{{ $registration->registration_number }}</p>
                                <p class="text-sm text-gray-500 text-center mt-2">Simpan nomor ini untuk tracking status</p>
                            </div>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Nama:</span>
                            <p class="text-lg font-semibold text-gray-900">{{ $registration->full_name }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Jalur Pendaftaran:</span>
                            <p class="text-lg font-semibold text-gray-900">{{ ucfirst($registration->registration_path) }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Status:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                Menunggu Verifikasi
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Download Notification -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-blue-800">Download Form Pendaftaran</h3>
                            <p class="text-sm text-blue-700">Form pendaftaran berisi semua data yang Anda isi dan dapat digunakan sebagai bukti pendaftaran. Form akan otomatis terbuka untuk dicetak.</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <!-- Download Form Button -->
                    <a href="{{ route('ppdb.download-form', $registration->registration_number) }}" target="_blank"
                       class="inline-flex items-center px-6 py-3 bg-primary-500 text-white font-semibold rounded-lg hover:bg-primary-600 transition-colors duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        📄 Download Form Pendaftaran
                    </a>

                    <!-- Check Status Button -->
                    <a href="{{ route('ppdb.status') }}" 
                       class="inline-flex items-center px-6 py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        🔍 Cek Status Pendaftaran
                    </a>
                </div>

                <!-- Status Check Notification -->
                <div class="mt-8 bg-green-50 border border-green-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-4">🔍 Cara Cek Status Pendaftaran</h3>
                    <div class="text-left space-y-2 text-green-700">
                        <p>• <strong>Klik tombol "Cek Status Pendaftaran"</strong> di atas</p>
                        <p>• <strong>Masukkan nomor pendaftaran</strong> yang telah Anda simpan</p>
                        <p>• <strong>Lihat status terbaru</strong> pendaftaran Anda</p>
                        <p>• <strong>Download form</strong> dari halaman status jika diperlukan</p>
                    </div>
                </div>

                <!-- Important Information -->
                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-4">⚠️ Informasi Penting</h3>
                    <div class="text-left space-y-2 text-yellow-700">
                        <p>• <strong>Simpan nomor pendaftaran</strong> untuk keperluan tracking status</p>
                        <p>• <strong>Periksa email</strong> secara berkala untuk notifikasi terbaru</p>
                        <p>• <strong>Download form pendaftaran</strong> sebagai bukti pendaftaran</p>
                        <p>• <strong>Hubungi admin</strong> jika mengalami kendala atau pertanyaan</p>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mt-8 bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Kontak Bantuan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="text-center">
                            <div class="font-medium text-gray-700">Telepon</div>
                            <div class="text-gray-600">(0913) 1234567</div>
                        </div>
                        <div class="text-center">
                            <div class="font-medium text-gray-700">Email</div>
                            <div class="text-gray-600">ppdb@smpn01namrole.sch.id</div>
                        </div>
                        <div class="text-center">
                            <div class="font-medium text-gray-700">WhatsApp</div>
                            <div class="text-gray-600">+62 812-3456-7890</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
