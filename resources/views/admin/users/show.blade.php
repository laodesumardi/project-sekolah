@extends('admin.layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail User</h1>
            <p class="text-gray-600">Informasi lengkap pengguna</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <div class="mx-auto h-24 w-24 rounded-full overflow-hidden mb-4">
                        @if($user->avatar)
                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" 
                                 class="h-24 w-24 rounded-full object-cover" 
                                 alt="{{ $user->name }}">
                        @else
                            <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center">
                                <i class="fas fa-user text-gray-600 text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    
                    <div class="mt-4">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            @if($user->role === 'admin') bg-red-100 text-red-800
                            @elseif($user->role === 'teacher') bg-blue-100 text-blue-800
                            @elseif($user->role === 'student') bg-green-100 text-green-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <div class="mt-4">
                        <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full
                            @if($user->is_active) bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            <i class="fas fa-circle text-xs mr-1"></i>
                            {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 space-y-3">
                    <!-- Edit Button -->
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>
                        Edit User
                    </a>
                    
                    <!-- Toggle Status Button -->
                    <button onclick="toggleActive({{ $user->id }})" 
                            class="w-full px-4 py-2 rounded-lg transition-colors flex items-center justify-center
                            @if($user->is_active) bg-orange-600 hover:bg-orange-700 text-white
                            @else bg-green-600 hover:bg-green-700 text-white
                            @endif">
                        <i class="fas fa-toggle-{{ $user->is_active ? 'on' : 'off' }} mr-2"></i>
                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} User
                    </button>
                    
                    <!-- Delete Button -->
                    @if($user->id !== auth()->id())
                    <button onclick="deleteUser({{ $user->id }})" 
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-trash mr-2"></i>Hapus User
                    </button>
                    @endif
                    
                    <!-- Back to List Button -->
                    <a href="{{ route('admin.users.index') }}" 
                       class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-list mr-2"></i>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

        <!-- User Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Role</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($user->role) }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nomor Telepon</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->phone ?: '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status Akun</label>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($user->is_active)
                                <span class="text-green-600">Aktif</span>
                            @else
                                <span class="text-red-600">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email Verified</label>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($user->email_verified_at)
                                <span class="text-green-600">✓ Sudah</span>
                            @else
                                <span class="text-red-600">✗ Belum</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($user->address)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-500">Alamat</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->address }}</p>
                </div>
                @endif
            </div>

            <!-- Account Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Bergabung</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Terakhir Update</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d M Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">ID User</label>
                        <p class="mt-1 text-sm text-gray-900">#{{ $user->id }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Terakhir Login</label>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($user->last_login_at)
                                {{ $user->last_login_at->format('d M Y H:i') }}
                            @else
                                Belum pernah login
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Activity Log (if available) -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center text-sm">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user-plus text-blue-600"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-900">Akun dibuat</p>
                            <p class="text-gray-500">{{ $user->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center text-sm">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-edit text-green-600"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-900">Profil terakhir diupdate</p>
                            <p class="text-gray-500">{{ $user->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex items-center mb-4">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
            </div>
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Hapus</h3>
                <p class="text-sm text-gray-500 mb-4">Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex space-x-3">
                    <button onclick="closeDeleteModal()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <form id="delete-form" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle active status
function toggleActive(userId) {
    if (confirm('Apakah Anda yakin ingin mengubah status user ini?')) {
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
                alert('Gagal mengubah status user');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

// Delete user
function deleteUser(userId) {
    document.getElementById('delete-form').action = `/admin/users/${userId}`;
    document.getElementById('delete-modal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('delete-modal').classList.add('hidden');
}
</script>
@endsection
