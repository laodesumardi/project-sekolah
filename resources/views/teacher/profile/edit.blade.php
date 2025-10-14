@extends('teacher.layouts.app')

@section('title', 'Edit Profile Guru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
                <p class="text-gray-600 mt-1">Perbarui informasi profile dan data pribadi Anda</p>
            </div>
            <a href="{{ route('teacher.profile.show') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200">
                Kembali
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('teacher.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                    <button type="button" onclick="showTab('personal')" id="tab-personal" class="tab-button py-4 px-1 border-b-2 border-blue-500 text-blue-600 text-sm font-medium">
                        Data Pribadi
                    </button>
                    <button type="button" onclick="showTab('photo')" id="tab-photo" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium">
                        Foto Profile
                    </button>
                    <button type="button" onclick="showTab('password')" id="tab-password" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium">
                        Ubah Password
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Data Pribadi Tab -->
                <div id="content-personal" class="tab-content">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $teacher->user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-300 @enderror">
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $teacher->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('phone') border-red-300 @enderror">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="address" id="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('address') border-red-300 @enderror">{{ old('address', $teacher->address) }}</textarea>
                                @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="bio" class="block text-sm font-medium text-gray-700">Bio / Deskripsi Singkat</label>
                                <textarea name="bio" id="bio" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('bio') border-red-300 @enderror" placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', $teacher->bio) }}</textarea>
                                @error('bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Foto Profile Tab -->
                <div id="content-photo" class="tab-content hidden">
                    <div class="space-y-6">
                        <div class="flex items-center space-x-6">
                            <!-- Current Photo -->
                            <div class="flex-shrink-0">
                                <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100">
                                    <img id="current-photo" src="{{ $teacher->profile_picture_url }}" alt="Current photo" class="w-full h-full object-cover">
                                </div>
                            </div>
                            
                            <!-- Photo Upload -->
                            <div class="flex-1">
                                <label for="photo" class="block text-sm font-medium text-gray-700">Upload Foto Baru</label>
                                <input type="file" name="photo" id="photo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('photo') border-red-300 @enderror">
                                @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</p>
                            </div>
                        </div>

                        <!-- Photo Preview -->
                        <div id="photo-preview" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100">
                                <img id="preview-image" src="" alt="Preview" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ubah Password Tab -->
                <div id="content-password" class="tab-content hidden">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                                <input type="password" name="current_password" id="current_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('current_password') border-red-300 @enderror">
                                @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <input type="password" name="new_password" id="new_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('new_password') border-red-300 @enderror">
                                @error('new_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('new_password_confirmation') border-red-300 @enderror">
                                @error('new_password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kekuatan Password</label>
                                <div class="mt-2">
                                    <div class="flex space-x-2">
                                        <div id="strength-1" class="h-2 w-full bg-gray-200 rounded"></div>
                                        <div id="strength-2" class="h-2 w-full bg-gray-200 rounded"></div>
                                        <div id="strength-3" class="h-2 w-full bg-gray-200 rounded"></div>
                                        <div id="strength-4" class="h-2 w-full bg-gray-200 rounded"></div>
                                    </div>
                                    <p id="strength-text" class="mt-1 text-sm text-gray-500">Masukkan password baru</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('teacher.profile.show') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');

    // Add active class to selected tab button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('border-transparent', 'text-gray-500');
    activeButton.classList.add('border-blue-500', 'text-blue-600');
}

// Photo preview
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('photo-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Password strength checker
document.getElementById('new_password').addEventListener('input', function(e) {
    const password = e.target.value;
    const strength = checkPasswordStrength(password);
    
    // Update strength indicators
    for (let i = 1; i <= 4; i++) {
        const indicator = document.getElementById('strength-' + i);
        if (i <= strength.level) {
            indicator.className = 'h-2 w-full rounded ' + strength.color;
        } else {
            indicator.className = 'h-2 w-full bg-gray-200 rounded';
        }
    }
    
    // Update strength text
    document.getElementById('strength-text').textContent = strength.text;
    document.getElementById('strength-text').className = 'mt-1 text-sm ' + strength.textColor;
});

function checkPasswordStrength(password) {
    let score = 0;
    let feedback = [];
    
    if (password.length >= 8) score++;
    else feedback.push('minimal 8 karakter');
    
    if (/[a-z]/.test(password)) score++;
    else feedback.push('huruf kecil');
    
    if (/[A-Z]/.test(password)) score++;
    else feedback.push('huruf besar');
    
    if (/[0-9]/.test(password)) score++;
    else feedback.push('angka');
    
    if (/[^A-Za-z0-9]/.test(password)) score++;
    else feedback.push('karakter khusus');
    
    if (score <= 1) {
        return {
            level: 1,
            color: 'bg-red-500',
            text: 'Sangat lemah',
            textColor: 'text-red-600'
        };
    } else if (score <= 2) {
        return {
            level: 2,
            color: 'bg-orange-500',
            text: 'Lemah',
            textColor: 'text-orange-600'
        };
    } else if (score <= 3) {
        return {
            level: 3,
            color: 'bg-yellow-500',
            text: 'Sedang',
            textColor: 'text-yellow-600'
        };
    } else {
        return {
            level: 4,
            color: 'bg-green-500',
            text: 'Kuat',
            textColor: 'text-green-600'
        };
    }
}
</script>
@endsection

