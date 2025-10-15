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
                padding: 0.5rem 0;
            }
            
            .navbar-logo {
                position: static;
                flex-shrink: 0;
            }
            
            .navbar-logo h1 {
                font-size: 1rem;
            }
            
            .navbar-logo p {
                font-size: 0.75rem;
            }
            
            .navbar-menu {
                display: none;
            }
            
            .navbar-actions {
                position: static;
                flex-shrink: 0;
            }
        }
        
        /* Extra small screens */
        @media (max-width: 480px) {
            .navbar-container {
                padding: 0.25rem 0;
            }
            
            .navbar-logo h1 {
                font-size: 0.9rem;
            }
            
            .navbar-logo p {
                font-size: 0.7rem;
            }
            
            .mobile-menu-item {
                padding: 0.6rem 0.8rem;
                font-size: 0.85rem;
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
                margin-left: 8rem;
                margin-right: 3.5rem;
                gap: 0.1rem;
            }
            
            .navbar-actions {
                position: absolute;
                right: -2.5rem;
                flex-shrink: 0;
            }
            
            /* Consistent spacing for all menu items */
            .navbar-menu a {
                margin: 0;
            }
            
            /* Desktop dropdown styling */
            .group:hover .group-hover\\:opacity-100 {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
                animation: dropdownSlideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .group:hover .group-hover\\:visible {
                visibility: visible;
            }
            
            /* Dropdown animation */
            @keyframes dropdownSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            /* Dropdown item hover effects */
            .group .group-hover\\:opacity-100 a:hover {
                background-color: #eff6ff;
                color: #2563eb;
                transform: translateX(4px);
            }
            
            /* Active state for dropdown items */
            .group .group-hover\\:opacity-100 a.active {
                background-color: #eff6ff;
                color: #2563eb;
                border-left: 3px solid #3b82f6;
            }
            
            /* Desktop dropdown styling - same as mobile */
            .group .group-hover\\:opacity-100 a {
                display: flex;
                align-items: center;
                padding: 12px 16px;
                transition: all 0.2s ease;
            }
            
            .group .group-hover\\:opacity-100 a:hover {
                background-color: #f9fafb;
                color: #3b82f6;
            }
            
            .group .group-hover\\:opacity-100 a.active {
                background-color: #eff6ff;
                color: #2563eb;
                border-left: 4px solid #3b82f6;
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
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
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
            max-height: 80vh;
            overflow-y: auto;
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
            font-size: 0.9rem;
            line-height: 1.4;
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
        
        /* Mobile dropdown styles */
        .mobile-dropdown {
            border-bottom: 1px solid #f3f4f6;
        }
        
        .mobile-dropdown button {
            border: none;
            background: none;
            cursor: pointer;
            width: 100%;
            text-decoration: none;
        }
        
        .mobile-dropdown button:hover {
            background-color: #f9fafb;
            color: #3b82f6;
        }
        
        .mobile-dropdown-content {
            background-color: #f9fafb;
            border-left: 4px solid #e5e7eb;
        }
        
        .mobile-dropdown-content .mobile-menu-item {
            border-bottom: 1px solid #e5e7eb;
        }
        
        .mobile-dropdown-content .mobile-menu-item:last-child {
            border-bottom: none;
        }
        
        .mobile-dropdown-content .mobile-menu-item:hover {
            background-color: #f3f4f6;
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
            <div class="navbar-menu hidden lg:flex items-center space-x-4">
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
                    <div class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform translate-y-1 group-hover:translate-y-0">
                        <div class="py-2">
                            <a href="{{ route('academic.curriculum') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors duration-200 {{ request()->routeIs('academic.curriculum') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span>Kurikulum</span>
                                </div>
                            </a>
                            <a href="{{ route('academic.teachers') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors duration-200 {{ request()->routeIs('academic.teachers') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Tenaga Pendidik</span>
                                </div>
                            </a>
                            <a href="{{ route('extracurriculars.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors duration-200 {{ request()->routeIs('extracurriculars.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span>Ekstrakurikuler</span>
                                </div>
                            </a>
                            <a href="{{ route('academic.calendar') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors duration-200 {{ request()->routeIs('academic.calendar') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Kalender Akademik</span>
                                </div>
                            </a>
                            <a href="{{ route('academic.achievements') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors duration-200 {{ request()->routeIs('academic.achievements') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                    <span>Prestasi</span>
                                </div>
                            </a>
                            <a href="{{ route('accreditation') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors duration-200 {{ request()->routeIs('accreditation') ? 'bg-primary-50 text-primary-600' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Akreditasi</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('facilities.index') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('facilities*') ? 'text-primary-600 active' : '' }}">
                    Fasilitas
                </a>
                <a href="{{ route('gallery.index') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('gallery*') ? 'text-primary-600 active' : '' }}">
                    Galeri
                </a>
                <a href="{{ route('ppdb.index') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('ppdb*') ? 'text-primary-600 active' : '' }}">
                    PPDB
                </a>
                <div class="relative group">
                    <button class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 flex items-center {{ request()->routeIs('library*') ? 'text-primary-600 active' : '' }}">
                        Perpustakaan
                        <svg class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute left-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-2">
                            <a href="{{ route('library') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 mr-3 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <div>
                                    <div class="font-medium">Perpustakaan Digital</div>
                                    <div class="text-sm text-gray-500">Akses koleksi digital</div>
                                </div>
                            </a>
                            <a href="https://saranaguru.erlanggaonline.co.id/user/login" target="_blank" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <div class="font-medium">Sarana Guru</div>
                                    <div class="text-sm text-gray-500">Portal pembelajaran guru</div>
                                </div>
                            </a>
                            <a href="https://e-library.erlanggaonline.co.id/user/TWpVMk56RT0" target="_blank" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <div>
                                    <div class="font-medium">E-Library</div>
                                    <div class="text-sm text-gray-500">Perpustakaan digital Erlangga</div>
                                </div>
                            </a>
                            <a href="https://asesmen.erlanggaonline.co.id/" target="_blank" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M6 16h.01" />
                                </svg>
                                <div>
                                    <div class="font-medium">Asesmen Online</div>
                                    <div class="text-sm text-gray-500">Platform evaluasi pembelajaran</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('news') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('news*') ? 'text-primary-600 active' : '' }}">
                    Berita
                </a>
                <a href="{{ route('contact') }}" class="navbar-link text-gray-700 hover:text-primary-500 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('contact*') ? 'text-primary-600 active' : '' }}">
                    Kontak
                </a>
            </div>

            <!-- Desktop CTA Button -->
            <div class="navbar-actions hidden lg:block">
                @auth
                    <a href="{{ route('dashboard') }}" class="login-btn bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 shadow-md hover:shadow-lg">
                        Dashboard
                    </a>
                @else
                <a href="{{ route('login') }}" class="login-btn bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 shadow-md hover:shadow-lg">
                    Portal Login
                </a>
                @endauth
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
                
                <!-- Akademik Dropdown for Mobile -->
                <div class="mobile-dropdown">
                    <button class="mobile-menu-item w-full text-left flex items-center" data-dropdown="academic-dropdown" type="button">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Akademik</span>
                        </div>
                    </button>
                    <div class="mobile-dropdown-content hidden" id="academic-dropdown">
                        <a href="{{ route('academic.curriculum') }}" class="mobile-menu-item pl-8 {{ request()->routeIs('academic.curriculum') ? 'active' : '' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span>Kurikulum</span>
                            </div>
                        </a>
                        <a href="{{ route('academic.teachers') }}" class="mobile-menu-item pl-8 {{ request()->routeIs('academic.teachers') ? 'active' : '' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>Tenaga Pendidik</span>
                            </div>
                        </a>
                        <a href="{{ route('extracurriculars.index') }}" class="mobile-menu-item pl-8 {{ request()->routeIs('extracurriculars.*') ? 'active' : '' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span>Ekstrakurikuler</span>
                            </div>
                        </a>
                        <a href="{{ route('academic.calendar') }}" class="mobile-menu-item pl-8 {{ request()->routeIs('academic.calendar') ? 'active' : '' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Kalender Akademik</span>
                            </div>
                        </a>
                        <a href="{{ route('academic.achievements') }}" class="mobile-menu-item pl-8 {{ request()->routeIs('academic.achievements') ? 'active' : '' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                <span>Prestasi</span>
                            </div>
                        </a>
                        <a href="{{ route('accreditation') }}" class="mobile-menu-item pl-8 {{ request()->routeIs('accreditation') ? 'active' : '' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Akreditasi</span>
                            </div>
                        </a>
                    </div>
                </div>
                
                <a href="{{ route('facilities.index') }}" class="mobile-menu-item {{ request()->routeIs('facilities*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Fasilitas</span>
                    </div>
                </a>
                
                <a href="{{ route('gallery.index') }}" class="mobile-menu-item {{ request()->routeIs('gallery*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Galeri</span>
                    </div>
                </a>
                
                <a href="{{ route('ppdb.index') }}" class="mobile-menu-item {{ request()->routeIs('ppdb*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>PPDB</span>
                    </div>
                </a>
                
                <div class="mobile-menu-item">
                    <button onclick="toggleMobileDropdown('library-dropdown')" class="flex items-center justify-between w-full">
                        <div class="flex items-center space-x-3">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Perpustakaan</span>
                        </div>
                        <svg class="h-4 w-4 transition-transform duration-200" id="library-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="library-dropdown" class="hidden ml-8 mt-2 space-y-2">
                        <a href="{{ route('library') }}" class="flex items-center space-x-3 text-gray-600 hover:text-primary-500 py-2">
                            <svg class="h-4 w-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Perpustakaan Digital</span>
                        </a>
                        <a href="https://saranaguru.erlanggaonline.co.id/user/login" target="_blank" class="flex items-center space-x-3 text-gray-600 hover:text-primary-500 py-2">
                            <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Sarana Guru</span>
                        </a>
                        <a href="https://e-library.erlanggaonline.co.id/user/TWpVMk56RT0" target="_blank" class="flex items-center space-x-3 text-gray-600 hover:text-primary-500 py-2">
                            <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>E-Library</span>
                        </a>
                        <a href="https://asesmen.erlanggaonline.co.id/" target="_blank" class="flex items-center space-x-3 text-gray-600 hover:text-primary-500 py-2">
                            <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M6 16h.01" />
                            </svg>
                            <span>Asesmen Online</span>
                        </a>
                    </div>
                </div>
                
                <a href="{{ route('news') }}" class="mobile-menu-item {{ request()->routeIs('news*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <span>Berita</span>
                    </div>
                </a>
                
                <a href="{{ route('contact') }}" class="mobile-menu-item {{ request()->routeIs('contact*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Kontak</span>
                    </div>
                </a>
            </nav>

            <!-- Mobile CTA Button -->
            <div class="mt-4 pt-4 border-t border-gray-200">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full bg-primary-500 hover:bg-primary-600 text-white block px-4 py-3 rounded-lg text-base font-medium text-center transition-colors duration-200">
                        Dashboard
                    </a>
                @else
                <a href="{{ route('login') }}" class="w-full bg-primary-500 hover:bg-primary-600 text-white block px-4 py-3 rounded-lg text-base font-medium text-center transition-colors duration-200">
                    Portal Login
                </a>
                @endauth
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
    
    // Mobile dropdown toggle function
    function toggleMobileDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const arrow = document.getElementById(dropdownId.replace('-dropdown', '-arrow'));
        
        if (dropdown) {
            // Toggle dropdown visibility
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                if (arrow) {
                    arrow.style.transform = 'rotate(180deg)';
                }
            } else {
                dropdown.classList.add('hidden');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
        }
    }
    
    // Make functions globally available
    window.toggleMobileMenu = toggleMobileMenu;
    window.closeMobileMenu = closeMobileMenu;
    window.toggleMobileDropdown = toggleMobileDropdown;
    
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
    
    // Close mobile menu when clicking on menu items (except dropdown buttons)
    const mobileMenuItems = document.querySelectorAll('.mobile-menu-item:not([data-dropdown])');
    mobileMenuItems.forEach(item => {
        item.addEventListener('click', function() {
            closeMobileMenu();
        });
    });
    
    // Handle mobile dropdown buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('[data-dropdown]')) {
            e.preventDefault();
            e.stopPropagation();
            const button = e.target.closest('[data-dropdown]');
            const dropdownId = button.getAttribute('data-dropdown');
            toggleMobileDropdown(dropdownId);
        }
    });
    
    // Prevent dropdown from closing when clicking on submenu items
    document.addEventListener('click', function(e) {
        if (e.target.closest('.mobile-dropdown-content')) {
            e.stopPropagation();
        }
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