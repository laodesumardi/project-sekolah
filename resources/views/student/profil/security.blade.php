@extends('student.layouts.app')

@section('title', 'Pengaturan Keamanan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('student.profil.index') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <span class="sr-only">Profil</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Keamanan</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Pengaturan Keamanan
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Kelola keamanan akun dan privasi Anda
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('student.profil.index') }}" 
               class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.293 9.293a1 1 0 011.414 0L12 10.586l1.293-1.293a1 1 0 111.414 1.414L13.414 12l1.293 1.293a1 1 0 01-1.414 1.414L12 13.414l-1.293 1.293a1 1 0 01-1.414-1.414L10.586 12 9.293 10.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Change Password -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Ubah Password</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Ubah password untuk meningkatkan keamanan akun Anda
            </p>
        </div>
        <form id="changePasswordForm" class="px-4 pb-5 sm:px-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">
                        Password Saat Ini <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700">
                        Password Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="new_password" 
                           name="new_password" 
                           required
                           minlength="8"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                </div>
                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">
                        Konfirmasi Password Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="new_password_confirmation" 
                           name="new_password_confirmation" 
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
            </div>
            <div class="flex justify-end pt-4">
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>

    <!-- Active Sessions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Sesi Aktif</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Kelola sesi yang sedang aktif di akun Anda
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="space-y-4">
                @foreach($activeSessions as $session)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg {{ $session->is_current ? 'bg-blue-50 border-blue-200' : '' }}">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $session->is_current ? 'bg-blue-100' : 'bg-gray-100' }}">
                                @if($session->is_current)
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $session->device }}</div>
                            <div class="text-sm text-gray-500">{{ $session->location }}</div>
                            <div class="text-xs text-gray-400">{{ $session->ip_address }} • {{ $session->last_activity->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($session->is_current)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Sesi Saat Ini
                        </span>
                        @else
                        <button onclick="logoutSession({{ $session->id }})" 
                                class="text-red-600 hover:text-red-900 text-sm font-medium">
                            Keluar
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Login History -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Riwayat Login</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Riwayat login ke akun Anda
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($loginHistory as $history)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $history->device }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $history->location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $history->ip_address }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $history->login_time->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $history->status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($history->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Privacy Settings -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Pengaturan Privasi</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Kelola pengaturan privasi akun Anda
            </p>
        </div>
        <form id="privacyForm" class="px-4 pb-5 sm:px-6">
            @csrf
            <div class="space-y-4">
                <div class="flex items-center">
                    <input id="show_profile_to_students" 
                           name="show_profile_to_students" 
                           type="checkbox" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="show_profile_to_students" class="ml-2 block text-sm text-gray-900">
                        Tampilkan profil kepada siswa lain
                    </label>
                </div>
                <div class="flex items-center">
                    <input id="show_email_to_teachers" 
                           name="show_email_to_teachers" 
                           type="checkbox" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="show_email_to_teachers" class="ml-2 block text-sm text-gray-900">
                        Tampilkan email kepada guru
                    </label>
                </div>
                <div class="flex items-center">
                    <input id="allow_parent_access" 
                           name="allow_parent_access" 
                           type="checkbox" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="allow_parent_access" class="ml-2 block text-sm text-gray-900">
                        Izinkan akses orang tua
                    </label>
                </div>
                <div class="flex items-center">
                    <input id="two_factor_enabled" 
                           name="two_factor_enabled" 
                           type="checkbox" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="two_factor_enabled" class="ml-2 block text-sm text-gray-900">
                        Aktifkan autentikasi dua faktor
                    </label>
                </div>
            </div>
            <div class="flex justify-end pt-4">
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Change Password Form
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const button = this.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    
    // Validate passwords
    const newPassword = formData.get('new_password');
    const confirmPassword = formData.get('new_password_confirmation');
    
    if (newPassword !== confirmPassword) {
        alert('Konfirmasi password tidak cocok!');
        return;
    }
    
    if (newPassword.length < 8) {
        alert('Password minimal 8 karakter!');
        return;
    }
    
    // Show loading state
    button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengubah...';
    button.disabled = true;
    
    // Simulate password change
    setTimeout(() => {
        alert('Password berhasil diubah!');
        this.reset();
        button.innerHTML = originalText;
        button.disabled = false;
    }, 2000);
});

// Privacy Form
document.getElementById('privacyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const button = this.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyimpan...';
    button.disabled = true;
    
    // Simulate save
    setTimeout(() => {
        alert('Pengaturan privasi berhasil disimpan!');
        button.innerHTML = originalText;
        button.disabled = false;
    }, 1500);
});

// Logout Session
function logoutSession(sessionId) {
    if (confirm('Apakah Anda yakin ingin mengakhiri sesi ini?')) {
        // Show loading state
        alert('Sesi berhasil diakhiri!');
    }
}

// Password strength indicator
document.getElementById('new_password').addEventListener('input', function() {
    const password = this.value;
    const strength = calculatePasswordStrength(password);
    
    // You can add visual feedback here
    if (password.length > 0) {
        if (strength < 3) {
            this.style.borderColor = '#ef4444';
        } else if (strength < 5) {
            this.style.borderColor = '#f59e0b';
        } else {
            this.style.borderColor = '#10b981';
        }
    } else {
        this.style.borderColor = '#d1d5db';
    }
});

function calculatePasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    return strength;
}
</script>
@endsection









