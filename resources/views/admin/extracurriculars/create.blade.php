@extends('admin.layouts.app')

@section('title', 'Tambah Ekstrakurikuler')

@section('content')
<div class="p-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-[#13315c]">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('admin.extracurriculars.index') }}" class="ml-1 text-gray-700 hover:text-[#13315c] md:ml-2">Ekstrakurikuler</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-gray-500 md:ml-2">Tambah Baru</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Ekstrakurikuler Baru</h1>
        <p class="text-gray-600 mt-1">Buat ekstrakurikuler baru untuk sekolah</p>
    </div>

    <form action="{{ route('admin.extracurriculars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form (Left Column - 70%) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Ekstrakurikuler -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Ekstrakurikuler *</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('name') border-red-500 @enderror"
                                   placeholder="Contoh: Basket Putra"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="md:col-span-2">
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug (URL)</label>
                            <input type="text" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('slug') border-red-500 @enderror"
                                   readonly>
                            <p class="mt-1 text-sm text-gray-500" id="slug-preview">URL akan otomatis dibuat</p>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                            <select id="category" 
                                    name="category" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('category') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Kategori</option>
                                <option value="olahraga" {{ old('category') == 'olahraga' ? 'selected' : '' }}>🏃 Olahraga</option>
                                <option value="seni" {{ old('category') == 'seni' ? 'selected' : '' }}>🎨 Seni</option>
                                <option value="akademik" {{ old('category') == 'akademik' ? 'selected' : '' }}>📚 Akademik</option>
                                <option value="keagamaan" {{ old('category') == 'keagamaan' ? 'selected' : '' }}>🕌 Keagamaan</option>
                                <option value="teknologi" {{ old('category') == 'teknologi' ? 'selected' : '' }}>💻 Teknologi</option>
                                <option value="bahasa" {{ old('category') == 'bahasa' ? 'selected' : '' }}>🗣️ Bahasa</option>
                                <option value="sosial" {{ old('category') == 'sosial' ? 'selected' : '' }}>🤝 Sosial</option>
                                <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>➕ Lainnya</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi Singkat -->
                        <div>
                            <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                            <textarea id="short_description" 
                                      name="short_description" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('short_description') border-red-500 @enderror"
                                      placeholder="Deskripsi singkat untuk ditampilkan di card (maks 500 karakter)">{{ old('short_description') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Akan ditampilkan di halaman list</p>
                            @error('short_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi Lengkap -->
                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Lengkap *</label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="8"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="Deskripsi lengkap ekstrakurikuler..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Jadwal & Lokasi -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Jadwal & Lokasi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hari Kegiatan -->
                        <div>
                            <label for="schedule_day" class="block text-sm font-medium text-gray-700 mb-2">Hari Kegiatan *</label>
                            <select id="schedule_day" 
                                    name="schedule_day" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('schedule_day') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Hari</option>
                                <option value="senin" {{ old('schedule_day') == 'senin' ? 'selected' : '' }}>Senin</option>
                                <option value="selasa" {{ old('schedule_day') == 'selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="rabu" {{ old('schedule_day') == 'rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="kamis" {{ old('schedule_day') == 'kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="jumat" {{ old('schedule_day') == 'jumat' ? 'selected' : '' }}>Jumat</option>
                                <option value="sabtu" {{ old('schedule_day') == 'sabtu' ? 'selected' : '' }}>Sabtu</option>
                                <option value="minggu" {{ old('schedule_day') == 'minggu' ? 'selected' : '' }}>Minggu</option>
                            </select>
                            @error('schedule_day')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi Kegiatan *</label>
                            <input type="text" 
                                   id="location" 
                                   name="location" 
                                   value="{{ old('location') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('location') border-red-500 @enderror"
                                   placeholder="Contoh: Lapangan Basket, Ruang Musik, Lab Komputer"
                                   required>
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Waktu Mulai -->
                        <div>
                            <label for="schedule_time_start" class="block text-sm font-medium text-gray-700 mb-2">Waktu Mulai</label>
                            <input type="time" 
                                   id="schedule_time_start" 
                                   name="schedule_time_start" 
                                   value="{{ old('schedule_time_start') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('schedule_time_start') border-red-500 @enderror">
                            @error('schedule_time_start')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Waktu Selesai -->
                        <div>
                            <label for="schedule_time_end" class="block text-sm font-medium text-gray-700 mb-2">Waktu Selesai</label>
                            <input type="time" 
                                   id="schedule_time_end" 
                                   name="schedule_time_end" 
                                   value="{{ old('schedule_time_end') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('schedule_time_end') border-red-500 @enderror">
                            @error('schedule_time_end')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pembina/Pelatih -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pembina/Pelatih</h3>
                    
                    <div class="space-y-4">
                        <!-- Tipe Pembina -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Pembina</label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="instructor_type" 
                                           value="internal" 
                                           {{ old('instructor_type', 'internal') == 'internal' ? 'checked' : '' }}
                                           class="text-[#13315c] focus:ring-[#13315c]">
                                    <span class="ml-2 text-sm text-gray-700">Guru Internal</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="instructor_type" 
                                           value="external" 
                                           {{ old('instructor_type') == 'external' ? 'checked' : '' }}
                                           class="text-[#13315c] focus:ring-[#13315c]">
                                    <span class="ml-2 text-sm text-gray-700">Pelatih Eksternal</span>
                                </label>
                            </div>
                        </div>

                        <!-- Pembina Internal -->
                        <div id="internal-instructor" style="display: {{ old('instructor_type', 'internal') == 'internal' ? 'block' : 'none' }}">
                            <label for="instructor_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Guru Pembina</label>
                            <select id="instructor_id" 
                                    name="instructor_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('instructor_id') border-red-500 @enderror">
                                <option value="">Pilih Guru</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('instructor_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->user->name }} - {{ $teacher->nip }}
                                    </option>
                                @endforeach
                            </select>
                            @error('instructor_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pembina Eksternal -->
                        <div id="external-instructor" style="display: {{ old('instructor_type') == 'external' ? 'block' : 'none' }}">
                            <label for="instructor_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pelatih/Pembina</label>
                            <input type="text" 
                                   id="instructor_name" 
                                   name="instructor_name" 
                                   value="{{ old('instructor_name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('instructor_name') border-red-500 @enderror"
                                   placeholder="Nama lengkap pelatih">
                            @error('instructor_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Peserta & Pendaftaran -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Peserta & Pendaftaran</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kuota Maksimal -->
                        <div>
                            <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-2">Kuota Maksimal Peserta</label>
                            <input type="number" 
                                   id="max_participants" 
                                   name="max_participants" 
                                   value="{{ old('max_participants') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('max_participants') border-red-500 @enderror"
                                   placeholder="Contoh: 30"
                                   min="1">
                            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ada batasan</p>
                            @error('max_participants')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Pendaftaran -->
                        <div class="flex items-center">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_registration_open" 
                                       value="1"
                                       {{ old('is_registration_open', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-[#13315c] focus:ring-[#13315c]">
                                <span class="ml-2 text-sm text-gray-700">Pendaftaran Dibuka</span>
                            </label>
                        </div>

                        <!-- Tanggal Buka Pendaftaran -->
                        <div>
                            <label for="registration_start" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Buka Pendaftaran</label>
                            <input type="date" 
                                   id="registration_start" 
                                   name="registration_start" 
                                   value="{{ old('registration_start') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('registration_start') border-red-500 @enderror">
                            @error('registration_start')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Tutup Pendaftaran -->
                        <div>
                            <label for="registration_end" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Tutup Pendaftaran</label>
                            <input type="date" 
                                   id="registration_end" 
                                   name="registration_end" 
                                   value="{{ old('registration_end') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('registration_end') border-red-500 @enderror">
                            @error('registration_end')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Media Sosial -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Media Sosial</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Facebook -->
                        <div>
                            <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-2">Link Facebook</label>
                            <input type="url" 
                                   id="facebook_url" 
                                   name="facebook_url" 
                                   value="{{ old('facebook_url') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('facebook_url') border-red-500 @enderror"
                                   placeholder="https://facebook.com/...">
                            @error('facebook_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Instagram -->
                        <div>
                            <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-2">Link Instagram</label>
                            <input type="url" 
                                   id="instagram_url" 
                                   name="instagram_url" 
                                   value="{{ old('instagram_url') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('instagram_url') border-red-500 @enderror"
                                   placeholder="https://instagram.com/...">
                            @error('instagram_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- YouTube -->
                        <div>
                            <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-2">Link YouTube</label>
                            <input type="url" 
                                   id="youtube_url" 
                                   name="youtube_url" 
                                   value="{{ old('youtube_url') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent @error('youtube_url') border-red-500 @enderror"
                                   placeholder="https://youtube.com/...">
                            @error('youtube_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Right Column - 30%) -->
            <div class="space-y-6">
                <!-- Publish Settings -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Publikasi</h4>
                    
                    <div class="space-y-4">
                        <!-- Status Aktif -->
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Aktif</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#13315c]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#13315c]"></div>
                            </label>
                        </div>

                        <!-- Featured -->
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Unggulan</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       value="1"
                                       {{ old('is_featured') ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#13315c]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#13315c]"></div>
                            </label>
                        </div>

                        <!-- Urutan Tampilan -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampilan</label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', 0) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#13315c] focus:border-transparent"
                                   min="0">
                            <p class="mt-1 text-sm text-gray-500">Angka lebih kecil tampil lebih dulu</p>
                        </div>
                    </div>
                </div>

                <!-- Logo Ekstrakurikuler -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Logo Ekstrakurikuler</h4>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-[#13315c] hover:bg-blue-50 transition-colors duration-200 cursor-pointer"
                         onclick="document.getElementById('logo').click()">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Upload Logo</p>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG | Max 2MB | 500x500px</p>
                    </div>
                    
                    <input type="file" 
                           id="logo" 
                           name="logo" 
                           accept="image/png,image/jpeg,image/jpg"
                           class="hidden"
                           onchange="handleLogoUpload(event)">
                </div>

                <!-- Cover Image -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Gambar Cover/Banner</h4>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-[#13315c] hover:bg-blue-50 transition-colors duration-200 cursor-pointer"
                         onclick="document.getElementById('cover_image').click()">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Upload Cover</p>
                        <p class="text-xs text-gray-500">JPG, JPEG, PNG | Max 3MB | 16:9 ratio</p>
                    </div>
                    
                    <input type="file" 
                           id="cover_image" 
                           name="cover_image" 
                           accept="image/jpeg,image/jpg,image/png"
                           class="hidden"
                           onchange="handleCoverUpload(event)">
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-white border-t border-gray-200 px-6 py-4 flex justify-between items-center">
            <a href="{{ route('admin.extracurriculars.index') }}" 
               class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                Batal
            </a>
            
            <div class="flex space-x-4">
                <button type="submit" 
                        class="bg-[#13315c] text-white px-6 py-2 rounded-lg hover:bg-[#1e4d8b] transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan & Publikasikan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Auto-generate slug
document.getElementById('name').addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
    
    document.getElementById('slug').value = slug;
    document.getElementById('slug-preview').textContent = 'URL: ' + window.location.origin + '/ekstrakurikuler/' + slug;
});

// Toggle instructor type
document.querySelectorAll('input[name="instructor_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const internalDiv = document.getElementById('internal-instructor');
        const externalDiv = document.getElementById('external-instructor');
        
        if (this.value === 'internal') {
            internalDiv.style.display = 'block';
            externalDiv.style.display = 'none';
        } else {
            internalDiv.style.display = 'none';
            externalDiv.style.display = 'block';
        }
    });
});

// Image upload handlers
function handleLogoUpload(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    // Validate type
    const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
    if (!allowedTypes.includes(file.type)) {
        alert('Format tidak didukung. Hanya PNG, JPG, dan JPEG yang diperbolehkan.');
        event.target.value = '';
        return;
    }
    
    // Validate size (2MB)
    if (file.size > 2097152) {
        alert('Ukuran file maksimal 2MB.');
        event.target.value = '';
        return;
    }
    
    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        // You can add preview functionality here
        console.log('Logo uploaded:', file.name);
    };
    reader.readAsDataURL(file);
}

function handleCoverUpload(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    // Validate type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!allowedTypes.includes(file.type)) {
        alert('Format tidak didukung. Hanya JPG, JPEG, dan PNG yang diperbolehkan.');
        event.target.value = '';
        return;
    }
    
    // Validate size (3MB)
    if (file.size > 3145728) {
        alert('Ukuran file maksimal 3MB.');
        event.target.value = '';
        return;
    }
    
    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        // You can add preview functionality here
        console.log('Cover uploaded:', file.name);
    };
    reader.readAsDataURL(file);
}
</script>
@endsection