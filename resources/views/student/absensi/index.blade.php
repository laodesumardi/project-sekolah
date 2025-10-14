@extends('student.layouts.app')

@section('title', 'Absensi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Absensi
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Pantau kehadiran dan ketepatan waktu Anda
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            <a href="{{ route('student.absensi.calendar') }}" 
               class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                Kalender Absensi
            </a>
            <button type="button" onclick="exportAttendance()"
                    class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Export Laporan
            </button>
            <button type="button" onclick="refreshAttendance()"
                    class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                </svg>
                Refresh
            </button>
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Tingkat Kehadiran</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['attendance_rate'] }}%</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Ketepatan Waktu</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['punctuality_rate'] }}%</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Streak Saat Ini</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['current_streak'] }} hari</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Streak Terpanjang</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['longest_streak'] }} hari</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Summary -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Hadir</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['present_days'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Terlambat</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['late_days'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Tidak Hadir</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['absent_days'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-0">
                <label for="search" class="block text-sm font-medium text-gray-700">Cari Absensi</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ $search }}"
                       placeholder="Cari berdasarkan mata pelajaran, guru, atau catatan..."
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div class="flex-1 min-w-0">
                <label for="subject" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                <select id="subject" name="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($filterOptions['subjects'] as $subjectOption)
                    <option value="{{ $subjectOption }}" {{ $subject === $subjectOption ? 'selected' : '' }}>{{ $subjectOption }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-0">
                <label for="month" class="block text-sm font-medium text-gray-700">Bulan</label>
                <select id="month" name="month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @foreach($filterOptions['months'] as $monthValue => $monthLabel)
                    <option value="{{ $monthValue }}" {{ $month === $monthValue ? 'selected' : '' }}>{{ $monthLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-0">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Semua Status</option>
                    @foreach($filterOptions['statuses'] as $statusOption)
                    <option value="{{ $statusOption }}" {{ $status === $statusOption ? 'selected' : '' }}>
                        {{ ucfirst($statusOption) }}
                    </option>
                    @endforeach
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

    <!-- Quick Access -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Recent Activities -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Aktivitas Terbaru</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Aktivitas absensi terbaru
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-3">
                    @foreach($recentActivities as $activity)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                    {{ $activity->type === 'attendance_recorded' ? 'bg-green-100' : 
                                       ($activity->type === 'late_marked' ? 'bg-yellow-100' : 'bg-red-100') }}">
                                    @if($activity->type === 'attendance_recorded')
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    @elseif($activity->type === 'late_marked')
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @else
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $activity->title }}</p>
                                <p class="text-sm text-gray-500">{{ $activity->subject }}</p>
                                <p class="text-xs text-gray-400">{{ $activity->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $activity->status === 'present' ? 'bg-green-100 text-green-800' : 
                                   ($activity->status === 'late' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($activity->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Monthly Summary -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Ringkasan Bulanan</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Perbandingan bulan ini dan bulan lalu
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Bulan Ini</p>
                            <p class="text-sm text-gray-500">{{ $monthlySummary['current_month']['total_days'] }} hari</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-blue-600">{{ $monthlySummary['current_month']['attendance_rate'] }}%</p>
                            <p class="text-xs text-gray-500">{{ $monthlySummary['current_month']['present'] }} hadir</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Bulan Lalu</p>
                            <p class="text-sm text-gray-500">{{ $monthlySummary['previous_month']['total_days'] }} hari</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-gray-600">{{ $monthlySummary['previous_month']['attendance_rate'] }}%</p>
                            <p class="text-xs text-gray-500">{{ $monthlySummary['previous_month']['present'] }} hadir</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Trends -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Tren Kehadiran</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Performa kehadiran per mata pelajaran
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-3">
                    @foreach($attendanceTrends['subject_performance'] as $subject => $rate)
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">{{ $subject }}</span>
                        <div class="flex items-center">
                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $rate }}%"></div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $rate }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if(!empty($attendanceTrends['recommendations']))
                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <h4 class="text-sm font-medium text-yellow-800">Rekomendasi:</h4>
                    <ul class="mt-1 text-sm text-yellow-700">
                        @foreach($attendanceTrends['recommendations'] as $recommendation)
                        <li>• {{ $recommendation }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Attendance List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Absensi</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ $attendance->count() }} catatan absensi ditemukan
            </p>
        </div>
        <ul class="divide-y divide-gray-200">
            @forelse($attendance as $record)
            <li>
                <div class="px-4 py-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center
                                    {{ $record->status === 'present' ? 'bg-green-100' : 
                                       ($record->status === 'late' ? 'bg-yellow-100' : 'bg-red-100') }}">
                                    @if($record->status === 'present')
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    @elseif($record->status === 'late')
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @else
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $record->subject }}</div>
                                <div class="text-sm text-gray-500">{{ $record->teacher }} • {{ $record->class }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $record->date->format('d M Y') }} • {{ $record->room }}
                                </div>
                                @if($record->time_in && $record->time_out)
                                <div class="flex items-center mt-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-2">
                                        Masuk: {{ $record->time_in }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        Keluar: {{ $record->time_out }}
                                    </span>
                                </div>
                                @endif
                                @if($record->notes)
                                <div class="mt-1">
                                    <p class="text-xs text-gray-600">{{ $record->notes }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $record->status === 'present' ? 'bg-green-100 text-green-800' : 
                                   ($record->status === 'late' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($record->status) }}
                            </span>
                            <a href="{{ route('student.absensi.show', $record->id) }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            @empty
            <li>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data absensi</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada catatan absensi yang tersedia.</p>
                </div>
            </li>
            @endforelse
        </ul>
    </div>
</div>

<script>
function applyFilters() {
    const search = document.getElementById('search').value;
    const subject = document.getElementById('subject').value;
    const month = document.getElementById('month').value;
    const status = document.getElementById('status').value;
    
    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (subject) params.append('subject', subject);
    if (month) params.append('month', month);
    if (status) params.append('status', status);
    
    window.location.href = '{{ route("student.absensi.index") }}?' + params.toString();
}

function refreshAttendance() {
    location.reload();
}

function exportAttendance() {
    const month = document.getElementById('month').value;
    
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengekspor...';
    button.disabled = true;
    
    // Simulate export
    setTimeout(() => {
        alert('Laporan absensi berhasil diekspor!');
        button.innerHTML = originalText;
        button.disabled = false;
    }, 2000);
}

// Auto-refresh every 10 minutes
setInterval(function() {
    location.reload();
}, 600000); // 10 minutes
</script>
@endsection
