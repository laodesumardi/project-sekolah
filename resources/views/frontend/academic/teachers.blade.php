@extends('layouts.app')

@section('title', 'Tenaga Pendidik - SMP Negeri 01 Namrole')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Akademik', 'url' => null],
    ['name' => 'Tenaga Pendidik', 'url' => null]
]" />

<!-- Page Header -->
<x-page-header 
    title="Tenaga Pendidik" 
    subtitle="Guru-guru profesional yang mengajar di SMP Negeri 01 Namrole" 
/>

<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="flex-1">
                    <form method="GET" class="flex gap-4">
                        <div class="flex-1">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari guru atau mata pelajaran..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div class="w-48">
                            <select name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="">Semua Mata Pelajaran</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject }}" {{ request('subject') === $subject ? 'selected' : '' }}>
                                        {{ $subject }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" 
                                class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if($teachers->count() > 0)
            <!-- Teachers Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($teachers as $teacher)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 cursor-pointer"
                         onclick="openTeacherModal({{ $teacher->id }})">
                        
                        <!-- Profile Photo -->
                        <div class="h-48 bg-gradient-to-br from-primary-500 to-secondary flex items-center justify-center">
                            @if($teacher->user && $teacher->user->profile_photo_path)
                                <img src="{{ $teacher->user->profile_photo_url }}" 
                                     alt="{{ $teacher->name }}"
                                     class="w-24 h-24 rounded-full object-cover border-4 border-white">
                            @else
                                <div class="w-24 h-24 rounded-full bg-white flex items-center justify-center">
                                    <svg class="w-12 h-12 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $teacher->user ? $teacher->user->name : 'Unknown' }}</h3>
                            
                            @if($teacher->subject)
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    {{ $teacher->subject }}
                                </div>
                            @endif

                            @if($teacher->education)
                                <div class="flex items-center text-sm text-gray-600 mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    {{ $teacher->education }}
                                </div>
                            @endif

                            <a href="{{ route('academic.teacher-detail', $teacher) }}" 
                               class="block w-full bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600 transition-colors duration-200 text-center">
                                Lihat Profil
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data Guru</h3>
                <p class="text-gray-600">Data tenaga pendidik akan segera ditambahkan.</p>
            </div>
        @endif
    </div>
</div>

<!-- Teacher Modal -->
<div id="teacherModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <!-- Close Button -->
                <button onclick="closeTeacherModal()" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Modal Content -->
                <div id="teacherModalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openTeacherModal(teacherId) {
    // Show modal
    document.getElementById('teacherModal').classList.remove('hidden');
    
    // Load content via AJAX
    fetch(`/akademik/guru/${teacherId}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('teacherModalContent').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading teacher details:', error);
        });
}

function closeTeacherModal() {
    document.getElementById('teacherModal').classList.add('hidden');
}

// Close modal on background click
document.getElementById('teacherModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTeacherModal();
    }
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTeacherModal();
    }
});
</script>
@endsection
