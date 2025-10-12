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
            transform: translateY(-10px);
            opacity: 0;
        }
        
        #mobile-menu.show {
            transform: translateY(0);
            opacity: 1;
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
        
        /* Responsive navbar container */
        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            height: 4rem;
        }
        
        /* Mobile responsive adjustments */
        @media (max-width: 1023px) {
            .navbar-container {
                justify-content: space-between;
            }
            
            .navbar-logo {
                position: static;
                flex-shrink: 0;
            }
            
            .navbar-menu {
                display: none;
            }
            
            .navbar-actions {
                position: static;
                flex-shrink: 0;
            }
        }
        
        /* Desktop layout */
        @media (min-width: 1024px) {
            .navbar-container {
                justify-content: center;
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
        }
        
        /* Mobile menu button */
        .mobile-menu-btn {
            display: block;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
        }
        
        .mobile-menu-btn:hover {
            background-color: #f3f4f6;
        }
        
        @media (min-width: 1024px) {
            .mobile-menu-btn {
                display: none;
            }
        }
        
        /* Mobile menu dropdown */
        .mobile-menu-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e5e7eb;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            z-index: 50;
            transform: translateY(-10px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .mobile-menu-dropdown.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }
        
        /* Mobile menu items */
        .mobile-menu-item {
            display: block;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.2s;
        }
        
        .mobile-menu-item:hover {
            background-color: #f9fafb;
            color: #3b82f6;
        }
        
        .mobile-menu-item.active {
            background-color: #eff6ff;
            color: #2563eb;
            border-left: 4px solid #3b82f6;
        }
        
        /* Hamburger animation */
        .hamburger {
            width: 24px;
            height: 24px;
            position: relative;
            cursor: pointer;
        }
        
        .hamburger span {
            display: block;
            position: absolute;
            height: 2px;
            width: 100%;
            background: #374151;
            border-radius: 1px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }
        
        .hamburger span:nth-child(1) {
            top: 0px;
        }
        
        .hamburger span:nth-child(2) {
            top: 8px;
        }
        
        .hamburger span:nth-child(3) {
            top: 16px;
        }
        
        .hamburger.open span:nth-child(1) {
            top: 8px;
            transform: rotate(135deg);
        }
        
        .hamburger.open span:nth-child(2) {
            opacity: 0;
            left: -60px;
        }
        
        .hamburger.open span:nth-child(3) {
            top: 8px;
            transform: rotate(-135deg);
        }
    </style>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="navbar-container">
            <!-- Logo & School Name -->
            <div class="navbar-logo">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo Sekolah" class="h-10 w-10 object-contain">
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold text-primary-500">SMP Negeri 01</h1>
                        <p class="text-xs sm:text-sm text-gray-600">Namrole</p>
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
                <button type="button" class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <div class="hamburger" id="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div class="mobile-menu-dropdown lg:hidden" id="mobile-menu-dropdown">
        <div class="px-4 py-2">
            <!-- Mobile Menu Items -->
            <nav class="space-y-1">
                <a href="{{ route('home') }}" class="mobile-menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Home</span>
                    </div>
                </a>
                
                <a href="{{ route('about') }}" class="mobile-menu-item {{ request()->routeIs('about') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Tentang</span>
                    </div>
                </a>
                
                <a href="{{ route('academic.curriculum') }}" class="mobile-menu-item {{ request()->routeIs('academic.*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Akademik</span>
                    </div>
                </a>
                
                <a href="{{ route('facilities') }}" class="mobile-menu-item {{ request()->routeIs('facilities*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Fasilitas</span>
                    </div>
                </a>
                
                <a href="{{ route('ppdb') }}" class="mobile-menu-item {{ request()->routeIs('ppdb*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>PPDB</span>
                    </div>
                </a>
                
                <a href="{{ route('gallery') }}" class="mobile-menu-item {{ request()->routeIs('gallery*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Galeri</span>
                    </div>
                </a>
                
                <a href="{{ route('library') }}" class="mobile-menu-item {{ request()->routeIs('library*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Perpustakaan</span>
                    </div>
                </a>
                
                <a href="{{ route('news') }}" class="mobile-menu-item {{ request()->routeIs('news*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <span>Berita</span>
                    </div>
                </a>
            </nav>

            <!-- Mobile CTA Button -->
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('login') }}" class="w-full bg-primary-500 hover:bg-primary-600 text-white block px-4 py-3 rounded-lg text-base font-medium text-center transition-colors duration-200">
                    Portal Login
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    function toggleMobileMenu() {
        const mobileMenuDropdown = document.getElementById('mobile-menu-dropdown');
        const hamburger = document.getElementById('hamburger');
        
        if (mobileMenuDropdown && hamburger) {
            mobileMenuDropdown.classList.toggle('show');
            hamburger.classList.toggle('open');
        }
    }
    
    // Close mobile menu
    function closeMobileMenu() {
        const mobileMenuDropdown = document.getElementById('mobile-menu-dropdown');
        const hamburger = document.getElementById('hamburger');
        
        if (mobileMenuDropdown && hamburger) {
            mobileMenuDropdown.classList.remove('show');
            hamburger.classList.remove('open');
        }
    }
    
    // Make functions globally available
    window.toggleMobileMenu = toggleMobileMenu;
    window.closeMobileMenu = closeMobileMenu;
    
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
    
    // Close mobile menu when clicking on menu items
    const mobileMenuItems = document.querySelectorAll('.mobile-menu-item');
    mobileMenuItems.forEach(item => {
        item.addEventListener('click', function() {
            closeMobileMenu();
        });
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        const mobileMenuDropdown = document.getElementById('mobile-menu-dropdown');
        const hamburger = document.getElementById('hamburger');
        const navbar = document.querySelector('nav');
        
        if (mobileMenuDropdown && hamburger && navbar) {
            if (!navbar.contains(e.target) && mobileMenuDropdown.classList.contains('show')) {
                closeMobileMenu();
            }
        }
    });
    
    // Close mobile menu when pressing escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMobileMenu();
        }
    });
});
</script>