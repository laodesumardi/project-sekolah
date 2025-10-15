@extends('admin.layouts.app')

@section('page-title', 'Dashboard Analytics')

@section('content')
@include('components.dashboard-updater')
<div class="p-3 sm:p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-4 sm:mb-6 lg:mb-8">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-1 sm:mb-2">Dashboard Analytics</h1>
        <p class="text-sm sm:text-base text-gray-600">Ringkasan data dan statistik sekolah</p>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
            <!-- Total Siswa -->
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-lg sm:text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Siswa</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900" data-stat="students">{{ number_format($stats['total_students']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Guru -->
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-green-600 text-lg sm:text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Guru</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900" data-stat="teachers">{{ number_format($stats['total_teachers']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Berita -->
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-newspaper text-purple-600 text-lg sm:text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Berita</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ number_format($stats['total_news']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Fasilitas -->
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-orange-600 text-lg sm:text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Fasilitas</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ number_format($stats['total_facilities']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Galeri -->
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-images text-pink-600 text-lg sm:text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Galeri</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ number_format($stats['total_galleries']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Prestasi -->
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-trophy text-yellow-600 text-lg sm:text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Prestasi</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ number_format($stats['total_achievements']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Berita Bulan Ini</p>
                        <p class="text-lg sm:text-2xl font-bold text-blue-600">{{ $monthlyNews }}</p>
                    </div>
                    <i class="fas fa-newspaper text-blue-500 text-xl sm:text-2xl flex-shrink-0 ml-2"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Fasilitas Bulan Ini</p>
                        <p class="text-lg sm:text-2xl font-bold text-orange-600">{{ $monthlyFacilities }}</p>
                    </div>
                    <i class="fas fa-building text-orange-500 text-xl sm:text-2xl flex-shrink-0 ml-2"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Galeri Bulan Ini</p>
                        <p class="text-lg sm:text-2xl font-bold text-pink-600">{{ $monthlyGalleries }}</p>
                    </div>
                    <i class="fas fa-images text-pink-500 text-xl sm:text-2xl flex-shrink-0 ml-2"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Prestasi Bulan Ini</p>
                        <p class="text-lg sm:text-2xl font-bold text-yellow-600">{{ $monthlyAchievements }}</p>
                    </div>
                    <i class="fas fa-trophy text-yellow-500 text-xl sm:text-2xl flex-shrink-0 ml-2"></i>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8 mb-6 sm:mb-8">
            <!-- Monthly Trends Chart -->
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Trend Bulanan</h3>
                    <div class="flex space-x-2">
                        <button class="px-2 sm:px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">12 Bulan</button>
                    </div>
                </div>
                <div class="h-48 sm:h-64">
                    <canvas id="monthlyTrendsChart"></canvas>
                </div>
            </div>

            <!-- Achievement Levels Chart -->
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Level Prestasi</h3>
                </div>
                <div class="h-48 sm:h-64">
                    <canvas id="achievementLevelsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Achievement Categories Chart -->
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border mb-6 sm:mb-8">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Kategori Prestasi</h3>
            </div>
            <div class="h-48 sm:h-64">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
            <!-- Recent News -->
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Berita Terbaru</h3>
                    <a href="{{ route('admin.news.index') }}" class="text-xs sm:text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
                </div>
                <div class="space-y-3 sm:space-y-4">
                    @forelse($recentActivities->where('type', 'news') as $activity)
                    <div class="flex items-start space-x-2 sm:space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-newspaper text-blue-600 text-xs sm:text-sm"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs sm:text-sm text-gray-500">Tidak ada berita terbaru</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Achievements -->
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Prestasi Terbaru</h3>
                    <a href="{{ route('admin.achievements.index') }}" class="text-xs sm:text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
                </div>
                <div class="space-y-3 sm:space-y-4">
                    @forelse($recentActivities->where('type', 'achievement') as $activity)
                    <div class="flex items-start space-x-2 sm:space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-trophy text-yellow-600 text-xs sm:text-sm"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs sm:text-sm text-gray-500">Tidak ada prestasi terbaru</p>
                    @endforelse
                </div>
            </div>
        </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Trends Chart
const monthlyCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: @json($monthlyData['months']),
        datasets: [
            {
                label: 'Berita',
                data: @json($monthlyData['news']),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4
            },
            {
                label: 'Fasilitas',
                data: @json($monthlyData['facilities']),
                borderColor: 'rgb(249, 115, 22)',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                tension: 0.4
            },
            {
                label: 'Galeri',
                data: @json($monthlyData['galleries']),
                borderColor: 'rgb(236, 72, 153)',
                backgroundColor: 'rgba(236, 72, 153, 0.1)',
                tension: 0.4
            },
            {
                label: 'Prestasi',
                data: @json($monthlyData['achievements']),
                borderColor: 'rgb(234, 179, 8)',
                backgroundColor: 'rgba(234, 179, 8, 0.1)',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Achievement Levels Chart
const levelsCtx = document.getElementById('achievementLevelsChart').getContext('2d');
new Chart(levelsCtx, {
    type: 'doughnut',
    data: {
        labels: ['Sekolah', 'Kecamatan', 'Kota', 'Provinsi', 'Nasional', 'Internasional'],
        datasets: [{
            data: [
                @json($achievementLevels['sekolah']),
                @json($achievementLevels['kecamatan']),
                @json($achievementLevels['kota']),
                @json($achievementLevels['provinsi']),
                @json($achievementLevels['nasional']),
                @json($achievementLevels['internasional'])
            ],
            backgroundColor: [
                '#3B82F6',
                '#10B981',
                '#F59E0B',
                '#EF4444',
                '#8B5CF6',
                '#EC4899'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});

// Category Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
    type: 'bar',
    data: {
        labels: ['Akademik', 'Olahraga', 'Seni', 'Teknologi', 'Keagamaan', 'Lomba', 'Kompetisi', 'Olimpiade', 'Lainnya'],
        datasets: [{
            label: 'Jumlah Prestasi',
            data: [
                @json($categoryData['akademik']),
                @json($categoryData['olahraga']),
                @json($categoryData['seni']),
                @json($categoryData['teknologi']),
                @json($categoryData['keagamaan']),
                @json($categoryData['lomba']),
                @json($categoryData['kompetisi']),
                @json($categoryData['olimpiade']),
                @json($categoryData['lainnya'])
            ],
            backgroundColor: 'rgba(59, 130, 246, 0.8)',
            borderColor: 'rgb(59, 130, 246)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush
@endsection
