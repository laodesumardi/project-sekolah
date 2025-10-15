<!-- Mobile menu button -->
<div class="lg:hidden fixed top-4 left-4 z-50">
    <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500 bg-white shadow-lg">
        <span class="sr-only">Open main menu</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="menu-icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
        <svg class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close-icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>

<!-- Mobile overlay -->
<div id="mobile-overlay" class="lg:hidden fixed inset-0 z-40 bg-gray-600 bg-opacity-75 hidden"></div>

<!-- Sidebar -->
<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col" id="desktop-sidebar">
    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-green-600 px-6 pb-4">
        <!-- Logo -->
        <div class="flex h-16 shrink-0 items-center">
            <div class="h-8 w-8 bg-white rounded-lg flex items-center justify-center">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <span class="ml-2 text-white font-bold text-lg">Portal Siswa</span>
        </div>
        
        <!-- Student Profile Mini -->
        <div class="flex items-center space-x-3 p-3 bg-white bg-opacity-10 rounded-lg">
            @if(Auth::user()->profile)
                <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile->profile_picture_url }}" alt="{{ Auth::user()->name }}">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-white text-opacity-75 truncate">{{ Auth::user()->profile->class->name ?? 'Kelas' }}</p>
                </div>
            @else
                <div class="h-10 w-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                    <i class="fas fa-user text-white text-lg"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-white text-opacity-75 truncate">Siswa</p>
                </div>
            @endif
        </div>
        
        <!-- Navigation -->
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('student.dashboard') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.dashboard') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        
                        <!-- Jadwal Pelajaran -->
                        <li>
                            <a href="{{ route('student.jadwal.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.jadwal.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                                </svg>
                                Jadwal Pelajaran
                            </a>
                        </li>
                        
                        <!-- Materi Pembelajaran -->
                        <li>
                            <a href="{{ route('student.materi.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.materi.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                                Materi Pembelajaran
                            </a>
                        </li>
                        
                        <!-- Pembelajaran -->
                        <li>
                            <a href="{{ route('student.pembelajaran.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.pembelajaran.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                                Pembelajaran
                            </a>
                        </li>
                        
                        <!-- Tugas & Ujian -->
                        <li>
                            <a href="{{ route('student.tugas.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.tugas.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Tugas & Ujian
                            </a>
                        </li>
                        
                        
                        <!-- Nilai & Rapor -->
                        <li>
                            <a href="{{ route('student.nilai.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.nilai.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                                Nilai & Rapor
                            </a>
                        </li>
                        
                        <!-- Absensi -->
                        <li>
                            <a href="{{ route('student.absensi.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.absensi.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0z" />
                                </svg>
                                Absensi
                            </a>
                        </li>
                        
                        
                        
                        <!-- Forum Diskusi -->
                        <li>
                            <a href="{{ route('student.forum.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.forum.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Forum Diskusi
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Profile & Settings -->
                <li class="mt-auto">
                    <ul role="list" class="-mx-2 space-y-1">
                        <li>
                            <a href="{{ route('student.profil.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.profil.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Profil
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('student.pengaturan.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.pengaturan.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Pengaturan
                            </a>
                        </li>
                        
                        <!-- Logout -->
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-white hover:text-white hover:bg-white hover:bg-opacity-10 w-full text-left">
                                    <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Mobile sidebar -->
<div id="mobile-sidebar" class="lg:hidden fixed inset-y-0 left-0 z-50 w-64 bg-green-600 transform -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="flex grow flex-col gap-y-5 overflow-y-auto px-6 pb-4">
        <!-- Mobile header -->
        <div class="flex h-16 shrink-0 items-center justify-between">
            <div class="flex items-center">
                <div class="h-8 w-8 bg-white rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="ml-2 text-white font-bold text-lg">Portal Siswa</span>
            </div>
            <button type="button" id="mobile-close-button" class="p-2 rounded-md text-white hover:bg-white hover:bg-opacity-10">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Student Profile Mini -->
        <div class="flex items-center space-x-3 p-3 bg-white bg-opacity-10 rounded-lg">
            @if(Auth::user()->profile)
                <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile->profile_picture_url }}" alt="{{ Auth::user()->name }}">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-white text-opacity-75 truncate">{{ Auth::user()->profile->class->name ?? 'Kelas' }}</p>
                </div>
            @else
                <div class="h-10 w-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                    <i class="fas fa-user text-white text-lg"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-white text-opacity-75 truncate">Siswa</p>
                </div>
            @endif
        </div>
        
        <!-- Navigation -->
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('student.dashboard') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.dashboard') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        
                        <!-- Jadwal Pelajaran -->
                        <li>
                            <a href="{{ route('student.jadwal.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.jadwal.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                                </svg>
                                Jadwal Pelajaran
                            </a>
                        </li>
                        
                        <!-- Materi Pembelajaran -->
                        <li>
                            <a href="{{ route('student.materi.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.materi.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                                Materi Pembelajaran
                            </a>
                        </li>
                        
                        <!-- Pembelajaran -->
                        <li>
                            <a href="{{ route('student.pembelajaran.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.pembelajaran.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                                Pembelajaran
                            </a>
                        </li>
                        
                        <!-- Tugas & Ujian -->
                        <li>
                            <a href="{{ route('student.tugas.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.tugas.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Tugas & Ujian
                            </a>
                        </li>
                        
                        <!-- Nilai & Rapor -->
                        <li>
                            <a href="{{ route('student.nilai.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.nilai.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                                Nilai & Rapor
                            </a>
                        </li>
                        
                        <!-- Absensi -->
                        <li>
                            <a href="{{ route('student.absensi.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.absensi.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0z" />
                                </svg>
                                Absensi
                            </a>
                        </li>
                        
                        
                        <!-- Forum Diskusi -->
                        <li>
                            <a href="{{ route('student.forum.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.forum.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Forum Diskusi
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Profile & Settings -->
                <li class="mt-auto">
                    <ul role="list" class="-mx-2 space-y-1">
                        <li>
                            <a href="{{ route('student.profil.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.profil.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Profil
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('student.pengaturan.index') }}" 
                               class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold {{ request()->routeIs('student.pengaturan.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:text-white hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Pengaturan
                            </a>
                        </li>
                        
                        <!-- Logout -->
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-white hover:text-white hover:bg-white hover:bg-opacity-10 w-full text-left">
                                    <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>

<script>
// Mobile menu functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileCloseButton = document.getElementById('mobile-close-button');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    // Open mobile menu
    mobileMenuButton.addEventListener('click', function() {
        mobileSidebar.classList.remove('-translate-x-full');
        mobileOverlay.classList.remove('hidden');
        menuIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });

    // Close mobile menu
    function closeMobileMenu() {
        mobileSidebar.classList.add('-translate-x-full');
        mobileOverlay.classList.add('hidden');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    mobileCloseButton.addEventListener('click', closeMobileMenu);
    mobileOverlay.addEventListener('click', closeMobileMenu);

    // Close menu when clicking on a link
    const mobileLinks = mobileSidebar.querySelectorAll('a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileSidebar.classList.contains('-translate-x-full')) {
            closeMobileMenu();
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) { // lg breakpoint
            closeMobileMenu();
        }
    });
});
</script>
