@props(['teacher', 'showSubject' => true, 'showEducation' => true, 'showExperience' => true, 'showContact' => false, 'showExtracurriculars' => false, 'size' => 'default', 'clickable' => true])

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
    
    $photoSizes = [
        'small' => 'w-16 h-16',
        'default' => 'w-20 h-20',
        'large' => 'w-24 h-24'
    ];
@endphp

<div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 {{ $clickable ? 'hover:border-blue-300 cursor-pointer' : '' }} {{ $sizeClasses[$size] }}"
     @if($clickable) onclick="window.location.href='{{ route('academic.teacher-detail', $teacher) }}'" @endif>
    <!-- Header -->
    <div class="flex items-start space-x-4 mb-4">
        <!-- Photo -->
        <div class="flex-shrink-0">
            @if($teacher->photo)
                <img src="{{ asset('storage/' . $teacher->photo) }}" 
                     alt="{{ $teacher->name }}" 
                     class="{{ $photoSizes[$size] }} rounded-full object-cover">
            @else
                <div class="{{ $photoSizes[$size] }} bg-gray-200 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            @endif
        </div>
        
        <!-- Info -->
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="{{ $titleSizes[$size] }} font-semibold text-gray-900 mb-1 line-clamp-2">
                        {{ $teacher->name }}
                    </h3>
                    
                    @if($showSubject && $teacher->subject)
                        <p class="text-sm text-blue-600 font-medium mb-2">
                            {{ $teacher->subject }}
                        </p>
                    @endif
                    
                    <div class="flex items-center space-x-2">
                        @if($teacher->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Tidak Aktif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details -->
    <div class="space-y-3">
        @if($showEducation && $teacher->education)
            <div class="flex items-start text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span class="line-clamp-2">{{ $teacher->education }}</span>
            </div>
        @endif

        @if($showExperience && $teacher->years_of_experience)
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $teacher->years_of_experience }} tahun pengalaman
            </div>
        @endif

        @if($showContact)
            <div class="space-y-1">
                @if($teacher->email)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:{{ $teacher->email }}" class="hover:text-blue-600">{{ $teacher->email }}</a>
                    </div>
                @endif
                
                @if($teacher->phone)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <a href="tel:{{ $teacher->phone }}" class="hover:text-blue-600">{{ $teacher->phone }}</a>
                    </div>
                @endif
            </div>
        @endif

        @if($showExtracurriculars && $teacher->extracurriculars->count() > 0)
            <div class="pt-2 border-t border-gray-100">
                <p class="text-xs text-gray-500 mb-2">Ekstrakurikuler yang dibina:</p>
                <div class="flex flex-wrap gap-1">
                    @foreach($teacher->extracurriculars->take(3) as $extracurricular)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $extracurricular->name }}
                        </span>
                    @endforeach
                    @if($teacher->extracurriculars->count() > 3)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                            +{{ $teacher->extracurriculars->count() - 3 }} lainnya
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    @if($clickable)
        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500">
                    Klik untuk melihat profil lengkap
                </span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </div>
    @endif
</div>

