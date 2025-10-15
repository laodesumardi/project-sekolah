<div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 group cursor-pointer" 
     onclick="window.location.href='{{ route('facilities.show', $facility) }}'"
     data-facility-id="{{ $facility->id }}">
    <!-- Image -->
    <div class="overflow-hidden">
        <img src="{{ $facility->image_url }}" 
             alt="{{ $facility->name }}" 
             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
    </div>
    
    <!-- Content -->
    <div class="p-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary-500 transition-colors duration-200">
                {{ $facility->name }}
            </h3>
            
            <!-- Status Badge -->
            @if($facility->is_available)
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Tersedia
                </span>
            @else
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    Tidak Tersedia
                </span>
            @endif
        </div>
        
        <!-- Category -->
        @if($facility->category)
            <div class="mb-2">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $facility->category_name }}
                </span>
            </div>
        @endif
        
        <!-- Description -->
        <p class="text-gray-600 text-sm mb-4">
            {{ Str::limit($facility->description, 100) }}
        </p>
        
        <!-- Capacity -->
        @if($facility->capacity)
            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                </svg>
                Kapasitas: {{ $facility->capacity }} orang
            </div>
        @endif
    </div>
</div>