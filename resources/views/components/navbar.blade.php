<nav class="bg-white shadow-lg sticky top-0 z-50">
    <style>
        /* Custom navbar styles */
        .navbar-link {
            position: relative;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .navbar-link:hover {
            transform: translateY(-1px);
        }
        
        .navbar-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            height: 2px;
            background: var(--primary-600, #3b82f6);
        }
        
        /* Mobile menu animation */
        #mobile-menu {
            transition: all 0.3s ease;
        }
        
        /* Logo animation */
        .logo-container:hover .logo-icon {
            transform: scale(1.1);
        }
        
        .logo-icon {
            transition: transform 0.3s ease;
        }
        
        /* Button hover effects */
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        .login-btn {
            transition: all 0.3s ease;
        }
        
        /* Navbar alignment fixes */
        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            position: relative;
        }
        
        .navbar-logo {
            position: absolute;
            left: -2rem;
            flex-shrink: 0;
        }
        
        .navbar-menu {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            margin-left: 5rem;
        }
        
        .navbar-actions {
            position: absolute;
            right: -2rem;
            flex-shrink: 0;
        }
    </style>
    <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
        <div class="navbar-container h-16">
            <!-- Logo & School Name -->
            <div class="navbar-logo">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo Sekolah" class="h-10 w-10 object-contain">
                    <div>
                        <h1 class="text-xl font-bold text-primary-500">SMP Negeri 01</h1>
                        <p class="text-sm text-gray-600">Namrole</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="navbar-menu hidden lg:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="navbar-link text-primary-500 hover:text-primary-600 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-primary-600 active' : '' }}">
                    Home
                </a>
                <a href="{{ route('about') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('about') ? 'text-primary-600 active' : '' }}">
                    Tentang
                </a>
                <div class="relative group">
                    <a href="{{ route('academic.curriculum') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('academic.*') ? 'text-primary-600 active' : '' }}">
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
                <a href="{{ route('facilities') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('facilities*') ? 'text-primary-600 active' : '' }}">
                    Fasilitas
                </a>
                <a href="{{ route('ppdb') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('ppdb*') ? 'text-primary-600 active' : '' }}">
                    PPDB
                </a>
                <a href="{{ route('gallery') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('gallery*') ? 'text-primary-600 active' : '' }}">
                    Galeri
                </a>
                <a href="{{ route('library') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('library*') ? 'text-primary-600 active' : '' }}">
                    Perpustakaan
                </a>
                <a href="{{ route('news') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('news*') ? 'text-primary-600 active' : '' }}">
                    Berita
                </a>
            </div>

            <!-- Desktop CTA Button -->
            <div class="navbar-actions hidden lg:block">
                <a href="{{ route('login') }}" class="login-btn bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 shadow-md hover:shadow-lg">
                    Portal Login
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <button type="button" class="text-gray-700 hover:text-primary-500 focus:outline-none focus:text-primary-500 transition-colors duration-200" onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="lg:hidden hidden">
            <div class="px-4 pt-3 pb-4 space-y-2 bg-gray-50 rounded-lg mt-2">
                <a href="{{ route('home') }}" class="text-primary-500 block px-4 py-3 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-600' : '' }}">
                    Home
                </a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-primary-500 block px-4 py-3 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'bg-primary-50 text-primary-600' : '' }}">
                    Tentang
                </a>
                <a href="{{ route('academic.curriculum') }}" class="text-gray-700 hover:text-primary-500 block px-4 py-3 rounded-md text-base font-medium {{ request()->routeIs('academic.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    Akademik
                </a>
                <a href="{{ route('facilities') }}" class="text-gray-700 hover:text-primary-500 block px-4 py-3 rounded-md text-base font-medium {{ request()->routeIs('facilities*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    Fasilitas
                </a>
                <a href="{{ route('ppdb') }}" class="text-gray-700 hover:text-primary-500 block px-4 py-3 rounded-md text-base font-medium {{ request()->routeIs('ppdb*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    PPDB
                </a>
                <a href="{{ route('gallery') }}" class="text-gray-700 hover:text-primary-500 block px-4 py-3 rounded-md text-base font-medium {{ request()->routeIs('gallery*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    Galeri
                </a>
                <a href="{{ route('library') }}" class="text-gray-700 hover:text-primary-500 block px-4 py-3 rounded-md text-base font-medium {{ request()->routeIs('library*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    Perpustakaan
                </a>
                <a href="{{ route('news') }}" class="text-gray-700 hover:text-primary-500 block px-4 py-3 rounded-md text-base font-medium {{ request()->routeIs('news*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    Berita
                </a>
                <div class="pt-4 border-t border-gray-200">
                    <a href="{{ route('login') }}" class="bg-primary-500 hover:bg-primary-600 text-white block px-4 py-3 rounded-md text-base font-medium text-center transition-colors duration-200">
                        Portal Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu) {
            mobileMenu.classList.toggle('hidden');
        }
    }
    
    // Make function globally available
    window.toggleMobileMenu = toggleMobileMenu;
    
    // Handle dropdown hover for desktop
    const dropdownGroups = document.querySelectorAll('.group');
    dropdownGroups.forEach(group => {
        const dropdown = group.querySelector('.group-hover\\:opacity-100');
        if (dropdown) {
            group.addEventListener('mouseenter', function() {
                dropdown.classList.remove('opacity-0', 'invisible');
                dropdown.classList.add('opacity-100', 'visible');
            });
            
            group.addEventListener('mouseleave', function() {
                dropdown.classList.remove('opacity-100', 'visible');
                dropdown.classList.add('opacity-0', 'invisible');
            });
        }
    });
});
</script>