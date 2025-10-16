<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'SMP Negeri 01 Namrole') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-[#13315c] transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out" id="sidebar">
            <div class="flex items-center justify-center h-16 bg-[#1e4d8b]">
                <h1 class="text-white text-xl font-bold">Admin Panel</h1>
            </div>
            
            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1e4d8b] hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#1e4d8b] text-white' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>

                    <!-- Homepage Settings -->
                    <a href="{{ route('admin.homepage-settings.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1e4d8b] hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.homepage-settings*') ? 'bg-[#1e4d8b] text-white' : '' }}">
                        <i class="fas fa-home mr-3"></i>
                        Homepage Settings
                    </a>


                    <!-- News Management -->
                    <a href="{{ route('admin.news.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1e4d8b] hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.news*') ? 'bg-[#1e4d8b] text-white' : '' }}">
                        <i class="fas fa-newspaper mr-3"></i>
                        Berita
                    </a>

                    <!-- Facility Management -->
                    <a href="{{ route('admin.facilities.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1e4d8b] hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.facilities*') ? 'bg-[#1e4d8b] text-white' : '' }}">
                        <i class="fas fa-building mr-3"></i>
                        Fasilitas
                    </a>

                    <!-- Gallery Management -->
                    <a href="{{ route('admin.gallery.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1e4d8b] hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.gallery*') ? 'bg-[#1e4d8b] text-white' : '' }}">
                        <i class="fas fa-images mr-3"></i>
                        Galeri
                    </a>


                    <!-- PPDB Management -->
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1e4d8b] hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.users*') ? 'bg-[#1e4d8b] text-white' : '' }}">
                        <i class="fas fa-user-graduate mr-3"></i>
                        PPDB
                    </a>

                    <!-- Academic Management -->
                    <div class="mt-4">
                        <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Akademik</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.subjects.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1e4d8b] hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.subjects*') ? 'bg-[#1e4d8b] text-white' : '' }}">
                                <i class="fas fa-book mr-3"></i>
                                Mata Pelajaran
                            </a>
                            <a href="{{ route('admin.calendar.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1e4d8b] hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.calendar*') ? 'bg-[#1e4d8b] text-white' : '' }}">
                                <i class="fas fa-calendar mr-3"></i>
                                Kalender Akademik
                            </a>
                            <a href="{{ route('admin.extracurriculars.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1e4d8b] hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.extracurriculars*') ? 'bg-[#1e4d8b] text-white' : '' }}">
                                <i class="fas fa-running mr-3"></i>
                                Ekstrakurikuler
                            </a>
                        </div>
                    </div>

                    <!-- Tags Management -->
                    <a href="{{ route('admin.tags.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-[#1e4d8b] hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.tags*') ? 'bg-[#1e4d8b] text-white' : '' }}">
                        <i class="fas fa-tags mr-3"></i>
                        Tags
                    </a>
                </div>
            </nav>
        </div>

        <!-- Mobile sidebar overlay -->
        <div class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 hidden" id="sidebar-overlay"></div>

        <!-- Main content -->
        <div class="lg:ml-64">
            <!-- Top navigation -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700" onclick="toggleSidebar()">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <h2 class="text-xl font-semibold text-gray-800 ml-4 lg:ml-0">@yield('title', 'Admin Dashboard')</h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                            <i class="fas fa-bell text-xl"></i>
                        </button>

                        <!-- User menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm text-gray-700 hover:text-gray-900 focus:outline-none">
                                <div class="w-8 h-8 bg-[#13315c] rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <span class="ml-2">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
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
            </div>

            <!-- Page content -->
            <main class="flex-1">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-6 mt-4" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <i class="fas fa-check-circle mr-2"></i>
                        </div>
                        <div>
                            <p class="font-bold">Sukses!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-6 mt-4" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                        </div>
                        <div>
                            <p class="font-bold">Error!</p>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-6 mt-4" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                        </div>
                        <div>
                            <p class="font-bold">Terdapat kesalahan:</p>
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Close sidebar when clicking overlay
        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            toggleSidebar();
        });

        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                if (!sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            }
        });
    </script>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
