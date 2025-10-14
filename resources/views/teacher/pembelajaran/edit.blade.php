@extends('teacher.layouts.app')

@section('title', 'Edit Konten Pembelajaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('teacher.pembelajaran.index') }}" class="text-gray-400 hover:text-gray-500">
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
                            <span class="ml-4 text-sm font-medium text-gray-500">Edit Konten</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Edit Konten Pembelajaran
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Edit konten pembelajaran yang sudah ada
            </p>
        </div>
    </div>

    <!-- Form -->
    <form id="learningForm" onsubmit="submitForm(event)" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Dasar</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Informasi dasar konten pembelajaran
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Pembelajaran</label>
                        <input type="text" name="title" id="title" required value="{{ $content->title }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                               placeholder="Masukkan judul pembelajaran">
                    </div>
                    <div>
                        <label for="subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                        <select name="subject_id" id="subject_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject }}" {{ $content->subject === $subject ? 'selected' : '' }}>{{ $subject }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="class_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                        <select name="class_id" id="class_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Pilih Kelas</option>
                            @foreach($classes as $class)
                            <option value="{{ $class }}" {{ $content->class === $class ? 'selected' : '' }}>{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipe Konten</label>
                        <select name="type" id="type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Pilih Tipe Konten</option>
                            <option value="interactive" {{ $content->type === 'interactive' ? 'selected' : '' }}>Pembelajaran Interaktif</option>
                            <option value="experiment" {{ $content->type === 'experiment' ? 'selected' : '' }}>Eksperimen Virtual</option>
                            <option value="presentation" {{ $content->type === 'presentation' ? 'selected' : '' }}>Presentasi</option>
                            <option value="practice" {{ $content->type === 'practice' ? 'selected' : '' }}>Praktik</option>
                            <option value="coding" {{ $content->type === 'coding' ? 'selected' : '' }}>Coding Challenge</option>
                            <option value="quiz" {{ $content->type === 'quiz' ? 'selected' : '' }}>Quiz</option>
                            <option value="simulation" {{ $content->type === 'simulation' ? 'selected' : '' }}>Simulasi</option>
                        </select>
                    </div>
                    <div>
                        <label for="difficulty" class="block text-sm font-medium text-gray-700">Tingkat Kesulitan</label>
                        <select name="difficulty" id="difficulty" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Pilih Tingkat Kesulitan</option>
                            <option value="easy" {{ $content->difficulty === 'easy' ? 'selected' : '' }}>Mudah</option>
                            <option value="medium" {{ $content->difficulty === 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="hard" {{ $content->difficulty === 'hard' ? 'selected' : '' }}>Sulit</option>
                        </select>
                    </div>
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700">Durasi (menit)</label>
                        <input type="number" name="duration" id="duration" required min="1" value="{{ $content->duration }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                               placeholder="Masukkan durasi dalam menit">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Deskripsi & Tujuan</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Deskripsi dan tujuan pembelajaran
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="space-y-6">
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Pembelajaran</label>
                        <textarea name="description" id="description" rows="4" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                  placeholder="Masukkan deskripsi pembelajaran">{{ $content->description }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tujuan Pembelajaran</label>
                        <div id="objectives-container">
                            @foreach($content->objectives as $index => $objective)
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" name="objectives[]" required value="{{ $objective }}"
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                       placeholder="Masukkan tujuan pembelajaran">
                                <button type="button" onclick="removeObjective(this)" 
                                        class="text-red-600 hover:text-red-900">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addObjective()" 
                                class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Tujuan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Pengaturan Tambahan</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Pengaturan tambahan untuk konten pembelajaran
                </p>
            </div>
            <div class="px-4 pb-5 sm:px-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                        <input type="text" name="tags" id="tags" value="{{ implode(', ', $content->tags) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                               placeholder="Masukkan tags (pisahkan dengan koma)">
                        <p class="mt-1 text-sm text-gray-500">Contoh: matematika, aljabar, interaktif</p>
                    </div>
                    <div>
                        <label for="prerequisites" class="block text-sm font-medium text-gray-700">Prasyarat</label>
                        <input type="text" name="prerequisites" id="prerequisites"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                               placeholder="Masukkan prasyarat pembelajaran">
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('teacher.pembelajaran.show', $content->id) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </a>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Update Konten
            </button>
        </div>
    </form>
</div>

<script>
function addObjective() {
    const container = document.getElementById('objectives-container');
    const newObjective = document.createElement('div');
    newObjective.className = 'flex items-center space-x-2 mb-2';
    newObjective.innerHTML = `
        <input type="text" name="objectives[]" required
               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
               placeholder="Masukkan tujuan pembelajaran">
        <button type="button" onclick="removeObjective(this)" 
                class="text-red-600 hover:text-red-900">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    `;
    container.appendChild(newObjective);
}

function removeObjective(button) {
    button.parentElement.remove();
}

async function submitForm(event) {
    event.preventDefault();
    
    const form = document.getElementById('learningForm');
    const formData = new FormData(form);
    
    // Show loading state
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memperbarui...';
    submitButton.disabled = true;
    
    try {
        const response = await fetch('{{ route("teacher.pembelajaran.update.post", $content->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                title: formData.get('title'),
                subject_id: formData.get('subject_id'),
                class_id: formData.get('class_id'),
                type: formData.get('type'),
                description: formData.get('description'),
                objectives: formData.getAll('objectives[]'),
                difficulty: formData.get('difficulty'),
                duration: formData.get('duration'),
                tags: formData.get('tags'),
                prerequisites: formData.get('prerequisites')
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert(data.message);
            window.location.href = '{{ route("teacher.pembelajaran.show", $content->id) }}';
        } else {
            alert(data.message || 'Gagal mengupdate konten pembelajaran.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal mengupdate konten pembelajaran. Silakan coba lagi.');
    } finally {
        // Restore button state
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    }
}
</script>
@endsection
