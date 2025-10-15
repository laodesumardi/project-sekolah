<div class="flex flex-col h-full bg-white">
    <!-- Logo -->
    <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg">
        <div class="flex items-center">
            <i class="fas fa-graduation-cap text-2xl mr-3"></i>
            <div>
                <span class="text-lg font-bold">SMP Negeri 01 Namrole</span>
                <p class="text-xs text-blue-100">Dashboard Guru</p>
            </div>
        </div>
        <button onclick="toggleSidebar()" class="md:hidden text-white hover:text-blue-200 transition-colors duration-200">
            <i class="fas fa-bars text-lg"></i>
        </button>
    </div>

    <!-- Teacher Profile -->
    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
        @if(Auth::user()->teacher)
            <div class="flex items-center">
                <div class="relative">
                    <img src="{{ Auth::user()->teacher->profile_picture_url }}" 
                         alt="{{ Auth::user()->teacher->full_name }}" 
                         class="w-12 h-12 rounded-full object-cover border-3 border-blue-200 shadow-md">
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full shadow-sm"></div>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-bold text-gray-900">{{ Auth::user()->teacher->full_name }}</h3>
                    <p class="text-xs text-gray-600 font-medium">NIP: {{ Auth::user()->teacher->nip }}</p>
                    <p class="text-xs text-blue-600 font-medium">
                        {{ Auth::user()->teacher->subjects->first()->name ?? 'Mata Pelajaran' }}
                    </p>
                    <div class="flex items-center mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Aktif
                        </span>
                    </div>
                </div>
            </div>
        @else
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center shadow-md">
                    <i class="fas fa-user text-gray-600"></i>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                    <p class="text-xs text-gray-600 font-medium">Guru</p>
                    <div class="flex items-center mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Profil Belum Lengkap
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('teacher.dashboard') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('teacher.dashboard') ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-tachometer-alt w-5 h-5 mr-3 {{ request()->routeIs('teacher.dashboard') ? 'text-blue-600' : 'text-gray-500' }}"></i>
            <span>Dashboard</span>
            @if(request()->routeIs('teacher.dashboard'))
                <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
            @endif
        </a>

        <!-- Teaching Tools Section -->
        <div class="mt-6 mb-2">
            <h4 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Alat Mengajar</h4>
        </div>

        <!-- Assignments -->
        <a href="{{ route('teacher.assignments.index') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('teacher.assignments.*') ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-tasks w-5 h-5 mr-3 {{ request()->routeIs('teacher.assignments.*') ? 'text-blue-600' : 'text-gray-500' }}"></i>
            <span>Tugas</span>
            @if(request()->routeIs('teacher.assignments.*'))
                <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
            @endif
        </a>

        <!-- Grades -->
        <a href="{{ route('teacher.grades.index') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('teacher.grades.*') ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-chart-line w-5 h-5 mr-3 {{ request()->routeIs('teacher.grades.*') ? 'text-blue-600' : 'text-gray-500' }}"></i>
            <span>Nilai</span>
            @if(request()->routeIs('teacher.grades.*'))
                <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
            @endif
        </a>

        <!-- Attendance -->
        <a href="{{ route('teacher.attendance.index') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('teacher.attendance.*') ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-calendar-check w-5 h-5 mr-3 {{ request()->routeIs('teacher.attendance.*') ? 'text-blue-600' : 'text-gray-500' }}"></i>
            <span>Absensi</span>
            @if(request()->routeIs('teacher.attendance.*'))
                <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
            @endif
        </a>

        <!-- Learning Materials -->
        <a href="{{ route('teacher.learning-materials.index') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('teacher.learning-materials.*') ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-book w-5 h-5 mr-3 {{ request()->routeIs('teacher.learning-materials.*') ? 'text-blue-600' : 'text-gray-500' }}"></i>
            <span>Materi Pembelajaran</span>
            @if(request()->routeIs('teacher.learning-materials.*'))
                <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
            @endif
        </a>

        <!-- Schedules -->
        <a href="{{ route('teacher.schedules.index') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('teacher.schedules.*') ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-calendar-alt w-5 h-5 mr-3 {{ request()->routeIs('teacher.schedules.*') ? 'text-blue-600' : 'text-gray-500' }}"></i>
            <span>Jadwal</span>
            @if(request()->routeIs('teacher.schedules.*'))
                <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
            @endif
        </a>

        <!-- Quick Actions Section -->
        <div class="mt-6 mb-2">
            <h4 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi Cepat</h4>
        </div>

        <!-- Quick Create Assignment -->
        <a href="{{ route('teacher.assignments.create') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 text-gray-700 hover:bg-green-50 hover:text-green-700">
            <i class="fas fa-plus-circle w-5 h-5 mr-3 text-green-500"></i>
            <span>Buat Tugas</span>
        </a>

        <!-- Quick Upload Material -->
        <a href="{{ route('teacher.learning-materials.create') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 text-gray-700 hover:bg-green-50 hover:text-green-700">
            <i class="fas fa-upload w-5 h-5 mr-3 text-green-500"></i>
            <span>Upload Materi</span>
        </a>

        <!-- Quick Input Attendance -->
        <a href="{{ route('teacher.attendance.create') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 text-gray-700 hover:bg-green-50 hover:text-green-700">
            <i class="fas fa-user-check w-5 h-5 mr-3 text-green-500"></i>
            <span>Input Absensi</span>
        </a>

        <!-- Divider -->
        <div class="border-t border-gray-200 my-4"></div>

        <!-- Account Section -->
        <div class="mb-2">
            <h4 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Akun & Pengaturan</h4>
        </div>

        <!-- Profile -->
        <a href="{{ route('teacher.profile.show') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('teacher.profile.*') ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-user w-5 h-5 mr-3 {{ request()->routeIs('teacher.profile.*') ? 'text-blue-600' : 'text-gray-500' }}"></i>
            <span>Profil</span>
            @if(request()->routeIs('teacher.profile.*'))
                <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
            @endif
        </a>

        <!-- Settings -->
        <a href="#" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
            <i class="fas fa-cog w-5 h-5 mr-3 text-gray-500"></i>
            <span>Pengaturan</span>
        </a>

        <!-- Help -->
        <a href="#" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
            <i class="fas fa-question-circle w-5 h-5 mr-3 text-gray-500"></i>
            <span>Bantuan</span>
        </a>
    </nav>

    <!-- Footer -->
    <div class="px-4 py-4 border-t border-gray-200 bg-gray-50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="flex items-center w-full px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                <i class="fas fa-sign-out-alt w-5 h-5 mr-3 text-red-500"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</div>
