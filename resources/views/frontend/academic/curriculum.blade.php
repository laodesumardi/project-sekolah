@extends('layouts.app')

@section('title', 'Kurikulum - SMP Negeri 01 Namrole')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Akademik', 'url' => null],
    ['name' => 'Kurikulum', 'url' => null]
]" />

<!-- Page Header -->
<x-page-header 
    title="Kurikulum Sekolah" 
    subtitle="Struktur kurikulum dan mata pelajaran yang diajarkan di SMP Negeri 01 Namrole" 
/>

<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Curriculum Explanation -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-primary-800 mb-4">Kurikulum Merdeka</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    SMP Negeri 01 Namrole menggunakan Kurikulum Merdeka yang memberikan fleksibilitas 
                    dalam pembelajaran dan mengembangkan potensi siswa secara optimal.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-primary-50 rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-primary-800 mb-4">Keunggulan Kurikulum Merdeka</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Pembelajaran yang lebih fleksibel dan menyenangkan
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Fokus pada pengembangan karakter dan kompetensi
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Penilaian yang lebih komprehensif dan berkelanjutan
                        </li>
                    </ul>
                </div>

                <div class="bg-secondary-50 rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-secondary-800 mb-4">Struktur Program</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Mata Pelajaran Wajib</span>
                            <span class="font-semibold text-secondary-600">32 JP/Minggu</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Mata Pelajaran Pilihan</span>
                            <span class="font-semibold text-secondary-600">4 JP/Minggu</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Ekstrakurikuler</span>
                            <span class="font-semibold text-secondary-600">2 JP/Minggu</span>
                        </div>
                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center font-semibold">
                                <span>Total Jam Pelajaran</span>
                                <span class="text-primary-600">38 JP/Minggu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects by Grade Level -->
        <div class="space-y-8">
            @foreach($subjectsByGrade as $grade => $subjects)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-primary-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white">
                            @if($grade === 'all')
                                Mata Pelajaran Umum
                            @else
                                Kelas {{ $grade }}
                            @endif
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($subjects as $subject)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex justify-between items-start mb-3">
                                        <h4 class="font-semibold text-gray-900">{{ $subject->name }}</h4>
                                        <span class="text-sm text-gray-500">{{ $subject->code }}</span>
                                    </div>
                                    
                                    @if($subject->description)
                                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($subject->description, 100) }}</p>
                                    @endif
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500">
                                            {{ $subject->hours_per_week }} JP/Minggu
                                        </span>
                                        
                                        @if($subject->syllabus_file)
                                            <a href="{{ route('academic.syllabus.download', $subject) }}" 
                                               class="inline-flex items-center text-primary-600 hover:text-primary-700 text-sm font-medium">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Download Silabus
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Additional Information -->
        <div class="mt-12 bg-gradient-to-r from-primary-500 to-secondary rounded-lg p-8 text-white">
            <div class="text-center">
                <h3 class="text-2xl font-bold mb-4">Informasi Lebih Lanjut</h3>
                <p class="text-lg mb-6">
                    Untuk informasi lebih detail tentang kurikulum dan mata pelajaran, 
                    silakan hubungi bagian akademik sekolah.
                </p>
                <a href="{{ route('kontak') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white text-primary-600 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

