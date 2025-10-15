@extends('layouts.app')

@section('title', 'Daftar Ekstrakurikuler - ' . $extracurricular->name)

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Ekstrakurikuler', 'url' => route('extracurriculars.index')],
    ['name' => $extracurricular->name, 'url' => route('extracurriculars.show', $extracurricular->slug)],
    ['name' => 'Daftar', 'url' => null]
]" />

<div class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-8 text-white">
                <div class="flex items-center space-x-4">
                    @if($extracurricular->cover_image)
                        <img src="{{ $extracurricular->cover_image_url }}" alt="{{ $extracurricular->name }}" 
                             class="w-16 h-16 rounded-lg object-cover border-2 border-white">
                    @else
                        <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold">{{ $extracurricular->name }}</h1>
                        <p class="text-blue-100">Form Pendaftaran Ekstrakurikuler</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Info Card -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-blue-800">Informasi Pendaftaran</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p><strong>Kuota:</strong> {{ $extracurricular->current_participants }}/{{ $extracurricular->max_participants }} peserta</p>
                                <p><strong>Jadwal:</strong> {{ $extracurricular->schedule_day }}, {{ $extracurricular->schedule_time }}</p>
                                <p><strong>Lokasi:</strong> {{ $extracurricular->location }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('extracurriculars.register', $extracurricular->slug) }}" class="space-y-6">
                    @csrf
                    
                    <!-- Student Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Siswa</h3>
                        
                        @if(auth()->check() && auth()->user()->student)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" value="{{ auth()->user()->name }}" readonly 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                                    <input type="text" value="{{ auth()->user()->student->class->name ?? 'Belum ditentukan' }}" readonly 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600">
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Login Diperlukan</h3>
                                <p class="text-gray-600 mb-4">Silakan login terlebih dahulu untuk mendaftar ekstrakurikuler</p>
                                <a href="{{ route('login') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Login
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Motivation -->
                    <div>
                        <label for="motivation" class="block text-sm font-medium text-gray-700 mb-2">
                            Alasan Mengikuti Ekstrakurikuler <span class="text-red-500">*</span>
                        </label>
                        <textarea id="motivation" name="motivation" rows="4" required
                                  placeholder="Ceritakan alasan Anda ingin mengikuti ekstrakurikuler ini..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('motivation') border-red-500 @enderror">{{ old('motivation') }}</textarea>
                        @error('motivation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Experience -->
                    <div>
                        <label for="experience" class="block text-sm font-medium text-gray-700 mb-2">
                            Pengalaman Terkait
                        </label>
                        <textarea id="experience" name="experience" rows="3"
                                  placeholder="Ceritakan pengalaman Anda yang terkait dengan ekstrakurikuler ini (opsional)..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('experience') border-red-500 @enderror">{{ old('experience') }}</textarea>
                        @error('experience')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Agreement -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" id="agreement" name="agreement" required
                                   class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="agreement" class="text-sm text-gray-700">
                                Saya menyatakan bahwa informasi yang saya berikan adalah benar dan saya bersedia mengikuti semua aturan dan jadwal ekstrakurikuler ini. <span class="text-red-500">*</span>
                            </label>
                        </div>
                        @error('agreement')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('extracurriculars.show', $extracurricular->slug) }}" 
                           class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-md text-center hover:bg-gray-600 transition-colors">
                            Batal
                        </a>
                        @if(auth()->check() && auth()->user()->student)
                            <button type="submit" 
                                    class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors">
                                Daftar Sekarang
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
