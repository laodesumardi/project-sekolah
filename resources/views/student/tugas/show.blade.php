@extends('student.layouts.app')

@section('title', $assignment->title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('student.tugas.index') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <span class="sr-only">Tugas & Ujian</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Detail Tugas</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                {{ $assignment->title }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ $assignment->subject }} • {{ $assignment->teacher }} • {{ $assignment->class }}
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            @if($assignment->status === 'open' && !$assignment->is_submitted)
            <button onclick="startAssignment({{ $assignment->id }})" 
                    class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                Mulai {{ $assignment->type === 'exam' ? 'Ujian' : 'Tugas' }}
            </button>
            @elseif($assignment->is_submitted)
            <span class="inline-flex items-center rounded-md bg-green-100 px-3 py-2 text-sm font-semibold text-green-800">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Sudah Dikumpulkan
            </span>
            @else
            <span class="inline-flex items-center rounded-md bg-red-100 px-3 py-2 text-sm font-semibold text-red-800">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                Ditutup
            </span>
            @endif
        </div>
    </div>

    <!-- Assignment Info -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center
                            {{ $assignment->type === 'assignment' ? 'bg-blue-100' : 
                               ($assignment->type === 'exam' ? 'bg-red-100' : 'bg-green-100') }}">
                            @if($assignment->type === 'assignment')
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            @elseif($assignment->type === 'exam')
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            @else
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @endif
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $assignment->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $assignment->subject }} • {{ $assignment->teacher }} • {{ $assignment->class }}</p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="text-sm text-gray-500">{{ $assignment->points }} poin</span>
                            <span class="text-sm text-gray-500">{{ ucfirst($assignment->difficulty) }}</span>
                            <span class="text-sm text-gray-500">
                                @if($assignment->due_date > now())
                                    Berakhir {{ $assignment->due_date->diffForHumans() }}
                                @else
                                    Terlambat {{ $assignment->due_date->diffForHumans() }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst(str_replace('_', ' ', $assignment->type)) }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $assignment->status === 'open' ? 'bg-green-100 text-green-800' : 
                           ($assignment->status === 'closed' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                        {{ ucfirst($assignment->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignment Details -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Description -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Deskripsi</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <p class="text-sm text-gray-700">{{ $assignment->description }}</p>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Instruksi</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <p class="text-sm text-gray-700">{{ $assignment->instructions }}</p>
                </div>
            </div>

            <!-- Attachments -->
            @if(count($assignment->attachments) > 0)
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Lampiran</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="space-y-2">
                        @foreach($assignment->attachments as $attachment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-900">{{ $attachment }}</span>
                            </div>
                            <button onclick="downloadAttachment('{{ $attachment }}')" 
                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Download
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Questions (for exams) -->
            @if($assignment->type === 'exam' && count($questions) > 0)
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Soal Ujian</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="space-y-4">
                        @foreach($questions as $question)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-900">Soal {{ $loop->iteration }}</span>
                                <span class="text-sm text-gray-500">{{ $question->points }} poin</span>
                            </div>
                            <p class="text-sm text-gray-700 mb-3">{{ $question->question }}</p>
                            @if($question->type === 'multiple_choice' && $question->options)
                            <div class="space-y-2">
                                @foreach($question->options as $option)
                                <div class="flex items-center">
                                    <input type="radio" name="q{{ $question->id }}" value="{{ $option }}" 
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label class="ml-3 text-sm text-gray-700">{{ $option }}</label>
                                </div>
                                @endforeach
                            </div>
                            @elseif($question->type === 'essay')
                            <textarea name="q{{ $question->id }}" rows="4" 
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                      placeholder="Tulis jawaban Anda di sini..."></textarea>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Assignment Info -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Tugas</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <dl class="divide-y divide-gray-200">
                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Mata Pelajaran</dt>
                            <dd class="text-gray-900">{{ $assignment->subject }}</dd>
                        </div>
                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Guru</dt>
                            <dd class="text-gray-900">{{ $assignment->teacher }}</dd>
                        </div>
                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Kelas</dt>
                            <dd class="text-gray-900">{{ $assignment->class }}</dd>
                        </div>
                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Poin</dt>
                            <dd class="text-gray-900">{{ $assignment->points }}</dd>
                        </div>
                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Tingkat Kesulitan</dt>
                            <dd class="text-gray-900">{{ ucfirst($assignment->difficulty) }}</dd>
                        </div>
                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Batas Waktu</dt>
                            <dd class="text-gray-900">{{ $assignment->due_date->format('d M Y H:i') }}</dd>
                        </div>
                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Status</dt>
                            <dd class="text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $assignment->status === 'open' ? 'bg-green-100 text-green-800' : 
                                       ($assignment->status === 'closed' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($assignment->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Submission Status -->
            @if($submission)
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Status Pengumpulan</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500">Dikumpulkan</span>
                            <span class="text-sm text-gray-900">{{ $submission->submitted_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500">Skor</span>
                            <span class="text-sm font-bold text-gray-900">{{ $submission->score }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500">Status</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ ucfirst($submission->status) }}
                            </span>
                        </div>
                        @if($submission->feedback)
                        <div class="mt-3">
                            <span class="text-sm font-medium text-gray-500">Feedback</span>
                            <p class="text-sm text-gray-700 mt-1">{{ $submission->feedback }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Related Assignments -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tugas Terkait</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="space-y-3">
                        @foreach($relatedAssignments as $related)
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
                            <a href="{{ route('student.tugas.show', $related->id) }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Lihat
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function startAssignment(assignmentId) {
    // Scroll to questions section if it exists
    const questionsSection = document.querySelector('[data-questions]');
    if (questionsSection) {
        questionsSection.scrollIntoView({ behavior: 'smooth' });
    } else {
        alert('Mulai mengerjakan tugas!');
    }
}

function downloadAttachment(filename) {
    // Simulate download
    alert('Downloading: ' + filename);
}

// Auto-save answers every 30 seconds
setInterval(function() {
    const answers = {};
    const inputs = document.querySelectorAll('input[type="radio"]:checked, textarea');
    inputs.forEach(input => {
        if (input.name.startsWith('q')) {
            answers[input.name] = input.value;
        }
    });
    
    if (Object.keys(answers).length > 0) {
        // Auto-save logic here
        console.log('Auto-saving answers:', answers);
    }
}, 30000);
</script>
@endsection





