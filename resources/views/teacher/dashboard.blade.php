@extends('teacher.layouts.app')

@section('title', 'Dashboard Guru')
@section('subtitle', 'Selamat datang di dashboard guru')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Selamat datang, {{ $teacher->full_name }}!</h2>
                <p class="text-blue-100 mt-1">Hari ini adalah {{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-chalkboard-teacher text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-tasks text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Tugas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_assignments'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-book text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Materi Pembelajaran</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_materials'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-users text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kelas yang Diampu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_classes'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Mata Pelajaran</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_subjects'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Today's Schedule -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Jadwal Hari Ini</h3>
                </div>
                <div class="p-6">
                    @if($todaySchedule->count() > 0)
                        <div class="space-y-4">
                            @foreach($todaySchedule as $schedule)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-clock text-blue-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="font-medium text-gray-900">{{ $schedule->subject->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $schedule->class->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">{{ $schedule->time_range }}</p>
                                        <p class="text-xs text-gray-600">{{ $schedule->room ?? 'Ruangan belum ditentukan' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600">Tidak ada jadwal untuk hari ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Aksi Cepat</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('teacher.assignments.create') }}" 
                       class="flex items-center w-full p-3 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus-circle text-blue-600 w-5 h-5 mr-3"></i>
                        <span class="font-medium">Buat Tugas Baru</span>
                    </a>
                    <a href="{{ route('teacher.learning-materials.create') }}" 
                       class="flex items-center w-full p-3 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-book text-green-600 w-5 h-5 mr-3"></i>
                        <span class="font-medium">Upload Materi</span>
                    </a>
                    <a href="{{ route('teacher.attendance.create') }}" 
                       class="flex items-center w-full p-3 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-calendar-check text-yellow-600 w-5 h-5 mr-3"></i>
                        <span class="font-medium">Input Absensi</span>
                    </a>
                    <a href="{{ route('teacher.grades.create') }}" 
                       class="flex items-center w-full p-3 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <i class="fas fa-chart-line text-purple-600 w-5 h-5 mr-3"></i>
                        <span class="font-medium">Input Nilai</span>
                    </a>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                </div>
                <div class="p-6">
                    @if($recentActivities->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentActivities as $activity)
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-{{ $activity->activity_type === 'teaching' ? 'chalkboard-teacher' : 'calendar' }} text-blue-600 text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $activity->title }}</p>
                                        <p class="text-xs text-gray-600">{{ $activity->date->format('d M Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 text-sm">Belum ada aktivitas</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Tasks -->
    @if($pendingAssignments->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Tugas yang Perlu Perhatian</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($pendingAssignments as $assignment)
                        <div class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-medium text-gray-900">{{ $assignment->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $assignment->class->name }} - {{ $assignment->subject->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">Batas Waktu</p>
                                <p class="text-xs text-gray-600">{{ $assignment->due_date->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
