@extends('admin.layouts.app')

@section('title', 'Detail Album Galeri')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $gallery->title }}</h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('admin.gallery.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2">Galeri</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail Album</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('admin.gallery.edit', $gallery) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Album
            </a>
            <a href="{{ route('gallery.show', $gallery->slug) }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                Lihat di Frontend
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content (Left Column - 70%) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Album Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $gallery->title }}</h2>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: #13315c; color: white;">
                                {{ $gallery->category_name }}
                            </span>
                            @if($gallery->is_featured)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                ⭐ Featured
                            </span>
                            @endif
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gallery->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $gallery->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($gallery->description)
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Deskripsi:</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $gallery->description }}</p>
                </div>
                @endif

                <!-- Meta Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    @if($gallery->date)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-600">Tanggal:</span>
                        <span class="ml-2 font-medium">{{ $gallery->formatted_date }}</span>
                    </div>
                    @endif
                    @if($gallery->location)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-600">Lokasi:</span>
                        <span class="ml-2 font-medium">{{ $gallery->location }}</span>
                    </div>
                    @endif
                    @if($gallery->photographer)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-600">Fotografer:</span>
                        <span class="ml-2 font-medium">{{ $gallery->photographer }}</span>
                    </div>
                    @endif
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-600">Total Foto:</span>
                        <span class="ml-2 font-medium">{{ $gallery->total_photos }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-600">Total Views:</span>
                        <span class="ml-2 font-medium">{{ $gallery->view_count }}</span>
                    </div>
                </div>
            </div>

            <!-- Photos Grid -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Foto dalam Album ({{ $gallery->images->count() }})</h3>
                </div>

                @if($gallery->images->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($gallery->images as $index => $image)
                    <div class="relative group">
                        <div class="aspect-square overflow-hidden rounded-lg border border-gray-200">
                            <img src="{{ $image->thumbnail_url }}" 
                                 alt="{{ $image->title ?? $gallery->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                        </div>
                        
                        <!-- Image Info -->
                        <div class="mt-2 text-xs text-gray-600">
                            <p class="font-medium truncate">{{ $image->title ?? 'Tanpa judul' }}</p>
                            <p class="text-gray-500">{{ $image->formatted_size }}</p>
                        </div>
                        
                        <!-- Cover Badge -->
                        @if($image->is_cover)
                        <div class="absolute top-2 left-2 bg-yellow-400 text-white text-xs font-semibold px-2 py-1 rounded">
                            Cover
                        </div>
                        @endif
                        
                        <!-- Sort Order -->
                        <div class="absolute top-2 right-2 bg-primary-500 text-white text-xs font-semibold px-2 py-1 rounded" style="background-color: #13315c;">
                            #{{ $index + 1 }}
                        </div>
                        
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <div class="text-white text-center">
                                <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <p class="text-xs">Lihat Detail</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada foto</h3>
                    <p class="mt-1 text-sm text-gray-500">Album ini belum memiliki foto.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar (Right Column - 30%) -->
        <div class="space-y-6">
            <!-- Album Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Album</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Foto</span>
                        <span class="text-lg font-semibold text-gray-900">{{ $gallery->total_photos }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Views</span>
                        <span class="text-lg font-semibold text-gray-900">{{ $gallery->view_count }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gallery->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $gallery->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Featured</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gallery->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $gallery->is_featured ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Album Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Album</h3>
                
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-600">Dibuat oleh:</span>
                        <p class="text-sm font-medium">{{ $gallery->creator->name ?? 'Unknown' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Tanggal dibuat:</span>
                        <p class="text-sm font-medium">{{ $gallery->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Terakhir diupdate:</span>
                        <p class="text-sm font-medium">{{ $gallery->updated_at->format('d M Y H:i') }}</p>
                    </div>
                    @if($gallery->updater)
                    <div>
                        <span class="text-sm text-gray-600">Diupdate oleh:</span>
                        <p class="text-sm font-medium">{{ $gallery->updater->name }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.gallery.edit', $gallery) }}" 
                       class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium text-center block">
                        Edit Album
                    </a>
                    
                    <a href="{{ route('gallery.show', $gallery->slug) }}" 
                       target="_blank"
                       class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium text-center block">
                        Lihat di Frontend
                    </a>
                    
                    <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" class="inline-block w-full" onsubmit="return confirm('Yakin ingin menghapus album ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors font-medium">
                            Hapus Album
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



