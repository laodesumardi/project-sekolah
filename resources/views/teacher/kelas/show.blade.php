@extends('teacher.layouts.app')

@section('title', 'Detail Kelas - ' . $class->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('teacher.kelas.index') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <span class="sr-only">Kelas</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Detail Kelas</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                {{ $class->name }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Kelas {{ $class->name }} • {{ $students->count() }} siswa • {{ now()->format('d F Y') }}
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            <button type="button" 
                    onclick="refreshClass()"
                    class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                </svg>
                Refresh
            </button>
            <a href="{{ route('teacher.kelas.index') }}" 
               class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 010-1.06L10.94 8.25H3.75a.75.75 0 010-1.5h7.19L7.72 3.47a.75.75 0 011.06-1.06l4.5 4.5a.75.75 0 010 1.06l-4.5 4.5a.75.75 0 01-1.06 0z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-0">
                <label for="search" class="block text-sm font-medium text-gray-700">Cari Siswa</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ $search }}"
                       placeholder="Cari berdasarkan nama..."
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div class="flex-1 min-w-0">
                <label for="sort" class="block text-sm font-medium text-gray-700">Urutkan</label>
                <select id="sort" name="sort" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="nis" {{ $sortBy == 'nis' ? 'selected' : '' }}>NIS</option>
                    <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Nama</option>
                    <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>Tanggal Bergabung</option>
                </select>
            </div>
            <div class="flex-1 min-w-0">
                <label for="order" class="block text-sm font-medium text-gray-700">Urutan</label>
                <select id="order" name="order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>A-Z</option>
                    <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Z-A</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="button" 
                        onclick="applyFilters()"
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Terapkan Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Siswa</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_students'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Kehadiran Hari Ini</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $attendanceSummary['present_today'] }}/{{ $attendanceSummary['total_students'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Rata-rata Nilai</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $gradeSummary['average_grade'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tugas Aktif</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $upcomingAssignments->where('status', 'active')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Metrik Performa Kelas</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Indikator performa dan partisipasi siswa
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $performanceMetrics['participation_rate'] }}%</div>
                    <div class="text-sm text-gray-500">Tingkat Partisipasi</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $performanceMetrics['assignment_completion'] }}%</div>
                    <div class="text-sm text-gray-500">Penyelesaian Tugas</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $performanceMetrics['quiz_average'] }}</div>
                    <div class="text-sm text-gray-500">Rata-rata Kuis</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $performanceMetrics['behavior_score'] }}%</div>
                    <div class="text-sm text-gray-500">Skor Perilaku</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Siswa</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ $students->count() }} siswa di kelas {{ $class->name }}
            </p>
        </div>
        <ul class="divide-y divide-gray-200">
            @forelse($students as $student)
            <li>
                <div class="px-4 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-sm font-medium text-blue-600">
                                    {{ substr($student->user->name, 0, 2) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $student->user->name }}</div>
                            <div class="text-sm text-gray-500">NIS: {{ $student->nis ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-400">Bergabung: {{ $student->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Aktif
                        </span>
                        <button onclick="viewStudentDetails({{ $student->id }})" 
                                class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                            Detail
                        </button>
                    </div>
                </div>
            </li>
            @empty
            <li>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada siswa</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada siswa yang terdaftar di kelas ini.</p>
                </div>
            </li>
            @endforelse
        </ul>
    </div>

    <!-- Upcoming Assignments -->
    @if($upcomingAssignments->count() > 0)
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Tugas Mendatang</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Tugas yang akan datang untuk kelas ini
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="space-y-3">
                @foreach($upcomingAssignments as $assignment)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $assignment->title }}</p>
                            <p class="text-sm text-gray-500">{{ $assignment->subject }} • {{ $assignment->submitted }}/{{ $assignment->total }} siswa</p>
                            <p class="text-xs text-gray-400">Deadline: {{ $assignment->due_date->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $assignment->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $assignment->status === 'active' ? 'Aktif' : 'Akan Datang' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Class Announcements -->
    @if($announcements->count() > 0)
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Pengumuman Kelas</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Pengumuman terbaru untuk kelas ini
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="space-y-3">
                @foreach($announcements as $announcement)
                <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $announcement->title }}</p>
                        <p class="text-sm text-gray-500">{{ $announcement->content }}</p>
                        <p class="text-xs text-gray-400">{{ $announcement->author }} • {{ $announcement->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="ml-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $announcement->priority === 'high' ? 'bg-red-100 text-red-800' : 
                               ($announcement->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            {{ $announcement->priority === 'high' ? 'Penting' : 
                               ($announcement->priority === 'medium' ? 'Sedang' : 'Rendah') }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Aksi Cepat</h3>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <button onclick="inputAttendance()" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Input Absensi</p>
                        <p class="text-sm text-gray-500">Catat kehadiran siswa</p>
                    </div>
                </button>

                <button onclick="inputGrades()" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Input Nilai</p>
                        <p class="text-sm text-gray-500">Masukkan nilai siswa</p>
                    </div>
                </button>

                <button onclick="createAssignment()" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Buat Tugas</p>
                        <p class="text-sm text-gray-500">Buat tugas baru</p>
                    </div>
                </button>

                <button onclick="viewAnalytics()" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Analytics</p>
                        <p class="text-sm text-gray-500">Lihat analisis kelas</p>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function applyFilters() {
    const search = document.getElementById('search').value;
    const sort = document.getElementById('sort').value;
    const order = document.getElementById('order').value;
    
    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (sort) params.append('sort', sort);
    if (order) params.append('order', order);
    
    window.location.href = '{{ route("teacher.kelas.show", $class->id) }}?' + params.toString();
}

function refreshClass() {
    location.reload();
}

function viewStudentDetails(studentId) {
    window.location.href = '{{ route("teacher.kelas.show", $class->id) }}/student/' + studentId;
}

function inputAttendance() {
    window.location.href = '{{ route("teacher.kelas.show", $class->id) }}/attendance';
}

function inputGrades() {
    window.location.href = '{{ route("teacher.kelas.show", $class->id) }}/grades';
}

function createAssignment() {
    alert('Fitur buat tugas akan segera tersedia!');
}

function viewAnalytics() {
    window.location.href = '{{ route("teacher.kelas.analytics", $class->id) }}';
}

// Auto-refresh every 15 minutes
setInterval(function() {
    location.reload();
}, 900000); // 15 minutes
</script>
@endsection