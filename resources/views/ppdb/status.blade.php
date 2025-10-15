@extends('layouts.app')

@section('title', 'Cek Status Pendaftaran PPDB')
@section('description', 'Cek status pendaftaran PPDB SMP Negeri 01 Namrole')

@push('styles')
<style>
    /* Status Pendaftaran Styles */
    .status-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .status-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .status-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .status-card:hover::before {
        opacity: 1;
    }
    
    .status-icon {
        transition: transform 0.3s ease;
    }
    
    .status-card:hover .status-icon {
        transform: scale(1.1);
    }
    
    .status-text {
        transition: color 0.3s ease;
    }
    
    .status-card:hover .status-text {
        color: #1f2937;
    }
    
    /* Animation for status cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .status-card {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .status-card:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    /* Button hover effects */
    .status-button {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .status-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    .status-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .status-button:hover::before {
        left: 100%;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🔍 Cek Status Pendaftaran PPDB</h1>
            <p class="text-gray-600">SMP Negeri 01 Namrole - Tahun Ajaran {{ $setting->academicYear->year ?? date('Y') }}</p>
            
            <!-- Info Box -->
            <div class="mt-4 inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Masukkan nomor pendaftaran untuk melihat status terbaru
            </div>
        </div>

        <!-- Status Pendaftaran PPDB -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">📋 Status Pendaftaran PPDB</h2>
                
                @php
                    $status = $setting->getRegistrationStatus();
                    $daysUntilEnd = $setting->getDaysUntilEnd();
                    $daysUntilStart = $setting->getDaysUntilStart();
                @endphp
                
                @if($status === 'open')
                    <!-- Pendaftaran Sedang Berlangsung -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="status-card bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6">
                            <div class="flex items-center space-x-4">
                                <div class="status-icon w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="status-text text-xl font-bold text-green-800">Pendaftaran Sedang Berlangsung</h3>
                                    <p class="status-text text-green-700 font-semibold">Berakhir dalam {{ $daysUntilEnd }} hari</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="status-card bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
                            <div class="flex items-center space-x-4">
                                <div class="status-icon w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="status-text text-xl font-bold text-blue-800">Periode Pendaftaran</h3>
                                    <p class="status-text text-blue-700 font-semibold">{{ $setting->start_date->format('d M Y') }} - {{ $setting->end_date->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('ppdb.form') }}" 
                           class="status-button inline-flex items-center px-8 py-4 bg-yellow-500 hover:bg-yellow-600 text-black font-bold text-xl rounded-lg transition-colors duration-200 shadow-lg">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            MULAI PENDAFTARAN
                        </a>
                    </div>
                    
                @elseif($status === 'not_started')
                    <!-- Pendaftaran Belum Dimulai -->
                    <div class="status-card bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-8 text-center">
                        <div class="status-icon w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="status-text text-2xl font-bold text-yellow-800 mb-2">Pendaftaran Belum Dimulai</h3>
                        <p class="status-text text-lg text-yellow-700 mb-2">Pendaftaran akan dibuka pada {{ $setting->start_date->format('d F Y, H:i') }}</p>
                        <p class="status-text text-sm text-yellow-600">Dimulai dalam {{ $daysUntilStart }} hari</p>
                    </div>
                    
                @elseif($status === 'ended')
                    <!-- Pendaftaran Sudah Berakhir -->
                    <div class="status-card bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl p-8 text-center">
                        <div class="status-icon w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h3 class="status-text text-2xl font-bold text-red-800 mb-2">Pendaftaran Sudah Berakhir</h3>
                        <p class="status-text text-lg text-red-700 mb-2">Pendaftaran telah ditutup pada {{ $setting->end_date->format('d F Y, H:i') }}</p>
                        <p class="status-text text-sm text-red-600">Sudah berakhir {{ $setting->end_date->diffInDays(now()) }} hari yang lalu</p>
                    </div>
                    
                @elseif($status === 'inactive')
                    <!-- Pendaftaran Tidak Aktif -->
                    <div class="status-card bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-8 text-center">
                        <div class="status-icon w-16 h-16 bg-gray-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                            </svg>
                        </div>
                        <h3 class="status-text text-2xl font-bold text-gray-800 mb-2">Pendaftaran Tidak Aktif</h3>
                        <p class="status-text text-lg text-gray-700">Pendaftaran PPDB saat ini tidak aktif</p>
                    </div>
                    
                @else
                    <!-- Status Tidak Diketahui -->
                    <div class="status-card bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-8 text-center">
                        <div class="status-icon w-16 h-16 bg-gray-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="status-text text-2xl font-bold text-gray-800 mb-2">Status Tidak Diketahui</h3>
                        <p class="status-text text-lg text-gray-700">Status pendaftaran tidak dapat ditentukan</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Status Check Form -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Masukkan Nomor Pendaftaran</h2>
                
                <form method="POST" action="{{ route('ppdb.check-status') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="registration_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Pendaftaran
                        </label>
                        <input type="text" id="registration_number" name="registration_number" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="Masukkan nomor pendaftaran (contoh: PPDB20250001)"
                               value="{{ old('registration_number') }}">
                        @error('registration_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-primary-500 text-white font-bold text-lg rounded-lg hover:bg-primary-600 transition-colors duration-200 shadow-lg">
                            <svg class="w-6 h-6 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            CEK STATUS
                        </button>
                    </div>
                </form>

                <!-- Help Section -->
                <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Butuh Bantuan?</h3>
                    <p class="text-blue-800 text-sm mb-2">
                        Jika Anda mengalami kesulitan atau tidak menemukan nomor pendaftaran, silakan hubungi:
                    </p>
                    <div class="text-blue-800 text-sm space-y-1">
                        <p><strong>Email:</strong> ppdb@smpn01namrole.sch.id</p>
                        <p><strong>Telepon:</strong> (0913) 1234567</p>
                        <p><strong>Jam Layanan:</strong> Senin - Jumat, 08.00 - 16.00 WIT</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Information -->
        @if(session('registration'))
            @php $registration = session('registration'); @endphp
            <div class="max-w-2xl mx-auto mt-8">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Status Pendaftaran</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="font-semibold text-gray-700">Nomor Pendaftaran:</span>
                            <span class="text-primary-600 font-bold">{{ $registration->registration_number }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="font-semibold text-gray-700">Nama:</span>
                            <span class="text-gray-900">{{ $registration->full_name }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="font-semibold text-gray-700">Jalur Pendaftaran:</span>
                            <span class="text-gray-900">{{ ucfirst($registration->registration_path) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="font-semibold text-gray-700">Status:</span>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($registration->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($registration->status == 'verified') bg-blue-100 text-blue-800
                                @elseif($registration->status == 'accepted') bg-green-100 text-green-800
                                @elseif($registration->status == 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                @switch($registration->status)
                                    @case('pending') Menunggu Verifikasi @break
                                    @case('verified') Terverifikasi @break
                                    @case('accepted') Diterima @break
                                    @case('rejected') Ditolak @break
                                    @case('reserved') Cadangan @break
                                    @default {{ ucfirst($registration->status) }} @break
                                @endswitch
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="font-semibold text-gray-700">Tanggal Pendaftaran:</span>
                            <span class="text-gray-900">{{ $registration->created_at->format('d F Y, H:i') }}</span>
                        </div>
                        
                        @if($registration->verified_at)
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="font-semibold text-gray-700">Tanggal Verifikasi:</span>
                            <span class="text-gray-900">{{ $registration->verified_at->format('d F Y, H:i') }}</span>
                        </div>
                        @endif
                        
                        @if($registration->admin_notes)
                        <div class="py-2">
                            <span class="font-semibold text-gray-700 block mb-2">Catatan Admin:</span>
                            <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $registration->admin_notes }}</p>
                        </div>
                        @endif
                    </div>
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('ppdb.download-form', $registration->registration_number) }}" target="_blank"
                           class="inline-flex items-center px-6 py-3 bg-primary-500 text-white font-bold rounded-lg hover:bg-primary-600 transition-colors duration-200 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download Formulir
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to status cards
    const statusCards = document.querySelectorAll('.status-card');
    
    statusCards.forEach((card, index) => {
        // Add staggered animation
        card.style.animationDelay = `${index * 0.2}s`;
        
        // Add hover effects
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
            this.style.boxShadow = '0 12px 28px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        });
    });
    
    // Add pulse animation to status icons
    const statusIcons = document.querySelectorAll('.status-icon');
    
    statusIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.animation = 'pulse 0.6s ease-in-out';
        });
        
        icon.addEventListener('animationend', function() {
            this.style.animation = '';
        });
    });
    
    // Add shimmer effect to buttons
    const statusButtons = document.querySelectorAll('.status-button');
    
    statusButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.background = 'linear-gradient(45deg, #f59e0b, #fbbf24, #f59e0b)';
            this.style.backgroundSize = '200% 200%';
            this.style.animation = 'shimmer 1.5s ease-in-out';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.background = '';
            this.style.backgroundSize = '';
            this.style.animation = '';
        });
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    @keyframes shimmer {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .status-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .status-icon {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .status-text {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .status-button {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection
