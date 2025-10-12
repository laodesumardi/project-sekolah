@props(['achievement', 'showCategory' => true, 'showDate' => true, 'showDescription' => true, 'showParticipants' => true, 'showLevel' => true, 'size' => 'default'])

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
    
    $rankColors = [
        'Juara 1' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'Juara 2' => 'bg-gray-100 text-gray-800 border-gray-200',
        'Juara 3' => 'bg-orange-100 text-orange-800 border-orange-200',
        'Harapan' => 'bg-blue-100 text-blue-800 border-blue-200'
    ];
    
    $categoryColors = [
        'Akademik' => 'bg-blue-100 text-blue-800',
        'Olahraga' => 'bg-green-100 text-green-800',
        'Seni' => 'bg-purple-100 text-purple-800',
        'Lain-lain' => 'bg-gray-100 text-gray-800'
    ];
    
    $levelColors = [
        'Kecamatan' => 'bg-green-100 text-green-800',
        'Kabupaten' => 'bg-blue-100 text-blue-800',
        'Provinsi' => 'bg-purple-100 text-purple-800',
        'Nasional' => 'bg-red-100 text-red-800',
        'Internasional' => 'bg-yellow-100 text-yellow-800'
    ];
@endphp

<div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 {{ $sizeClasses[$size] }}">
    <!-- Header -->
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <h3 class="{{ $titleSizes[$size] }} font-semibold text-gray-900 mb-2 line-clamp-2">
                {{ $achievement->title }}
            </h3>
            
            @if($showCategory)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $categoryColors[$achievement->category] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $achievement->category }}
                </span>
            @endif
        </div>
        
        @if($achievement->is_featured)
            <div class="ml-2">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
            </div>
        @endif
    </div>

    <!-- Rank Badge -->
    <div class="mb-4">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold border-2 {{ $rankColors[$achievement->rank] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
            🏆 {{ $achievement->rank }}
        </span>
    </div>

    <!-- Description -->
    @if($showDescription && $achievement->description)
        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
            {{ Str::limit($achievement->description, 120) }}
        </p>
    @endif

    <!-- Details -->
    <div class="space-y-2 mb-4">
        @if($showDate)
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ $achievement->date->format('d F Y') }}
            </div>
        @endif

        @if($showLevel)
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $levelColors[$achievement->achievement_level] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $achievement->achievement_level }}
                </span>
            </div>
        @endif

        @if($showParticipants && $achievement->participant_names)
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                {{ $achievement->participant_names }}
            </div>
        @endif

        @if($achievement->competition_name)
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
                {{ $achievement->competition_name }}
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
        <div class="flex items-center text-xs text-gray-500">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ $achievement->created_at->diffForHumans() }}
        </div>
        
        @if($achievement->certificate)
            <a href="{{ asset('storage/' . $achievement->certificate) }}" 
               target="_blank"
               class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Sertifikat
            </a>
        @endif
    </div>
</div>

