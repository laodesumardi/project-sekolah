@extends('teacher.layouts.app')

@section('title', 'Keamanan & Privasi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Keamanan & Privasi</h1>
                <p class="text-gray-600 mt-1">Kelola keamanan akun dan pengaturan privasi Anda</p>
            </div>
            <a href="{{ route('teacher.profile.show') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200">
                Kembali
            </a>
        </div>
    </div>

    <!-- Security Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Change Password -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ubah Password</h3>
                <form action="{{ route('teacher.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('current_password') border-red-300 @enderror">
                            @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <input type="password" name="new_password" id="new_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('new_password') border-red-300 @enderror">
                            @error('new_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('new_password_confirmation') border-red-300 @enderror">
                            @error('new_password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kekuatan Password</label>
                            <div class="mt-2">
                                <div class="flex space-x-2">
                                    <div id="strength-1" class="h-2 w-full bg-gray-200 rounded"></div>
                                    <div id="strength-2" class="h-2 w-full bg-gray-200 rounded"></div>
                                    <div id="strength-3" class="h-2 w-full bg-gray-200 rounded"></div>
                                    <div id="strength-4" class="h-2 w-full bg-gray-200 rounded"></div>
                                </div>
                                <p id="strength-text" class="mt-1 text-sm text-gray-500">Masukkan password baru</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                                Ubah Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Active Sessions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sesi Aktif</h3>
                <div class="space-y-4">
                    @forelse($activeSessions as $session)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $session->device_type ?? 'Device' }}</p>
                                <p class="text-xs text-gray-500">{{ $session->browser ?? 'Browser' }} • {{ $session->os ?? 'OS' }}</p>
                                <p class="text-xs text-gray-400">{{ $session->location ?? 'Location' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($session->is_current)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Sesi Saat Ini
                            </span>
                            @else
                            <form action="{{ route('teacher.profile.logout-devices') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="session_id" value="{{ $session->id }}">
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Logout
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada sesi</h3>
                        <p class="mt-1 text-sm text-gray-500">Tidak ada sesi aktif yang ditemukan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Login History -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Login</h3>
                <div class="space-y-4">
                    @forelse($loginHistory as $login)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $login->ip_address ?? 'IP Address' }}</p>
                                <p class="text-xs text-gray-500">{{ $login->browser ?? 'Browser' }} • {{ $login->os ?? 'OS' }}</p>
                                <p class="text-xs text-gray-400">{{ $login->location ?? 'Location' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">{{ $login->created_at ?? now()->format('d M Y H:i') }}</p>
                            @if($login->is_suspicious ?? false)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Mencurigakan
                            </span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada riwayat</h3>
                        <p class="mt-1 text-sm text-gray-500">Tidak ada riwayat login yang ditemukan.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Two-Factor Authentication -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Autentikasi Dua Faktor</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">2FA Status</p>
                            <p class="text-xs text-gray-500">Tambahkan lapisan keamanan ekstra ke akun Anda</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" {{ $teacher->two_factor_enabled ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    
                    @if($teacher->two_factor_enabled)
                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-green-800">2FA telah diaktifkan</p>
                        </div>
                    </div>
                    @else
                    <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <p class="text-sm text-yellow-800">2FA belum diaktifkan</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Privacy Settings -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Privasi</h3>
                <form action="{{ route('teacher.profile.privacy') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Tampilkan Profile ke Siswa</p>
                                <p class="text-xs text-gray-500">Izinkan siswa melihat profile Anda</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="show_profile_to_students" class="sr-only peer" {{ $teacher->show_profile_to_students ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Tampilkan Email ke Guru Lain</p>
                                <p class="text-xs text-gray-500">Izinkan guru lain melihat email Anda</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="show_email_to_teachers" class="sr-only peer" {{ $teacher->show_email_to_teachers ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Izinkan Akses Orang Tua</p>
                                <p class="text-xs text-gray-500">Izinkan orang tua mengakses informasi Anda</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="allow_parent_access" class="sr-only peer" {{ $teacher->allow_parent_access ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Password strength checker
document.getElementById('new_password').addEventListener('input', function(e) {
    const password = e.target.value;
    const strength = checkPasswordStrength(password);
    
    // Update strength indicators
    for (let i = 1; i <= 4; i++) {
        const indicator = document.getElementById('strength-' + i);
        if (i <= strength.level) {
            indicator.className = 'h-2 w-full rounded ' + strength.color;
        } else {
            indicator.className = 'h-2 w-full bg-gray-200 rounded';
        }
    }
    
    // Update strength text
    document.getElementById('strength-text').textContent = strength.text;
    document.getElementById('strength-text').className = 'mt-1 text-sm ' + strength.textColor;
});

function checkPasswordStrength(password) {
    let score = 0;
    let feedback = [];
    
    if (password.length >= 8) score++;
    else feedback.push('minimal 8 karakter');
    
    if (/[a-z]/.test(password)) score++;
    else feedback.push('huruf kecil');
    
    if (/[A-Z]/.test(password)) score++;
    else feedback.push('huruf besar');
    
    if (/[0-9]/.test(password)) score++;
    else feedback.push('angka');
    
    if (/[^A-Za-z0-9]/.test(password)) score++;
    else feedback.push('karakter khusus');
    
    if (score <= 1) {
        return {
            level: 1,
            color: 'bg-red-500',
            text: 'Sangat lemah',
            textColor: 'text-red-600'
        };
    } else if (score <= 2) {
        return {
            level: 2,
            color: 'bg-orange-500',
            text: 'Lemah',
            textColor: 'text-orange-600'
        };
    } else if (score <= 3) {
        return {
            level: 3,
            color: 'bg-yellow-500',
            text: 'Sedang',
            textColor: 'text-yellow-600'
        };
    } else {
        return {
            level: 4,
            color: 'bg-green-500',
            text: 'Kuat',
            textColor: 'text-green-600'
        };
    }
}
</script>
@endsection

