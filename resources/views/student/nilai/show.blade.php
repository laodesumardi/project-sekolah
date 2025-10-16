@extends('student.layouts.app')

@section('title', 'Detail Nilai ' . $subject->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('student.nilai.index') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <span class="sr-only">Nilai & Rapor</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Detail Nilai</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Detail Nilai {{ $subject->name }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ $subject->teacher }} • Kelas VII A
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
            <a href="{{ route('student.nilai.index') }}" 
               class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.293 9.293a1 1 0 011.414 0L12 10.586l1.293-1.293a1 1 0 111.414 1.414L13.414 12l1.293 1.293a1 1 0 01-1.414 1.414L12 13.414l-1.293 1.293a1 1 0 01-1.414-1.414L10.586 12 9.293 10.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Subject Stats -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Rata-rata</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $subjectStats['average'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Nilai Tertinggi</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $subjectStats['highest'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Nilai</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $subjectStats['total_grades'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade History Chart -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Grafik Perkembangan Nilai</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Perkembangan nilai {{ $subject->name }} dari waktu ke waktu
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Grafik akan ditampilkan di sini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grades List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Nilai {{ $subject->name }}</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ $subjectGrades->count() }} nilai ditemukan
            </p>
        </div>
        <ul class="divide-y divide-gray-200">
            @forelse($subjectGrades as $grade)
            <li>
                <div class="px-4 py-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center
                                    {{ $grade->grade >= 90 ? 'bg-green-100' : 
                                       ($grade->grade >= 80 ? 'bg-blue-100' : 
                                       ($grade->grade >= 70 ? 'bg-yellow-100' : 'bg-red-100')) }}">
                                    <span class="text-lg font-bold 
                                        {{ $grade->grade >= 90 ? 'text-green-600' : 
                                           ($grade->grade >= 80 ? 'text-blue-600' : 
                                           ($grade->grade >= 70 ? 'text-yellow-600' : 'text-red-600')) }}">
                                        {{ $grade->grade }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $grade->description }}</div>
                                <div class="text-sm text-gray-500">{{ $grade->period }} • {{ $grade->teacher }}</div>
                                <div class="text-xs text-gray-400">
                                    Semester {{ $grade->semester }} • {{ $grade->date->format('d M Y') }}
                                </div>
                                <div class="flex items-center mt-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-2">
                                        Bobot: {{ $grade->weight }}%
                                    </span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                        {{ $grade->status === 'final' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($grade->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $grade->grade >= 90 ? 'bg-green-100 text-green-800' : 
                                   ($grade->grade >= 80 ? 'bg-blue-100 text-blue-800' : 
                                   ($grade->grade >= 70 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                {{ $grade->grade >= 90 ? 'A' : 
                                   ($grade->grade >= 80 ? 'B' : 
                                   ($grade->grade >= 70 ? 'C' : 'D')) }}
                            </span>
                        </div>
                    </div>
                </div>
            </li>
            @empty
            <li>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada nilai</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada nilai untuk mata pelajaran ini.</p>
                </div>
            </li>
            @endforelse
        </ul>
    </div>

    <!-- Teacher Feedback -->
    @if($teacherFeedback->count() > 0)
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Feedback Guru</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Komentar dan saran dari {{ $subject->teacher }}
            </p>
        </div>
        <div class="px-4 pb-5 sm:px-6">
            <div class="space-y-4">
                @foreach($teacherFeedback as $feedback)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-800">{{ $feedback->feedback }}</p>
                            <p class="mt-1 text-xs text-blue-600">{{ $feedback->date->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<script>
// Simple chart implementation
function drawGradeChart() {
    const grades = @json($gradeHistory);
    const ctx = document.getElementById('gradeChart');
    
    if (ctx && grades.length > 0) {
        // Chart implementation would go here
        console.log('Drawing grade chart with data:', grades);
    }
}

// Initialize chart when page loads
document.addEventListener('DOMContentLoaded', function() {
    drawGradeChart();
});
</script>
@endsection









