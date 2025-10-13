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

        <!-- Akademik -->
        <li class="mt-4">
            <div class="px-4 py-2">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Akademik</h3>
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

        <!-- Ekstrakurikuler -->
        <li>
            <a href="{{ route('admin.extracurriculars.index') }}" 
               class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.extracurriculars.*') ? 'bg-primary-600' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Ekstrakurikuler
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

        <!-- Prestasi -->
        <li>
            <a href="{{ route('admin.achievements.index') }}" 
               class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.achievements.*') ? 'bg-primary-600' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
                Prestasi
            </a>
        </li>

        <!-- PPDB -->
        <li class="mt-6">
            <div class="px-4 py-2">
                <span class="text-primary-200 text-xs font-semibold uppercase tracking-wider">PPDB</span>
            </div>
        </li>

        <!-- Dashboard PPDB -->
        <li>
            <a href="{{ route('admin.ppdb.dashboard') }}" 
               class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.ppdb.dashboard') ? 'bg-primary-600' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Dashboard PPDB
            </a>
        </li>

        <!-- Pendaftar -->
        <li>
            <a href="{{ route('admin.ppdb.index') }}" 
               class="flex items-center px-4 py-3 text-white hover:bg-primary-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.ppdb.index') || request()->routeIs('admin.ppdb.show') ? 'bg-primary-600' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                Data Pendaftar
            </a>
        </li>

        <!-- Settings PPDB -->
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

        <!-- Divider -->
        <li class="border-t border-primary-400 my-6"></li>

        <!-- User Management (Coming Soon) -->
        <li>
            <div class="px-4 py-2">
                <span class="text-primary-200 text-xs font-semibold uppercase tracking-wider">User Management</span>
            </div>
        </li>

        <li>
            <a href="#" 
               class="flex items-center px-4 py-3 text-primary-300 hover:bg-primary-600 rounded-lg transition-colors duration-200 opacity-50 cursor-not-allowed">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                Manajemen User
                <span class="ml-auto text-xs bg-primary-400 text-white px-2 py-1 rounded-full">Soon</span>
            </a>
        </li>
        </ul>
    </nav>

    <!-- Sidebar Footer -->
    <div class="flex-shrink-0 p-4 border-t border-primary-400">
        <div class="text-center">
            <p class="text-primary-200 text-xs">© 2024 SMP Negeri 01 Namrole</p>
            <p class="text-primary-300 text-xs">Admin Panel v1.0</p>
        </div>
    </div>
</div>
