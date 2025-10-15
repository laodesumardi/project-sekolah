@extends('admin.layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Manajemen User</h1>
                    <p class="text-gray-600">Kelola pengguna sistem sekolah dengan mudah</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.users.export', request()->query()) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-download mr-2"></i>
                        <span>Export Data</span>
                    </a>
                    <a href="{{ route('admin.users.create') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Tambah User</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total User</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-green-50 text-green-600">
                        <i class="fas fa-user-check text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['active'] }}</p>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-red-50 text-red-600">
                        <i class="fas fa-user-times text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Tidak Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['inactive'] }}</p>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-purple-50 text-purple-600">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Guru</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['teacher'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Filter & Pencarian</h3>
                <p class="text-sm text-gray-600">Gunakan filter di bawah untuk menemukan user yang Anda cari</p>
            </div>
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i>Pencarian
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama, email, atau phone..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-tag mr-1"></i>Role
                    </label>
                    <select name="role" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="teacher" {{ request('role') === 'teacher' ? 'selected' : '' }}>Guru</option>
                        <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Siswa</option>
                        <option value="parent" {{ request('role') === 'parent' ? 'selected' : '' }}>Orang Tua</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-toggle-on mr-1"></i>Status
                    </label>
                    <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-search mr-2"></i>Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <form id="bulk-form" method="POST" action="{{ route('admin.users.bulk-action') }}">
                @csrf
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" id="select-all" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="select-all" class="text-sm font-medium text-gray-700">Pilih Semua</label>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                <select name="action" id="bulk-action" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Aksi</option>
                                    <option value="activate">Aktifkan</option>
                                    <option value="deactivate">Nonaktifkan</option>
                                    <option value="delete">Hapus</option>
                                </select>
                                
                                <button type="submit" class="inline-flex items-center justify-center bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-check mr-2"></i>Terapkan
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span>{{ $users->total() }} user ditemukan</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto table-container">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <input type="checkbox" id="select-all-header" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-user mr-2"></i>User
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-user-tag mr-2"></i>Role
                                </th>
                                <th class="hidden sm:table-cell px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-phone mr-2"></i>Kontak
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-toggle-on mr-2"></i>Status
                                </th>
                                <th class="hidden md:table-cell px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-calendar mr-2"></i>Bergabung
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-2"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="table-row-hover hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 user-checkbox">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($user->avatar)
                                                <img class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-200" src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                                    <i class="fas fa-user text-white text-sm"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if($user->role === 'admin') bg-red-100 text-red-800
                                        @elseif($user->role === 'teacher') bg-blue-100 text-blue-800
                                        @elseif($user->role === 'student') bg-green-100 text-green-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        <i class="fas fa-user-tag mr-1"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($user->phone)
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-gray-400 mr-2"></i>
                                            <span class="font-medium">{{ $user->phone }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if($user->is_active) bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        <i class="fas fa-circle text-xs mr-2"></i>
                                        {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                        {{ $user->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="action-buttons">
                                        <!-- View Button -->
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-blue-500 text-white text-xs font-medium rounded-lg hover:bg-blue-600 transition-all duration-200 shadow-sm hover:shadow-md"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye mr-1"></i>
                                            Lihat
                                        </a>
                                        
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-indigo-500 text-white text-xs font-medium rounded-lg hover:bg-indigo-600 transition-all duration-200 shadow-sm hover:shadow-md"
                                           title="Edit User">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>
                                        
                                        <!-- Toggle Status Button -->
                                        <button onclick="toggleActive({{ $user->id }})" 
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md
                                                @if($user->is_active) bg-orange-500 text-white hover:bg-orange-600
                                                @else bg-green-500 text-white hover:bg-green-600
                                                @endif"
                                                title="{{ $user->is_active ? 'Nonaktifkan User' : 'Aktifkan User' }}">
                                            <i class="fas fa-toggle-{{ $user->is_active ? 'on' : 'off' }} mr-1"></i>
                                            {{ $user->is_active ? 'Nonaktif' : 'Aktif' }}
                                        </button>
                                        
                                        <!-- Delete Button -->
                                        @if($user->id !== auth()->id())
                                        <button onclick="deleteUser({{ $user->id }})" 
                                                class="inline-flex items-center px-3 py-2 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 transition-all duration-200 shadow-sm hover:shadow-md"
                                                title="Hapus User">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-users text-2xl text-gray-400"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada user ditemukan</h3>
                                        <p class="text-gray-500 mb-4">Coba ubah filter pencarian atau tambahkan user baru</p>
                                        <a href="{{ route('admin.users.create') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah User Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-center">
                        {{ $users->links() }}
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="modal-content">
        <div class="p-8">
            <!-- Header with Icon -->
            <div class="flex items-center justify-center mb-6">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
            </div>
            
            <!-- Content -->
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-900 mb-3">Konfirmasi Hapus</h3>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Apakah Anda yakin ingin menghapus user ini?<br>
                    <span class="text-red-600 font-medium">Tindakan ini tidak dapat dibatalkan.</span>
                </p>
                
                <!-- Action Buttons -->
                <div class="flex space-x-4">
                    <button onclick="closeDeleteModal()" 
                            class="modal-button flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold border border-gray-200">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <form id="delete-form" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="modal-button w-full bg-red-600 text-white px-6 py-3 rounded-xl hover:bg-red-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
    
    const colors = {
        success: 'bg-green-500 text-white',
        error: 'bg-red-500 text-white',
        warning: 'bg-yellow-500 text-white',
        info: 'bg-blue-500 text-white'
    };
    
    const icons = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-circle',
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };
    
    notification.className += ` ${colors[type]}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="${icons[type]} mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Delete confirmation modal
function showDeleteConfirmation(count, callback) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="bulk-modal-content">
            <div class="p-8">
                <!-- Header with Icon -->
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Konfirmasi Hapus Massal</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Apakah Anda yakin ingin menghapus <span class="font-semibold text-red-600">${count} user</span>?<br>
                        <span class="text-red-600 font-medium">Tindakan ini tidak dapat dibatalkan.</span>
                    </p>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        <button id="cancel-bulk-delete" class="modal-button flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold border border-gray-200">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button id="confirm-bulk-delete" class="modal-button flex-1 bg-red-600 text-white px-6 py-3 rounded-xl hover:bg-red-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                            <i class="fas fa-trash mr-2"></i>Hapus ${count} User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Animate modal in
    setTimeout(() => {
        const modalContent = document.getElementById('bulk-modal-content');
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Add event listeners
    document.getElementById('cancel-bulk-delete').addEventListener('click', () => {
        const modalContent = document.getElementById('bulk-modal-content');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.remove();
        }, 300);
    });
    
    document.getElementById('confirm-bulk-delete').addEventListener('click', () => {
        const modalContent = document.getElementById('bulk-modal-content');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.remove();
            callback();
        }, 300);
    });
}

// Select all functionality
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

document.getElementById('select-all-header').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    document.getElementById('select-all').checked = this.checked;
});

// Toggle active status
function toggleActive(userId) {
    fetch(`/admin/users/${userId}/toggle-active`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showNotification('Gagal mengubah status user', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan', 'error');
    });
}

// Delete user
function deleteUser(userId) {
    const modal = document.getElementById('delete-modal');
    const modalContent = document.getElementById('modal-content');
    
    document.getElementById('delete-form').action = `/admin/users/${userId}`;
    modal.classList.remove('hidden');
    
    // Animate modal in
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    const modalContent = document.getElementById('modal-content');
    
    // Animate modal out
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Bulk action form
document.getElementById('bulk-form').addEventListener('submit', function(e) {
    const selectedUsers = document.querySelectorAll('.user-checkbox:checked');
    const action = document.getElementById('bulk-action').value;
    
    if (selectedUsers.length === 0) {
        e.preventDefault();
        showNotification('Pilih user yang akan diproses', 'warning');
        return;
    }
    
    if (!action) {
        e.preventDefault();
        showNotification('Pilih aksi yang akan dilakukan', 'warning');
        return;
    }
    
    if (action === 'delete') {
        e.preventDefault();
        showDeleteConfirmation(selectedUsers.length, () => {
            document.getElementById('bulk-form').submit();
        });
    }
});
</script>
@endsection

@push('styles')
<style>
    /* Modern Admin Users Page Styling */
    .action-buttons {
        display: flex !important;
        flex-wrap: wrap;
        gap: 6px;
        align-items: center;
    }
    
    .action-buttons a,
    .action-buttons button {
        display: inline-flex !important;
        visibility: visible !important;
        opacity: 1 !important;
        min-width: 70px;
        white-space: nowrap;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .action-buttons a:hover,
    .action-buttons button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Ensure icons are visible */
    .action-buttons i {
        display: inline-block !important;
        visibility: visible !important;
        font-size: 0.75rem;
    }
    
    /* Table row hover effects */
    .table-row-hover:hover {
        background-color: #f8fafc;
        transform: scale(1.001);
    }
    
    /* Statistics cards hover effect */
    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    /* Custom scrollbar for table */
    .table-container::-webkit-scrollbar {
        height: 6px;
    }
    
    .table-container::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .table-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    .table-container::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Mobile responsive adjustments */
    @media (max-width: 640px) {
        .action-buttons {
            flex-direction: column;
            gap: 4px;
        }
        
        .action-buttons a,
        .action-buttons button {
            width: 100%;
            justify-content: center;
            min-width: auto;
        }
        
        .stat-card {
            padding: 1rem;
        }
    }
    
    /* Loading states */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    /* Success/Error states */
    .success-flash {
        animation: slideInDown 0.3s ease;
    }
    
    .error-flash {
        animation: slideInDown 0.3s ease;
    }
    
    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Modal animations */
    .modal-backdrop {
        backdrop-filter: blur(4px);
    }
    
    .modal-content {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .modal-content.scale-95 {
        transform: scale(0.95);
    }
    
    .modal-content.scale-100 {
        transform: scale(1);
    }
    
    .modal-content.opacity-0 {
        opacity: 0;
    }
    
    .modal-content.opacity-100 {
        opacity: 1;
    }
    
    /* Button hover effects */
    .modal-button {
        transition: all 0.2s ease;
    }
    
    .modal-button:hover {
        transform: translateY(-1px);
    }
    
    .modal-button:active {
        transform: translateY(0);
    }
</style>
@endpush

<script>
// Add event listeners for user management actions
document.addEventListener('DOMContentLoaded', function() {
    // Listen for form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Dispatch custom event when user is created/updated
            if (form.action.includes('/users')) {
                if (form.method === 'POST') {
                    // User created
                    setTimeout(() => {
                        document.dispatchEvent(new CustomEvent('userCreated'));
                    }, 1000);
                } else if (form.method === 'PUT' || form.method === 'PATCH') {
                    // User updated
                    setTimeout(() => {
                        document.dispatchEvent(new CustomEvent('userUpdated'));
                    }, 1000);
                }
            }
        });
    });

    // Listen for delete actions
    const deleteButtons = document.querySelectorAll('[data-action="delete"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            setTimeout(() => {
                document.dispatchEvent(new CustomEvent('userDeleted'));
            }, 1000);
        });
    });

    // Listen for toggle actions
    const toggleButtons = document.querySelectorAll('[data-action="toggle"]');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            setTimeout(() => {
                document.dispatchEvent(new CustomEvent('userUpdated'));
            }, 1000);
        });
    });
});
</script>
