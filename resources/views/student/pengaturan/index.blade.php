@extends('student.layouts.app')

@section('title', 'Pengaturan')
@section('description', 'Kelola pengaturan akun dan preferensi Anda')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Pengaturan</h1>
                    <p class="mt-2 text-gray-600">Kelola pengaturan akun dan preferensi Anda</p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="exportSettings()" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export
                    </button>
                    <button onclick="resetSettings()" 
                            class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Settings Tabs -->
        <div class="bg-white shadow rounded-lg">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                    <button onclick="showTab('general')" 
                            id="tab-general"
                            class="py-4 px-1 border-b-2 font-medium text-sm tab-button active">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Umum
                    </button>
                    <button onclick="showTab('notifications')" 
                            id="tab-notifications"
                            class="py-4 px-1 border-b-2 font-medium text-sm tab-button">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5a1.5 1.5 0 01-1.5-1.5V6a1.5 1.5 0 011.5-1.5h15A1.5 1.5 0 0121 6v12a1.5 1.5 0 01-1.5 1.5h-15z"></path>
                        </svg>
                        Notifikasi
                    </button>
                    <button onclick="showTab('privacy')" 
                            id="tab-privacy"
                            class="py-4 px-1 border-b-2 font-medium text-sm tab-button">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Privasi
                    </button>
                    <button onclick="showTab('account')" 
                            id="tab-account"
                            class="py-4 px-1 border-b-2 font-medium text-sm tab-button">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Akun
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- General Settings -->
                <div id="content-general" class="tab-content">
                    <form id="generalForm">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700">Bahasa</label>
                                <select id="language" name="language" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="id" {{ $settings['preferences']['language'] == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                    <option value="en" {{ $settings['preferences']['language'] == 'en' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="timezone" class="block text-sm font-medium text-gray-700">Zona Waktu</label>
                                <select id="timezone" name="timezone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Asia/Jakarta" {{ $settings['preferences']['timezone'] == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta</option>
                                    <option value="Asia/Makassar" {{ $settings['preferences']['timezone'] == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar</option>
                                    <option value="Asia/Jayapura" {{ $settings['preferences']['timezone'] == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="date_format" class="block text-sm font-medium text-gray-700">Format Tanggal</label>
                                <select id="date_format" name="date_format" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="d/m/Y" {{ $settings['preferences']['date_format'] == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                    <option value="m/d/Y" {{ $settings['preferences']['date_format'] == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                    <option value="Y-m-d" {{ $settings['preferences']['date_format'] == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="time_format" class="block text-sm font-medium text-gray-700">Format Waktu</label>
                                <select id="time_format" name="time_format" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="24" {{ $settings['preferences']['time_format'] == '24' ? 'selected' : '' }}>24 Jam</option>
                                    <option value="12" {{ $settings['preferences']['time_format'] == '12' ? 'selected' : '' }}>12 Jam (AM/PM)</option>
                                </select>
                            </div>
                            
                            <div class="sm:col-span-2">
                                <label for="theme" class="block text-sm font-medium text-gray-700">Tema</label>
                                <select id="theme" name="theme" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="light" {{ $settings['preferences']['theme'] == 'light' ? 'selected' : '' }}>Terang</option>
                                    <option value="dark" {{ $settings['preferences']['theme'] == 'dark' ? 'selected' : '' }}>Gelap</option>
                                    <option value="auto" {{ $settings['preferences']['theme'] == 'auto' ? 'selected' : '' }}>Otomatis</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan Pengaturan Umum
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Notification Settings -->
                <div id="content-notifications" class="tab-content hidden">
                    <form id="notificationsForm">
                        @csrf
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Notifikasi Email</h3>
                                    <p class="text-sm text-gray-500">Terima notifikasi melalui email</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="email_notifications" value="1" 
                                           {{ $settings['notifications']['email_notifications'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Notifikasi SMS</h3>
                                    <p class="text-sm text-gray-500">Terima notifikasi melalui SMS</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="sms_notifications" value="1" 
                                           {{ $settings['notifications']['sms_notifications'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Notifikasi Push</h3>
                                    <p class="text-sm text-gray-500">Terima notifikasi push di browser</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="push_notifications" value="1" 
                                           {{ $settings['notifications']['push_notifications'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Pengingat Tugas</h3>
                                    <p class="text-sm text-gray-500">Terima pengingat untuk tugas yang akan deadline</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="assignment_reminders" value="1" 
                                           {{ $settings['notifications']['assignment_reminders'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Notifikasi Nilai</h3>
                                    <p class="text-sm text-gray-500">Terima notifikasi ketika ada nilai baru</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="grade_notifications" value="1" 
                                           {{ $settings['notifications']['grade_notifications'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Notifikasi Pengumuman</h3>
                                    <p class="text-sm text-gray-500">Terima notifikasi untuk pengumuman sekolah</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="announcement_notifications" value="1" 
                                           {{ $settings['notifications']['announcement_notifications'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan Pengaturan Notifikasi
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Privacy Settings -->
                <div id="content-privacy" class="tab-content hidden">
                    <form id="privacyForm">
                        @csrf
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Tampilkan Profil ke Siswa Lain</h3>
                                    <p class="text-sm text-gray-500">Izinkan siswa lain melihat profil Anda</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="show_profile_to_students" value="1" 
                                           {{ $settings['privacy']['show_profile_to_students'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Tampilkan Email ke Guru</h3>
                                    <p class="text-sm text-gray-500">Izinkan guru melihat email Anda</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="show_email_to_teachers" value="1" 
                                           {{ $settings['privacy']['show_email_to_teachers'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Izinkan Akses Orang Tua</h3>
                                    <p class="text-sm text-gray-500">Izinkan orang tua mengakses akun Anda</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="allow_parent_access" value="1" 
                                           {{ $settings['privacy']['allow_parent_access'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Tampilkan Absensi ke Orang Tua</h3>
                                    <p class="text-sm text-gray-500">Izinkan orang tua melihat data absensi Anda</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="show_attendance_to_parents" value="1" 
                                           {{ $settings['privacy']['show_attendance_to_parents'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Tampilkan Nilai ke Orang Tua</h3>
                                    <p class="text-sm text-gray-500">Izinkan orang tua melihat nilai Anda</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="show_grades_to_parents" value="1" 
                                           {{ $settings['privacy']['show_grades_to_parents'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan Pengaturan Privasi
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Settings -->
                <div id="content-account" class="tab-content hidden">
                    <div class="space-y-6">
                        <!-- Change Password -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Ubah Password</h3>
                            <form id="passwordForm">
                                @csrf
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                                        <input type="password" id="current_password" name="current_password" required
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                        <input type="password" id="new_password" name="new_password" required
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Ubah Password
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Account Settings -->
                        <form id="accountForm">
                            @csrf
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Two-Factor Authentication</h3>
                                        <p class="text-sm text-gray-500">Tambahkan lapisan keamanan ekstra ke akun Anda</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="two_factor_enabled" value="1" 
                                               {{ $settings['account']['two_factor_enabled'] ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Auto Logout</h3>
                                        <p class="text-sm text-gray-500">Otomatis logout setelah periode tidak aktif</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="auto_logout" value="1" 
                                               {{ $settings['account']['auto_logout'] ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                
                                <div>
                                    <label for="session_timeout" class="block text-sm font-medium text-gray-700">Timeout Sesi (menit)</label>
                                    <select id="session_timeout" name="session_timeout" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="15" {{ $settings['account']['session_timeout'] == 15 ? 'selected' : '' }}>15 menit</option>
                                        <option value="30" {{ $settings['account']['session_timeout'] == 30 ? 'selected' : '' }}>30 menit</option>
                                        <option value="60" {{ $settings['account']['session_timeout'] == 60 ? 'selected' : '' }}>1 jam</option>
                                        <option value="120" {{ $settings['account']['session_timeout'] == 120 ? 'selected' : '' }}>2 jam</option>
                                        <option value="240" {{ $settings['account']['session_timeout'] == 240 ? 'selected' : '' }}>4 jam</option>
                                        <option value="480" {{ $settings['account']['session_timeout'] == 480 ? 'selected' : '' }}>8 jam</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Simpan Pengaturan Akun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tab functionality
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    });
    
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById('tab-' + tabName);
    activeTab.classList.add('active', 'border-blue-500', 'text-blue-600');
    activeTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
}

// Form submissions
document.getElementById('generalForm').addEventListener('submit', function(e) {
    e.preventDefault();
    submitForm('{{ route("student.pengaturan.general") }}', new FormData(this), 'Pengaturan umum');
});

document.getElementById('notificationsForm').addEventListener('submit', function(e) {
    e.preventDefault();
    submitForm('{{ route("student.pengaturan.notifications") }}', new FormData(this), 'Pengaturan notifikasi');
});

document.getElementById('privacyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    submitForm('{{ route("student.pengaturan.privacy") }}', new FormData(this), 'Pengaturan privasi');
});

document.getElementById('accountForm').addEventListener('submit', function(e) {
    e.preventDefault();
    submitForm('{{ route("student.pengaturan.account") }}', new FormData(this), 'Pengaturan akun');
});

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    submitForm('{{ route("student.pengaturan.password") }}', new FormData(this), 'Password');
});

function submitForm(url, formData, formName) {
    const button = event.target.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    
    button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyimpan...';
    button.disabled = true;
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(formName + ' berhasil diperbarui!');
        } else {
            alert('Gagal memperbarui ' + formName.toLowerCase() + ': ' + (data.message || 'Terjadi kesalahan'));
        }
        button.innerHTML = originalText;
        button.disabled = false;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan ' + formName.toLowerCase());
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function exportSettings() {
    if (confirm('Apakah Anda yakin ingin mengexport pengaturan?')) {
        window.open('{{ route("student.pengaturan.export") }}', '_blank');
    }
}

function resetSettings() {
    if (confirm('Apakah Anda yakin ingin mereset semua pengaturan ke default? Tindakan ini tidak dapat dibatalkan.')) {
        fetch('{{ route("student.pengaturan.reset") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pengaturan berhasil direset!');
                location.reload();
            } else {
                alert('Gagal mereset pengaturan: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mereset pengaturan');
        });
    }
}
</script>
@endsection






