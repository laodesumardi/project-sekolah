@extends('student.layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('student.profil.index') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <span class="sr-only">Profil</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Edit Profil</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Edit Profil
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui informasi pribadi Anda
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('student.profil.index') }}" 
               class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.293 9.293a1 1 0 011.414 0L12 10.586l1.293-1.293a1 1 0 111.414 1.414L13.414 12l1.293 1.293a1 1 0 01-1.414 1.414L12 13.414l-1.293 1.293a1 1 0 01-1.414-1.414L10.586 12 9.293 10.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Formulir Edit Profil</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Lengkapi informasi pribadi Anda
            </p>
        </div>
        <form id="editProfileForm" class="px-4 pb-5 sm:px-6" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <!-- Photo Upload -->
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <img id="photo-preview" 
                             class="h-20 w-20 rounded-full object-cover" 
                             src="{{ $student->profile_picture ? Storage::disk('public')->url($student->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($student->user->name) . '&background=3b82f6&color=ffffff&size=200' }}" 
                             alt="Profile Photo">
                    </div>
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700">
                            Foto Profil
                        </label>
                        <input type="file" 
                               id="photo" 
                               name="photo" 
                               accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ $user->name }}"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ $user->email }}"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            No. Telepon
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ $student->phone }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">
                            Jenis Kelamin
                        </label>
                        <select id="gender" 
                                name="gender"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ $student->gender === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $student->gender === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">
                        Alamat Lengkap
                    </label>
                    <textarea id="address" 
                              name="address" 
                              rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ $student->address }}</textarea>
                </div>

                <!-- Birth Information -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="birth_place" class="block text-sm font-medium text-gray-700">
                            Tempat Lahir
                        </label>
                        <input type="text" 
                               id="birth_place" 
                               name="birth_place" 
                               value="{{ $student->birth_place }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700">
                            Tanggal Lahir
                        </label>
                        <input type="date" 
                               id="birth_date" 
                               name="birth_date" 
                               value="{{ $student->birth_date ? $student->birth_date->format('Y-m-d') : '' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="religion" class="block text-sm font-medium text-gray-700">
                            Agama
                        </label>
                        <select id="religion" 
                                name="religion"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ $student->religion === 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ $student->religion === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ $student->religion === 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ $student->religion === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ $student->religion === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ $student->religion === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700">
                        Bio / Deskripsi Diri
                    </label>
                    <textarea id="bio" 
                              name="bio" 
                              rows="4"
                              maxlength="1000"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                              placeholder="Ceritakan sedikit tentang diri Anda...">{{ $student->bio }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Maksimal 1000 karakter</p>
                </div>

                <!-- Guidelines -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <h4 class="text-sm font-medium text-blue-900 mb-2">Panduan Edit Profil</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Pastikan informasi yang Anda berikan akurat dan terkini</li>
                        <li>• Foto profil akan ditampilkan di berbagai bagian sistem</li>
                        <li>• Email akan digunakan untuk notifikasi penting</li>
                        <li>• Informasi pribadi akan dijaga kerahasiaannya</li>
                        <li>• Perubahan akan disimpan secara otomatis</li>
                    </ul>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('student.profil.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Photo preview
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photo-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Bio character counter
document.getElementById('bio').addEventListener('input', function() {
    const maxLength = 1000;
    const currentLength = this.value.length;
    const remaining = maxLength - currentLength;
    
    if (remaining < 100) {
        this.style.borderColor = remaining < 10 ? '#ef4444' : '#f59e0b';
    } else {
        this.style.borderColor = '#d1d5db';
    }
});

// Form submission
document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const button = this.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    
    // Validate required fields
    const name = formData.get('name').trim();
    const email = formData.get('email').trim();
    
    if (!name || !email) {
        alert('Mohon lengkapi field yang wajib diisi!');
        return;
    }
    
    // Show loading state
    button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyimpan...';
    button.disabled = true;
    
    // Submit form via AJAX
    fetch('{{ route("student.profil.update") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error('HTTP error! status: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            alert('Profil berhasil diperbarui!');
            window.location.href = '{{ route("student.profil.index") }}';
        } else {
            console.error('Error response:', data);
            alert('Gagal memperbarui profil: ' + (data.message || 'Terjadi kesalahan'));
            button.innerHTML = originalText;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan profil: ' + error.message);
        button.innerHTML = originalText;
        button.disabled = false;
    });
});

// Auto-save draft (optional)
let draftTimer;
function autoSaveDraft() {
    clearTimeout(draftTimer);
    draftTimer = setTimeout(() => {
        const formData = new FormData(document.getElementById('editProfileForm'));
        const data = {
            name: formData.get('name'),
            email: formData.get('email'),
            phone: formData.get('phone'),
            address: formData.get('address'),
            birth_place: formData.get('birth_place'),
            birth_date: formData.get('birth_date'),
            gender: formData.get('gender'),
            religion: formData.get('religion'),
            bio: formData.get('bio'),
            timestamp: new Date().toISOString()
        };
        
        localStorage.setItem('profile_draft', JSON.stringify(data));
    }, 5000); // Auto-save every 5 seconds
}

// Add event listeners for auto-save
document.getElementById('name').addEventListener('input', autoSaveDraft);
document.getElementById('email').addEventListener('input', autoSaveDraft);
document.getElementById('phone').addEventListener('input', autoSaveDraft);
document.getElementById('address').addEventListener('input', autoSaveDraft);
document.getElementById('birth_place').addEventListener('input', autoSaveDraft);
document.getElementById('birth_date').addEventListener('change', autoSaveDraft);
document.getElementById('gender').addEventListener('change', autoSaveDraft);
document.getElementById('religion').addEventListener('change', autoSaveDraft);
document.getElementById('bio').addEventListener('input', autoSaveDraft);

// Clear draft on successful submission
document.getElementById('editProfileForm').addEventListener('submit', function() {
    localStorage.removeItem('profile_draft');
});
</script>
@endsection
