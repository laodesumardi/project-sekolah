<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo Sekolah" class="h-10 w-10 object-contain">
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-primary-500">SMP Negeri 01</h1>
                        <p class="text-sm text-gray-600">Namrole</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <a href="{{ route('home') }}" class="text-primary-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Home
                    </a>
                    <a href="{{ route('tentang') }}" class="text-gray-700 hover:text-primary-500 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Tentang
                    </a>
                    <div class="relative group">
                        <a href="{{ route('academic.curriculum') }}" class="text-gray-700 hover:text-primary-500 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Akademik
                        </a>
                        <!-- Dropdown Menu -->
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="py-1">
                                <a href="{{ route('academic.curriculum') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kurikulum</a>
                                <a href="{{ route('academic.extracurriculars') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ekstrakurikuler</a>
                                <a href="{{ route('academic.teachers') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tenaga Pendidik</a>
                                <a href="{{ route('academic.calendar') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kalender Akademik</a>
                                <a href="{{ route('academic.achievements') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Prestasi</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('ppdb') }}" class="text-gray-700 hover:text-primary-500 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        PPDB
                    </a>
                    <a href="{{ route('galeri') }}" class="text-gray-700 hover:text-primary-500 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Galeri
                    </a>
                    <a href="{{ route('berita') }}" class="text-gray-700 hover:text-primary-500 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Berita
                    </a>
                    <a href="{{ route('kontak') }}" class="text-gray-700 hover:text-primary-500 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Kontak
                    </a>
                </div>
            </div>

            <!-- Desktop CTA Button -->
            <div class="hidden md:block">
                <a href="{{ route('login') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Portal Login
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" type="button" class="text-gray-700 hover:text-primary-500 focus:outline-none focus:text-primary-500" onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobile-menu" class="md:hidden hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
            <a href="{{ route('home') }}" class="text-primary-500 block px-3 py-2 rounded-md text-base font-medium">
                Home
            </a>
            <a href="{{ route('tentang') }}" class="text-gray-700 hover:text-primary-500 block px-3 py-2 rounded-md text-base font-medium">
                Tentang
            </a>
            <a href="{{ route('akademik') }}" class="text-gray-700 hover:text-primary-500 block px-3 py-2 rounded-md text-base font-medium">
                Akademik
            </a>
            <a href="{{ route('ppdb') }}" class="text-gray-700 hover:text-primary-500 block px-3 py-2 rounded-md text-base font-medium">
                PPDB
            </a>
            <a href="{{ route('galeri') }}" class="text-gray-700 hover:text-primary-500 block px-3 py-2 rounded-md text-base font-medium">
                Galeri
            </a>
            <a href="{{ route('berita') }}" class="text-gray-700 hover:text-primary-500 block px-3 py-2 rounded-md text-base font-medium">
                Berita
            </a>
            <a href="{{ route('kontak') }}" class="text-gray-700 hover:text-primary-500 block px-3 py-2 rounded-md text-base font-medium">
                Kontak
            </a>
            <div class="pt-4">
                <a href="{{ route('login') }}" class="bg-primary-500 hover:bg-primary-600 text-white block px-3 py-2 rounded-md text-base font-medium text-center">
                    Portal Login
                </a>
            </div>
        </div>
    </div>
</nav>
