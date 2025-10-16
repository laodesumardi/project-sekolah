@extends('admin.layouts.app')

@section('title', 'Kelola Fasilitas')

@section('content')
<div class="p-3 sm:p-4 lg:p-6 space-y-4 sm:space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">Kelola Fasilitas</h1>
                    <nav class="flex mt-1 sm:mt-2" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-xs sm:text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <i class="fas fa-home w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2"></i>
                                    <span class="hidden sm:inline">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right w-4 h-4 sm:w-6 sm:h-6 text-gray-400"></i>
                                    <span class="ml-1 text-xs sm:text-sm font-medium text-gray-500 md:ml-2">Fasilitas</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.facilities.create') }}" class="bg-[#13315c] hover:bg-[#1e4d8b] text-white px-3 sm:px-4 py-2 rounded-lg flex items-center transition-colors w-full sm:w-auto justify-center">
                        <i class="fas fa-plus w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2"></i>
                        <span class="hidden sm:inline">Tambah Fasilitas</span>
                        <span class="sm:hidden">Tambah</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
            <!-- Total Facilities -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-building w-5 h-5 sm:w-6 sm:h-6 text-blue-600"></i>
                    </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Total Fasilitas</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                </div>
            </div>

            <!-- Available Facilities -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle w-5 h-5 sm:w-6 sm:h-6 text-green-600"></i>
                    </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Tersedia</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['available'] }}</p>
                </div>
                </div>
            </div>

            <!-- Unavailable Facilities -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 border-l-4 border-red-500">
                <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-red-100 rounded-full">
                    <i class="fas fa-times-circle w-5 h-5 sm:w-6 sm:h-6 text-red-600"></i>
                    </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Tidak Tersedia</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['unavailable'] }}</p>
                </div>
                </div>
            </div>

            <!-- Total Views -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-eye w-5 h-5 sm:w-6 sm:h-6 text-purple-600"></i>
                    </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Total Views</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ number_format($stats['total_views']) }}</p>
                </div>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="bg-white rounded-lg shadow">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-medium text-gray-900">Daftar Fasilitas</h3>
            </div>

            <!-- Filters -->
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <!-- Search -->
                <div class="sm:col-span-2 lg:col-span-1">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Cari</label>
                    <input type="text" id="search-input" class="w-full border border-gray-300 rounded-lg px-2 sm:px-3 py-2 text-xs sm:text-sm focus:ring-[#13315c] focus:border-[#13315c]" placeholder="Cari fasilitas...">
                    </div>

                    <!-- Category Filter -->
                    <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="category-filter" class="w-full border border-gray-300 rounded-lg px-2 sm:px-3 py-2 text-xs sm:text-sm focus:ring-[#13315c] focus:border-[#13315c]">
                            <option value="">Semua Kategori</option>
                            <option value="ruang_kelas">Ruang Kelas</option>
                            <option value="laboratorium">Laboratorium</option>
                            <option value="olahraga">Olahraga</option>
                            <option value="perpustakaan">Perpustakaan</option>
                            <option value="mushola">Mushola</option>
                            <option value="kantin">Kantin</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status-filter" class="w-full border border-gray-300 rounded-lg px-2 sm:px-3 py-2 text-xs sm:text-sm focus:ring-[#13315c] focus:border-[#13315c]">
                            <option value="">Semua Status</option>
                            <option value="available">Tersedia</option>
                            <option value="unavailable">Tidak Tersedia</option>
                        </select>
                    </div>

                    <!-- Bulk Actions -->
                <div class="sm:col-span-2 lg:col-span-1">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Aksi Massal</label>
                    <div class="flex flex-wrap gap-1 sm:gap-2">
                        <button id="bulk-delete" class="px-2 sm:px-3 py-1 sm:py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-xs sm:text-sm">
                                Hapus
                            </button>
                        <button id="bulk-available" class="px-2 sm:px-3 py-1 sm:py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-xs sm:text-sm">
                                Tersedia
                            </button>
                        <button id="bulk-unavailable" class="px-2 sm:px-3 py-1 sm:py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 text-xs sm:text-sm">
                                Tidak Tersedia
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Mobile View -->
        <div class="block sm:hidden">
            @forelse($facilities as $index => $facility)
            <div class="border-b border-gray-200 p-4">
                <div class="flex items-start space-x-3">
                    <input type="checkbox" class="facility-checkbox rounded border-gray-300 text-[#13315c] focus:ring-[#13315c] mt-1" value="{{ $facility->id }}">
                    <div class="flex-shrink-0">
                        <img src="{{ $facility->thumbnail_url }}" alt="{{ $facility->name }}" class="w-16 h-16 object-cover rounded-lg">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900 truncate">{{ $facility->name }}</h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $facility->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $facility->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($facility->description, 60) }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center space-x-3 text-xs text-gray-500">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $facility->category_name }}
                                </span>
                                <span>{{ $facility->location ?? '-' }}</span>
                                <span>{{ $facility->getFormattedCapacity() }}</span>
                                <span class="flex items-center">
                                    <i class="fas fa-eye w-3 h-3 mr-1"></i>
                                    {{ number_format($facility->view_count) }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <a href="{{ route('admin.facilities.edit', $facility) }}" class="text-blue-600 hover:text-blue-900 p-1" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button onclick="deleteFacility('{{ $facility->slug }}')" class="text-red-600 hover:text-red-900 p-1" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada fasilitas ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan fasilitas baru.</p>
            </div>
            @endforelse
        </div>

        <!-- Desktop View -->
        <div class="hidden sm:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                        <th class="px-3 lg:px-6 py-3 text-left">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-[#13315c] focus:ring-[#13315c]">
                            </th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thumbnail</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Fasilitas</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kapasitas</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($facilities as $index => $facility)
                        <tr class="hover:bg-gray-50">
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="facility-checkbox rounded border-gray-300 text-[#13315c] focus:ring-[#13315c]" value="{{ $facility->id }}">
                            </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                {{ $facilities->firstItem() + $index }}
                            </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                            <img src="{{ $facility->thumbnail_url }}" alt="{{ $facility->name }}" class="w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-lg">
                            </td>
                        <td class="px-3 lg:px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 truncate max-w-xs">{{ $facility->name }}</div>
                            <div class="text-xs sm:text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($facility->description, 40) }}</div>
                            </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $facility->category_name }}
                                </span>
                            </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                {{ $facility->location ?? '-' }}
                            </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                {{ $facility->getFormattedCapacity() }}
                            </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $facility->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $facility->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                <div class="flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ number_format($facility->view_count) }}
                                </div>
                            </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-1 sm:space-x-2">
                                <a href="{{ route('admin.facilities.edit', $facility) }}" class="text-blue-600 hover:text-blue-900 p-1" title="Edit">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                <button onclick="deleteFacility('{{ $facility->slug }}')" class="text-red-600 hover:text-red-900 p-1" title="Hapus">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada fasilitas ditemukan</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan fasilitas baru.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($facilities->hasPages())
        <div class="px-3 sm:px-6 py-3 sm:py-4 border-t border-gray-200">
                {{ $facilities->links() }}
            </div>
            @endif
    </div>
</div>

<!-- Delete Form -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Bulk Delete Form -->
<form id="bulk-delete-form" method="POST" action="{{ route('admin.facilities.bulk-delete') }}" style="display: none;">
    @csrf
    <input type="hidden" name="facility_ids" id="bulk-delete-ids">
</form>

<!-- Bulk Status Form -->
<form id="bulk-status-form" method="POST" action="{{ route('admin.facilities.bulk-status') }}" style="display: none;">
    @csrf
    <input type="hidden" name="facility_ids" id="bulk-status-ids">
    <input type="hidden" name="status" id="bulk-status-value">
</form>

@push('scripts')
<script>
// Select All Checkbox
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.facility-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Individual Checkbox
document.querySelectorAll('.facility-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const allCheckboxes = document.querySelectorAll('.facility-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.facility-checkbox:checked');
        const selectAllCheckbox = document.getElementById('select-all');
        
        if (checkedCheckboxes.length === allCheckboxes.length) {
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.checked = false;
        }
    });
});

// Delete Facility
function deleteFacility(facilitySlug) {
    if (confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/facilities/${facilitySlug}`;
        form.submit();
    }
}

// Bulk Actions
document.getElementById('bulk-delete').addEventListener('click', function() {
    const checkedBoxes = document.querySelectorAll('.facility-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Pilih fasilitas yang akan dihapus');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin menghapus ${checkedBoxes.length} fasilitas?`)) {
        const ids = Array.from(checkedBoxes).map(cb => cb.value);
        document.getElementById('bulk-delete-ids').value = JSON.stringify(ids);
        document.getElementById('bulk-delete-form').submit();
    }
});

document.getElementById('bulk-available').addEventListener('click', function() {
    const checkedBoxes = document.querySelectorAll('.facility-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Pilih fasilitas yang akan diubah statusnya');
        return;
    }
    
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    document.getElementById('bulk-status-ids').value = JSON.stringify(ids);
    document.getElementById('bulk-status-value').value = '1';
    document.getElementById('bulk-status-form').submit();
});

document.getElementById('bulk-unavailable').addEventListener('click', function() {
    const checkedBoxes = document.querySelectorAll('.facility-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Pilih fasilitas yang akan diubah statusnya');
        return;
    }
    
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    document.getElementById('bulk-status-ids').value = JSON.stringify(ids);
    document.getElementById('bulk-status-value').value = '0';
    document.getElementById('bulk-status-form').submit();
});

// Filters
document.getElementById('search-input').addEventListener('input', function() {
    // Implement search functionality
    filterTable();
});

document.getElementById('category-filter').addEventListener('change', function() {
    filterTable();
});

document.getElementById('status-filter').addEventListener('change', function() {
    filterTable();
});

function filterTable() {
    // Implement table filtering
    // This would typically involve AJAX requests to the server
    console.log('Filtering table...');
}
</script>
@endpush
@endsection