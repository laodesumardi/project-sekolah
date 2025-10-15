@extends('admin.layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah User Baru</h1>
            <p class="text-gray-600">Buat akun pengguna baru untuk sistem sekolah</p>
        </div>
        <a href="{{ route('admin.users.index') }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="max-w-2xl">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role" name="role" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror">
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Guru</option>
                            <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Siswa</option>
                            <option value="parent" {{ old('role') === 'parent' ? 'selected' : '' }}>Orang Tua</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Avatar Upload -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Foto Profil</h3>
                
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <div id="avatar-preview" class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Foto Profil
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" 
                               onchange="previewAvatar(this)"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('avatar') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">JPG, PNG maksimal 2MB</p>
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Akun</h3>
                
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Akun Aktif
                    </label>
                </div>
                <p class="mt-1 text-sm text-gray-500">User dapat login dan menggunakan sistem</p>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.users.index') }}" 
                   class="inline-flex items-center px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            preview.innerHTML = `<img src="${e.target.result}" class="h-20 w-20 rounded-full object-cover" alt="Avatar Preview">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Password strength indicator
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strength = getPasswordStrength(password);
    updatePasswordStrength(strength);
});

function getPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    return strength;
}

function updatePasswordStrength(strength) {
    const indicator = document.getElementById('password-strength') || createPasswordStrengthIndicator();
    const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
    const labels = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
    
    indicator.className = `h-2 rounded ${colors[strength] || 'bg-gray-300'}`;
    indicator.style.width = `${(strength / 5) * 100}%`;
    
    const label = indicator.nextElementSibling;
    if (label) {
        label.textContent = labels[strength] || '';
    }
}

function createPasswordStrengthIndicator() {
    const passwordField = document.getElementById('password');
    const container = document.createElement('div');
    container.className = 'mt-2';
    container.innerHTML = `
        <div class="h-2 bg-gray-300 rounded">
            <div id="password-strength" class="h-2 rounded bg-gray-300"></div>
        </div>
        <p id="password-strength-label" class="text-sm text-gray-600 mt-1"></p>
    `;
    passwordField.parentNode.appendChild(container);
    return document.getElementById('password-strength');
}
</script>
@endsection
