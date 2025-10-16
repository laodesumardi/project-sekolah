@extends('layouts.app')

@section('title', 'Pendaftaran Ditutup - PPDB 2025')

@section('content')
<!-- Page Header -->
<section class="relative py-20 bg-red-500">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">Pendaftaran Ditutup</h1>
        <p class="text-xl text-gray-200 mb-6">Pendaftaran PPDB {{ $settings['hero_title'] }} saat ini ditutup</p>
        <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2 inline-block">
            <span class="text-white font-medium">Periode: {{ date('d M', strtotime($settings['registration_period_start'])) }} - {{ date('d M Y', strtotime($settings['registration_period_end'])) }}</span>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Closed Icon -->
            <div class="mb-8">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100">
                    <i class="fas fa-lock text-red-600 text-4xl"></i>
                </div>
            </div>

            <!-- Closed Message -->
            <div class="bg-white rounded-xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Pendaftaran Sedang Ditutup</h2>
                <p class="text-lg text-gray-600 mb-6">
                    Maaf, pendaftaran PPDB {{ $settings['hero_title'] }} saat ini sedang ditutup. 
                    Silakan hubungi panitia untuk informasi lebih lanjut.
                </p>

                <!-- Contact Information -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Kontak Panitia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Telepon:</p>
                            <p class="text-base text-gray-900">{{ $settings['contact_phone'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Email:</p>
                            <p class="text-base text-gray-900">{{ $settings['contact_email'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">WhatsApp:</p>
                            <p class="text-base text-gray-900">{{ $settings['contact_whatsapp'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Alamat:</p>
                            <p class="text-base text-gray-900">{{ $settings['contact_address'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" 
                       class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                        <i class="fas fa-home mr-2"></i>
                        Kembali ke Beranda
                    </a>
                    <a href="{{ route('ppdb.status') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>
                        Cek Status Pendaftaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
