@extends('teacher.layouts.app')

@section('title', 'Manajemen Tugas')
@section('subtitle', 'Kelola tugas dan penilaian siswa')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Tugas</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola tugas dan penilaian siswa</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('teacher.assignments.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Buat Tugas Baru
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                <select id="class_id" name="class_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran</label>
                <select id="subject_id" name="subject_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Dipublikasikan</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Mendatang</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Assignments List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($assignments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submissions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($assignments as $assignment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-tasks text-blue-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $assignment->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($assignment->description, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $assignment->class->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $assignment->subject->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $assignment->due_date->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $assignment->due_date->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($assignment->is_published)
                                        @if($assignment->is_overdue)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Dipublikasikan
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-edit mr-1"></i>
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <span class="text-green-600 font-medium">{{ $assignment->graded_count }}</span>
                                        <span class="text-gray-500 mx-1">/</span>
                                        <span class="text-gray-900">{{ $assignment->submission_count }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $assignment->pending_count }} menunggu
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('teacher.assignments.show', $assignment) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('teacher.assignments.edit', $assignment) }}" 
                                           class="text-yellow-600 hover:text-yellow-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="togglePublish({{ $assignment->id }})" 
                                                class="text-green-600 hover:text-green-900">
                                            <i class="fas fa-{{ $assignment->is_published ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <form method="POST" action="{{ route('teacher.assignments.destroy', $assignment) }}" 
                                              class="inline" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $assignments->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-tasks text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada tugas</h3>
                <p class="text-gray-600 mb-6">Mulai dengan membuat tugas pertama Anda</p>
                <a href="{{ route('teacher.assignments.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Tugas Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function togglePublish(assignmentId) {
    fetch(`/guru/assignments/${assignmentId}/toggle-publish`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            location.reload();
        } else {
            showNotification(data.error || 'Terjadi kesalahan', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan', 'error');
    });
}
</script>
@endsection
