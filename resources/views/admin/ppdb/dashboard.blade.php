@extends('admin.layouts.app')

@section('page-title', 'Dashboard PPDB')

@section('content')
<div class="p-4 lg:p-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 lg:p-6 mb-6 lg:mb-8">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <h2 class="text-xl lg:text-2xl font-bold text-white mb-2">Dashboard PPDB</h2>
                <p class="text-blue-100 text-sm lg:text-base">Kelola pendaftaran peserta didik baru dengan mudah</p>
            </div>
            <div class="hidden lg:block">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
        <!-- Total Applicants -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-2 lg:p-3 bg-blue-100 rounded-full">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 lg:ml-4">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Total Pendaftar</p>
                    <p class="text-xl lg:text-2xl font-semibold text-gray-900">{{ $totalRegistrations }}</p>
                    <p class="text-xs text-gray-500">+{{ $recentApplicants }} hari ini</p>
                </div>
            </div>
        </div>

        <!-- Pending Verification -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-2 lg:p-3 bg-yellow-100 rounded-full">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 lg:ml-4">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Menunggu Verifikasi</p>
                    <p class="text-xl lg:text-2xl font-semibold text-gray-900">{{ $pendingCount }}</p>
                    <p class="text-xs text-gray-500">Perlu tindakan</p>
                </div>
            </div>
        </div>

        <!-- Verified Applicants -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-2 lg:p-3 bg-green-100 rounded-full">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 lg:ml-4">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Terverifikasi</p>
                    <p class="text-xl lg:text-2xl font-semibold text-gray-900">{{ $verifiedCount }}</p>
                    <p class="text-xs text-gray-500">{{ $totalRegistrations > 0 ? round(($verifiedCount / $totalRegistrations) * 100, 1) : 0 }}% dari total</p>
                </div>
            </div>
        </div>

        <!-- Accepted Applicants -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-2 lg:p-3 bg-purple-100 rounded-full">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 lg:ml-4">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Diterima</p>
                    <p class="text-xl lg:text-2xl font-semibold text-gray-900">{{ $acceptedCount }}</p>
                    <p class="text-xs text-gray-500">{{ $totalRegistrations > 0 ? round(($acceptedCount / $totalRegistrations) * 100, 1) : 0 }}% dari total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-8 mb-6 lg:mb-8">
        <!-- Applicants Chart -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base lg:text-lg font-semibold text-gray-900">Pendaftar Harian</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-xs lg:text-sm text-gray-500">30 hari terakhir</span>
                </div>
            </div>
            <div class="h-48 lg:h-64">
                <canvas id="applicantsChart"></canvas>
            </div>
        </div>

        <!-- Path Distribution -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base lg:text-lg font-semibold text-gray-900">Distribusi Jalur</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-xs lg:text-sm text-gray-500">Total: {{ $totalApplicants }}</span>
                </div>
            </div>
            <div class="h-48 lg:h-64">
                <canvas id="pathChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quota Progress -->
    <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6 mb-6 lg:mb-8">
        <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-4">Progress Kuota</h3>
        <div class="space-y-4">
            @if($setting)
            <!-- Regular Path -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Jalur Reguler</span>
                    <span class="text-sm text-gray-500">{{ $pathDistribution['regular'] ?? 0 }} / {{ $setting->quota_regular }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full transition-all duration-300" 
                         style="width: {{ $setting->quota_regular > 0 ? (($pathDistribution['regular'] ?? 0) / $setting->quota_regular) * 100 : 0 }}%"></div>
                </div>
            </div>

            <!-- Achievement Path -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Jalur Prestasi</span>
                    <span class="text-sm text-gray-500">{{ $pathDistribution['achievement'] ?? 0 }} / {{ $setting->quota_achievement }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full transition-all duration-300" 
                         style="width: {{ $setting->quota_achievement > 0 ? (($pathDistribution['achievement'] ?? 0) / $setting->quota_achievement) * 100 : 0 }}%"></div>
                </div>
            </div>

            <!-- Affirmation Path -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Jalur Afirmasi</span>
                    <span class="text-sm text-gray-500">{{ $pathDistribution['affirmation'] ?? 0 }} / {{ $setting->quota_affirmation }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-orange-500 h-2 rounded-full transition-all duration-300" 
                         style="width: {{ $setting->quota_affirmation > 0 ? (($pathDistribution['affirmation'] ?? 0) / $setting->quota_affirmation) * 100 : 0 }}%"></div>
                </div>
            </div>
            @else
            <div class="text-center py-8">
                <p class="text-gray-500">Pengaturan PPDB belum dikonfigurasi</p>
                <a href="{{ route('admin.ppdb-settings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Konfigurasi sekarang</a>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Applicants & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-8">
        <!-- Recent Applicants -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base lg:text-lg font-semibold text-gray-900">Pendaftar Terbaru</h3>
                <a href="{{ route('admin.ppdb.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Lihat semua</a>
            </div>
            <div class="space-y-3">
                @forelse($recentApplicants as $applicant)
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-medium text-sm">{{ substr($applicant->full_name, 0, 1) }}</span>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $applicant->full_name }}</p>
                        <p class="text-xs text-gray-500">{{ $applicant->registration_number }} • {{ $applicant->path_label }}</p>
                    </div>
                    <span class="text-xs text-gray-400">{{ $applicant->created_at->diffForHumans() }}</span>
                </div>
                @empty
                <div class="text-center py-4">
                    <p class="text-gray-500 text-sm">Belum ada pendaftar</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.ppdb.index') }}" 
                   class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span class="text-blue-800 font-medium">Kelola Pendaftar</span>
                </a>
                
                <a href="{{ route('admin.ppdb-settings.index') }}" 
                   class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-green-800 font-medium">Pengaturan PPDB</span>
                </a>

                <a href="{{ route('ppdb.announcement') }}" 
                   class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    <span class="text-purple-800 font-medium">Pengumuman</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Applicants Chart
    const applicantsCtx = document.getElementById('applicantsChart').getContext('2d');
    const applicantsChart = new Chart(applicantsCtx, {
        type: 'line',
        data: {
            labels: [
                @for($i = 29; $i >= 0; $i--)
                    '{{ now()->subDays($i)->format('d M') }}'{{ $i > 0 ? ',' : '' }}
                @endfor
            ],
            datasets: [{
                label: 'Pendaftar',
                data: [
                    @for($i = 29; $i >= 0; $i--)
                        {{ $applicantsPerDay->where('date', now()->subDays($i)->format('Y-m-d'))->first()->count ?? 0 }}{{ $i > 0 ? ',' : '' }}
                    @endfor
                ],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
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

    // Path Distribution Chart
    const pathCtx = document.getElementById('pathChart').getContext('2d');
    const pathChart = new Chart(pathCtx, {
        type: 'doughnut',
        data: {
            labels: ['Reguler', 'Prestasi', 'Afirmasi'],
            datasets: [{
                data: [
                    {{ $pathDistribution['regular'] ?? 0 }},
                    {{ $pathDistribution['achievement'] ?? 0 }},
                    {{ $pathDistribution['affirmation'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(34, 197, 94)',
                    'rgb(251, 146, 60)'
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
                }
            }
        }
    });
</script>
@endpush