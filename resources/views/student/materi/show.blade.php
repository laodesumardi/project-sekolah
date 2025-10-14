@extends('student.layouts.app')

@section('title', $material->title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('student.materi.index') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <span class="sr-only">Materi</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Detail Materi</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                {{ $material->title }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ $material->subject }} • {{ $material->teacher }} • {{ $material->created_at->format('d F Y') }}
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            <button onclick="toggleFavorite({{ $material->id }})" 
                    class="inline-flex items-center rounded-md bg-yellow-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                Favorit
            </button>
            <button onclick="downloadMaterial({{ $material->id }})" 
                    class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" clip-rule="evenodd" />
                </svg>
                Download
            </button>
        </div>
    </div>

    <!-- Material Info -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center
                            {{ $material->type === 'pdf' ? 'bg-red-100' : 
                               ($material->type === 'video' ? 'bg-blue-100' : 
                               ($material->type === 'presentation' ? 'bg-orange-100' : 
                               ($material->type === 'document' ? 'bg-green-100' : 'bg-gray-100'))) }}">
                            @if($material->type === 'pdf')
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            @elseif($material->type === 'video')
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                            @elseif($material->type === 'presentation')
                            <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1v-2zm8-8a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1zm0 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd" />
                            @else
                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                            @endif
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $material->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $material->subject }} • {{ $material->teacher }}</p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $material->difficulty === 'easy' ? 'bg-green-100 text-green-800' : 
                                   ($material->difficulty === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($material->difficulty) }}
                            </span>
                            <span class="text-sm text-gray-500">{{ $material->file_size }}</span>
                            <span class="text-sm text-gray-500">{{ $material->downloads }} download</span>
                            <span class="text-sm text-gray-500">{{ $material->views }} view</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst($material->type) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Material Content -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Description -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Deskripsi Materi</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <p class="text-sm text-gray-700">{{ $material->description }}</p>
                </div>
            </div>

            <!-- Tags -->
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tag</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach($material->tags as $tag)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            {{ $tag }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Comments -->
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Komentar</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="space-y-4">
                        @foreach($comments as $comment)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-600">{{ substr($comment->student_name, 0, 2) }}</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">{{ $comment->student_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $comment->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <p class="text-sm text-gray-700 mt-1">{{ $comment->comment }}</p>
                                @if($comment->is_helpful)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mt-1">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Membantu
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Add Comment Form -->
                    <div class="mt-6">
                        <form onsubmit="addComment(event, {{ $material->id }})">
                            <div class="flex space-x-3">
                                <input type="text" 
                                       id="comment" 
                                       name="comment" 
                                       placeholder="Tulis komentar..."
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                       required>
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Kirim
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Progress -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Progress</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm font-medium text-gray-900">
                                <span>Penyelesaian</span>
                                <span>{{ $progress['progress_percentage'] }}%</span>
                            </div>
                            <div class="mt-2 bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $progress['progress_percentage'] }}%"></div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            <p>Waktu yang dihabiskan: {{ $progress['time_spent'] }}</p>
                            <p>Terakhir diakses: {{ $progress['last_accessed']->format('d M Y H:i') }}</p>
                            <p>Status: {{ ucfirst($progress['completion_status']) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Materials -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Materi Terkait</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="space-y-3">
                        @foreach($relatedMaterials as $related)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $related->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $related->subject }}</p>
                                </div>
                            </div>
                            <button onclick="viewMaterial({{ $related->id }})" 
                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Lihat
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFavorite(materialId) {
    fetch('{{ route("student.materi.index") }}/' + materialId + '/favorite', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function downloadMaterial(materialId) {
    window.location.href = '{{ route("student.materi.index") }}/' + materialId + '/download';
}

function viewMaterial(materialId) {
    window.location.href = '{{ route("student.materi.index") }}/' + materialId;
}

function addComment(event, materialId) {
    event.preventDefault();
    
    const comment = document.getElementById('comment').value;
    
    fetch('{{ route("student.materi.index") }}/' + materialId + '/comment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            comment: comment
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endsection

