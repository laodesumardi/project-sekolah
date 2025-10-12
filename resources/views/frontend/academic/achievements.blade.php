@extends('layouts.app')

@section('title', 'Prestasi - SMP Negeri 01 Namrole')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Akademik', 'url' => null],
    ['name' => 'Prestasi', 'url' => null]
]" />

<!-- Page Header -->
<x-page-header 
    title="Prestasi Sekolah" 
    subtitle="Prestasi dan pencapaian siswa SMP Negeri 01 Namrole" 
/>

<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Tahun</label>
                    <select name="year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Semua Tahun</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kategori</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-6 md:mt-0">
                    <button type="submit" 
                            class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        @if($achievements->count() > 0)
            <!-- Timeline -->
            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-4 md:left-1/2 transform md:-translate-x-px top-0 bottom-0 w-0.5 bg-primary-200"></div>

                @foreach($achievements as $achievement)
                    <div class="relative flex items-center mb-8">
                        <!-- Timeline Dot -->
                        <div class="flex-shrink-0 w-8 h-8 bg-primary-500 rounded-full border-4 border-white shadow-lg flex items-center justify-center z-10">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="ml-8 md:ml-16 w-full">
                            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $achievement->title }}</h3>
                                        <div class="flex flex-wrap gap-2 mb-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                                {{ $achievement->formatted_level }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-secondary-100 text-secondary-800">
                                                {{ ucfirst($achievement->category) }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $achievement->rank }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">{{ $achievement->date->format('d M Y') }}</p>
                                        <p class="text-sm text-gray-400">{{ $achievement->formatted_participant_type }}</p>
                                    </div>
                                </div>

                                @if($achievement->description)
                                    <p class="text-gray-700 mb-4">{{ $achievement->description }}</p>
                                @endif

                                <div class="border-t pt-4">
                                    <h4 class="font-medium text-gray-900 mb-2">Peserta:</h4>
                                    <p class="text-sm text-gray-600">{{ $achievement->participant_names }}</p>
                                    
                                    @if($achievement->competition_name)
                                        <div class="mt-2">
                                            <h4 class="font-medium text-gray-900 mb-1">Kompetisi:</h4>
                                            <p class="text-sm text-gray-600">{{ $achievement->competition_name }}</p>
                                        </div>
                                    @endif

                                    @if($achievement->organizer)
                                        <div class="mt-2">
                                            <h4 class="font-medium text-gray-900 mb-1">Penyelenggara:</h4>
                                            <p class="text-sm text-gray-600">{{ $achievement->organizer }}</p>
                                        </div>
                                    @endif
                                </div>

                                @if($achievement->certificate_image)
                                    <div class="mt-4 flex gap-2">
                                        <button onclick="openCertificateModal('{{ $achievement->certificate_url }}', '{{ $achievement->title }}')"
                                                class="inline-flex items-center px-3 py-2 bg-primary-500 text-white text-sm rounded-lg hover:bg-primary-600 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Lihat Sertifikat
                                        </button>
                                        
                                        <button onclick="shareAchievement('{{ $achievement->title }}', '{{ $achievement->formatted_level }}', '{{ $achievement->rank }}')"
                                                class="inline-flex items-center px-3 py-2 bg-secondary-500 text-white text-sm rounded-lg hover:bg-secondary-600 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                            </svg>
                                            Share
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Prestasi</h3>
                <p class="text-gray-600">Data prestasi akan segera ditambahkan.</p>
            </div>
        @endif
    </div>
</div>

<!-- Certificate Modal -->
<div id="certificateModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <!-- Close Button -->
                <button onclick="closeCertificateModal()" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Modal Content -->
                <div id="certificateModalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openCertificateModal(imageUrl, title) {
    // Show modal
    document.getElementById('certificateModal').classList.remove('hidden');
    
    // Populate modal content
    const content = `
        <div class="text-center">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">${title}</h3>
            <img src="${imageUrl}" alt="${title}" class="max-w-full h-auto rounded-lg shadow-lg">
        </div>
    `;
    
    document.getElementById('certificateModalContent').innerHTML = content;
}

function closeCertificateModal() {
    document.getElementById('certificateModal').classList.add('hidden');
}

function shareAchievement(title, level, rank) {
    const text = `🎉 Prestasi SMP Negeri 01 Namrole!\n\n${title}\n${level} - ${rank}\n\n#SMPNegeri01Namrole #Prestasi #Sekolah`;
    
    if (navigator.share) {
        navigator.share({
            title: 'Prestasi SMP Negeri 01 Namrole',
            text: text,
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(text).then(() => {
            alert('Teks prestasi telah disalin ke clipboard!');
        });
    }
}

// Close modal on background click
document.getElementById('certificateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCertificateModal();
    }
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCertificateModal();
    }
});

// Timeline animation
document.addEventListener('DOMContentLoaded', function() {
    const timelineItems = document.querySelectorAll('.relative.flex.items-center');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    timelineItems.forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(item);
    });
});
</script>
@endsection

