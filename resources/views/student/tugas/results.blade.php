@extends('student.layouts.app')

@section('title', 'Hasil ' . $assignment->title)

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
                            <a href="{{ route('student.tugas.show', $assignment->id) }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                                {{ $assignment->title }}
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Hasil</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Hasil {{ $assignment->title }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ $assignment->subject }} • {{ $assignment->teacher }} • {{ $assignment->class }}
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            <a href="{{ route('student.tugas.show', $assignment->id) }}" 
               class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.293 9.293a1 1 0 011.414 0L12 10.586l1.293-1.293a1 1 0 111.414 1.414L13.414 12l1.293 1.293a1 1 0 01-1.414 1.414L12 13.414l-1.293 1.293a1 1 0 01-1.414-1.414L10.586 12 9.293 10.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Tugas
            </a>
        </div>
    </div>

    <!-- Score Overview -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="text-center">
                <div class="text-6xl font-bold text-blue-600 mb-2">{{ $results['score'] }}</div>
                <div class="text-2xl font-semibold text-gray-900 mb-4">Skor Anda</div>
                <div class="text-lg text-gray-500">dari {{ $assignment->points }} poin maksimal</div>
            </div>
        </div>
    </div>

    <!-- Results Details -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main Results -->
        <div class="lg:col-span-2">
            <!-- Performance Summary -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Ringkasan Performa</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $results['correct_answers'] }}</div>
                            <div class="text-sm text-gray-500">Jawaban Benar</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-red-600">{{ $results['wrong_answers'] }}</div>
                            <div class="text-sm text-gray-500">Jawaban Salah</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $results['total_questions'] }}</div>
                            <div class="text-sm text-gray-500">Total Soal</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback -->
            @if($submission->feedback)
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Feedback Guru</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-800">{{ $submission->feedback }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Time Analysis -->
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Analisis Waktu</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Waktu yang Digunakan</div>
                            <div class="text-2xl font-bold text-gray-900">{{ $results['time_taken'] }}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Dikumpulkan Pada</div>
                            <div class="text-2xl font-bold text-gray-900">{{ $results['submitted_at']->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
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
                            <dt class="text-gray-500">Poin Maksimal</dt>
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
                    </dl>
                </div>
            </div>

            <!-- Performance Rating -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Rating Performa</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="text-center">
                        @php
                            $percentage = ($results['score'] / $assignment->points) * 100;
                            $rating = $percentage >= 90 ? 'Excellent' : 
                                     ($percentage >= 80 ? 'Good' : 
                                     ($percentage >= 70 ? 'Fair' : 'Needs Improvement'));
                            $ratingColor = $percentage >= 90 ? 'text-green-600' : 
                                         ($percentage >= 80 ? 'text-blue-600' : 
                                         ($percentage >= 70 ? 'text-yellow-600' : 'text-red-600'));
                        @endphp
                        <div class="text-4xl font-bold {{ $ratingColor }} mb-2">{{ $rating }}</div>
                        <div class="text-sm text-gray-500">{{ number_format($percentage, 1) }}% dari poin maksimal</div>
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Aksi Cepat</h3>
                </div>
                <div class="px-4 pb-5 sm:px-6">
                    <div class="space-y-3">
                        <a href="{{ route('student.tugas.index') }}" 
                           class="w-full inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.293 9.293a1 1 0 011.414 0L12 10.586l1.293-1.293a1 1 0 111.414 1.414L13.414 12l1.293 1.293a1 1 0 01-1.414 1.414L12 13.414l-1.293 1.293a1 1 0 01-1.414-1.414L10.586 12 9.293 10.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Lihat Semua Tugas
                        </a>
                        <button onclick="printResults()" 
                                class="w-full inline-flex items-center justify-center rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                            </svg>
                            Cetak Hasil
                        </button>
                        <button onclick="shareResults()" 
                                class="w-full inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3 3 0 000-2.319l4.94-2.47A3 3 0 0015 8z" />
                            </svg>
                            Bagikan Hasil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printResults() {
    window.print();
}

function shareResults() {
    if (navigator.share) {
        navigator.share({
            title: 'Hasil {{ $assignment->title }}',
            text: 'Saya mendapat skor {{ $results["score"] }} dari {{ $assignment->points }} poin!',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const text = `Saya mendapat skor {{ $results["score"] }} dari {{ $assignment->points }} poin untuk {{ $assignment->title }}!`;
        navigator.clipboard.writeText(text).then(() => {
            alert('Hasil telah disalin ke clipboard!');
        });
    }
}
</script>
@endsection




