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
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-primary-500 sidebar-transition fixed inset-y-0 left-0 z-50 lg:static lg:translate-x-0 sidebar-expanded lg:sidebar-expanded sidebar-mobile flex flex-col h-full">
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

        <!-- Main Content -->
        <div class="flex-1 flex flex-col content-transition lg:ml-0">
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
                        <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-5a7.5 7.5 0 1 0-15 0v5h5l-5 5-5-5h5v-5a7.5 7.5 0 1 0 15 0v5z"></path>
                            </svg>
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
                        </button>

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
            <main class="flex-1 overflow-y-auto">
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
    </script>

    @stack('scripts')
</body>
</html>
