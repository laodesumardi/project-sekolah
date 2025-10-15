@extends('admin.layouts.app')

@section('page-title', 'Manajemen Prestasi')

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-4 sm:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="min-w-0 flex-1">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-1 sm:mb-2 truncate">Manajemen Prestasi</h1>
                <p class="text-sm sm:text-base text-gray-600">Kelola prestasi dan pencapaian sekolah</p>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('admin.achievements.create') }}" 
                   class="inline-flex items-center px-3 sm:px-4 py-2 bg-[#13315c] text-white rounded-lg hover:bg-[#1e4d8b] transition-colors w-full sm:w-auto justify-center">
                    <i class="fas fa-plus mr-1 sm:mr-2"></i>
                    <span class="hidden sm:inline">Tambah Prestasi</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-trophy text-blue-600 text-lg sm:text-xl"></i>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Prestasi</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-medal text-green-600 text-lg sm:text-xl"></i>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Nasional</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $stats['national'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-globe text-yellow-600 text-lg sm:text-xl"></i>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Internasional</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $stats['international'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-eye text-purple-600 text-lg sm:text-xl"></i>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Views</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ number_format($stats['views']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border mb-4 sm:mb-6">
        <form method="GET" action="{{ route('admin.achievements.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Level</label>
                <select name="level" class="w-full border border-gray-300 rounded-lg px-2 sm:px-3 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                    <option value="">Semua Level</option>
                    <option value="sekolah" {{ request('level') == 'sekolah' ? 'selected' : '' }}>Sekolah</option>
                    <option value="kecamatan" {{ request('level') == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                    <option value="kota" {{ request('level') == 'kota' ? 'selected' : '' }}>Kota</option>
                    <option value="provinsi" {{ request('level') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                    <option value="nasional" {{ request('level') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                    <option value="internasional" {{ request('level') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                </select>
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Kategori</label>
                <select name="category" class="w-full border border-gray-300 rounded-lg px-2 sm:px-3 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    <option value="akademik" {{ request('category') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                    <option value="olahraga" {{ request('category') == 'olahraga' ? 'selected' : '' }}>Olahraga</option>
                    <option value="seni" {{ request('category') == 'seni' ? 'selected' : '' }}>Seni</option>
                    <option value="teknologi" {{ request('category') == 'teknologi' ? 'selected' : '' }}>Teknologi</option>
                    <option value="keagamaan" {{ request('category') == 'keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                    <option value="lomba" {{ request('category') == 'lomba' ? 'selected' : '' }}>Lomba</option>
                    <option value="kompetisi" {{ request('category') == 'kompetisi' ? 'selected' : '' }}>Kompetisi</option>
                    <option value="olimpiade" {{ request('category') == 'olimpiade' ? 'selected' : '' }}>Olimpiade</option>
                    <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Tahun</label>
                <select name="year" class="w-full border border-gray-300 rounded-lg px-2 sm:px-3 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-[#13315c] focus:border-transparent">
                    <option value="">Semua Tahun</option>
                    @for($year = date('Y'); $year >= 2020; $year--)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-[#13315c] text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-[#1e4d8b] transition-colors text-xs sm:text-sm">
                    <i class="fas fa-search mr-1 sm:mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Achievements Table -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Daftar Prestasi</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-xs sm:text-sm text-gray-500">{{ $achievements->total() }} prestasi ditemukan</span>
                </div>
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block sm:hidden">
            @forelse($achievements as $achievement)
            <div class="p-4 border-b border-gray-200 last:border-b-0">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        @if($achievement->certificate_image)
                        <img class="h-12 w-12 rounded-lg object-cover border" 
                             src="{{ asset('storage/achievements/certificates/' . $achievement->certificate_image) }}" 
                             alt="{{ $achievement->title }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="h-12 w-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center border" style="display: none;">
                            <i class="fas fa-certificate text-blue-600"></i>
                        </div>
                        @elseif($achievement->trophy_image)
                        <img class="h-12 w-12 rounded-lg object-cover border" 
                             src="{{ asset('storage/achievements/trophies/' . $achievement->trophy_image) }}" 
                             alt="{{ $achievement->title }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="h-12 w-12 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-lg flex items-center justify-center border" style="display: none;">
                            <i class="fas fa-trophy text-yellow-600"></i>
                        </div>
                        @else
                        <div class="h-12 w-12 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-lg flex items-center justify-center border">
                            <i class="fas fa-trophy text-yellow-600"></i>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div class="min-w-0 flex-1">
                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ $achievement->title }}</h4>
                                <p class="text-xs text-gray-500 truncate">{{ $achievement->event_name }}</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $achievement->level_color }}">
                                        {{ ucfirst($achievement->achievement_level) }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ ucfirst($achievement->category) }}</span>
                                </div>
                                <div class="flex items-center space-x-1 mt-1">
                                    @if($achievement->is_featured)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-star mr-1"></i>F
                                    </span>
                                    @endif
                                    @if($achievement->is_published)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>P
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-clock mr-1"></i>D
                                    </span>
                                    @endif
                                    <span class="text-xs text-gray-500">{{ $achievement->formatted_date }}</span>
                                    <span class="text-xs text-gray-500">{{ number_format($achievement->view_count) }} views</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-1 ml-2">
                                <a href="{{ route('achievements.show', $achievement->slug) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-lg transition-colors" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.achievements.edit', $achievement) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 rounded-lg transition-colors" 
                                   title="Edit Prestasi">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-6 text-center">
                <div class="text-gray-500">
                    <i class="fas fa-trophy text-3xl mb-3"></i>
                    <p class="text-base font-medium">Tidak ada prestasi ditemukan</p>
                    <p class="text-sm">Mulai dengan menambahkan prestasi pertama Anda</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Desktop View -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full min-w-[1200px] achievement-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 lg:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-80">Prestasi</th>
                        <th class="px-3 lg:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Level</th>
                        <th class="px-3 lg:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Kategori</th>
                        <th class="px-3 lg:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Tanggal</th>
                        <th class="px-3 lg:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Status</th>
                        <th class="px-3 lg:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Views</th>
                        <th class="px-3 lg:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-80">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($achievements as $achievement)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 lg:px-4 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($achievement->certificate_image)
                                    <img class="h-10 w-10 rounded-lg object-cover border" 
                                         src="{{ asset('storage/achievements/certificates/' . $achievement->certificate_image) }}" 
                                         alt="{{ $achievement->title }}"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="h-10 w-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center border" style="display: none;">
                                        <i class="fas fa-certificate text-blue-600"></i>
                                    </div>
                                    @elseif($achievement->trophy_image)
                                    <img class="h-10 w-10 rounded-lg object-cover border" 
                                         src="{{ asset('storage/achievements/trophies/' . $achievement->trophy_image) }}" 
                                         alt="{{ $achievement->title }}"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="h-10 w-10 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-lg flex items-center justify-center border" style="display: none;">
                                        <i class="fas fa-trophy text-yellow-600"></i>
                                    </div>
                                    @else
                                    <div class="h-10 w-10 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-lg flex items-center justify-center border">
                                        <i class="fas fa-trophy text-yellow-600"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($achievement->title, 40) }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($achievement->event_name, 30) }}</div>
                                    <div class="flex items-center space-x-1 mt-1">
                                        @if($achievement->is_featured)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-star mr-1"></i>F
                                        </span>
                                        @endif
                                        @if($achievement->is_published)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>P
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-clock mr-1"></i>D
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 lg:px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $achievement->level_color }}">
                                {{ ucfirst($achievement->achievement_level) }}
                            </span>
                        </td>
                        <td class="px-3 lg:px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ ucfirst($achievement->category) }}
                        </td>
                        <td class="px-3 lg:px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $achievement->formatted_date }}
                        </td>
                        <td class="px-3 lg:px-4 py-4 whitespace-nowrap">
                            @if($achievement->is_published)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>P
                            </span>
                            @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>D
                            </span>
                            @endif
                        </td>
                        <td class="px-3 lg:px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($achievement->view_count) }}
                        </td>
                        <td class="px-3 lg:px-4 py-4 whitespace-nowrap text-right text-sm font-medium actions-column">
                            <div class="flex items-center justify-end space-x-1">
                                <!-- View Button -->
                                <a href="{{ route('achievements.show', $achievement->slug) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-lg transition-colors" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('admin.achievements.edit', $achievement) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 rounded-lg transition-colors" 
                                   title="Edit Prestasi">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- Toggle Featured Button -->
                                <form action="{{ route('admin.achievements.toggle-featured', $achievement) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center w-8 h-8 {{ $achievement->is_featured ? 'text-yellow-600 hover:text-yellow-800 hover:bg-yellow-100' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100' }} rounded-lg transition-colors" 
                                            title="{{ $achievement->is_featured ? 'Hapus dari Featured' : 'Jadikan Featured' }}">
                                        <i class="fas fa-star{{ $achievement->is_featured ? '' : '-o' }}"></i>
                                    </button>
                                </form>
                                
                                <!-- Toggle Published Button -->
                                <form action="{{ route('admin.achievements.toggle-published', $achievement) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center w-8 h-8 {{ $achievement->is_published ? 'text-green-600 hover:text-green-800 hover:bg-green-100' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100' }} rounded-lg transition-colors" 
                                            title="{{ $achievement->is_published ? 'Unpublish' : 'Publish' }}">
                                        <i class="fas fa-{{ $achievement->is_published ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('admin.achievements.destroy', $achievement) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus prestasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-lg transition-colors" 
                                            title="Hapus Prestasi">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-trophy text-4xl mb-4"></i>
                                <p class="text-lg font-medium">Tidak ada prestasi ditemukan</p>
                                <p class="text-sm">Mulai dengan menambahkan prestasi pertama Anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($achievements->hasPages())
        <div class="px-3 sm:px-6 py-3 sm:py-4 border-t">
            {{ $achievements->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.actions-column {
    min-width: 200px;
    white-space: nowrap;
}

.achievement-table {
    table-layout: fixed;
}

.achievement-table th:first-child,
.achievement-table td:first-child {
    width: 300px;
    min-width: 300px;
}

.achievement-table th:last-child,
.achievement-table td:last-child {
    width: 200px;
    min-width: 200px;
}
</style>
@endpush

@push('scripts')
<script>
// Handle toggle buttons
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Featured
    document.querySelectorAll('form[action*="toggle-featured"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const button = this.querySelector('button');
            const originalText = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Loading...';
            button.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to update UI
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.innerHTML = originalText;
                button.disabled = false;
            });
        });
    });
    
    // Toggle Published
    document.querySelectorAll('form[action*="toggle-published"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const button = this.querySelector('button');
            const originalText = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Loading...';
            button.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to update UI
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.innerHTML = originalText;
                button.disabled = false;
            });
        });
    });
});
</script>
@endpush
@endsection
