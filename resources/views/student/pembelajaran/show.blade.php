@extends('student.layouts.app')

@section('title', $content->title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('student.pembelajaran.index') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <span class="sr-only">Pembelajaran</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Detail Pembelajaran</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                {{ $content->title }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ $content->subject }} • {{ $content->teacher }} • {{ $content->duration }}
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            @if($content->status === 'available')
            <button onclick="startLearning({{ $content->id }})" 
                    class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                Mulai Pembelajaran
            </button>
            @elseif($content->status === 'in_progress')
            <button onclick="continueLearning({{ $content->id }})" 
                    class="inline-flex items-center rounded-md bg-yellow-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                Lanjutkan Pembelajaran
            </button>
            @else
            <button onclick="reviewContent({{ $content->id }})" 
                    class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                Review Pembelajaran
            </button>
            @endif
        </div>
    </div>

    <!-- Content Info -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center
                            {{ $content->type === 'interactive' ? 'bg-blue-100' : 
                               ($content->type === 'experiment' ? 'bg-green-100' : 
                               ($content->type === 'presentation' ? 'bg-orange-100' : 
                               ($content->type === 'practice' ? 'bg-purple-100' : 
                               ($content->type === 'coding' ? 'bg-indigo-100' : 'bg-gray-100')))) }}">
                            @if($content->type === 'interactive')
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            @elseif($content->type === 'experiment')
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                            @elseif($content->type === 'presentation')
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v14a1 1 0 01-1 1H3a1 1 0 01-1-1V5a1 1 0 011-1h4zM9 6h6v2H9V6z" />
                            </svg>
                            @elseif($content->type === 'practice')
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            @elseif($content->type === 'coding')
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            @else
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            @endif
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $content->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $content->subject }} • {{ $content->teacher }}</p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $content->difficulty === 'easy' ? 'bg-green-100 text-green-800' : 
                                   ($content->difficulty === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($content->difficulty) }}
                            </span>
                            <span class="text-sm text-gray-500">{{ $content->duration }}</span>
                            <span class="text-sm text-gray-500">{{ $content->students_count }} siswa</span>
                            <span class="text-sm text-gray-500">Rating: {{ $content->rating }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst(str_replace('_', ' ', $content->type)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Details -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Description -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Deskripsi Pembelajaran</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <p class="text-sm text-gray-700">{{ $content->description }}</p>
                </div>
            </div>

            <!-- Learning Objectives -->
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tujuan Pembelajaran</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <ul class="list-disc list-inside space-y-2">
                        @foreach($content->objectives as $objective)
                        <li class="text-sm text-gray-700">{{ $objective }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Prerequisites -->
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Prasyarat</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <ul class="list-disc list-inside space-y-2">
                        @foreach($content->prerequisites as $prerequisite)
                        <li class="text-sm text-gray-700">{{ $prerequisite }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Learning Notes -->
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Catatan Pembelajaran</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="space-y-4">
                        @foreach($notes as $note)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700">{{ $note->note }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $note->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Add Note Form -->
                    <div class="mt-6">
                        <form onsubmit="saveNote(event, {{ $content->id }})">
                            <div class="flex space-x-3">
                                <input type="text" 
                                       id="note" 
                                       name="note" 
                                       placeholder="Tambah catatan pembelajaran..."
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                       required>
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quiz Section -->
            @if($quiz)
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Quiz Pembelajaran</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Test pemahaman Anda dengan quiz interaktif
                    </p>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="space-y-4">
                        @foreach($quiz['questions'] as $question)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">{{ $question->question }}</h4>
                            <div class="space-y-2">
                                @foreach($question->options as $option)
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="question_{{ $question->id }}" 
                                           value="{{ $option }}"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        <button onclick="submitQuiz({{ $content->id }})" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Submit Quiz
                        </button>
                    </div>
                </div>
            </div>
            @endif
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
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progress['progress_percentage'] }}%"></div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            <p>Waktu yang dihabiskan: {{ $progress['time_spent'] }}</p>
                            <p>Terakhir diakses: {{ $progress['last_accessed']->format('d M Y H:i') }}</p>
                            <p>Status: {{ ucfirst($progress['completion_status']) }}</p>
                            <p>Catatan: {{ $progress['notes_count'] }}</p>
                            <p>Bookmark: {{ $progress['bookmarks_count'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Content -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Konten Terkait</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="space-y-3">
                        @foreach($relatedContent as $related)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $related->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $related->subject }}</p>
                                </div>
                            </div>
                            <button onclick="viewContent({{ $related->id }})" 
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
function startLearning(contentId) {
    fetch('{{ route("student.pembelajaran.index") }}/' + contentId + '/start', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert('Pembelajaran dimulai!');
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function continueLearning(contentId) {
    alert('Melanjutkan pembelajaran...');
}

function reviewContent(contentId) {
    alert('Review pembelajaran...');
}

function viewContent(contentId) {
    window.location.href = '{{ route("student.pembelajaran.index") }}/' + contentId;
}

function saveNote(event, contentId) {
    event.preventDefault();
    
    const note = document.getElementById('note').value;
    
    fetch('{{ route("student.pembelajaran.index") }}/' + contentId + '/notes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            note: note
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function submitQuiz(contentId) {
    const answers = {};
    const radioButtons = document.querySelectorAll('input[type="radio"]:checked');
    
    radioButtons.forEach(button => {
        answers[button.name] = button.value;
    });
    
    fetch('{{ route("student.pembelajaran.index") }}/' + contentId + '/quiz', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            answers: answers
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert('Quiz berhasil disubmit! Skor: ' + data.score);
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endsection

