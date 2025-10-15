@extends('admin.layouts.app')

@section('title', 'Detail Fasilitas')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Page Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Fasilitas</h1>
                    <nav class="flex mt-2" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <a href="{{ route('admin.facilities.index') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">Fasilitas</a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-gray-500 md:ml-2">{{ $facility->name }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.facilities.edit', $facility) }}" class="bg-[#13315c] hover:bg-[#1e4d8b] text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('admin.facilities.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg flex items-center transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Image -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <img 
                        src="{{ $facility->image_url }}" 
                        alt="{{ $facility->name }}" 
                        class="w-full h-96 object-cover"
                        onerror="this.src='{{ asset('images/placeholder-facility.jpg') }}'"
                    >
                </div>
            </div>

            <!-- Right Column - Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <!-- Header -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-[#13315c] mb-2">{{ $facility->name }}</h1>
                        
                        <!-- Category Badge -->
                        <span class="inline-block bg-[#13315c] text-white text-sm uppercase px-3 py-1 rounded mb-4">
                            {{ $facility->category_name }}
                        </span>
                        
                        <!-- Status Badge -->
                        <div class="mb-4">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $facility->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    @if($facility->is_available)
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    @else
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    @endif
                                </svg>
                                {{ $facility->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="space-y-4 mb-6">
                        @if($facility->capacity)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Kapasitas</p>
                                <p class="font-semibold text-gray-900">{{ $facility->getFormattedCapacity() }}</p>
                            </div>
                        </div>
                        @endif

                        @if($facility->location)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Lokasi</p>
                                <p class="font-semibold text-gray-900">{{ $facility->location }}</p>
                            </div>
                        </div>
                        @endif

                        @if($facility->floor)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Lantai</p>
                                <p class="font-semibold text-gray-900">{{ $facility->floor }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Total Views</p>
                                <p class="font-semibold text-gray-900">{{ number_format($facility->view_count) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($facility->description)) !!}
                        </div>
                    </div>

                    <!-- Specifications -->
                    @if($facility->facilities_spec)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Spesifikasi & Fasilitas</h3>
                        <div class="space-y-2">
                            @foreach($facility->getSpecificationsArray() as $spec)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ trim($spec) }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Metadata -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Informasi Tambahan</h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Slug:</span>
                                <span class="font-mono">{{ $facility->slug }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Urutan:</span>
                                <span>{{ $facility->sort_order }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Dibuat:</span>
                                <span>{{ $facility->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Diupdate:</span>
                                <span>{{ $facility->updated_at->format('d M Y H:i') }}</span>
                            </div>
                            @if($facility->creator)
                            <div class="flex justify-between">
                                <span>Dibuat oleh:</span>
                                <span>{{ $facility->creator->name }}</span>
                            </div>
                            @endif
                            @if($facility->updater)
                            <div class="flex justify-between">
                                <span>Diupdate oleh:</span>
                                <span>{{ $facility->updater->name }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection