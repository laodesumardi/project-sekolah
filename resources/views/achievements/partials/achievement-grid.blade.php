@if($achievements->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($achievements as $achievement)
    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 border-{{ $achievement->level_color }}-500">
        <!-- Image Section -->
        <div class="relative h-48 overflow-hidden">
            @if($achievement->certificate_image)
            <img src="{{ $achievement->certificate_url }}" alt="{{ $achievement->title }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
            @elseif($achievement->trophy_image)
            <img src="{{ $achievement->trophy_url }}" alt="{{ $achievement->title }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
            @else
            <div class="w-full h-full bg-gradient-to-br from-[#13315c] to-[#1e4d8b] flex items-center justify-center">
                <i class="fas fa-trophy text-6xl text-white/50"></i>
            </div>
            @endif
            
            <!-- Level Badge -->
            <div class="absolute top-4 left-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-white bg-{{ $achievement->level_color }}-500/95 backdrop-blur-sm">
                    <i class="fas fa-trophy mr-1"></i>{{ strtoupper($achievement->achievement_level) }}
                </span>
            </div>
            
            <!-- Category Badge -->
            <div class="absolute top-4 right-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-white bg-black/70">
                    {{ $achievement->category_name }}
                </span>
            </div>
            
            <!-- Rank Badge (on hover) -->
            <div class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                <div class="bg-white rounded-full p-4 border-4 border-{{ $achievement->level_color }}-500">
                    <div class="text-2xl font-bold text-{{ $achievement->level_color }}-500">{{ $achievement->rank }}</div>
                </div>
            </div>
        </div>
        
        <!-- Content Section -->
        <div class="p-6">
            <h3 class="text-xl font-bold text-[#13315c] mb-2 line-clamp-2 hover:text-[#1e4d8b]">{{ $achievement->title }}</h3>
            <p class="text-gray-700 font-semibold mb-3 line-clamp-1">
                <i class="fas fa-calendar mr-2"></i>{{ $achievement->event_name }}
            </p>
            
            <!-- Meta Info Grid -->
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-calendar mr-2"></i>
                    <span>{{ $achievement->formatted_date }}</span>
                </div>
                @if($achievement->organizer)
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-building mr-2"></i>
                    <span class="truncate">{{ $achievement->organizer }}</span>
                </div>
                @endif
                @if($achievement->location)
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-map-pin mr-2"></i>
                    <span class="truncate">{{ $achievement->location }}</span>
                </div>
                @endif
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-users mr-2"></i>
                    <span>{{ $achievement->participant_type === 'individu' ? 'Individu' : ucfirst($achievement->participant_type) }}</span>
                </div>
            </div>
            
            @if($achievement->description)
            <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ strip_tags($achievement->description) }}</p>
            @endif
            
            <!-- Footer -->
            <div class="flex items-center justify-between">
                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-eye mr-1"></i>
                    <span>{{ $achievement->view_count }} views</span>
                </div>
                <a href="{{ route('achievements.show', $achievement->slug) }}" 
                   class="inline-flex items-center px-4 py-2 border-2 border-{{ $achievement->level_color }}-500 text-{{ $achievement->level_color }}-500 rounded-lg hover:bg-{{ $achievement->level_color }}-500 hover:text-white transition-colors">
                    Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<!-- Empty State -->
<div class="text-center py-16">
    <i class="fas fa-trophy text-6xl text-gray-400 mb-4"></i>
    <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada prestasi tersedia</h3>
    <p class="text-gray-500 mb-6">Silakan cek filter atau kata kunci</p>
    <a href="{{ route('achievements') }}" 
       class="inline-flex items-center px-4 py-2 bg-[#13315c] text-white rounded-lg hover:bg-[#1e4d8b] transition-colors">
        Reset Filter
    </a>
</div>
@endif









