@extends('layouts.app')

@section('title', 'Prestasi Sekolah')
@section('description', 'Catatan prestasi dan pencapaian siswa-siswi SMP Negeri 01 Namrole')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Background Section -->
    <x-background-section 
        section="hero"
        title="Prestasi Sekolah"
        subtitle="Catatan prestasi dan pencapaian siswa-siswi"
    />
                
                <!-- Statistics Link -->
                <div class="mb-8">
                    <a href="{{ route('achievements.statistics') }}" class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white rounded-lg hover:bg-white/30 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Lihat Statistik & Pencapaian
                    </a>
                </div>
                
                <!-- Hero Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold">{{ $stats['total'] }}</div>
                        <div class="text-sm text-blue-100">Total Prestasi</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold">{{ $stats['national'] }}</div>
                        <div class="text-sm text-blue-100">Prestasi Nasional</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold">{{ $stats['international'] }}</div>
                        <div class="text-sm text-blue-100">Prestasi Internasional</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold">{{ $stats['this_year'] }}</div>
                        <div class="text-sm text-blue-100">Tahun Ini</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Level Tabs -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('achievements', ['level' => 'all']) }}" 
                       class="px-4 py-2 rounded-full border-2 border-gray-300 text-gray-700 hover:border-[#13315c] hover:text-[#13315c] transition-colors {{ request('level', 'all') === 'all' ? 'bg-[#13315c] text-white border-[#13315c]' : '' }}">
                        <i class="fas fa-trophy mr-2"></i>Semua
                    </a>
                    @foreach(['sekolah', 'kecamatan', 'kota', 'provinsi', 'nasional', 'internasional'] as $level)
                    <a href="{{ route('achievements', ['level' => $level]) }}" 
                       class="px-4 py-2 rounded-full border-2 border-gray-300 text-gray-700 hover:border-[#13315c] hover:text-[#13315c] transition-colors {{ request('level') === $level ? 'bg-[#13315c] text-white border-[#13315c]' : '' }}">
                        <i class="fas fa-trophy mr-2"></i>{{ ucfirst($level) }}
                        @if(isset($levels[$level]))
                        <span class="ml-1 bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs">{{ $levels[$level] }}</span>
                        @endif
                    </a>
                    @endforeach
                </div>

                <!-- Search & Sort -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search Box -->
                    <div class="relative">
                        <input type="text" 
                               id="search-input"
                               placeholder="Cari prestasi, event, atau peserta..." 
                               class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>

                    <!-- Sort Dropdown -->
                    <select id="sort-select" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                        <option value="recent">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="level">Tingkat</option>
                        <option value="views">Paling Banyak Dilihat</option>
                        <option value="name">Nama (A-Z)</option>
                    </select>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="mt-4">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('achievements', array_merge(request()->query(), ['category' => 'all'])) }}" 
                       class="px-3 py-1 rounded-full border border-gray-300 text-gray-700 hover:border-[#13315c] hover:text-[#13315c] transition-colors {{ request('category', 'all') === 'all' ? 'bg-[#13315c] text-white border-[#13315c]' : '' }}">
                        Semua
                    </a>
                    @foreach(['akademik', 'olahraga', 'seni', 'teknologi', 'keagamaan', 'lomba', 'kompetisi', 'olimpiade', 'lainnya'] as $category)
                    <a href="{{ route('achievements', array_merge(request()->query(), ['category' => $category])) }}" 
                       class="px-3 py-1 rounded-full border border-gray-300 text-gray-700 hover:border-[#13315c] hover:text-[#13315c] transition-colors {{ request('category') === $category ? 'bg-[#13315c] text-white border-[#13315c]' : '' }}">
                        {{ ucfirst($category) }}
                        @if(isset($categories[$category]))
                        <span class="ml-1 bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs">{{ $categories[$category] }}</span>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Year Filter -->
            <div class="mt-4">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('achievements', array_merge(request()->query(), ['year' => 'all'])) }}" 
                       class="px-3 py-1 rounded-full border border-gray-300 text-gray-700 hover:border-[#13315c] hover:text-[#13315c] transition-colors {{ request('year', 'all') === 'all' ? 'bg-[#13315c] text-white border-[#13315c]' : '' }}">
                        Semua Tahun
                    </a>
                    @foreach($years as $year => $count)
                    <a href="{{ route('achievements', array_merge(request()->query(), ['year' => $year])) }}" 
                       class="px-3 py-1 rounded-full border border-gray-300 text-gray-700 hover:border-[#13315c] hover:text-[#13315c] transition-colors {{ request('year') == $year ? 'bg-[#13315c] text-white border-[#13315c]' : '' }}">
                        {{ $year }} <span class="ml-1 bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs">{{ $count }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Featured Achievements -->
        @if($featured->count() > 0)
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-[#13315c] mb-6">Prestasi Unggulan</h2>
            <div class="relative">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($featured as $achievement)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative h-48 bg-gradient-to-r from-[#13315c] to-[#1e4d8b]">
                            @if($achievement->certificate_image)
                            <img src="{{ $achievement->certificate_url }}" alt="{{ $achievement->title }}" class="w-full h-full object-cover">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-white bg-[#13315c]/90">
                                    <i class="fas fa-trophy mr-2"></i>{{ strtoupper($achievement->achievement_level) }}
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-white bg-black/70">
                                    {{ $achievement->category_name }}
                                </span>
                            </div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <h3 class="text-xl font-bold text-white mb-2">{{ $achievement->title }}</h3>
                                <p class="text-blue-100">{{ $achievement->event_name }}</p>
                                <p class="text-sm text-blue-200">{{ $achievement->formatted_date }} • {{ $achievement->rank }}</p>
                            </div>
                        </div>
                        <div class="p-4">
                            <a href="{{ route('achievements.show', $achievement->slug) }}" 
                               class="inline-flex items-center px-4 py-2 bg-[#13315c] text-white rounded-lg hover:bg-[#1e4d8b] transition-colors">
                                Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Achievements Grid -->
        <div id="achievements-grid">
            @if($achievements->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($achievements as $achievement)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 @if($achievement->achievement_level === 'sekolah') border-blue-500 @elseif($achievement->achievement_level === 'kecamatan') border-green-500 @elseif($achievement->achievement_level === 'kota') border-yellow-500 @elseif($achievement->achievement_level === 'provinsi') border-orange-500 @elseif($achievement->achievement_level === 'nasional') border-red-500 @elseif($achievement->achievement_level === 'internasional') border-purple-500 @else border-gray-500 @endif">
                    <!-- Image Section -->
                    <div class="relative h-48 overflow-hidden">
                        @if($achievement->certificate_image)
                        <img src="{{ $achievement->certificate_url }}" alt="{{ $achievement->title }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        @elseif($achievement->trophy_image)
                        <img src="{{ $achievement->trophy_url }}" alt="{{ $achievement->title }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-[#13315c] to-[#1e4d8b] flex items-center justify-center">
                            <i class="fas fa-trophy text-6xl text-white/50"></i>
                        </div>
                        @endif
                        
                        <!-- Level Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-white @if($achievement->achievement_level === 'sekolah') bg-blue-500/95 @elseif($achievement->achievement_level === 'kecamatan') bg-green-500/95 @elseif($achievement->achievement_level === 'kota') bg-yellow-500/95 @elseif($achievement->achievement_level === 'provinsi') bg-orange-500/95 @elseif($achievement->achievement_level === 'nasional') bg-red-500/95 @elseif($achievement->achievement_level === 'internasional') bg-purple-500/95 @else bg-gray-500/95 @endif backdrop-blur-sm">
                                <i class="fas fa-trophy mr-1"></i>{{ strtoupper($achievement->achievement_level) }}
                            </span>
                        </div>
                        
                        <!-- Category Badge -->
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-white bg-black/70">
                                {{ $achievement->category_name }}
                            </span>
                        </div>
                        
                        <!-- Rank Badge (on hover) -->
                        <div class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="bg-white rounded-full p-4 border-4 @if($achievement->achievement_level === 'sekolah') border-blue-500 @elseif($achievement->achievement_level === 'kecamatan') border-green-500 @elseif($achievement->achievement_level === 'kota') border-yellow-500 @elseif($achievement->achievement_level === 'provinsi') border-orange-500 @elseif($achievement->achievement_level === 'nasional') border-red-500 @elseif($achievement->achievement_level === 'internasional') border-purple-500 @else border-gray-500 @endif">
                                <div class="text-2xl font-bold @if($achievement->achievement_level === 'sekolah') text-blue-500 @elseif($achievement->achievement_level === 'kecamatan') text-green-500 @elseif($achievement->achievement_level === 'kota') text-yellow-500 @elseif($achievement->achievement_level === 'provinsi') text-orange-500 @elseif($achievement->achievement_level === 'nasional') text-red-500 @elseif($achievement->achievement_level === 'internasional') text-purple-500 @else text-gray-500 @endif">{{ $achievement->rank }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[#13315c] mb-2 line-clamp-2 hover:text-[#1e4d8b]">{{ $achievement->title }}</h3>
                        <p class="text-gray-700 font-semibold mb-3 line-clamp-1">
                            <i class="fas fa-calendar mr-2"></i>{{ $achievement->event_name }}
                        </p>
                        
                        <!-- Meta Info Grid -->
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar mr-2"></i>
                                <span>{{ $achievement->formatted_date }}</span>
                            </div>
                            @if($achievement->organizer)
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-building mr-2"></i>
                                <span class="truncate">{{ $achievement->organizer }}</span>
                            </div>
                            @endif
                            @if($achievement->location)
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-map-pin mr-2"></i>
                                <span class="truncate">{{ $achievement->location }}</span>
                            </div>
                            @endif
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-users mr-2"></i>
                                <span>{{ $achievement->participant_type === 'individu' ? 'Individu' : ucfirst($achievement->participant_type) }}</span>
                            </div>
                        </div>
                        
                        @if($achievement->description)
                        <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ strip_tags($achievement->description) }}</p>
                        @endif
                        
                        <!-- Footer -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-xs text-gray-500">
                                <i class="fas fa-eye mr-1"></i>
                                <span>{{ $achievement->view_count }} views</span>
                            </div>
                            <a href="{{ route('achievements.show', $achievement->slug) }}" 
                               class="inline-flex items-center px-4 py-2 border-2 @if($achievement->achievement_level === 'sekolah') border-blue-500 text-blue-500 hover:bg-blue-500 @elseif($achievement->achievement_level === 'kecamatan') border-green-500 text-green-500 hover:bg-green-500 @elseif($achievement->achievement_level === 'kota') border-yellow-500 text-yellow-500 hover:bg-yellow-500 @elseif($achievement->achievement_level === 'provinsi') border-orange-500 text-orange-500 hover:bg-orange-500 @elseif($achievement->achievement_level === 'nasional') border-red-500 text-red-500 hover:bg-red-500 @elseif($achievement->achievement_level === 'internasional') border-purple-500 text-purple-500 hover:bg-purple-500 @else border-gray-500 text-gray-500 hover:bg-gray-500 @endif hover:text-white transition-colors rounded-lg">
                                Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $achievements->links() }}
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <i class="fas fa-trophy text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada prestasi tersedia</h3>
                <p class="text-gray-500 mb-6">Silakan cek filter atau kata kunci</p>
                <a href="{{ route('achievements') }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#13315c] text-white rounded-lg hover:bg-[#1e4d8b] transition-colors">
                    Reset Filter
                </a>
            </div>
            @endif
        </div>

        <!-- Statistics Section -->
        <div class="bg-gray-50 rounded-lg p-8 mt-12">
            <h2 class="text-2xl font-bold text-center text-[#13315c] mb-8">Prestasi dalam Angka</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-[#13315c] rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-trophy text-2xl text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-[#13315c]">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-600">Total Prestasi</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-flag text-2xl text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-[#13315c]">{{ $stats['national'] }}</div>
                    <div class="text-sm text-gray-600">Prestasi Nasional</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-globe text-2xl text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-[#13315c]">{{ $stats['international'] }}</div>
                    <div class="text-sm text-gray-600">Prestasi Internasional</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-medal text-2xl text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-[#13315c]">0</div>
                    <div class="text-sm text-gray-600">Juara 1</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-calendar text-2xl text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-[#13315c]">{{ $stats['this_year'] }}</div>
                    <div class="text-sm text-gray-600">Tahun Ini</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('search-input');
    const sortSelect = document.getElementById('sort-select');
    
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterAchievements();
        }, 500);
    });
    
    sortSelect.addEventListener('change', function() {
        filterAchievements();
    });
    
    function filterAchievements() {
        const search = searchInput.value;
        const sort = sortSelect.value;
        const currentUrl = new URL(window.location);
        
        if (search) {
            currentUrl.searchParams.set('search', search);
        } else {
            currentUrl.searchParams.delete('search');
        }
        
        if (sort && sort !== 'recent') {
            currentUrl.searchParams.set('sort', sort);
        } else {
            currentUrl.searchParams.delete('sort');
        }
        
        window.location.href = currentUrl.toString();
    }
});
</script>
@endsection





