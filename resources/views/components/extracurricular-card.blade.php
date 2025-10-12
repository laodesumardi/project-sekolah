@props(['extracurricular', 'showCategory' => true, 'showSchedule' => true, 'showInstructor' => true, 'showParticipants' => true, 'showDescription' => true, 'showImages' => false, 'size' => 'default', 'clickable' => true])

@php
    $sizeClasses = [
        'small' => 'p-4',
        'default' => 'p-6',
        'large' => 'p-8'
    ];
    
    $titleSizes = [
        'small' => 'text-lg',
        'default' => 'text-xl',
        'large' => 'text-2xl'
    ];
    
    $iconSizes = [
        'small' => 'w-12 h-12',
        'default' => 'w-16 h-16',
        'large' => 'w-20 h-20'
    ];
    
    $categoryColors = [
        'Olahraga' => 'bg-green-100 text-green-800',
        'Seni' => 'bg-purple-100 text-purple-800',
        'Akademik' => 'bg-blue-100 text-blue-800',
        'Keagamaan' => 'bg-yellow-100 text-yellow-800',
        'Teknologi' => 'bg-indigo-100 text-indigo-800',
        'Lain-lain' => 'bg-gray-100 text-gray-800'
    ];
    
    $dayNames = [
        'monday' => 'Senin',
        'tuesday' => 'Selasa',
        'wednesday' => 'Rabu',
        'thursday' => 'Kamis',
        'friday' => 'Jumat',
        'saturday' => 'Sabtu',
        'sunday' => 'Minggu'
    ];
@endphp

<div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 {{ $clickable ? 'hover:border-blue-300 cursor-pointer' : '' }} {{ $sizeClasses[$size] }}"
     @if($clickable) onclick="window.location.href='{{ route('academic.extracurricular-detail', $extracurricular) }}'" @endif>
    <!-- Header -->
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <h3 class="{{ $titleSizes[$size] }} font-semibold text-gray-900 mb-2 line-clamp-2">
                {{ $extracurricular->name }}
            </h3>
            
            @if($showCategory)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $categoryColors[$extracurricular->category] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $extracurricular->category }}
                </span>
            @endif
        </div>
        
        @if($extracurricular->icon)
            <div class="ml-4 flex-shrink-0">
                <img src="{{ asset('storage/' . $extracurricular->icon) }}" 
                     alt="{{ $extracurricular->name }}" 
                     class="{{ $iconSizes[$size] }} rounded-lg object-cover">
            </div>
        @else
            <div class="ml-4 flex-shrink-0">
                <div class="{{ $iconSizes[$size] }} bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
        @endif
    </div>

    <!-- Status -->
    <div class="mb-4">
        @if($extracurricular->is_active)
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                Aktif
            </span>
        @else
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                Tidak Aktif
            </span>
        @endif
    </div>

    <!-- Description -->
    @if($showDescription && $extracurricular->description)
        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
            {{ Str::limit($extracurricular->description, 120) }}
        </p>
    @endif

    <!-- Details -->
    <div class="space-y-2 mb-4">
        @if($showSchedule)
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ $dayNames[$extracurricular->schedule_day] ?? ucfirst($extracurricular->schedule_day) }}
            </div>
            
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $extracurricular->schedule_time->format('H:i') }}
            </div>
        @endif

        @if($showInstructor && $extracurricular->instructor)
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Pembina: {{ $extracurricular->instructor->name }}
            </div>
        @endif

        @if($showParticipants && $extracurricular->max_participants)
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Maksimal {{ $extracurricular->max_participants }} peserta
            </div>
        @endif
    </div>

    <!-- Images Preview -->
    @if($showImages && $extracurricular->images->count() > 0)
        <div class="mb-4">
            <div class="flex space-x-2">
                @foreach($extracurricular->images->take(3) as $image)
                    <img src="{{ $image->thumbnail_url }}" 
                         alt="{{ $image->caption }}" 
                         class="w-12 h-12 rounded-lg object-cover">
                @endforeach
                @if($extracurricular->images->count() > 3)
                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-xs text-gray-500">+{{ $extracurricular->images->count() - 3 }}</span>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Footer -->
    @if($clickable)
        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <span class="text-xs text-gray-500">
                Klik untuk melihat detail
            </span>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </div>
    @endif
</div>

