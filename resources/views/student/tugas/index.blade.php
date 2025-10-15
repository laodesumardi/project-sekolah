@extends('student.layouts.app')

@section('title', 'Tugas & Ujian')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Tugas & Ujian
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Kelola tugas dan ujian Anda
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <button type="button" onclick="refreshAssignments()"
                    class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
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
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Tugas</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['total_assignments'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['completed'] }}</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Menunggu</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['pending'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Terlambat</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['overdue'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Overview -->
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Rata-rata Skor</h3>
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600">{{ $stats['average_score'] }}</div>
                <div class="text-sm text-gray-500">dari 100</div>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tingkat Penyelesaian</h3>
            <div class="text-center">
                <div class="text-4xl font-bold text-green-600">{{ $stats['completion_rate'] }}%</div>
                <div class="text-sm text-gray-500">Tugas selesai</div>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Total Poin</h3>
            <div class="text-center">
                <div class="text-4xl font-bold text-purple-600">{{ $stats['earned_points'] }}</div>
                <div class="text-sm text-gray-500">dari {{ $stats['total_points'] }} poin</div>
            </div>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-0">
                <label for="search" class="block text-sm font-medium text-gray-700">Cari Tugas</label>
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
                <label for="type" class="block text-sm font-medium text-gray-700">Tipe</label>
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
                    Aktivitas tugas dan ujian terbaru
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-3">
                    @foreach($recentActivities as $activity)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                    {{ $activity->type === 'submission' ? 'bg-green-100' : 
                                       ($activity->type === 'assignment' ? 'bg-blue-100' : 'bg-yellow-100') }}">
                                    @if($activity->type === 'submission')
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @elseif($activity->type === 'assignment')
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
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
                                <p class="text-xs text-gray-400">{{ $activity->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @if($activity->score)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $activity->score }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Upcoming Deadlines -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Batas Waktu Mendatang</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Tugas dan ujian yang akan segera berakhir
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-3">
                    @foreach($upcomingDeadlines as $deadline)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $deadline->title }}</p>
                                <p class="text-sm text-gray-500">{{ $deadline->subject }} • {{ $deadline->points }} poin</p>
                                <p class="text-xs text-gray-400">{{ $deadline->due_date->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            {{ $deadline->due_date->diffForHumans() }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Performance Analytics -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Analisis Performa</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Performa berdasarkan mata pelajaran
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-3">
                    @foreach($analytics['subject_performance'] as $subject => $score)
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">{{ $subject }}</span>
                        <div class="flex items-center">
                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $score }}%"></div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $score }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Assignments List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Tugas & Ujian</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ $assignments->count() }} tugas dan ujian ditemukan
            </p>
        </div>
        <ul class="divide-y divide-gray-200">
            @forelse($assignments as $assignment)
            <li>
                <div class="px-4 py-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center
                                    {{ $assignment->type === 'assignment' ? 'bg-blue-100' : 
                                       ($assignment->type === 'exam' ? 'bg-red-100' : 'bg-green-100') }}">
                                    @if($assignment->type === 'assignment')
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    @elseif($assignment->type === 'exam')
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    @else
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $assignment->title }}</div>
                                <div class="text-sm text-gray-500">{{ $assignment->subject }} • {{ $assignment->teacher }} • {{ $assignment->class }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $assignment->points }} poin • {{ $assignment->difficulty }} • 
                                    @if($assignment->due_date > now())
                                        Berakhir {{ $assignment->due_date->diffForHumans() }}
                                    @else
                                        Terlambat {{ $assignment->due_date->diffForHumans() }}
                                    @endif
                                </div>
                                <div class="flex items-center mt-1">
                                    @if($assignment->is_submitted)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mr-2">
                                        Dikumpulkan
                                    </span>
                                    @if($assignment->score)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        Skor: {{ $assignment->score }}
                                    </span>
                                    @endif
                                    @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Belum Dikumpulkan
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $assignment->status === 'open' ? 'bg-green-100 text-green-800' : 
                                   ($assignment->status === 'closed' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst($assignment->status) }}
                            </span>
                            <a href="{{ route('student.tugas.show', $assignment->id) }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Lihat
                            </a>
                            @if($assignment->is_submitted && $assignment->score)
                            <a href="{{ route('student.tugas.results', $assignment->id) }}" 
                               class="text-green-600 hover:text-green-900 text-sm font-medium">
                                Hasil
                            </a>
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
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada tugas atau ujian</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada tugas atau ujian yang tersedia.</p>
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
    
    window.location.href = '{{ route("student.tugas.index") }}?' + params.toString();
}

function refreshAssignments() {
    location.reload();
}

// Auto-refresh every 10 minutes
setInterval(function() {
    location.reload();
}, 600000); // 10 minutes
</script>
@endsection







