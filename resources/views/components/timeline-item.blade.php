<div class="relative flex items-center timeline-item">
    <!-- Timeline Dot -->
    <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-primary-500 rounded-full border-4 border-white shadow-lg z-10"></div>
    
    <!-- Content -->
    <div class="w-1/2 {{ $attributes->get('class', '') }}">
        <div class="bg-white rounded-lg shadow-lg p-6 ml-8">
            <div class="text-primary-500 font-bold text-lg mb-2">{{ $attributes->get('year', '') }}</div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $attributes->get('title', '') }}</h3>
            <p class="text-gray-600 leading-relaxed">{{ $attributes->get('description', '') }}</p>
        </div>
    </div>
</div>