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
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-red-800">Terjadi kesalahan:</h3>
                            <ul class="text-sm text-red-700 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Success Messages -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-green-800">Berhasil!</h3>
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form id="ppdbForm" method="POST" action="{{ route('ppdb.submit') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="registration_path" value="{{ request('path', 'regular') }}">

                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Data Pendaftaran</h2>
                    
                    <div class="space-y-6">
                        <!-- Data Siswa -->
                        <div class="border-b pb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Siswa</h3>
                        </div>
                        
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

                            <div>
                                <label for="school_origin" class="block text-sm font-medium text-gray-700 mb-2">Asal Sekolah *</label>
                                <input type="text" id="school_origin" name="school_origin" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Nama SD/MI asal">
                            </div>

                            <div>
                                <label for="school_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Sekolah Asal</label>
                                <input type="text" id="school_address" name="school_address" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Alamat sekolah asal">
                            </div>

                            <div>
                                <label for="graduation_year" class="block text-sm font-medium text-gray-700 mb-2">Tahun Lulus *</label>
                                <select id="graduation_year" name="graduation_year" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Pilih Tahun Lulus</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024" selected>2024</option>
                                    <option value="2025">2025</option>
                                </select>
                                <p class="text-sm text-gray-500 mt-1">Pilih tahun lulus dari SD/MI</p>
                            </div>

                            <div>
                                <label for="child_order" class="block text-sm font-medium text-gray-700 mb-2">Anak Ke-</label>
                                <input type="number" id="child_order" name="child_order" min="1" max="20" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="1">
                            </div>

                            <div>
                                <label for="siblings_count" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Saudara</label>
                                <input type="number" id="siblings_count" name="siblings_count" min="0" max="20" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="2">
                            </div>
                        </div>

                        <!-- Data Orang Tua -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Orang Tua/Wali</h3>
                        </div>
                        
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

                            <div>
                                <label for="father_phone" class="block text-sm font-medium text-gray-700 mb-2">No. HP Ayah</label>
                                <input type="tel" id="father_phone" name="father_phone" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="08xxxxxxxxxx">
                            </div>

                            <div>
                                <label for="mother_phone" class="block text-sm font-medium text-gray-700 mb-2">No. HP Ibu</label>
                                <input type="tel" id="mother_phone" name="mother_phone" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="08xxxxxxxxxx">
                            </div>

                            <div>
                                <label for="father_income" class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Ayah per Bulan</label>
                                <select id="father_income" name="father_income" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< 1 juta">< 1 juta</option>
                                    <option value="1-2 juta">1-2 juta</option>
                                    <option value="2-3 juta">2-3 juta</option>
                                    <option value="3-5 juta">3-5 juta</option>
                                    <option value="5-10 juta">5-10 juta</option>
                                    <option value="> 10 juta">> 10 juta</option>
                                </select>
                            </div>

                            <div>
                                <label for="mother_income" class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Ibu per Bulan</label>
                                <select id="mother_income" name="mother_income" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< 1 juta">< 1 juta</option>
                                    <option value="1-2 juta">1-2 juta</option>
                                    <option value="2-3 juta">2-3 juta</option>
                                    <option value="3-5 juta">3-5 juta</option>
                                    <option value="5-10 juta">5-10 juta</option>
                                    <option value="> 10 juta">> 10 juta</option>
                                </select>
                            </div>
                        </div>

                        <!-- Kontak & Alamat -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Kontak & Alamat</h3>
                        </div>
                        
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

                            <div>
                                <label for="rt" class="block text-sm font-medium text-gray-700 mb-2">RT</label>
                                <input type="text" id="rt" name="rt" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="001">
                            </div>

                            <div>
                                <label for="rw" class="block text-sm font-medium text-gray-700 mb-2">RW</label>
                                <input type="text" id="rw" name="rw" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="001">
                            </div>

                            <div>
                                <label for="village" class="block text-sm font-medium text-gray-700 mb-2">Desa/Kelurahan</label>
                                <input type="text" id="village" name="village" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Nama desa/kelurahan">
                            </div>

                            <div>
                                <label for="district" class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                                <input type="text" id="district" name="district" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Nama kecamatan">
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten</label>
                                <input type="text" id="city" name="city" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Nama kota/kabupaten">
                            </div>

                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                                <input type="text" id="postal_code" name="postal_code" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="12345">
                            </div>
                        </div>

                        <!-- Prestasi (untuk jalur prestasi) -->
                        @if(request('path') == 'achievement')
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Prestasi</h3>
                        </div>
                        
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
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumen Pendukung</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Siswa 3x4 (Latar Belakang Merah) *</label>
                                <input type="file" id="photo" name="photo" required accept="image/*" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <div class="image-preview mt-2"></div>
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                            </div>

                            <div>
                                <label for="ijazah" class="block text-sm font-medium text-gray-700 mb-2">Scan Ijazah SD/MI *</label>
                                <input type="file" id="ijazah" name="ijazah" required accept="image/*,.pdf" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, PDF. Maksimal 5MB</p>
                            </div>

                            <div>
                                <label for="skhun" class="block text-sm font-medium text-gray-700 mb-2">Scan SKHUN *</label>
                                <input type="file" id="skhun" name="skhun" required accept="image/*,.pdf" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, PDF. Maksimal 5MB</p>
                            </div>

                            <div>
                                <label for="kk" class="block text-sm font-medium text-gray-700 mb-2">Scan Kartu Keluarga *</label>
                                <input type="file" id="kk" name="kk" required accept="image/*,.pdf" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, PDF. Maksimal 5MB</p>
                            </div>

                            <div>
                                <label for="akta_kelahiran" class="block text-sm font-medium text-gray-700 mb-2">Scan Akta Kelahiran *</label>
                                <input type="file" id="akta_kelahiran" name="akta_kelahiran" required accept="image/*,.pdf" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, PDF. Maksimal 5MB</p>
                            </div>

                            <div>
                                <label for="ktp_ortu" class="block text-sm font-medium text-gray-700 mb-2">Scan KTP Orang Tua</label>
                                <input type="file" id="ktp_ortu" name="ktp_ortu" accept="image/*,.pdf" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, PDF. Maksimal 5MB (Opsional)</p>
                            </div>
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
<script>
// Simple form submission handling
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('ppdbForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    MENGIRIM...
                `;
            }
        });
    }
    
    // File upload preview
    const photoInput = document.getElementById('photo');
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewContainer = e.target.parentNode.querySelector('.image-preview');
            
            if (file && previewContainer) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.innerHTML = `
                        <div class="mt-2">
                            <img src="${e.target.result}" alt="Preview" class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush

