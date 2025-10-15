@if($galleries->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
    @foreach($galleries as $gallery)
    <div class="group gallery-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 overflow-hidden cursor-pointer"
         onclick="window.location.href='{{ route('gallery.show', $gallery->slug) }}'">
        
        <!-- Cover Image Section -->
        <div class="relative overflow-hidden" style="aspect-ratio: 16/9;">
            <img 
                src="{{ $gallery->cover_image_url }}" 
                alt="{{ $gallery->title }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                loading="lazy"
                onerror="this.src='{{ asset('images/placeholder-gallery.jpg') }}'"
            >
            
            <!-- Photo Count Badge -->
            <div class="absolute top-4 right-4 bg-black/70 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                </svg>
                {{ $gallery->total_photos }} Foto
            </div>
            
            <!-- Category Badge -->
            <div class="absolute top-4 left-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white uppercase" style="background-color: #13315c;">
                    {{ $gallery->category_name }}
                </span>
            </div>
            
            <!-- Hover Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="absolute bottom-4 left-4 right-4">
                    <div class="text-white">
                        <h3 class="font-semibold text-lg mb-2 line-clamp-2">
                            {{ $gallery->title }}
                        </h3>
                        @if($gallery->description)
                        <p class="text-sm opacity-90 line-clamp-2">
                            {{ $gallery->description }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Content Section -->
        <div class="p-6">
            <!-- Title -->
            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-[#13315c] transition-colors" style="color: #13315c;">
                {{ $gallery->title }}
            </h3>
            
            <!-- Date & Location -->
            @if($gallery->date || $gallery->location)
            <div class="flex flex-wrap gap-4 mb-3 text-sm text-gray-600">
                @if($gallery->date)
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $gallery->formatted_date }}
                </span>
                @endif
                @if($gallery->location)
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $gallery->location }}
                </span>
                @endif
            </div>
            @endif
            
            <!-- Description -->
            @if($gallery->description)
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                {{ $gallery->description }}
            </p>
            @endif
            
            <!-- Meta Info -->
            <div class="flex justify-between items-center text-sm text-gray-500 pt-4 border-t border-gray-100">
                <span class="flex items-center bg-gray-50 px-3 py-1 rounded-full">
                    <svg class="w-4 h-4 mr-2 text-[#13315c]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $gallery->view_count }} views
                </span>
                <span class="flex items-center bg-gray-50 px-3 py-1 rounded-full">
                    <svg class="w-4 h-4 mr-2 text-[#13315c]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $gallery->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
        
        <!-- View Album Button (Hover State) -->
        <div class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 text-white p-6 text-center font-bold flex items-center justify-center bg-gradient-to-r from-[#13315c] to-blue-600">
            <span class="text-lg">Lihat Album</span>
            <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
@if($galleries->hasPages())
<div class="mt-12 flex justify-center">
    <nav class="flex items-center space-x-2">
        {{ $galleries->links() }}
    </nav>
</div>
@endif

@else
<!-- Empty State -->
<div class="text-center py-16">
    <div class="mx-auto w-32 h-32 text-gray-400 mb-6">
        <svg fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
        </svg>
    </div>
    <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum ada galeri tersedia</h3>
    <p class="text-lg text-gray-500 max-w-md mx-auto">Silakan cek kembali nanti untuk melihat koleksi foto terbaru</p>
</div>
@endif

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.aspect-w-4 {
    position: relative;
    padding-bottom: 75%; /* 4:3 aspect ratio */
}

.aspect-h-3 {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>
