@extends('layouts.app')

@section('title', 'Cek Status Pendaftaran PPDB')
@section('description', 'Cek status pendaftaran PPDB SMP Negeri 01 Namrole')

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
@endsection
