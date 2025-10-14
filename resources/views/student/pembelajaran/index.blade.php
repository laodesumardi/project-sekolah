@extends('student.layouts.app')

@section('title', 'Pembelajaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Pembelajaran
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Akses konten pembelajaran interaktif dan tingkatkan kemampuan Anda
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            <button type="button" 
                    onclick="refreshLearning()"
                    class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
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
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Konten</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_content'] }}</dd>
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Selesai Hari Ini</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['completed_today'] }}</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Sedang Dikerjakan</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['in_progress'] }}</dd>
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Rata-rata Skor</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['average_score'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Learning Progress -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Progress Pembelajaran</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Kemajuan pembelajaran Anda secara keseluruhan
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $progress['overall_progress'] }}%</div>
                    <div class="text-sm text-gray-500">Progress Keseluruhan</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $progress['weekly_completed'] }}/{{ $progress['weekly_goal'] }}</div>
                    <div class="text-sm text-gray-500">Target Mingguan</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $progress['monthly_completed'] }}/{{ $progress['monthly_goal'] }}</div>
                    <div class="text-sm text-gray-500">Target Bulanan</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['streak_days'] }}</div>
                    <div class="text-sm text-gray-500">Hari Berturut-turut</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-0">
                <label for="search" class="block text-sm font-medium text-gray-700">Cari Konten</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ $search }}"
                       placeholder="Cari berdasarkan judul atau deskripsi..."
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
                <label for="type" class="block text-sm font-medium text-gray-700">Tipe Pembelajaran</label>
                <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Semua Tipe</option>
                    @foreach($filterOptions['types'] as $typeKey => $typeLabel)
                    <option value="{{ $typeKey }}" {{ $type === $typeKey ? 'selected' : '' }}>{{ $typeLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-0">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Semua Status</option>
                    @foreach($filterOptions['statuses'] as $statusKey => $statusLabel)
                    <option value="{{ $statusKey }}" {{ $status === $statusKey ? 'selected' : '' }}>{{ $statusLabel }}</option>
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
                    Aktivitas pembelajaran terbaru Anda
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-3">
                    @foreach($recentActivities as $activity)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                    {{ $activity->type === 'completed' ? 'bg-green-100' : 
                                       ($activity->type === 'started' ? 'bg-blue-100' : 'bg-yellow-100') }}">
                                    @if($activity->type === 'completed')
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @elseif($activity->type === 'started')
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @else
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $activity->title }}</p>
                                <p class="text-sm text-gray-500">{{ $activity->subject }}</p>
                                @if($activity->score)
                                <p class="text-xs text-gray-400">Skor: {{ $activity->score }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $activity->type === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($activity->type === 'started' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $activity->type)) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Upcoming Lessons -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Pembelajaran Mendatang</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Jadwal pembelajaran yang akan datang
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-3">
                    @foreach($upcomingLessons as $lesson)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $lesson->title }}</p>
                                <p class="text-sm text-gray-500">{{ $lesson->subject }} • {{ $lesson->teacher }}</p>
                                <p class="text-xs text-gray-400">{{ $lesson->scheduled_date->format('d M Y') }} • {{ $lesson->duration }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            Akan Datang
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Rekomendasi</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Konten pembelajaran yang direkomendasikan untuk Anda
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-3">
                    @foreach($recommendations as $recommendation)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $recommendation->title }}</p>
                                <p class="text-sm text-gray-500">{{ $recommendation->subject }}</p>
                                <p class="text-xs text-gray-400">{{ $recommendation->reason }}</p>
                            </div>
                        </div>
                        <button onclick="viewContent({{ $recommendation->id ?? 0 }})" 
                                class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                            Mulai
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Learning Content -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Konten Pembelajaran</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ $learningContent->count() }} konten pembelajaran ditemukan
            </p>
        </div>
        <ul class="divide-y divide-gray-200">
            @forelse($learningContent as $content)
            <li>
                <div class="px-4 py-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center
                                    {{ $content->type === 'interactive' ? 'bg-blue-100' : 
                                       ($content->type === 'experiment' ? 'bg-green-100' : 
                                       ($content->type === 'presentation' ? 'bg-orange-100' : 
                                       ($content->type === 'practice' ? 'bg-purple-100' : 
                                       ($content->type === 'coding' ? 'bg-indigo-100' : 'bg-gray-100')))) }}">
                                    @if($content->type === 'interactive')
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    @elseif($content->type === 'experiment')
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                    @elseif($content->type === 'presentation')
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v14a1 1 0 01-1 1H3a1 1 0 01-1-1V5a1 1 0 011-1h4zM9 6h6v2H9V6z" />
                                    </svg>
                                    @elseif($content->type === 'practice')
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    @elseif($content->type === 'coding')
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                    @else
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $content->title }}</div>
                                <div class="text-sm text-gray-500">{{ $content->subject }} • {{ $content->teacher }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $content->duration }} • {{ $content->students_count }} siswa • Rating: {{ $content->rating }}
                                </div>
                                <div class="flex items-center mt-1">
                                    @foreach($content->tags as $tag)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-1">
                                        {{ $tag }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $content->difficulty === 'easy' ? 'bg-green-100 text-green-800' : 
                                   ($content->difficulty === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($content->difficulty) }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $content->status === 'available' ? 'bg-blue-100 text-blue-800' : 
                                   ($content->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($content->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst(str_replace('_', ' ', $content->status)) }}
                            </span>
                            @if($content->status === 'available')
                            <button onclick="startLearning({{ $content->id }})" 
                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Mulai
                            </button>
                            @elseif($content->status === 'in_progress')
                            <button onclick="continueLearning({{ $content->id }})" 
                                    class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">
                                Lanjutkan
                            </button>
                            @else
                            <button onclick="viewContent({{ $content->id }})" 
                                    class="text-green-600 hover:text-green-900 text-sm font-medium">
                                Lihat
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
            @empty
            <li>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada konten pembelajaran</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada konten pembelajaran yang tersedia.</p>
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
    const type = document.getElementById('type').value;
    const status = document.getElementById('status').value;
    
    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (subject) params.append('subject', subject);
    if (type) params.append('type', type);
    if (status) params.append('status', status);
    
    window.location.href = '{{ route("student.pembelajaran.index") }}?' + params.toString();
}

function refreshLearning() {
    location.reload();
}

function startLearning(contentId) {
    fetch('{{ route("student.pembelajaran.index") }}/' + contentId + '/start', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            window.location.href = '{{ route("student.pembelajaran.index") }}/' + contentId;
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function continueLearning(contentId) {
    window.location.href = '{{ route("student.pembelajaran.index") }}/' + contentId;
}

function viewContent(contentId) {
    window.location.href = '{{ route("student.pembelajaran.index") }}/' + contentId;
}

// Auto-refresh every 15 minutes
setInterval(function() {
    location.reload();
}, 900000); // 15 minutes
</script>
@endsection
