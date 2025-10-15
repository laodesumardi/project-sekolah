@extends('admin.layouts.app')

@section('title', 'Kelola Galeri')

@section('content')
<div class="p-3 sm:p-4 lg:p-6 space-y-4 sm:space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">Kelola Galeri</h1>
            <nav class="flex mt-1 sm:mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-xs sm:text-sm font-medium text-gray-700 hover:text-primary-600">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            <span class="hidden sm:inline">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 sm:w-6 sm:h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-xs sm:text-sm font-medium text-gray-500 md:ml-2">Galeri</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="mt-3 sm:mt-0 flex-shrink-0">
            <a href="{{ route('admin.gallery.create') }}" 
               class="inline-flex items-center px-3 sm:px-4 py-2 bg-primary-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors w-full sm:w-auto justify-center" 
               style="background-color: #13315c;">
                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="hidden sm:inline">Buat Album Baru</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 border-l-4" style="border-left-color: #13315c;">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20" style="color: #13315c;">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Album</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['total_albums'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6 border-l-4" style="border-left-color: #13315c;">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20" style="color: #13315c;">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Foto</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['total_photos'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6 border-l-4" style="border-left-color: #13315c;">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20" style="color: #13315c;">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Featured Albums</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['featured_albums'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6 border-l-4" style="border-left-color: #13315c;">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20" style="color: #13315c;">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Views</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ number_format($stats['total_views']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 lg:gap-4">
                <!-- Category Filter -->
                <select id="category-filter" class="block w-full sm:w-auto px-2 sm:px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-xs sm:text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select id="status-filter" class="block w-full sm:w-auto px-2 sm:px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-xs sm:text-sm">
                    <option value="">Semua Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>

                <!-- Featured Filter -->
                <select id="featured-filter" class="block w-full sm:w-auto px-2 sm:px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-xs sm:text-sm">
                    <option value="">Semua Featured</option>
                    <option value="featured">Featured</option>
                    <option value="not_featured">Not Featured</option>
                </select>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 lg:gap-4">
                <!-- Search -->
                <div class="relative flex-1 sm:flex-none">
                    <div class="absolute inset-y-0 left-0 pl-2 sm:pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="search-input" placeholder="Cari album..." 
                           class="block w-full pl-8 sm:pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-xs sm:text-sm">
                </div>

                <!-- Sort -->
                <select id="sort-select" class="block w-full sm:w-auto px-2 sm:px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-xs sm:text-sm">
                    <option value="recent">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="views">Paling Banyak Dilihat</option>
                    <option value="title_asc">Judul (A-Z)</option>
                    <option value="title_desc">Judul (Z-A)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Galleries Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Mobile View -->
        <div class="block sm:hidden">
            @forelse($galleries as $gallery)
            <div class="border-b border-gray-200 p-4">
                <div class="flex items-start space-x-3">
                    <input type="checkbox" class="gallery-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500 mt-1" value="{{ $gallery->id }}">
                    <div class="flex-shrink-0">
                        <div class="h-16 w-16 rounded-lg overflow-hidden">
                            <img src="{{ $gallery->cover_image_url }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover">
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900 truncate">{{ $gallery->title }}</h3>
                            <div class="flex items-center space-x-1">
                                @if($gallery->is_featured)
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                @endif
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $gallery->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $gallery->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($gallery->description, 60) }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center space-x-3 text-xs text-gray-500">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" style="background-color: #13315c; color: white;">
                                    {{ $gallery->category_name }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $gallery->total_photos }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $gallery->view_count }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <a href="{{ route('admin.gallery.show', $gallery) }}" 
                                   class="text-green-600 hover:text-green-900 p-1" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.gallery.edit', $gallery) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-1" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button onclick="deleteGallery({{ $gallery->id }})" 
                                        class="text-red-600 hover:text-red-900 p-1" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-2-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $gallery->formatted_date ?? $gallery->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada album galeri</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat album galeri baru.</p>
            </div>
            @endforelse
        </div>

        <!-- Desktop View -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Album</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Foto</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Featured</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($galleries as $gallery)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="gallery-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500" value="{{ $gallery->id }}">
                        </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                            <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-lg overflow-hidden">
                                <img src="{{ $gallery->cover_image_url }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover">
                            </div>
                        </td>
                        <td class="px-3 lg:px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 truncate max-w-xs">{{ $gallery->title }}</div>
                            <div class="text-xs sm:text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($gallery->description, 40) }}</div>
                        </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" style="background-color: #13315c; color: white;">
                                {{ $gallery->category_name }}
                            </span>
                        </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $gallery->total_photos }}
                            </div>
                        </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                            {{ $gallery->formatted_date ?? $gallery->created_at->format('d M Y') }}
                        </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $gallery->view_count }}
                            </div>
                        </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $gallery->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $gallery->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                            @if($gallery->is_featured)
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            @else
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            @endif
                        </td>
                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-1 sm:space-x-2">
                                <a href="{{ route('admin.gallery.show', $gallery) }}" 
                                   class="text-green-600 hover:text-green-900 p-1" title="Lihat Detail">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.gallery.edit', $gallery) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-1" title="Edit">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button onclick="deleteGallery({{ $gallery->id }})" 
                                        class="text-red-600 hover:text-red-900 p-1" title="Hapus">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-2-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada album galeri</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat album galeri baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($galleries->hasPages())
        <div class="bg-white px-3 sm:px-4 py-3 border-t border-gray-200">
            {{ $galleries->links() }}
        </div>
        @endif
    </div>

    <!-- Bulk Actions -->
    <div id="bulk-actions" class="hidden bg-white rounded-lg shadow p-3 sm:p-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <span class="text-xs sm:text-sm text-gray-700">
                <span id="selected-count">0</span> album dipilih
            </span>
            <div class="flex flex-wrap gap-2">
                <button onclick="bulkPublish()" class="px-2 sm:px-3 py-1 bg-green-600 text-white text-xs sm:text-sm rounded hover:bg-green-700">
                    Publish
                </button>
                <button onclick="bulkUnpublish()" class="px-2 sm:px-3 py-1 bg-yellow-600 text-white text-xs sm:text-sm rounded hover:bg-yellow-700">
                    Unpublish
                </button>
                <button onclick="bulkFeature()" class="px-2 sm:px-3 py-1 bg-blue-600 text-white text-xs sm:text-sm rounded hover:bg-blue-700">
                    Feature
                </button>
                <button onclick="bulkUnfeature()" class="px-2 sm:px-3 py-1 bg-gray-600 text-white text-xs sm:text-sm rounded hover:bg-gray-700">
                    Unfeature
                </button>
                <button onclick="bulkDelete()" class="px-2 sm:px-3 py-1 bg-red-600 text-white text-xs sm:text-sm rounded hover:bg-red-700">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Bulk Action Form -->
<form id="bulk-form" method="POST" style="display: none;">
    @csrf
</form>

<script>
// Filter and search functionality
document.getElementById('category-filter').addEventListener('change', filterGalleries);
document.getElementById('status-filter').addEventListener('change', filterGalleries);
document.getElementById('featured-filter').addEventListener('change', filterGalleries);
document.getElementById('search-input').addEventListener('input', debounce(filterGalleries, 500));
document.getElementById('sort-select').addEventListener('change', filterGalleries);

function filterGalleries() {
    const params = new URLSearchParams();
    
    const category = document.getElementById('category-filter').value;
    const status = document.getElementById('status-filter').value;
    const featured = document.getElementById('featured-filter').value;
    const search = document.getElementById('search-input').value;
    const sort = document.getElementById('sort-select').value;
    
    if (category) params.append('category', category);
    if (status) params.append('status', status);
    if (featured) params.append('featured', featured);
    if (search) params.append('search', search);
    if (sort) params.append('sort', sort);
    
    window.location.href = '{{ route("admin.gallery.index") }}?' + params.toString();
}

// Select all functionality
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.gallery-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActions();
});

// Individual checkbox change
document.querySelectorAll('.gallery-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.gallery-checkbox:checked');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    
    if (checkedBoxes.length > 0) {
        bulkActions.classList.remove('hidden');
        selectedCount.textContent = checkedBoxes.length;
    } else {
        bulkActions.classList.add('hidden');
    }
}

// Bulk actions
function bulkPublish() {
    performBulkAction('publish');
}

function bulkUnpublish() {
    performBulkAction('unpublish');
}

function bulkFeature() {
    performBulkAction('feature');
}

function bulkUnfeature() {
    performBulkAction('unfeature');
}

function bulkDelete() {
    if (confirm('Yakin ingin menghapus album yang dipilih?')) {
        performBulkAction('delete');
    }
}

function performBulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.gallery-checkbox:checked');
    const galleryIds = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (galleryIds.length === 0) return;
    
    const form = document.getElementById('bulk-form');
    form.action = '{{ route("admin.gallery.bulk-status") }}';
    
    // Add gallery IDs
    galleryIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'gallery_ids[]';
        input.value = id;
        form.appendChild(input);
    });
    
    // Add action
    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = action;
    form.appendChild(actionInput);
    
    form.submit();
}

// Delete single gallery
function deleteGallery(id) {
    if (confirm('Yakin ingin menghapus album ini?')) {
        const form = document.getElementById('delete-form');
        form.action = '{{ route("admin.gallery.destroy", ":id") }}'.replace(':id', id);
        form.submit();
    }
}

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endsection


