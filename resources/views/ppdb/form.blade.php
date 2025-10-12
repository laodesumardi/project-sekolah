@extends('layouts.app')

@section('title', 'Formulir Pendaftaran PPDB')
@section('description', 'Formulir pendaftaran PPDB SMP Negeri 01 Namrole Tahun Ajaran ' . $setting->academicYear->year)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ppdb-form.css') }}">
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Formulir Pendaftaran PPDB</h1>
            <p class="text-gray-600">SMP Negeri 01 Namrole - Tahun Ajaran {{ $setting->academicYear->year }}</p>
        </div>

        <!-- Progress Bar -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-primary-500 text-white rounded-full flex items-center justify-center text-sm font-bold" data-step-indicator="1">1</div>
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold" data-step-indicator="2">2</div>
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold" data-step-indicator="3">3</div>
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold" data-step-indicator="4">4</div>
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold" data-step-indicator="5">5</div>
                    </div>
                    <div class="text-sm text-gray-600" id="progressText">Langkah 1 dari 5</div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-primary-500 h-2 rounded-full transition-all duration-300" id="progressBar" style="width: 20%"></div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="max-w-4xl mx-auto">
            <form id="ppdbForm" method="POST" action="{{ route('ppdb.submit') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="registration_path" value="{{ request('path', 'regular') }}">

                <!-- Step 1: Data Pribadi Siswa -->
                <div class="bg-white rounded-lg shadow-lg p-8" data-step-content="1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Data Pribadi Siswa</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap (Sesuai Ijazah) *</label>
                            <input type="text" id="full_name" name="full_name" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK *</label>
                            <input type="text" id="nik" name="nik" required maxlength="16" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">NISN *</label>
                            <input type="text" id="nisn" name="nisn" required maxlength="10" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                            <input type="text" id="birth_place" name="birth_place" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
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

                        <div>
                            <label for="child_number" class="block text-sm font-medium text-gray-700 mb-2">Anak Ke- *</label>
                            <input type="number" id="child_number" name="child_number" required min="1" max="20" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="siblings_count" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Saudara Kandung *</label>
                            <input type="number" id="siblings_count" name="siblings_count" required min="0" max="20" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                            <textarea id="address" name="address" required rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:col-span-2">
                            <div>
                                <label for="rt" class="block text-sm font-medium text-gray-700 mb-2">RT *</label>
                                <input type="text" id="rt" name="rt" required maxlength="3" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div>
                                <label for="rw" class="block text-sm font-medium text-gray-700 mb-2">RW *</label>
                                <input type="text" id="rw" name="rw" required maxlength="3" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div>
                                <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-2">Kelurahan *</label>
                                <input type="text" id="kelurahan" name="kelurahan" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div>
                                <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">Kecamatan *</label>
                                <input type="text" id="kecamatan" name="kecamatan" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten *</label>
                            <input type="text" id="city" name="city" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="province" class="block text-sm font-medium text-gray-700 mb-2">Provinsi *</label>
                            <input type="text" id="province" name="province" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Kode Pos *</label>
                            <input type="text" id="postal_code" name="postal_code" required maxlength="5" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon/HP *</label>
                            <input type="tel" id="phone" name="phone" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="height" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan (cm)</label>
                            <input type="number" id="height" name="height" min="50" max="250" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan (kg)</label>
                            <input type="number" id="weight" name="weight" min="10" max="200" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="blood_type" class="block text-sm font-medium text-gray-700 mb-2">Golongan Darah</label>
                            <select id="blood_type" name="blood_type" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="medical_history" class="block text-sm font-medium text-gray-700 mb-2">Riwayat Penyakit</label>
                            <textarea id="medical_history" name="medical_history" rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Siswa 3x4 (Latar Belakang Merah) *</label>
                            <input type="file" id="photo" name="photo" required accept="image/*" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <div class="image-preview mt-2"></div>
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    <button type="button" id="prevButton" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200" style="display: none;">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Sebelumnya
                    </button>
                    <button type="button" id="nextButton" class="px-6 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                        Selanjutnya
                        <svg class="w-5 h-5 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/ppdb-form.js') }}"></script>
@endpush

