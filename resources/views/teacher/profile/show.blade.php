@extends('teacher.layouts.app')

@section('title', 'Profil Guru')
@section('subtitle', 'Informasi profil dan pengaturan akun')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-8">
            <div class="flex items-center space-x-6">
                <div class="relative">
                    <img src="{{ $teacher->profile_picture_url }}" 
                         alt="{{ $teacher->full_name }}" 
                         class="w-24 h-24 rounded-full object-cover border-4 border-blue-200">
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 border-4 border-white rounded-full"></div>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $teacher->full_name }}</h1>
                    <p class="text-lg text-gray-600">NIP: {{ $teacher->nip }}</p>
                    <p class="text-sm text-gray-500">{{ $teacher->employment_status }}</p>
                    <div class="flex items-center mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Aktif
                        </span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('teacher.profile.edit') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Personal Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">NIK</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $teacher->nik }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $teacher->birth_place }}, {{ $teacher->birth_date->format('d M Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $teacher->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Agama</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $teacher->religion }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $teacher->address }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $teacher->phone }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Profesional</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status Kepegawaian</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->employment_status }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->join_date->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Pendidikan Terakhir</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->education_level }}</dd>
                    </div>
                    @if($teacher->major)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jurusan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $teacher->major }}</dd>
                        </div>
                    @endif
                    @if($teacher->university)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Universitas</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $teacher->university }}</dd>
                        </div>
                    @endif
                    @if($teacher->graduation_year)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tahun Lulus</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $teacher->graduation_year }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Teaching Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Mengajar</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Kelas yang Diampu</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($teacher->classes->count() > 0)
                                {{ $teacher->classes->pluck('name')->join(', ') }}
                            @else
                                <span class="text-gray-500">Belum ada kelas</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Mata Pelajaran</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($teacher->subjects->count() > 0)
                                {{ $teacher->subjects->pluck('name')->join(', ') }}
                            @else
                                <span class="text-gray-500">Belum ada mata pelajaran</span>
                            @endif
                        </dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bio Section -->
    @if($teacher->bio)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Tentang Saya</h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700 leading-relaxed">{{ $teacher->bio }}</p>
            </div>
        </div>
    @endif

    <!-- Documents and Certifications -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Documents -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Dokumen</h3>
            </div>
            <div class="p-6">
                @if($documents->count() > 0)
                    <div class="space-y-3">
                        @foreach($documents as $document)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-file text-blue-600 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $document->title }}</p>
                                        <p class="text-xs text-gray-600">{{ $document->file_size_formatted }}</p>
                                    </div>
                                </div>
                                <a href="{{ $document->file_url }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Belum ada dokumen</p>
                @endif
            </div>
        </div>

        <!-- Certifications -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Sertifikasi</h3>
            </div>
            <div class="p-6">
                @if($certifications->count() > 0)
                    <div class="space-y-3">
                        @foreach($certifications as $certification)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-certificate text-yellow-600 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $certification->certificate_name }}</p>
                                        <p class="text-xs text-gray-600">{{ $certification->issuing_institution }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-600">{{ $certification->issue_date->format('M Y') }}</p>
                                    @if($certification->expiry_date)
                                        <p class="text-xs {{ $certification->is_expired ? 'text-red-600' : 'text-gray-600' }}">
                                            {{ $certification->expiry_date->format('M Y') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Belum ada sertifikasi</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
