@extends('student.layouts.app')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Jadwal Pelajaran
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Jadwal pelajaran kelas {{ $studentClass->name ?? 'Anda' }} • {{ now()->format('d F Y') }}
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            <button type="button" 
                    onclick="exportSchedule('pdf')"
                    class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                PDF
            </button>
            <button type="button" 
                    onclick="exportSchedule('excel')"
                    class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Excel
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-0">
                <label for="day-filter" class="block text-sm font-medium text-gray-700">Filter Hari</label>
                <select id="day-filter" name="day" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    <option value="">Semua Hari</option>
                    @foreach($filterOptions['days'] as $day)
                    <option value="{{ $day }}" {{ $selectedDay == $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-0">
                <label for="subject-filter" class="block text-sm font-medium text-gray-700">Filter Mata Pelajaran</label>
                <select id="subject-filter" name="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($filterOptions['subjects'] as $subject)
                    <option value="{{ $subject }}" {{ $selectedSubject == $subject ? 'selected' : '' }}>{{ $subject }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-0">
                <label for="teacher-filter" class="block text-sm font-medium text-gray-700">Filter Guru</label>
                <select id="teacher-filter" name="teacher" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    <option value="">Semua Guru</option>
                    @foreach($filterOptions['teachers'] as $teacher)
                    <option value="{{ $teacher }}" {{ $selectedTeacher == $teacher ? 'selected' : '' }}>{{ $teacher }}</option>
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

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Mata Pelajaran</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_subjects'] }}</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Jam Pelajaran</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_hours'] }}</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Hari Aktif</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['days_with_class'] }}</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Hari Ini</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ count($todaySchedule) }} Pelajaran</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Time Info -->
    @if($currentTime['current_class'])
    <div class="bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-medium text-green-900">Sedang Berlangsung</h3>
                <p class="text-sm text-green-700">{{ $currentTime['current_class']['subject'] }} • {{ $currentTime['current_class']['teacher'] }}</p>
                <p class="text-xs text-green-600">{{ $currentTime['current_class']['time'] }} • {{ $currentTime['current_class']['room'] }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-green-900">{{ $currentTime['current_time'] }}</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Sedang Berlangsung
                </span>
            </div>
        </div>
    </div>
    @elseif($currentTime['next_class'])
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-medium text-blue-900">Kelas Berikutnya</h3>
                <p class="text-sm text-blue-700">{{ $currentTime['next_class']['subject'] }} • {{ $currentTime['next_class']['teacher'] }}</p>
                <p class="text-xs text-blue-600">{{ $currentTime['next_class']['time'] }} • {{ $currentTime['next_class']['room'] }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-blue-900">{{ $currentTime['current_time'] }}</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Akan Datang
                </span>
            </div>
        </div>
    </div>
    @endif

    <!-- Today's Schedule -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Jadwal Hari Ini</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ now()->locale('id')->dayName }}, {{ now()->format('d F Y') }}
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            @if(count($todaySchedule) > 0)
            <div class="space-y-3">
                @foreach($todaySchedule as $index => $lesson)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg {{ $index === 0 ? 'ring-2 ring-green-500 bg-green-50' : '' }}">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $lesson['subject'] }}</p>
                            <p class="text-sm text-gray-500">{{ $lesson['teacher'] }} • {{ $lesson['room'] }}</p>
                            <p class="text-xs text-gray-400">{{ $lesson['time'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($index === 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Sedang Berlangsung
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $lesson['type'] }}
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada jadwal</h3>
                <p class="mt-1 text-sm text-gray-500">Tidak ada jadwal pelajaran untuk hari ini.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Weekly Schedule -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Jadwal Mingguan</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Jadwal pelajaran untuk minggu ini
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="space-y-6">
                @foreach($schedule as $day => $daySchedule)
                <div>
                    <h4 class="text-md font-medium text-gray-900 mb-3">{{ $day }}</h4>
                    @if(count($daySchedule) > 0)
                    <div class="space-y-2">
                        @foreach($daySchedule as $lesson)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $lesson['subject'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $lesson['teacher'] }} • {{ $lesson['room'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500">{{ $lesson['time'] }}</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $lesson['type'] }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <p class="text-sm text-gray-500">Tidak ada jadwal untuk {{ $day }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Upcoming Classes -->
    @if(count($upcomingClasses) > 0)
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Jadwal Mendatang</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Jadwal pelajaran untuk 3 hari ke depan
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="space-y-4">
                @foreach($upcomingClasses as $upcoming)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-md font-medium text-gray-900">{{ $upcoming['day'] }}, {{ $upcoming['date']->format('d F Y') }}</h4>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $upcoming['count'] }} Pelajaran
                        </span>
                    </div>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($upcoming['schedule'] as $lesson)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $lesson['subject'] }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $lesson['teacher'] }}</p>
                                <p class="text-xs text-gray-400">{{ $lesson['time'] }}</p>
                            </div>
                        </div>
                        @endforeach
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
                <button onclick="refreshSchedule()" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Refresh Jadwal</p>
                        <p class="text-sm text-gray-500">Update jadwal terbaru</p>
                    </div>
                </button>

                <button onclick="shareSchedule()" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Bagikan Jadwal</p>
                        <p class="text-sm text-gray-500">Kirim ke teman</p>
                    </div>
                </button>

                <button onclick="setReminder()" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586-2.586a2 2 0 012.828 0L16 8.172a2 2 0 010 2.828l-2.586 2.586a2 2 0 01-2.828 0L4.828 7z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Set Reminder</p>
                        <p class="text-sm text-gray-500">Pengingat jadwal</p>
                    </div>
                </button>

                <button onclick="viewCalendar()" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Lihat Kalender</p>
                        <p class="text-sm text-gray-500">Tampilan kalender</p>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function applyFilters() {
    const day = document.getElementById('day-filter').value;
    const subject = document.getElementById('subject-filter').value;
    const teacher = document.getElementById('teacher-filter').value;
    
    const params = new URLSearchParams();
    if (day) params.append('day', day);
    if (subject) params.append('subject', subject);
    if (teacher) params.append('teacher', teacher);
    
    window.location.href = '{{ route("student.jadwal.index") }}?' + params.toString();
}

function exportSchedule(format) {
    if (format === 'pdf') {
        window.open('{{ route("student.jadwal.export.pdf") }}', '_blank');
    } else if (format === 'excel') {
        window.open('{{ route("student.jadwal.export.excel") }}', '_blank');
    }
}

function refreshSchedule() {
    location.reload();
}

function shareSchedule() {
    if (navigator.share) {
        navigator.share({
            title: 'Jadwal Pelajaran',
            text: 'Lihat jadwal pelajaran saya',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link jadwal telah disalin ke clipboard!');
        });
    }
}

function setReminder() {
    alert('Fitur reminder akan segera tersedia!');
}

function viewCalendar() {
    alert('Fitur kalender akan segera tersedia!');
}

// Auto-refresh every 5 minutes
setInterval(function() {
    // Only refresh if no filters are applied
    if (!document.getElementById('day-filter').value && 
        !document.getElementById('subject-filter').value && 
        !document.getElementById('teacher-filter').value) {
        location.reload();
    }
}, 300000); // 5 minutes
</script>
@endsection
