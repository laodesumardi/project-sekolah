@props(['number', 'label', 'description' => ''])

<div class="stat-card bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    <div class="flex justify-center mb-4">
        <div class="bg-primary-50 p-4 rounded-full">
            {{ $slot }}
        </div>
    </div>
    
    <div class="counter-number text-3xl font-bold text-primary-500 mb-2" data-end="{{ $number }}">
        0
    </div>
    
    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $label }}</h3>
    
    @if($description)
        <p class="text-gray-600 text-sm">{{ $description }}</p>
    @endif
</div>
