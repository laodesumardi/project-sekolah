@extends('layouts.app')

@section('title', 'Formulir Pendaftaran PPDB')
@section('description', 'Formulir pendaftaran PPDB SMP Negeri 01 Namrole Tahun Ajaran ' . $setting->academicYear->year)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Formulir Pendaftaran PPDB</h1>
            <p class="text-gray-600">SMP Negeri 01 Namrole - Tahun Ajaran {{ $setting->academicYear->year }}</p>
            <div class="mt-4 inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Jalur: {{ ucfirst(request('path', 'regular')) }}
            </div>
        </div>

        <!-- Form Container -->
        <div class="max-w-3xl mx-auto">
            <form id="ppdbForm" method="POST" action="{{ route('ppdb.submit') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="registration_path" value="{{ request('path', 'regular') }}">

                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Data Pendaftaran</h2>
                    
                    <div class="space-y-6">
                        <!-- Data Siswa -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap (Sesuai Ijazah) *</label>
                                <input type="text" id="full_name" name="full_name" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Masukkan nama lengkap sesuai ijazah">
                            </div>

                            <div>
                                <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">NISN *</label>
                                <input type="text" id="nisn" name="nisn" required maxlength="10" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="10 digit NISN">
                            </div>

                            <div>
                                <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                                <input type="text" id="birth_place" name="birth_place" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Kota tempat lahir">
                            </div>

                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                                <input type="date" id="birth_date" name="birth_date" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                                <select id="gender" name="gender" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">Agama *</label>
                                <select id="religion" name="religion" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                        </div>

                        <!-- Data Orang Tua -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="father_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Ayah *</label>
                                <input type="text" id="father_name" name="father_name" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Nama lengkap ayah">
                            </div>

                            <div>
                                <label for="mother_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu *</label>
                                <input type="text" id="mother_name" name="mother_name" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Nama lengkap ibu">
                            </div>

                            <div>
                                <label for="father_occupation" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ayah</label>
                                <input type="text" id="father_occupation" name="father_occupation" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Pekerjaan ayah (opsional)">
                            </div>

                            <div>
                                <label for="mother_occupation" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ibu</label>
                                <input type="text" id="mother_occupation" name="mother_occupation" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Pekerjaan ibu (opsional)">
                            </div>
                        </div>

                        <!-- Kontak -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon/HP *</label>
                                <input type="tel" id="phone" name="phone" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="08xxxxxxxxxx">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" id="email" name="email" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="email@example.com">
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                                <textarea id="address" name="address" required rows="3" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                          placeholder="Alamat lengkap tempat tinggal"></textarea>
                            </div>
                        </div>

                        <!-- Prestasi (untuk jalur prestasi) -->
                        @if(request('path') == 'achievement')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="achievement_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Prestasi</label>
                                <input type="text" id="achievement_name" name="achievement_name" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Nama prestasi yang diraih">
                            </div>

                            <div>
                                <label for="achievement_level" class="block text-sm font-medium text-gray-700 mb-2">Tingkat Prestasi</label>
                                <select id="achievement_level" name="achievement_level" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Pilih Tingkat</option>
                                    <option value="Sekolah">Sekolah</option>
                                    <option value="Kecamatan">Kecamatan</option>
                                    <option value="Kabupaten">Kabupaten</option>
                                    <option value="Provinsi">Provinsi</option>
                                    <option value="Nasional">Nasional</option>
                                </select>
                            </div>

                            <div>
                                <label for="achievement_year" class="block text-sm font-medium text-gray-700 mb-2">Tahun Prestasi</label>
                                <input type="number" id="achievement_year" name="achievement_year" min="2020" max="2025" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="2024">
                            </div>

                            <div>
                                <label for="achievement_rank" class="block text-sm font-medium text-gray-700 mb-2">Peringkat</label>
                                <input type="text" id="achievement_rank" name="achievement_rank" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Juara 1, Juara 2, dll">
                            </div>
                        </div>
                        @endif

                        <!-- Dokumen -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Siswa 3x4 (Latar Belakang Merah) *</label>
                            <input type="file" id="photo" name="photo" required accept="image/*" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <div class="image-preview mt-2"></div>
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 text-center">
                        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-primary-500 text-white font-bold text-lg rounded-lg hover:bg-primary-600 transition-colors duration-200 shadow-lg">
                            <svg class="w-6 h-6 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            DAFTAR SEKARANG
                        </button>
                        <p class="text-sm text-gray-500 mt-4">
                            Dengan mengirimkan formulir ini, Anda menyetujui syarat dan ketentuan yang berlaku.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/ppdb-form.js') }}"></script>
@endpush

