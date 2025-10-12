@extends('admin.layouts.app')

@section('title', 'Data Pendaftar PPDB')

@section('content')
<div class="p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Data Pendaftar PPDB</h1>
                <p class="text-gray-600 mt-1">Kelola data pendaftar Penerimaan Peserta Didik Baru</p>
            </div>
            <div class="mt-4 lg:mt-0 flex flex-col sm:flex-row gap-3">
                <button onclick="showAddModal()" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Pendaftar
                </button>
                <button onclick="exportData()" 
                        class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export
                </button>
                <button onclick="printData()" 
                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print
                </button>
                <a href="{{ route('admin.ppdb-settings.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Pengaturan
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pendaftar</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalRegistrations }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Diterima</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $acceptedCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $rejectedCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu Verifikasi</option>
                    <option value="verified">Terverifikasi</option>
                    <option value="accepted">Diterima</option>
                    <option value="rejected">Ditolak</option>
                    <option value="reserved">Cadangan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jalur Pendaftaran</label>
                <select id="pathFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Jalur</option>
                    <option value="regular">Reguler</option>
                    <option value="achievement">Prestasi</option>
                    <option value="affirmation">Afirmasi</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                <input type="text" id="searchInput" placeholder="Cari nama atau NISN..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex items-end">
                <button id="clearFilters" class="w-full px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Reset Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-4 lg:px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Pendaftar</h3>
                <div class="mt-2 sm:mt-0 flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Total: {{ $totalRegistrations }} pendaftar</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendaftar</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jalur</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($registrations as $registration)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="registration-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                                   value="{{ $registration->id }}">
                        </td>
                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-medium text-sm">{{ substr($registration->full_name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $registration->full_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $registration->registration_number }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($registration->registration_path === 'regular') bg-blue-100 text-blue-800
                                @elseif($registration->registration_path === 'achievement') bg-green-100 text-green-800
                                @elseif($registration->registration_path === 'affirmation') bg-orange-100 text-orange-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $registration->path_label }}
                            </span>
                        </td>
                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($registration->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($registration->status === 'verified') bg-blue-100 text-blue-800
                                @elseif($registration->status === 'accepted') bg-green-100 text-green-800
                                @elseif($registration->status === 'rejected') bg-red-100 text-red-800
                                @elseif($registration->status === 'reserved') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $registration->status_label }}
                            </span>
                        </td>
                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $registration->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.ppdb.show', $registration->id) }}" 
                   class="text-blue-600 hover:text-blue-900">Detail</a>
                <button onclick="editRegistration({{ $registration->id }})" 
                        class="text-green-600 hover:text-green-900">Edit</button>
                                <button onclick="deleteRegistration({{ $registration->id }})" 
                                        class="text-red-600 hover:text-red-900">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 lg:px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pendaftar</h3>
                                <p class="mt-1 text-sm text-gray-500">Belum ada data pendaftar yang tersedia.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($registrations->hasPages())
        <div class="px-4 lg:px-6 py-4 border-t border-gray-200">
            {{ $registrations->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Bulk Actions -->
<div id="bulkActions" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-white rounded-lg shadow-lg p-4 hidden">
    <div class="flex items-center space-x-4">
        <span id="selectedCount" class="text-sm text-gray-600">0 item dipilih</span>
        <div class="flex space-x-2">
            <button id="bulkAccept" class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                Terima
            </button>
            <button id="bulkReject" class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                Tolak
            </button>
            <button id="bulkDelete" class="px-3 py-1 bg-gray-600 text-white rounded text-sm hover:bg-gray-700">
                Hapus
            </button>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="registrationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Tambah Pendaftar</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="registrationForm" method="POST">
                @csrf
                <div id="formMethod" style="display: none;"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" name="full_name" id="full_name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NISN *</label>
                        <input type="text" name="nisn" id="nisn" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                        <input type="text" name="birth_place" id="birth_place" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                        <input type="date" name="birth_date" id="birth_date" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                        <select name="gender" id="gender" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="male">Laki-laki</option>
                            <option value="female">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Agama *</label>
                        <select name="religion" id="religion" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon *</label>
                        <input type="tel" name="phone" id="phone" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" id="email" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                        <textarea name="address" id="address" rows="3" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jalur Pendaftaran *</label>
                        <select name="registration_path" id="registration_path" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Jalur</option>
                            <option value="regular">Reguler</option>
                            <option value="achievement">Prestasi</option>
                            <option value="affirmation">Afirmasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pending">Menunggu Verifikasi</option>
                            <option value="verified">Terverifikasi</option>
                            <option value="accepted">Diterima</option>
                            <option value="rejected">Ditolak</option>
                            <option value="reserved">Cadangan</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal()" 
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const registrationCheckboxes = document.querySelectorAll('.registration-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');

    selectAllCheckbox.addEventListener('change', function() {
        registrationCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    registrationCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.registration-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count > 0) {
            bulkActions.classList.remove('hidden');
            selectedCount.textContent = `${count} item dipilih`;
        } else {
            bulkActions.classList.add('hidden');
        }
    }

    // Filter functionality
    const statusFilter = document.getElementById('statusFilter');
    const pathFilter = document.getElementById('pathFilter');
    const searchInput = document.getElementById('searchInput');
    const clearFilters = document.getElementById('clearFilters');

    function applyFilters() {
        const status = statusFilter.value;
        const path = pathFilter.value;
        const search = searchInput.value.toLowerCase();
        
        // Apply filters to table rows
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const statusCell = row.querySelector('td:nth-child(4) span');
            const pathCell = row.querySelector('td:nth-child(3) span');
            const nameCell = row.querySelector('td:nth-child(2) div div:first-child');
            
            let showRow = true;
            
            if (status && statusCell && !statusCell.textContent.toLowerCase().includes(status)) {
                showRow = false;
            }
            
            if (path && pathCell && !pathCell.textContent.toLowerCase().includes(path)) {
                showRow = false;
            }
            
            if (search && nameCell && !nameCell.textContent.toLowerCase().includes(search)) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }

    statusFilter.addEventListener('change', applyFilters);
    pathFilter.addEventListener('change', applyFilters);
    searchInput.addEventListener('input', applyFilters);

    clearFilters.addEventListener('click', function() {
        statusFilter.value = '';
        pathFilter.value = '';
        searchInput.value = '';
        applyFilters();
    });

    // Bulk actions
    document.getElementById('bulkAccept').addEventListener('click', function() {
        const selectedIds = getSelectedIds();
        if (selectedIds.length > 0) {
            if (confirm(`Terima ${selectedIds.length} pendaftar?`)) {
                bulkUpdateStatus(selectedIds, 'accepted');
            }
        }
    });

    document.getElementById('bulkReject').addEventListener('click', function() {
        const selectedIds = getSelectedIds();
        if (selectedIds.length > 0) {
            if (confirm(`Tolak ${selectedIds.length} pendaftar?`)) {
                bulkUpdateStatus(selectedIds, 'rejected');
            }
        }
    });

    document.getElementById('bulkDelete').addEventListener('click', function() {
        const selectedIds = getSelectedIds();
        if (selectedIds.length > 0) {
            if (confirm(`Hapus ${selectedIds.length} pendaftar? Tindakan ini tidak dapat dibatalkan.`)) {
                bulkDelete(selectedIds);
            }
        }
    });

    function bulkUpdateStatus(ids, status) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.ppdb.bulk-status") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        form.appendChild(statusInput);
        
        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'registration_ids[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }

    function bulkDelete(ids) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.ppdb.bulk-delete") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'registration_ids[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }

    function getSelectedIds() {
        const checkedBoxes = document.querySelectorAll('.registration-checkbox:checked');
        return Array.from(checkedBoxes).map(checkbox => checkbox.value);
    }
});

function deleteRegistration(id) {
    if (confirm('Apakah Anda yakin ingin menghapus pendaftar ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/ppdb/pendaftar/${id}`;
        form.submit();
    }
}

// Modal functions
function showAddModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Pendaftar';
    document.getElementById('registrationForm').reset();
    document.getElementById('registrationForm').action = '{{ route("admin.ppdb.store") }}';
    document.getElementById('formMethod').innerHTML = '';
    document.getElementById('registrationModal').classList.remove('hidden');
}

function editRegistration(id) {
    // Fetch registration data
    fetch(`/admin/ppdb/pendaftar/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = 'Edit Pendaftar';
            document.getElementById('full_name').value = data.full_name || '';
            document.getElementById('nisn').value = data.nisn || '';
            document.getElementById('birth_place').value = data.birth_place || '';
            document.getElementById('birth_date').value = data.birth_date || '';
            document.getElementById('gender').value = data.gender || '';
            document.getElementById('religion').value = data.religion || '';
            document.getElementById('phone').value = data.phone || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('address').value = data.address || '';
            document.getElementById('registration_path').value = data.registration_path || '';
            document.getElementById('status').value = data.status || '';
            
            document.getElementById('registrationForm').action = `/admin/ppdb/pendaftar/${id}`;
            document.getElementById('formMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('registrationModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat data pendaftar');
        });
}

function closeModal() {
    document.getElementById('registrationModal').classList.add('hidden');
}

// Export functionality
function exportData() {
    const status = document.getElementById('statusFilter').value;
    const path = document.getElementById('pathFilter').value;
    const search = document.getElementById('searchInput').value;
    
    let url = '{{ route("admin.ppdb.export") }}?';
    if (status) url += `status=${status}&`;
    if (path) url += `path=${path}&`;
    if (search) url += `search=${search}&`;
    
    window.open(url, '_blank');
}

// Print functionality
function printData() {
    window.print();
}
</script>
@endpush
