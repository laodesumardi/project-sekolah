@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="p-4 lg:p-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-primary-500 to-secondary rounded-lg p-4 lg:p-6 mb-6 lg:mb-8">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <h2 class="text-xl lg:text-2xl font-bold text-white mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-primary-100 text-sm lg:text-base">Kelola website sekolah dengan mudah melalui admin panel ini.</p>
            </div>
            <div class="hidden lg:block">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
        <!-- Total Facilities -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-2 lg:p-3 bg-blue-100 rounded-full">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-3 lg:ml-4">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Total Fasilitas</p>
                    <p class="text-xl lg:text-2xl font-semibold text-gray-900">{{ \App\Models\Facility::count() }}</p>
                    <p class="text-xs text-gray-500">+{{ \App\Models\Facility::whereMonth('created_at', now()->month)->count() }} bulan ini</p>
                </div>
            </div>
        </div>

        <!-- Available Facilities -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-2 lg:p-3 bg-green-100 rounded-full">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 lg:ml-4">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Fasilitas Tersedia</p>
                    <p class="text-xl lg:text-2xl font-semibold text-gray-900">{{ \App\Models\Facility::where('is_available', true)->count() }}</p>
                    <p class="text-xs text-gray-500">{{ round((\App\Models\Facility::where('is_available', true)->count() / \App\Models\Facility::count()) * 100, 1) }}% dari total</p>
                </div>
            </div>
        </div>

        <!-- Total News -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-2 lg:p-3 bg-purple-100 rounded-full">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <div class="ml-3 lg:ml-4">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Total Berita</p>
                    <p class="text-xl lg:text-2xl font-semibold text-gray-900">{{ \App\Models\News::count() }}</p>
                    <p class="text-xs text-gray-500">+{{ \App\Models\News::whereMonth('created_at', now()->month)->count() }} bulan ini</p>
                </div>
            </div>
        </div>

        <!-- Published News -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-2 lg:p-3 bg-orange-100 rounded-full">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div class="ml-3 lg:ml-4">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Berita Terbit</p>
                    <p class="text-xl lg:text-2xl font-semibold text-gray-900">{{ \App\Models\News::whereNotNull('published_at')->count() }}</p>
                    <p class="text-xs text-gray-500">{{ round((\App\Models\News::whereNotNull('published_at')->count() / \App\Models\News::count()) * 100, 1) }}% dari total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-8 mb-6 lg:mb-8">
        <!-- Content Creation Chart -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base lg:text-lg font-semibold text-gray-900">Konten Bulanan</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-xs lg:text-sm text-gray-500">6 bulan terakhir</span>
                </div>
            </div>
            <div class="h-48 lg:h-64">
                <canvas id="contentChart"></canvas>
            </div>
        </div>

        <!-- Content Distribution -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base lg:text-lg font-semibold text-gray-900">Distribusi Konten</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-xs lg:text-sm text-gray-500">Total: {{ \App\Models\Facility::count() + \App\Models\News::count() + \App\Models\Gallery::count() }}</span>
                </div>
            </div>
            <div class="h-48 lg:h-64">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-8 mb-6 lg:mb-8">
        <!-- Recent Content -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-4">Konten Terbaru</h3>
            <div class="space-y-4">
                @php
                    $recentFacilities = \App\Models\Facility::latest()->take(3)->get();
                    $recentNews = \App\Models\News::latest()->take(3)->get();
                    $recentGalleries = \App\Models\Gallery::latest()->take(3)->get();
                @endphp
                
                @foreach($recentFacilities as $facility)
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="p-2 bg-blue-100 rounded-full">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $facility->name }}</p>
                        <p class="text-xs text-gray-500">Fasilitas • {{ $facility->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-xs text-gray-400">{{ $facility->created_at->format('d M') }}</span>
                </div>
                @endforeach

                @foreach($recentNews as $news)
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="p-2 bg-purple-100 rounded-full">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $news->title }}</p>
                        <p class="text-xs text-gray-500">Berita • {{ $news->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-xs text-gray-400">{{ $news->created_at->format('d M') }}</span>
                </div>
                @endforeach

                @foreach($recentGalleries as $gallery)
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="p-2 bg-green-100 rounded-full">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $gallery->title }}</p>
                        <p class="text-xs text-gray-500">Galeri • {{ $gallery->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-xs text-gray-400">{{ $gallery->created_at->format('d M') }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Monthly Summary -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-4">Ringkasan Bulan {{ now()->format('F Y') }}</h3>
            <div class="space-y-4">
                @php
                    $currentMonth = now()->month;
                    $currentYear = now()->year;
                    
                    $monthlyFacilities = \App\Models\Facility::whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)->count();
                    $monthlyNews = \App\Models\News::whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)->count();
                    $monthlyGalleries = \App\Models\Gallery::whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)->count();
                @endphp
                
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 rounded-full">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Fasilitas Baru</p>
                            <p class="text-xs text-gray-500">Ditambahkan bulan ini</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-blue-600">{{ $monthlyFacilities }}</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-purple-100 rounded-full">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Berita Baru</p>
                            <p class="text-xs text-gray-500">Dipublikasikan bulan ini</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-purple-600">{{ $monthlyNews }}</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-100 rounded-full">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Galeri Baru</p>
                            <p class="text-xs text-gray-500">Ditambahkan bulan ini</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-green-600">{{ $monthlyGalleries }}</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-orange-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-orange-100 rounded-full">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Total Konten</p>
                            <p class="text-xs text-gray-500">Bulan ini</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-orange-600">{{ $monthlyFacilities + $monthlyNews + $monthlyGalleries }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.facilities.create') }}" 
                   class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="text-blue-800 font-medium">Tambah Fasilitas Baru</span>
                </a>
                
                <a href="{{ route('admin.facilities.index') }}" 
                   class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-purple-800 font-medium">Kelola Fasilitas</span>
                </a>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                @php
                    $recentActivities = collect();
                    
                    // Add recent facilities
                    $recentFacilities = \App\Models\Facility::latest()->take(2)->get();
                    foreach($recentFacilities as $facility) {
                        $recentActivities->push([
                            'type' => 'facility',
                            'title' => 'Fasilitas baru ditambahkan',
                            'description' => $facility->name,
                            'time' => $facility->created_at,
                            'color' => 'green'
                        ]);
                    }
                    
                    // Add recent news
                    $recentNews = \App\Models\News::latest()->take(2)->get();
                    foreach($recentNews as $news) {
                        $recentActivities->push([
                            'type' => 'news',
                            'title' => 'Berita dipublikasikan',
                            'description' => $news->title,
                            'time' => $news->created_at,
                            'color' => 'blue'
                        ]);
                    }
                    
                    // Add recent galleries
                    $recentGalleries = \App\Models\Gallery::latest()->take(2)->get();
                    foreach($recentGalleries as $gallery) {
                        $recentActivities->push([
                            'type' => 'gallery',
                            'title' => 'Galeri diperbarui',
                            'description' => $gallery->title,
                            'time' => $gallery->created_at,
                            'color' => 'purple'
                        ]);
                    }
                    
                    $recentActivities = $recentActivities->sortByDesc('time')->take(5);
                @endphp
                
                @foreach($recentActivities as $activity)
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="w-2 h-2 bg-{{ $activity['color'] }}-500 rounded-full mr-3"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">{{ $activity['title'] }}</p>
                        <p class="text-xs text-gray-500">{{ Str::limit($activity['description'], 50) }}</p>
                    </div>
                    <span class="text-xs text-gray-400">{{ $activity['time']->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Content Creation Chart
    const contentCtx = document.getElementById('contentChart').getContext('2d');
    const contentChart = new Chart(contentCtx, {
        type: 'line',
        data: {
            labels: [
                @for($i = 5; $i >= 0; $i--)
                    '{{ now()->subMonths($i)->format('M Y') }}'{{ $i > 0 ? ',' : '' }}
                @endfor
            ],
            datasets: [{
                label: 'Fasilitas',
                data: [
                    @for($i = 5; $i >= 0; $i--)
                        {{ \App\Models\Facility::whereYear('created_at', now()->subMonths($i)->year)
                            ->whereMonth('created_at', now()->subMonths($i)->month)->count() }}{{ $i > 0 ? ',' : '' }}
                    @endfor
                ],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4
            }, {
                label: 'Berita',
                data: [
                    @for($i = 5; $i >= 0; $i--)
                        {{ \App\Models\News::whereYear('created_at', now()->subMonths($i)->year)
                            ->whereMonth('created_at', now()->subMonths($i)->month)->count() }}{{ $i > 0 ? ',' : '' }}
                    @endfor
                ],
                borderColor: 'rgb(147, 51, 234)',
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                tension: 0.4
            }, {
                label: 'Galeri',
                data: [
                    @for($i = 5; $i >= 0; $i--)
                        {{ \App\Models\Gallery::whereYear('created_at', now()->subMonths($i)->year)
                            ->whereMonth('created_at', now()->subMonths($i)->month)->count() }}{{ $i > 0 ? ',' : '' }}
                    @endfor
                ],
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        font: {
                            size: 12
                        }
                    }
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 10
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });

    // Content Distribution Chart
    const distributionCtx = document.getElementById('distributionChart').getContext('2d');
    const distributionChart = new Chart(distributionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Fasilitas', 'Berita', 'Galeri'],
            datasets: [{
                data: [
                    {{ \App\Models\Facility::count() }},
                    {{ \App\Models\News::count() }},
                    {{ \App\Models\Gallery::count() }}
                ],
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(147, 51, 234)',
                    'rgb(34, 197, 94)'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        font: {
                            size: 12
                        }
                    }
                },
                title: {
                    display: false
                }
            }
        }
    });
</script>
@endpush
