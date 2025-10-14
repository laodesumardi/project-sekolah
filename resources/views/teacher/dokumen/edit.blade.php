@extends('teacher.layouts.app')

@section('title', 'Edit Dokumen')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Edit Dokumen
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Edit informasi dokumen
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('teacher.dokumen.index') }}" 
               class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.293 9.293a1 1 0 011.414 0L12 10.586l1.293-1.293a1 1 0 111.414 1.414L13.414 12l1.293 1.293a1 1 0 01-1.414 1.414L12 13.414l-1.293 1.293a1 1 0 01-1.414-1.414L10.586 12l-1.293-1.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Batal
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('teacher.dokumen.update', $document->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Document Type -->
                <div>
                    <label for="document_type" class="block text-sm font-medium text-gray-700">
                        Jenis Dokumen <span class="text-red-500">*</span>
                    </label>
                    <select id="document_type" name="document_type" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('document_type') border-red-300 @enderror"
                            required>
                        <option value="">Pilih jenis dokumen</option>
                        <option value="ktp" {{ (old('document_type', $document->document_type) == 'ktp') ? 'selected' : '' }}>KTP</option>
                        <option value="ijazah" {{ (old('document_type', $document->document_type) == 'ijazah') ? 'selected' : '' }}>Ijazah</option>
                        <option value="certificate" {{ (old('document_type', $document->document_type) == 'certificate') ? 'selected' : '' }}>Sertifikat</option>
                        <option value="sk" {{ (old('document_type', $document->document_type) == 'sk') ? 'selected' : '' }}>SK (Surat Keputusan)</option>
                        <option value="cv" {{ (old('document_type', $document->document_type) == 'cv') ? 'selected' : '' }}>CV</option>
                        <option value="other" {{ (old('document_type', $document->document_type) == 'other') ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('document_type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Document Name -->
                <div>
                    <label for="document_name" class="block text-sm font-medium text-gray-700">
                        Nama Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="document_name" id="document_name" 
                           value="{{ old('document_name', $document->document_name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('document_name') border-red-300 @enderror"
                           placeholder="Masukkan nama dokumen"
                           required>
                    @error('document_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current File -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        File Saat Ini
                    </label>
                    <div class="mt-1 flex items-center space-x-3">
                        <div class="flex-shrink-0 h-10 w-10">
                            @php
                                $iconClass = match($document->document_type) {
                                    'ktp' => 'bg-red-100 text-red-600',
                                    'ijazah' => 'bg-blue-100 text-blue-600',
                                    'certificate' => 'bg-yellow-100 text-yellow-600',
                                    'sk' => 'bg-green-100 text-green-600',
                                    'cv' => 'bg-purple-100 text-purple-600',
                                    default => 'bg-gray-100 text-gray-600'
                                };
                                
                                $icon = match($document->document_type) {
                                    'ktp' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
                                    'ijazah' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
                                    'certificate' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                    'sk' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                    'cv' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                    default => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                                };
                            @endphp
                            <div class="h-10 w-10 rounded-full {{ $iconClass }} flex items-center justify-center">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $document->document_name }}</p>
                            <p class="text-sm text-gray-500">{{ $document->file_size_human }} • {{ $document->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <a href="{{ route('teacher.dokumen.download', $document->id) }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Download
                            </a>
                        </div>
                    </div>
                </div>

                <!-- New File Upload -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700">
                        Ganti File (Opsional)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload file baru</span>
                                    <input id="file" name="file" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF, JPG, PNG hingga 5MB</p>
                        </div>
                    </div>
                    @error('file')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Issue Date -->
                <div>
                    <label for="issue_date" class="block text-sm font-medium text-gray-700">
                        Tanggal Terbit
                    </label>
                    <input type="date" name="issue_date" id="issue_date" 
                           value="{{ old('issue_date', $document->issue_date?->format('Y-m-d')) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('issue_date') border-red-300 @enderror">
                    @error('issue_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expiry Date -->
                <div>
                    <label for="expiry_date" class="block text-sm font-medium text-gray-700">
                        Tanggal Kedaluwarsa
                    </label>
                    <input type="date" name="expiry_date" id="expiry_date" 
                           value="{{ old('expiry_date', $document->expiry_date?->format('Y-m-d')) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('expiry_date') border-red-300 @enderror">
                    @error('expiry_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('teacher.dokumen.index') }}" 
                       class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        Update Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// File upload preview
document.getElementById('file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const uploadArea = document.querySelector('.border-dashed');
        uploadArea.innerHTML = `
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-gray-600">${file.name}</p>
                <p class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
            </div>
        `;
    }
});
</script>
@endsection
