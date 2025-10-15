@if($facilities->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($facilities as $facility)
    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105 cursor-pointer group" onclick="window.location.href='{{ route('facilities.show', $facility->slug) }}'">
        <!-- Image Section -->
        <div class="relative overflow-hidden rounded-t-xl">
            <div class="aspect-w-16 aspect-h-9">
                <img 
                    src="{{ $facility->image_url }}" 
                    alt="{{ $facility->name }}" 
                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300"
                    loading="lazy"
                    onerror="this.src='{{ asset('images/placeholder-facility.jpg') }}'"
                >
            </div>
            
            <!-- Category Badge -->
            <div class="absolute top-4 right-4">
                <span class="bg-[#13315c] bg-opacity-90 text-white text-xs uppercase px-3 py-1 rounded">
                    {{ $facility->category_name }}
                </span>
            </div>
            
            <!-- Hover Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="p-6">
            <!-- Facility Name -->
            <h3 class="text-xl font-semibold text-[#13315c] mb-2 line-clamp-2">
                {{ $facility->name }}
            </h3>

            <!-- Location & Capacity -->
            <div class="flex flex-col space-y-2 mb-3">
                @if($facility->location)
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $facility->location }}</span>
                </div>
                @endif

                @if($facility->capacity)
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span>{{ $facility->getFormattedCapacity() }}</span>
                </div>
                @endif
            </div>

            <!-- Description -->
            <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                {{ Str::limit($facility->description, 120) }}
            </p>

            <!-- Status & View Counter -->
            <div class="flex items-center justify-between">
                <!-- Status Badge -->
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $facility->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $facility->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                </span>

                <!-- View Counter -->
                <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span>{{ number_format($facility->view_count) }}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
@if($facilities->hasPages())
<div class="mt-8">
    {{ $facilities->links() }}
</div>
@endif

@else
<div class="text-center py-12">
    <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
    </div>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada fasilitas ditemukan</h3>
    <p class="text-gray-500">Coba ubah filter atau kata kunci pencarian</p>
</div>
@endif



