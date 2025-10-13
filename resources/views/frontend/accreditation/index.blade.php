@extends('layouts.app')

@section('title', 'Akreditasi Sekolah - SMP Negeri 01 Namrole')

@section('content')
<!-- Hero Section -->
<section class="bg-primary-500 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-6">Akreditasi Sekolah</h1>
        <p class="text-xl text-primary-100 max-w-3xl mx-auto">
            Pengakuan kualitas pendidikan yang telah diraih SMP Negeri 01 Namrole
        </p>
    </div>
</section>

<!-- Accreditation Information -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($homepageSetting && $homepageSetting->accreditation_grade)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Accreditation Badge -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-40 h-40 bg-green-500 text-white rounded-full mb-8 mx-auto">
                    <span class="text-5xl font-bold">{{ $homepageSetting->accreditation_grade ?? 'A' }}</span>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Akreditasi {{ $homepageSetting->accreditation_grade ?? 'A' }}</h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    {{ $homepageSetting->accreditation_description ?? 'Predikat sangat baik dalam standar pendidikan nasional' }}
                </p>
            </div>
            
            <!-- Accreditation Details -->
            <div class="space-y-8">
                <div class="bg-gray-50 rounded-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Detail Akreditasi</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Grade Akreditasi</h4>
                                <p class="text-gray-600">{{ $homepageSetting->accreditation_grade ?? 'A' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Berlaku Hingga</h4>
                                <p class="text-gray-600">{{ $homepageSetting->accreditation_valid_until ?? '2025' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($homepageSetting->accreditation_certificate)
                <div class="bg-white rounded-lg shadow-lg p-8 border-2 border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sertifikat Akreditasi</h3>
                    <div class="text-center">
                        <img src="{{ $homepageSetting->accreditation_certificate_url }}" 
                             alt="Sertifikat Akreditasi" 
                             class="w-64 h-64 object-cover rounded-lg mx-auto border-2 border-gray-200 shadow-lg">
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        <!-- Default content when no accreditation data -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Accreditation Badge -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-40 h-40 bg-green-500 text-white rounded-full mb-8 mx-auto">
                    <span class="text-5xl font-bold">A</span>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Akreditasi A</h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Predikat sangat baik dalam standar pendidikan nasional
                </p>
            </div>
            
            <!-- Accreditation Details -->
            <div class="space-y-8">
                <div class="bg-gray-50 rounded-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Detail Akreditasi</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Grade Akreditasi</h4>
                                <p class="text-gray-600">A</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Berlaku Hingga</h4>
                                <p class="text-gray-600">2025</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Accreditation Benefits -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Manfaat Akreditasi</h2>
            <p class="text-lg text-gray-600">Pengakuan kualitas pendidikan yang memberikan kepercayaan kepada masyarakat</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-500 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Kualitas Terjamin</h3>
                <p class="text-gray-600">Standar pendidikan yang telah memenuhi kriteria nasional</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-500 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Kepercayaan Masyarakat</h3>
                <p class="text-gray-600">Memberikan jaminan kualitas kepada orang tua dan siswa</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-500 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Pengembangan Berkelanjutan</h3>
                <p class="text-gray-600">Komitmen untuk terus meningkatkan kualitas pendidikan</p>
            </div>
        </div>
    </div>
</section>
@endsection
