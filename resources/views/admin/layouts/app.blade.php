<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700|inter:300,400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Pusher JS -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    
    <!-- Custom CSS -->
    <style>
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        .content-transition {
            transition: all 0.3s ease-in-out;
        }
        .sidebar-collapsed {
            width: 4rem;
        }
        .sidebar-expanded {
            width: 16rem;
        }
        
        /* Fix for content crop issues */
        body {
            overflow-x: hidden;
            min-height: 100vh;
        }
        
        .main-content {
            min-height: 100vh;
            width: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar {
            min-height: 100vh;
            overflow-y: auto;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 40;
        }
        
        .content-wrapper {
            margin-left: 16rem; /* Width of expanded sidebar */
            width: calc(100% - 16rem);
            min-height: 100vh;
            position: relative;
            z-index: 10;
        }
        
        .sidebar-collapsed + .content-wrapper {
            margin-left: 4rem; /* Width of collapsed sidebar */
            width: calc(100% - 4rem);
        }
        
        /* Ensure content is not hidden behind sidebar */
        .main-content {
            position: relative;
            z-index: 20;
            background: white;
            min-height: 100vh;
            width: 100%;
        }
        
        /* Ensure proper spacing */
        .content-wrapper {
            background: #f8fafc;
        }
        
        /* Fix for header */
        .main-content header {
            position: sticky;
            top: 0;
            z-index: 30;
            background: white;
        }
        
        @media (max-width: 1024px) {
            .content-wrapper {
                margin-left: 0;
                width: 100%;
            }
            
            .sidebar {
                z-index: 50;
            }
        }
        
        @media (max-width: 1024px) {
            .sidebar-mobile {
                transform: translateX(-100%);
            }
            .sidebar-mobile.open {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-primary-500 sidebar-transition fixed inset-y-0 left-0 z-50 lg:translate-x-0 sidebar-expanded sidebar-mobile flex flex-col sidebar">
            <!-- Sidebar Container -->
            <div class="flex flex-col h-full">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-center h-16 bg-primary-600 px-4 flex-shrink-0">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('logo.png') }}" alt="Logo Sekolah" class="h-8 w-8 object-contain">
                        <div class="text-white">
                            <h2 class="text-lg font-bold">Admin Panel</h2>
                            <p class="text-xs text-primary-200">SMP Negeri 01 Namrole</p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Navigation -->
                <nav class="flex-1 px-4 py-6 overflow-y-auto">
                    <ul class="space-y-2">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <!-- Kelola Konten -->
                    <li>
                        <div class="px-4 py-2">
                            <span class="text-primary-200 text-xs font-semibold uppercase tracking-wider">Kelola Konten</span>
                        </div>
                    </li>

                    <!-- Berita -->
                    <li>
                        <a href="{{ route('admin.news.index') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.news.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                            Berita
                        </a>
                    </li>

                    <!-- Galeri -->
                    <li>
                        <a href="{{ route('admin.gallery.index') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.gallery.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Galeri
                        </a>
                    </li>

                    <!-- Fasilitas -->
                    <li>
                        <a href="{{ route('admin.facilities.index') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.facilities.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Fasilitas
                        </a>
                    </li>

                    <!-- Prestasi -->
                    <li>
                        <a href="{{ route('admin.achievements.index') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.achievements.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00.806 1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            Prestasi
                        </a>
                    </li>

                    <!-- Ekstrakurikuler -->
                    <li>
                        <a href="{{ route('admin.extracurriculars.index') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.extracurriculars.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-5.523-4.477-10-10-10S-3 12.477-3 18v2m20 0H3"></path>
                            </svg>
                            Ekstrakurikuler
                        </a>
                    </li>

                    <!-- Pesan Masuk -->
                    <li>
                        <a href="{{ route('admin.messages.index') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.messages.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Pesan Masuk
                        </a>
                    </li>

                    <!-- Pengaturan Halaman -->
                    <li>
                        <div class="px-4 py-2">
                            <span class="text-primary-200 text-xs font-semibold uppercase tracking-wider">Pengaturan Halaman</span>
                        </div>
                    </li>

                    <!-- Pengaturan Beranda -->
                    <li>
                        <a href="{{ route('admin.homepage-settings.edit') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.homepage-settings.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Pengaturan Beranda
                        </a>
                    </li>

                    <!-- Pengaturan Tentang -->
                    <li>
                        <a href="{{ route('admin.about-page-settings.edit') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.about-page-settings.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pengaturan Tentang
                        </a>
                    </li>

                    <!-- Akademik -->
                    <li>
                        <div class="px-4 py-2">
                            <span class="text-primary-200 text-xs font-semibold uppercase tracking-wider">Akademik</span>
                        </div>
                    </li>

                    <!-- Mata Pelajaran -->
                    <li>
                        <a href="{{ route('admin.subjects.index') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.subjects.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Mata Pelajaran
                        </a>
                    </li>

                    <!-- Kalender Akademik -->
                    <li>
                        <a href="{{ route('admin.calendar.index') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.calendar.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Kalender Akademik
                        </a>
                    </li>

                    <!-- PPDB -->
                    <li class="mt-6">
                        <div class="px-4 py-2">
                            <span class="text-primary-200 text-xs font-semibold uppercase tracking-wider">PPDB</span>
                        </div>
                    </li>

                    <!-- Pengaturan PPDB -->
                    <li>
                        <a href="{{ route('admin.ppdb-settings.index') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.ppdb-settings.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Pengaturan PPDB
                        </a>
                    </li>

                    <!-- Data Pendaftar -->
                    <li>
                        <a href="{{ route('admin.ppdb.index') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.ppdb.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            Data Pendaftar
                        </a>
                    </li>

                    <!-- User Management Section -->
                    <li class="mt-6">
                        <div class="px-4 py-2">
                            <span class="text-primary-200 text-xs font-semibold uppercase tracking-wider">Manajemen User</span>
                        </div>
                    </li>

                    <!-- Manajemen User -->
                    <li>
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-primary-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Manajemen User
                        </a>
                    </li>
                    </ul>
                </nav>
            </div>
        </div>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col content-transition main-content">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 lg:px-6 py-4">
                    <!-- Mobile menu button -->
                    <button id="mobile-menu-button" class="lg:hidden text-gray-600 hover:text-gray-900 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Page Title -->
                    <div class="flex-1 ml-4 lg:ml-0">
                        <h1 class="text-xl lg:text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-2 lg:space-x-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative inline-flex items-center justify-center w-12 h-12 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#13315c] focus:ring-offset-2 group shadow-sm hover:shadow-md">
                                <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
                                </svg>
                                <span id="notification-badge" class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full min-w-[1.5rem] h-6 shadow-lg transform scale-0 transition-all duration-300 border-2 border-white">
                                    <span id="notification-count">0</span>
                                </span>
                            </button>
                            
                            <!-- Notification Dropdown -->
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-4 w-[28rem] bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden z-[9999]"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95 transform translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 scale-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 transform translate-y-2">
                                
                                <!-- Header -->
                                <div class="px-8 py-5 bg-gradient-to-r from-[#13315c] via-[#1e4d8b] to-[#2c5aa0] text-white relative overflow-hidden">
                                    <div class="absolute inset-0 bg-black/10"></div>
                                    <div class="relative flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-xl font-bold">Notifikasi</h3>
                                                <p class="text-sm text-white/80">Pesan dan pendaftaran terbaru</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span id="notification-total" class="bg-white/20 backdrop-blur-sm text-white text-sm px-4 py-2 rounded-full font-bold">0</span>
                                            <button @click="open = false" class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center hover:bg-white/30 transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div id="notification-content" class="max-h-96 overflow-y-auto">
                                    <!-- Notifications will be loaded here -->
                                    <div class="p-10 text-center text-gray-500">
                                        <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-bold text-gray-700 mb-3">Tidak ada notifikasi</h4>
                                        <p class="text-base text-gray-500">Semua notifikasi akan muncul di sini</p>
                                    </div>
                                </div>
                                
                                <!-- Footer -->
                                <div class="px-8 py-5 bg-gray-50 border-t border-gray-200">
                                    <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center justify-center w-full px-6 py-3 text-base font-semibold text-[#13315c] hover:text-[#1e4d8b] hover:bg-[#13315c]/5 rounded-xl transition-all duration-200 group">
                                        <svg class="w-5 h-5 mr-3 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Lihat semua notifikasi
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 lg:space-x-3 text-gray-700 hover:text-gray-900">
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="hidden lg:block text-sm font-medium">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 w-full main-content">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-4 lg:mx-6 mt-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-4 lg:mx-6 mt-4 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('hidden');
        });

        // Close sidebar when clicking overlay
        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.remove('open');
            overlay.classList.add('hidden');
        });

        // Close sidebar when clicking on links (mobile)
        document.querySelectorAll('#sidebar a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('sidebar-overlay');
                    
                    sidebar.classList.remove('open');
                    overlay.classList.add('hidden');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                sidebar.classList.remove('open');
                overlay.classList.add('hidden');
            }
        });

        // Auto-hide flash messages
        setTimeout(function() {
            const flashMessages = document.querySelectorAll('.bg-green-100, .bg-red-100');
            flashMessages.forEach(function(message) {
                message.style.transition = 'opacity 0.5s';
                message.style.opacity = '0';
                setTimeout(function() {
                    message.remove();
                }, 500);
            });
        }, 3000);

        // Notification System
        let notificationCount = 0;
        
        function updateNotificationBadge() {
            const badge = document.getElementById('notification-badge');
            const count = document.getElementById('notification-count');
            const total = document.getElementById('notification-total');
            
            if (notificationCount > 0) {
                badge.classList.remove('scale-0');
                badge.classList.add('scale-100');
                const displayCount = notificationCount > 9 ? '9+' : notificationCount.toString();
                count.textContent = displayCount;
                total.textContent = displayCount;
            } else {
                badge.classList.remove('scale-100');
                badge.classList.add('scale-0');
                total.textContent = '0';
            }
        }

        function addNotification(type, title, message, url = null) {
            const content = document.getElementById('notification-content');
            const emptyState = content.querySelector('.text-center');
            
            if (emptyState) {
                emptyState.remove();
            }

            const notification = document.createElement('div');
            notification.className = 'p-5 border-b border-gray-100 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 cursor-pointer transition-all duration-300 group relative overflow-hidden';
            if (url) {
                notification.onclick = () => window.location.href = url;
            }

            const icon = type === 'message' ? 
                '<div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>' :
                '<div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>';

            notification.innerHTML = `
                <div class="absolute inset-0 bg-gradient-to-r from-transparent to-transparent group-hover:from-blue-500/5 group-hover:to-blue-600/5 transition-all duration-300"></div>
                <div class="relative flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        ${icon}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-base font-bold text-gray-900 group-hover:text-[#13315c] transition-colors duration-200">${title}</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold ${type === 'message' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-green-100 text-green-800 border border-green-200'}">
                                ${type === 'message' ? 'Pesan' : 'Pendaftaran'}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3 leading-relaxed">${message}</p>
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-gray-500 flex items-center">
                                <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                Baru saja
                            </p>
                            <div class="flex items-center text-xs text-gray-400">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Klik untuk melihat
                            </div>
                        </div>
                    </div>
                </div>
            `;

            content.insertBefore(notification, content.firstChild);
            notificationCount++;
            updateNotificationBadge();
        }

        function loadNotifications() {
            fetch('/admin/notifications')
                .then(response => response.json())
                .then(data => {
                    const content = document.getElementById('notification-content');
                    content.innerHTML = '';
                    
                    if (data.notifications.length === 0) {
                        content.innerHTML = `
                            <div class="p-4 text-center text-gray-500">
                                <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-5a7.5 7.5 0 1 0-15 0v5h5l-5 5-5-5h5v-5a7.5 7.5 0 1 0 15 0v5z"></path>
                                </svg>
                                <p class="text-sm">Tidak ada notifikasi baru</p>
                            </div>
                        `;
                        notificationCount = 0;
                    } else {
                        data.notifications.forEach(notification => {
                            addNotification(notification.type, notification.title, notification.message, notification.url);
                        });
                        notificationCount = data.notifications.length;
                    }
                    updateNotificationBadge();
                })
                .catch(error => console.error('Error loading notifications:', error));
        }

        // Load notifications on page load
        loadNotifications();

        // Check for new notifications every 30 seconds
        setInterval(loadNotifications, 30000);

        // Real-time notifications with Pusher
        // Initialize Pusher
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY', 'your-pusher-key') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER', 'ap1') }}',
            encrypted: true
        });

        // Subscribe to admin notifications channel
        const channel = pusher.subscribe('admin-notifications');
        
        // Listen for new message notifications
        channel.bind('App\\Events\\NewMessageReceived', function(data) {
            addNotification(data.type, data.title, data.message, data.url);
            
            // Show browser notification if permission is granted
            if (Notification.permission === 'granted') {
                new Notification(data.title, {
                    body: data.message,
                    icon: '/favicon.ico'
                });
            }
        });
        
        // Listen for new registration notifications
        channel.bind('App\\Events\\NewRegistrationReceived', function(data) {
            addNotification(data.type, data.title, data.message, data.url);
            
            // Show browser notification if permission is granted
            if (Notification.permission === 'granted') {
                new Notification(data.title, {
                    body: data.message,
                    icon: '/favicon.ico'
                });
            }
        });

        // Request notification permission
        if (Notification.permission === 'default') {
            Notification.requestPermission();
        }

        // Simulate new notifications for testing
        // Uncomment these lines to test notifications
        /*
        setTimeout(() => {
            addNotification('message', 'Pesan Baru', 'John Doe mengirim pesan baru', '/admin/messages');
        }, 5000);
        
        setTimeout(() => {
            addNotification('registration', 'Pendaftaran Baru', 'Jane Smith mendaftar sebagai mahasiswa', '/admin/registrations');
        }, 10000);
        */
    </script>

    @stack('scripts')
</body>
</html>
