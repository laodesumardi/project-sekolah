@props(['event', 'showDescription' => true, 'showLocation' => true, 'showTime' => true, 'showType' => true, 'size' => 'default', 'clickable' => true])

@php
    $sizeClasses = [
        'small' => 'p-3',
        'default' => 'p-4',
        'large' => 'p-6'
    ];
    
    $titleSizes = [
        'small' => 'text-sm',
        'default' => 'text-base',
        'large' => 'text-lg'
    ];
    
    $typeColors = [
        'activity' => 'bg-blue-100 text-blue-800 border-blue-200',
        'exam' => 'bg-red-100 text-red-800 border-red-200',
        'deadline' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'holiday' => 'bg-gray-100 text-gray-800 border-gray-200'
    ];
    
    $typeIcons = [
        'activity' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
        'exam' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
        'deadline' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'holiday' => 'M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9'
    ];
@endphp

<div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 {{ $clickable ? 'hover:border-blue-300 cursor-pointer' : '' }} {{ $sizeClasses[$size] }}"
     @if($clickable) onclick="window.location.href='{{ route('academic.calendar') }}'" @endif>
    <!-- Header -->
    <div class="flex items-start justify-between mb-3">
        <div class="flex-1">
            <h3 class="{{ $titleSizes[$size] }} font-semibold text-gray-900 mb-2 line-clamp-2">
                {{ $event->title }}
            </h3>
            
            @if($showType)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border {{ $typeColors[$event->event_type] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcons[$event->event_type] ?? $typeIcons['activity'] }}"></path>
                    </svg>
                    {{ ucfirst($event->event_type) }}
                </span>
            @endif
        </div>
    </div>

    <!-- Date & Time -->
    <div class="space-y-1 mb-3">
        <div class="flex items-center text-sm text-gray-600">
            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ $event->start_date->format('d F Y') }}
            @if($event->end_date && $event->end_date != $event->start_date)
                - {{ $event->end_date->format('d F Y') }}
            @endif
        </div>
        
        @if($showTime && $event->start_time)
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $event->start_time->format('H:i') }}
                @if($event->end_time)
                    - {{ $event->end_time->format('H:i') }}
                @endif
            </div>
        @endif
    </div>

    <!-- Description -->
    @if($showDescription && $event->description)
        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
            {{ Str::limit($event->description, 100) }}
        </p>
    @endif

    <!-- Location -->
    @if($showLocation && $event->location)
        <div class="flex items-center text-sm text-gray-600 mb-3">
            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ $event->location }}
        </div>
    @endif

    <!-- Footer -->
    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
        <div class="flex items-center text-xs text-gray-500">
            @if($event->is_all_day)
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Sepanjang hari
            @else
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $event->start_time ? $event->start_time->format('H:i') : 'Waktu tidak ditentukan' }}
            @endif
        </div>
        
        @if($clickable)
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        @endif
    </div>
</div>

