@extends('student.layouts.app')

@section('title', 'Dashboard Siswa')
@section('description', 'Dashboard Portal Siswa SMP Negeri 01 Namrole')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-green-600 to-blue-600 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Selamat datang, {{ $student->full_name }}!</h1>
                <p class="text-white text-opacity-90 mt-1">{{ $student->class->name ?? 'Kelas' }} • {{ $student->academicYear->year ?? 'Tahun Ajaran' }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <img class="h-16 w-16 rounded-full border-2 border-white" src="{{ $student->profile_picture_url }}" alt="{{ $student->full_name }}">
                <div class="text-right">
                    <p class="text-sm text-white text-opacity-75">Status</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Aktif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Kehadiran Bulan Ini -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Kehadiran Bulan Ini</p>
                    <div class="flex items-center mt-2">
                        <div class="relative w-16 h-16">
                            <svg class="w-16 h-16 transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-gray-200" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                <path class="text-green-500" stroke="currentColor" stroke-width="3" stroke-dasharray="{{ $stats['attendance']['percentage'] }}, 100" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-sm font-bold text-gray-900">{{ $stats['attendance']['percentage'] }}%</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="flex space-x-4 text-xs">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-1"></div>
                                    <span>Hadir: {{ $stats['attendance']['present'] }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-red-500 rounded-full mr-1"></div>
                                    <span>Alpha: {{ $stats['attendance']['absent'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" class="text-sm text-primary-student hover:text-primary-light mt-2 inline-block">Lihat Detail</a>
        </div>

        <!-- Nilai Rata-rata -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Nilai Rata-rata</p>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['grades']['average'] }}</div>
                        <div class="text-sm text-gray-500">Kelas: {{ $stats['grades']['class_average'] }}</div>
                    </div>
                    <div class="mt-3 space-y-1">
                        @foreach($stats['grades']['subjects'] as $subject)
                        <div class="flex justify-between text-xs">
                            <span>{{ $subject['name'] }}</span>
                            <span class="font-medium">{{ $subject['grade'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <a href="#" class="text-sm text-primary-student hover:text-primary-light mt-2 inline-block">Lihat Rapor</a>
        </div>

        <!-- Tugas Pending -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tugas Pending</p>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['tasks']['pending'] }}</div>
                        @if($stats['tasks']['urgent'] > 0)
                        <div class="text-sm text-red-600 font-medium">{{ $stats['tasks']['urgent'] }} urgent</div>
                        @endif
                    </div>
                    <div class="mt-3 space-y-1">
                        @foreach($stats['tasks']['recent'] as $task)
                        <div class="flex justify-between text-xs">
                            <span class="truncate">{{ $task['title'] }}</span>
                            <span class="text-gray-500">{{ \Carbon\Carbon::parse($task['deadline'])->format('d/m') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <a href="#" class="text-sm text-green-600 hover:text-green-500 mt-2 inline-block">Lihat Semua Tugas</a>
        </div>

        <!-- Materi Baru -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Materi Baru</p>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['materials']['new'] }}</div>
                    </div>
                    <div class="mt-3 space-y-1">
                        @foreach($stats['materials']['recent'] as $material)
                        <div class="flex justify-between text-xs">
                            <span class="truncate">{{ $material['title'] }}</span>
                            <span class="text-gray-500">{{ $material['subject'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <a href="#" class="text-sm text-green-600 hover:text-green-500 mt-2 inline-block">Lihat Semua Materi</a>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Jadwal Hari Ini</h2>
                <a href="#" class="text-sm text-green-600 hover:text-green-500">Lihat Jadwal Lengkap</a>
            </div>
        </div>
        <div class="p-6">
            @if(count($todaySchedule) > 0)
            <div class="space-y-4">
                @foreach($todaySchedule as $schedule)
                <div class="flex items-center space-x-4 p-4 rounded-lg border {{ $schedule->status === 'current' ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $schedule->status === 'current' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600' }}">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $schedule->subject }}</p>
                                <p class="text-sm text-gray-500">{{ $schedule->teacher }} • {{ $schedule->room }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">{{ $schedule->time }}</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $schedule->status === 'current' ? 'bg-green-500 text-white' : 
                                       ($schedule->status === 'completed' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($schedule->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada jadwal</h3>
                <p class="mt-1 text-sm text-gray-500">Tidak ada jadwal pelajaran hari ini.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Pengumuman & Notifikasi -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center space-x-4">
                <button class="px-3 py-2 text-sm font-medium text-primary-student border-b-2 border-primary-student">Pengumuman</button>
                <button class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Notifikasi</button>
            </div>
        </div>
        <div class="p-6">
            @if(count($announcements) > 0)
            <div class="space-y-4">
                @foreach($announcements as $announcement)
                <div class="flex items-start space-x-3 p-4 rounded-lg border border-gray-200 hover:bg-gray-50">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900">{{ $announcement->title }}</h3>
                            <span class="text-xs text-gray-500">{{ $announcement->published_at->diffForHumans() }}</span>
                        </div>
                        <p class="mt-1 text-sm text-gray-600">{{ $announcement->excerpt }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengumuman</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada pengumuman terbaru.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Tugas & Deadline Terdekat -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Tugas & Deadline Terdekat</h2>
                <a href="#" class="text-sm text-green-600 hover:text-green-500">Lihat Semua</a>
            </div>
        </div>
        <div class="p-6">
            @if(count($pendingTasks) > 0)
            <div class="space-y-4">
                @foreach($pendingTasks as $task)
                <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:bg-gray-50">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 3 3 0 00-3-3h-1.5a.75.75 0 00-.75.75v.75m-6 0V6a3 3 0 013-3h1.5a.75.75 0 01.75.75v.75m-6 0h3m-3 0a3 3 0 00-3 3v1.5a3 3 0 003 3h3a3 3 0 003-3v-1.5a3 3 0 00-3-3h-3z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">{{ $task->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $task->subject }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</p>
                        </div>
                        @if($task->urgent)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Urgent
                        </span>
                        @endif
                        <button class="text-sm text-green-600 hover:text-green-500">Kerjakan</button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 3 3 0 00-3-3h-1.5a.75.75 0 00-.75.75v.75m-6 0V6a3 3 0 013-3h1.5a.75.75 0 01.75.75v.75m-6 0h3m-3 0a3 3 0 00-3 3v1.5a3 3 0 003 3h3a3 3 0 003-3v-1.5a3 3 0 00-3-3h-3z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada tugas</h3>
                <p class="mt-1 text-sm text-gray-500">Tidak ada tugas yang perlu dikerjakan.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Aktivitas Terkini -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Aktivitas Terkini</h2>
                <a href="#" class="text-sm text-green-600 hover:text-green-500">Lihat Semua</a>
            </div>
        </div>
        <div class="p-6">
            @if(count($recentActivities) > 0)
            <div class="space-y-4">
                @foreach($recentActivities as $activity)
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center
                            {{ $activity->type === 'material' ? 'bg-blue-100' : 
                               ($activity->type === 'grade' ? 'bg-green-100' : 
                               ($activity->type === 'task' ? 'bg-orange-100' : 'bg-purple-100')) }}">
                            <svg class="w-4 h-4 {{ $activity->type === 'material' ? 'text-blue-600' : 
                                                   ($activity->type === 'grade' ? 'text-green-600' : 
                                                   ($activity->type === 'task' ? 'text-orange-600' : 'text-purple-600')) }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                @if($activity->type === 'material')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                @elseif($activity->type === 'grade')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @elseif($activity->type === 'task')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 3 3 0 00-3-3h-1.5a.75.75 0 00-.75.75v.75m-6 0V6a3 3 0 013-3h1.5a.75.75 0 01.75.75v.75m-6 0h3m-3 0a3 3 0 00-3 3v1.5a3 3 0 003 3h3a3 3 0 003-3v-1.5a3 3 0 00-3-3h-3z" />
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                @endif
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-medium text-gray-900">{{ $activity->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $activity->description }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $activity->time }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada aktivitas</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada aktivitas terbaru.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-refresh dashboard data every 30 seconds
setInterval(function() {
    fetch('/siswa/dashboard/stats')
        .then(response => response.json())
        .then(data => {
            // Update stats if needed
            console.log('Dashboard stats updated');
        })
        .catch(error => {
            console.error('Error updating dashboard:', error);
        });
}, 30000);

// Real-time notifications
if ('Notification' in window) {
    if (Notification.permission === 'granted') {
        // Show notification for new activities
        fetch('/siswa/dashboard/activities')
            .then(response => response.json())
            .then(data => {
                // Check for new activities and show notifications
            });
    }
}
</script>
@endpush
