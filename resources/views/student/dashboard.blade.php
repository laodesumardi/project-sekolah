@extends('student.layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
@include('components.dashboard-updater')

<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Dashboard Siswa
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Selamat datang, {{ $profile->name ?? 'Siswa' }}! Lihat progress pembelajaran Anda.
            </p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Dokumen Terverifikasi</dt>
                            <dd class="text-2xl font-semibold text-gray-900" data-stat="documents_verified">{{ $stats['documents_verified'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tugas Selesai</dt>
                            <dd class="text-2xl font-semibold text-gray-900" data-stat="assignments_completed">{{ $stats['assignments_completed'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Kehadiran</dt>
                            <dd class="text-2xl font-semibold text-gray-900" data-stat="attendance_rate">{{ $stats['attendance_rate'] }}%</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Nilai Rata-rata</dt>
                            <dd class="text-2xl font-semibold text-gray-900" data-stat="current_gpa">{{ $stats['current_gpa'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Information -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Akademik</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Detail informasi akademik Anda
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Kelas Saat Ini</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $academicData['current_class'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tahun Masuk</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $academicData['entry_year'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Semester Aktif</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $academicData['active_semester'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Wali Kelas</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $academicData['homeroom_teacher'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status Siswa</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $academicData['student_status'] }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Aktivitas Terbaru</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Aktivitas terbaru dalam sistem
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div id="recent-activities" class="space-y-3">
                @if(isset($dashboardData['activities']) && count($dashboardData['activities']) > 0)
                    @foreach($dashboardData['activities'] as $activity)
                        <div class="flex items-center p-3 border-l-4 border-{{ $activity['color'] }}-500 bg-{{ $activity['color'] }}-50">
                            <div class="flex-shrink-0">
                                <i class="{{ $activity['icon'] }} text-{{ $activity['color'] }}-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-sm text-gray-500">Tidak ada aktivitas terbaru</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Aksi Cepat</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Akses cepat ke fitur-fitur penting
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('student.tugas.index') }}" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 rounded-lg border border-gray-200 hover:border-gray-300">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-blue-50 text-blue-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Tugas
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Lihat dan kerjakan tugas-tugas yang diberikan
                        </p>
                    </div>
                </a>

                <a href="{{ route('student.jadwal.index') }}" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 rounded-lg border border-gray-200 hover:border-gray-300">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-green-50 text-green-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Jadwal
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Lihat jadwal pelajaran Anda
                        </p>
                    </div>
                </a>

                <a href="{{ route('student.profil.index') }}" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 rounded-lg border border-gray-200 hover:border-gray-300">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-purple-50 text-purple-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Profil
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Kelola profil dan dokumen Anda
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
