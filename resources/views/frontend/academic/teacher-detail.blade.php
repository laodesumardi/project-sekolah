@extends('layouts.app')

@section('title', $teacher->name . ' - Tenaga Pendidik')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                <span class="sr-only">Home</span>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z"></path>
                                </svg>
                                <a href="{{ route('academic.teachers') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Tenaga Pendidik</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z"></path>
                                </svg>
                                <span class="ml-4 text-sm font-medium text-gray-500">{{ $teacher->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Header -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-start space-x-6">
                        @if($teacher->photo)
                            <img src="{{ asset('storage/' . $teacher->photo) }}" 
                                 alt="{{ $teacher->name }}" 
                                 class="w-24 h-24 rounded-full object-cover">
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-4">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $teacher->name }}</h1>
                                @if($teacher->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </div>
                            
                            <div class="space-y-2">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span class="font-medium">{{ $teacher->subject }}</span>
                                </div>
                                
                                @if($teacher->email)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <a href="mailto:{{ $teacher->email }}" class="hover:text-blue-600">{{ $teacher->email }}</a>
                                    </div>
                                @endif
                                
                                @if($teacher->phone)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <a href="tel:{{ $teacher->phone }}" class="hover:text-blue-600">{{ $teacher->phone }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bio -->
                @if($teacher->bio)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Biografi</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($teacher->bio)) !!}
                        </div>
                    </div>
                @endif

                <!-- Education -->
                @if($teacher->education)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Riwayat Pendidikan</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($teacher->education)) !!}
                        </div>
                    </div>
                @endif

                <!-- Teaching Experience -->
                @if($teacher->teaching_experience)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Pengalaman Mengajar</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($teacher->teaching_experience)) !!}
                        </div>
                    </div>
                @endif

                <!-- Extracurriculars -->
                @if($teacher->extracurriculars->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Ekstrakurikuler yang Dibina</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($teacher->extracurriculars as $extracurricular)
                                <a href="{{ route('academic.extracurricular-detail', $extracurricular) }}" 
                                   class="block p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:shadow-md transition-all">
                                    <div class="flex items-center space-x-3">
                                        @if($extracurricular->icon)
                                            <img src="{{ asset('storage/' . $extracurricular->icon) }}" 
                                                 alt="{{ $extracurricular->name }}" 
                                                 class="w-12 h-12 rounded-lg object-cover">
                                        @endif
                                        <div class="flex-1">
                                            <h3 class="font-medium text-gray-900">{{ $extracurricular->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $extracurricular->category }}</p>
                                            <p class="text-xs text-gray-500">{{ ucfirst($extracurricular->schedule_day) }} - {{ $extracurricular->schedule_time->format('H:i') }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Related Teachers -->
                @if($relatedTeachers->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Guru Lainnya</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($relatedTeachers as $related)
                                <a href="{{ route('academic.teacher-detail', $related) }}" 
                                   class="block p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:shadow-md transition-all">
                                    <div class="flex items-center space-x-3">
                                        @if($related->photo)
                                            <img src="{{ asset('storage/' . $related->photo) }}" 
                                                 alt="{{ $related->name }}" 
                                                 class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <h3 class="font-medium text-gray-900">{{ $related->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $related->subject }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Mata Pelajaran</span>
                            <span class="text-sm font-medium text-gray-900">{{ $teacher->subject }}</span>
                        </div>
                        @if($teacher->education_level)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Pendidikan</span>
                                <span class="text-sm font-medium text-gray-900">{{ $teacher->education_level }}</span>
                            </div>
                        @endif
                        @if($teacher->years_of_experience)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Pengalaman</span>
                                <span class="text-sm font-medium text-gray-900">{{ $teacher->years_of_experience }} tahun</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Status</span>
                            <span class="text-sm font-medium {{ $teacher->is_active ? 'text-green-600' : 'text-gray-600' }}">
                                {{ $teacher->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Kontak</h3>
                    <div class="space-y-3">
                        @if($teacher->email)
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <a href="mailto:{{ $teacher->email }}" class="text-sm text-blue-600 hover:text-blue-800">{{ $teacher->email }}</a>
                            </div>
                        @endif
                        @if($teacher->phone)
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <a href="tel:{{ $teacher->phone }}" class="text-sm text-blue-600 hover:text-blue-800">{{ $teacher->phone }}</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Office Hours -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4">Jam Konsultasi</h3>
                    <div class="space-y-2">
                        <p class="text-sm text-blue-800">
                            <strong>Senin - Jumat:</strong><br>
                            07:00 - 15:00
                        </p>
                        <p class="text-sm text-blue-800">
                            <strong>Lokasi:</strong><br>
                            Ruang Guru SMP Negeri 01 Namrole
                        </p>
                        <p class="text-sm text-blue-700 mt-4">
                            Untuk konsultasi di luar jam kerja, silakan hubungi melalui email atau telepon.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

