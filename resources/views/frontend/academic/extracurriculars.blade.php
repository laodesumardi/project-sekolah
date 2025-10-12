@extends('layouts.app')

@section('title', 'Ekstrakurikuler - SMP Negeri 01 Namrole')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Akademik', 'url' => null],
    ['name' => 'Ekstrakurikuler', 'url' => null]
]" />

<!-- Page Header -->
<x-page-header 
    title="Ekstrakurikuler" 
    subtitle="Kembangkan bakat dan minat melalui berbagai kegiatan ekstrakurikuler yang menarik" 
/>

<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filter Pills -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-2 justify-center">
                <a href="{{ route('academic.extracurriculars') }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ !request('category') ? 'bg-primary-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    Semua
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('academic.extracurriculars', ['category' => $category->category]) }}" 
                       class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ request('category') === $category->category ? 'bg-primary-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                        {{ ucfirst($category->category) }} ({{ $category->count }})
                    </a>
                @endforeach
            </div>
        </div>

        @if($extracurriculars->count() > 0)
            <!-- Extracurriculars Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($extracurriculars as $extracurricular)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 cursor-pointer"
                         onclick="openExtracurricularModal({{ $extracurricular->id }})">
                        
                        <!-- Icon/Logo -->
                        <div class="h-48 bg-gradient-to-br from-primary-500 to-secondary flex items-center justify-center">
                            @if($extracurricular->icon)
                                <img src="{{ $extracurricular->icon_url }}" 
                                     alt="{{ $extracurricular->name }}"
                                     class="w-16 h-16 object-contain">
                            @else
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $extracurricular->name }}</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    {{ ucfirst($extracurricular->category) }}
                                </span>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $extracurricular->description }}
                            </p>

                            <!-- Schedule -->
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $extracurricular->formatted_schedule }}
                            </div>

                            <!-- Instructor -->
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Pembina: {{ $extracurricular->instructor->name }}
                            </div>

                            <!-- Max Participants -->
                            @if($extracurricular->max_participants)
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Kuota: {{ $extracurricular->max_participants }} peserta
                                </div>
                            @endif

                            <!-- Button -->
                            <a href="{{ route('academic.extracurricular-detail', $extracurricular) }}" 
                               class="block w-full bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600 transition-colors duration-200 text-center">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Ekstrakurikuler</h3>
                <p class="text-gray-600">Ekstrakurikuler akan segera ditambahkan.</p>
            </div>
        @endif
    </div>
</div>

<!-- Extracurricular Modal -->
<div id="extracurricularModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <!-- Close Button -->
                <button onclick="closeExtracurricularModal()" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Modal Content -->
                <div id="modalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openExtracurricularModal(extracurricularId) {
    // Show modal
    document.getElementById('extracurricularModal').classList.remove('hidden');
    
    // Load content via AJAX
    fetch(`/akademik/ekstrakurikuler/${extracurricularId}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('modalContent').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading extracurricular details:', error);
        });
}

function closeExtracurricularModal() {
    document.getElementById('extracurricularModal').classList.add('hidden');
}

// Close modal on background click
document.getElementById('extracurricularModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeExtracurricularModal();
    }
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeExtracurricularModal();
    }
});
</script>
@endsection
