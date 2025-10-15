@extends('student.layouts.app')

@section('title', 'Materi Pembelajaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Materi Pembelajaran
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Akses dan download materi pembelajaran dari semua mata pelajaran
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            <button type="button" 
                    onclick="refreshMaterials()"
                    class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                </svg>
                Refresh
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Materi</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_materials'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Download Hari Ini</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['downloaded_today'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.111a.563.563 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.563.563 0 01-.84-.61l1.285-5.111a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Favorit</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['favorites_count'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tingkat Penyelesaian</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['completion_rate'] }}%</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-0">
                <label for="search" class="block text-sm font-medium text-gray-700">Cari Materi</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ $search }}"
                       placeholder="Cari berdasarkan judul atau deskripsi..."
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
            </div>
            <div class="flex-1 min-w-0">
                <label for="subject" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                <select id="subject" name="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($filterOptions['subjects'] as $subjectOption)
                    <option value="{{ $subjectOption }}" {{ $subject === $subjectOption ? 'selected' : '' }}>{{ $subjectOption }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-0">
                <label for="type" class="block text-sm font-medium text-gray-700">Tipe File</label>
                <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    <option value="">Semua Tipe</option>
                    @foreach($filterOptions['types'] as $typeKey => $typeLabel)
                    <option value="{{ $typeKey }}" {{ $type === $typeKey ? 'selected' : '' }}>{{ $typeLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-0">
                <label for="sort" class="block text-sm font-medium text-gray-700">Urutkan</label>
                <select id="sort" name="sort" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    @foreach($filterOptions['sort_options'] as $sortKey => $sortLabel)
                    <option value="{{ $sortKey }}" {{ $sortBy === $sortKey ? 'selected' : '' }}>{{ $sortLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="button" 
                        onclick="applyFilters()"
                        class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Terapkan Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Access -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Recent Materials -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Materi Terbaru</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Materi yang baru diupload
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-3">
                    @foreach($recentMaterials as $material)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $material->title }}</p>
                                <p class="text-sm text-gray-500">{{ $material->subject }}</p>
                                <p class="text-xs text-gray-400">{{ $material->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <button onclick="viewMaterial({{ $material->id }})" 
                                class="text-green-600 hover:text-green-900 text-sm font-medium">
                            Lihat
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Favorite Materials -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Materi Favorit</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Materi yang sudah difavoritkan
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-3">
                    @foreach($favoriteMaterials as $material)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $material->title }}</p>
                                <p class="text-sm text-gray-500">{{ $material->subject }}</p>
                                <p class="text-xs text-gray-400">{{ ucfirst($material->type) }}</p>
                            </div>
                        </div>
                        <button onclick="viewMaterial({{ $material->id }})" 
                                class="text-green-600 hover:text-green-900 text-sm font-medium">
                            Lihat
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Upcoming Materials -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Materi Mendatang</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Materi yang akan segera tersedia
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-3">
                    @foreach($upcomingMaterials as $material)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $material->title }}</p>
                                <p class="text-sm text-gray-500">{{ $material->subject }} • {{ $material->teacher }}</p>
                                <p class="text-xs text-gray-400">{{ $material->scheduled_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            Akan Datang
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Materials List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Semua Materi</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ $materials->count() }} materi ditemukan
            </p>
        </div>
        <ul class="divide-y divide-gray-200">
            @forelse($materials as $material)
            <li>
                <div class="px-4 py-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                    {{ $material->type === 'pdf' ? 'bg-red-100' : 
                                       ($material->type === 'video' ? 'bg-blue-100' : 
                                       ($material->type === 'presentation' ? 'bg-orange-100' : 
                                       ($material->type === 'document' ? 'bg-green-100' : 'bg-gray-100'))) }}">
                                    @if($material->type === 'pdf')
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    @elseif($material->type === 'video')
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                    @elseif($material->type === 'presentation')
                                    <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1v-2zm8-8a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1zm0 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    @else
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                    @endif
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $material->title }}</div>
                                <div class="text-sm text-gray-500">{{ $material->subject }} • {{ $material->teacher }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $material->file_size }} • {{ $material->downloads }} download • {{ $material->views }} view
                                </div>
                                <div class="flex items-center mt-1">
                                    @foreach($material->tags as $tag)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-1">
                                        {{ $tag }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $material->difficulty === 'easy' ? 'bg-green-100 text-green-800' : 
                                   ($material->difficulty === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($material->difficulty) }}
                            </span>
                            <button onclick="toggleFavorite({{ $material->id }})" 
                                    class="text-yellow-600 hover:text-yellow-900 {{ $material->is_favorite ? 'text-yellow-500' : 'text-gray-400' }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                            <button onclick="downloadMaterial({{ $material->id }})" 
                                    class="text-green-600 hover:text-green-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </button>
                            <button onclick="viewMaterial({{ $material->id }})" 
                                    class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </li>
            @empty
            <li>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada materi</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada materi pembelajaran yang tersedia.</p>
                </div>
            </li>
            @endforelse
        </ul>
    </div>
</div>

<script>
function applyFilters() {
    const search = document.getElementById('search').value;
    const subject = document.getElementById('subject').value;
    const type = document.getElementById('type').value;
    const sort = document.getElementById('sort').value;
    
    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (subject) params.append('subject', subject);
    if (type) params.append('type', type);
    if (sort) params.append('sort', sort);
    
    window.location.href = '{{ route("student.materi.index") }}?' + params.toString();
}

function refreshMaterials() {
    location.reload();
}

function viewMaterial(materialId) {
    window.location.href = '{{ route("student.materi.index") }}/' + materialId;
}

function downloadMaterial(materialId) {
    window.location.href = '{{ route("student.materi.index") }}/' + materialId + '/download';
}

function toggleFavorite(materialId) {
    fetch('{{ route("student.materi.index") }}/' + materialId + '/favorite', {
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
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Auto-refresh every 10 minutes
setInterval(function() {
    location.reload();
}, 600000); // 10 minutes
</script>
@endsection







