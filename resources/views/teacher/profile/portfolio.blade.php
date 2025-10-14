@extends('teacher.layouts.app')

@section('title', 'Portfolio Guru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Portfolio Guru</h1>
                <p class="text-gray-600 mt-1">Portfolio dan pencapaian profesional Anda</p>
            </div>
            <div class="flex items-center space-x-4">
                <button onclick="exportPortfolio()" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700">
                    Export Portfolio
                </button>
                <a href="{{ route('teacher.profile.show') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Portfolio Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Overview -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Portfolio</h3>
                
                <!-- Stats -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Tahun Mengajar</span>
                        <span class="text-sm font-medium text-gray-900">{{ $teacher->teaching_years }} tahun</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Total Siswa</span>
                        <span class="text-sm font-medium text-gray-900">{{ $teacher->total_students }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Mata Pelajaran</span>
                        <span class="text-sm font-medium text-gray-900">{{ $teacher->subjects->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Kelas yang Diampu</span>
                        <span class="text-sm font-medium text-gray-900">{{ $teacher->teachingClasses->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $teacher->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $teacher->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Portfolio Details -->
        <div class="lg:col-span-2">
            <!-- Tabs -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <button onclick="showTab('overview')" id="tab-overview" class="tab-button py-4 px-1 border-b-2 border-blue-500 text-blue-600 text-sm font-medium">
                            Overview
                        </button>
                        <button onclick="showTab('teaching')" id="tab-teaching" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium">
                            Riwayat Mengajar
                        </button>
                        <button onclick="showTab('achievements')" id="tab-achievements" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium">
                            Prestasi
                        </button>
                        <button onclick="showTab('development')" id="tab-development" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium">
                            Pengembangan
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Overview Tab -->
                    <div id="content-overview" class="tab-content">
                        <div class="space-y-6">
                            <!-- Profile Summary -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Profil Singkat</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-700">{{ $teacher->bio ?? 'Belum ada bio yang ditambahkan.' }}</p>
                                </div>
                            </div>

                            <!-- Current Teaching -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Mengajar Saat Ini</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @forelse($teacher->subjects as $subject)
                                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $subject->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $subject->pivot->is_primary ? 'Utama' : 'Tambahan' }}</p>
                                            </div>
                                            @if($subject->pivot->is_primary)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Utama
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-span-2 text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada mata pelajaran</h3>
                                        <p class="mt-1 text-sm text-gray-500">Belum ada mata pelajaran yang diampu.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Mengajar Tab -->
                    <div id="content-teaching" class="tab-content hidden">
                        <div class="space-y-6">
                            <!-- Teaching History -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Riwayat Mengajar</h4>
                                <div class="space-y-4">
                                    @forelse($teacher->teachingClasses as $class)
                                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $class->name ?? 'Kelas' }}</p>
                                                <p class="text-xs text-gray-500">{{ $class->pivot->subject_id ? 'Mata Pelajaran' : 'Wali Kelas' }}</p>
                                                <p class="text-xs text-gray-400">{{ $class->pivot->academic_year_id ?? 'Tahun Ajaran' }}</p>
                                            </div>
                                            @if($class->pivot->is_homeroom)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Wali Kelas
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada riwayat</h3>
                                        <p class="mt-1 text-sm text-gray-500">Belum ada riwayat mengajar.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prestasi Tab -->
                    <div id="content-achievements" class="tab-content hidden">
                        <div class="space-y-6">
                            <!-- Certifications -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Sertifikasi</h4>
                                <div class="space-y-4">
                                    @forelse($teacher->certifications as $certification)
                                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $certification->certification_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $certification->issuing_organization }}</p>
                                                <p class="text-xs text-gray-400">Diterbitkan: {{ $certification->issue_date ? $certification->issue_date->format('d M Y') : '-' }}</p>
                                            </div>
                                            @if($certification->expiry_date && $certification->expiry_date->isFuture())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                            @elseif($certification->expiry_date)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Kedaluwarsa
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada sertifikasi</h3>
                                        <p class="mt-1 text-sm text-gray-500">Belum ada sertifikasi yang ditambahkan.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengembangan Tab -->
                    <div id="content-development" class="tab-content hidden">
                        <div class="space-y-6">
                            <!-- Professional Development -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Pengembangan Profesional</h4>
                                <div class="space-y-4">
                                    @forelse($teacher->activities as $activity)
                                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $activity->activity_type }}</p>
                                                <p class="text-sm text-gray-700 mt-1">{{ $activity->description }}</p>
                                                <p class="text-xs text-gray-500 mt-2">{{ $activity->created_at->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada aktivitas</h3>
                                        <p class="mt-1 text-sm text-gray-500">Belum ada aktivitas pengembangan profesional.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');

    // Add active class to selected tab button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('border-transparent', 'text-gray-500');
    activeButton.classList.add('border-blue-500', 'text-blue-600');
}

function exportPortfolio() {
    // Export portfolio functionality
    alert('Fitur export portfolio akan segera tersedia!');
}
</script>
@endsection

