@extends('student.layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Profil Saya
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Kelola informasi pribadi dan akademik Anda
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            <a href="{{ route('student.profil.edit') }}" 
               class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                </svg>
                Edit Profil
            </a>
            <a href="{{ route('student.profil.security') }}" 
               class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                </svg>
                Keamanan
            </a>
        </div>
    </div>

    <!-- Profile Overview -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-20 w-20 rounded-full object-cover" 
                         src="{{ $profileData['photo'] }}" 
                         alt="{{ $profileData['name'] }}">
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">{{ $profileData['name'] }}</h3>
                    <p class="text-sm text-gray-500">{{ $profileData['email'] }}</p>
                    <div class="mt-2 flex items-center space-x-4">
                        <span class="text-sm text-gray-500">NIS: {{ $profileData['nis'] }}</span>
                        <span class="text-sm text-gray-500">•</span>
                        <span class="text-sm text-gray-500">NISN: {{ $profileData['nisn'] }}</span>
                    </div>
                </div>
                <div class="ml-auto">
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Kelengkapan Profil</div>
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['profile_completeness'] }}%</div>
                        <div class="w-24 bg-gray-200 rounded-full h-2 mt-1">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $stats['profile_completeness'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Dokumen Terverifikasi</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['documents_verified'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Verifikasi</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['documents_pending'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Login</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['login_count'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Usia Akun</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['account_age'] }} hari</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Tabs -->
    <div class="bg-white shadow rounded-lg">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-4" aria-label="Tabs">
                <button onclick="showTab('personal')" 
                        id="personal-tab"
                        class="tab-button active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                    Data Pribadi
                </button>
                <button onclick="showTab('academic')" 
                        id="academic-tab"
                        class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Data Akademik
                </button>
                <button onclick="showTab('parent')" 
                        id="parent-tab"
                        class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Data Orang Tua
                </button>
                <button onclick="showTab('documents')" 
                        id="documents-tab"
                        class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Dokumen
                </button>
            </nav>
        </div>

        <!-- Personal Data Tab -->
        <div id="personal-content" class="tab-content p-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Pribadi</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                            <dd class="text-sm text-gray-900">{{ $profileData['name'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-900">{{ $profileData['email'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                            <dd class="text-sm text-gray-900">{{ $profileData['phone'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="text-sm text-gray-900">{{ $profileData['address'] }}</dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tempat Lahir</dt>
                            <dd class="text-sm text-gray-900">{{ $profileData['birth_place'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                            <dd class="text-sm text-gray-900">{{ $profileData['birth_date'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                            <dd class="text-sm text-gray-900">{{ $profileData['gender'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Agama</dt>
                            <dd class="text-sm text-gray-900">{{ $profileData['religion'] }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Bio</h4>
                <p class="text-sm text-gray-900">{{ $profileData['bio'] }}</p>
            </div>
        </div>

        <!-- Academic Data Tab -->
        <div id="academic-content" class="tab-content p-6 hidden">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Akademik</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kelas Saat Ini</dt>
                            <dd class="text-sm text-gray-900">{{ $academicData['current_class'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tahun Masuk</dt>
                            <dd class="text-sm text-gray-900">{{ $academicData['entry_year'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Semester Aktif</dt>
                            <dd class="text-sm text-gray-900">{{ $academicData['active_semester'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Wali Kelas</dt>
                            <dd class="text-sm text-gray-900">{{ $academicData['homeroom_teacher'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status Siswa</dt>
                            <dd class="text-sm text-gray-900">{{ $academicData['student_status'] }}</dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Riwayat Kelas</h4>
                    <div class="space-y-3">
                        @foreach($academicData['class_history'] as $history)
                        <div class="border-l-4 border-blue-200 pl-4 py-2">
                            <div class="text-sm font-medium text-gray-900">{{ $history->year }}</div>
                            <div class="text-sm text-gray-500">{{ $history->class }} - {{ $history->semester }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Parent Data Tab -->
        <div id="parent-content" class="tab-content p-6 hidden">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Data Ayah</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama</dt>
                            <dd class="text-sm text-gray-900">{{ $parentData['father']['name'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Pekerjaan</dt>
                            <dd class="text-sm text-gray-900">{{ $parentData['father']['occupation'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                            <dd class="text-sm text-gray-900">{{ $parentData['father']['phone'] }}</dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Data Ibu</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama</dt>
                            <dd class="text-sm text-gray-900">{{ $parentData['mother']['name'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Pekerjaan</dt>
                            <dd class="text-sm text-gray-900">{{ $parentData['mother']['occupation'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                            <dd class="text-sm text-gray-900">{{ $parentData['mother']['phone'] }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Akun Orang Tua</h4>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email Orang Tua</dt>
                        <dd class="text-sm text-gray-900">{{ $parentData['parent_account']['email'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="text-sm text-gray-900">{{ $parentData['parent_account']['status'] }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Documents Tab -->
        <div id="documents-content" class="tab-content p-6 hidden">
            <div class="space-y-4">
                @foreach($documents as $document)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                {{ $document->status === 'verified' ? 'bg-green-100' : 'bg-yellow-100' }}">
                                @if($document->status === 'verified')
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $document->name }}</div>
                            <div class="text-sm text-gray-500">{{ $document->uploaded_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $document->status === 'verified' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($document->status) }}
                        </span>
                        <button class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                            Lihat
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Aktivitas Terbaru</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Aktivitas terbaru di akun Anda
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="space-y-3">
                @foreach($recentActivities as $activity)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                {{ $activity->type === 'profile_updated' ? 'bg-blue-100' : 
                                   ($activity->type === 'password_changed' ? 'bg-green-100' : 
                                   ($activity->type === 'document_uploaded' ? 'bg-yellow-100' : 'bg-purple-100')) }}">
                                @if($activity->type === 'profile_updated')
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                @elseif($activity->type === 'password_changed')
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                @elseif($activity->type === 'document_uploaded')
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                @else
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                @endif
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $activity->title }}</p>
                            <p class="text-sm text-gray-500">{{ $activity->description }}</p>
                            <p class="text-xs text-gray-400">{{ $activity->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.add('active', 'border-blue-500', 'text-blue-600');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
}

// Initialize with personal tab
document.addEventListener('DOMContentLoaded', function() {
    showTab('personal');
});
</script>
@endsection











