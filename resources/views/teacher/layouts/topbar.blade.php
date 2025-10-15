<div class="flex items-center justify-between h-16 px-6">
    <!-- Left side -->
    <div class="flex items-center">
        <button onclick="toggleSidebar()" class="md:hidden text-gray-600 hover:text-gray-900">
            <i class="fas fa-bars text-xl"></i>
    </button>

        <div class="ml-4">
            <h1 class="text-xl font-semibold text-gray-900">@yield('title', 'Dashboard Guru')</h1>
            <p class="text-sm text-gray-600">@yield('subtitle', 'Selamat datang di dashboard guru')</p>
                    </div>
                    </div>

    <!-- Right side -->
    <div class="flex items-center space-x-4">
            <!-- Notifications -->
        <div class="relative">
            <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-bell text-xl"></i>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
            </button>
        </div>

            <!-- Messages -->
        <div class="relative">
            <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-envelope text-xl"></i>
                <span class="absolute -top-1 -right-1 bg-blue-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">2</span>
            </button>
        </div>

        <!-- Profile Dropdown -->
            <div class="relative">
            <button onclick="toggleProfileDropdown()" class="flex items-center space-x-3 p-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                @if(Auth::user()->teacher)
                    <img src="{{ Auth::user()->teacher->profile_picture_url }}" 
                         alt="{{ Auth::user()->teacher->full_name }}" 
                         class="w-8 h-8 rounded-full object-cover">
                @else
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                @endif
                <div class="hidden md:block text-left">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-600">Guru</p>
                </div>
                <i class="fas fa-chevron-down text-xs"></i>
                </button>

            <!-- Profile Dropdown Menu -->
            <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50">
                <div class="py-1">
                    <a href="{{ route('teacher.profile.show') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user w-4 h-4 mr-3"></i>
                        Profil Saya
                    </a>
                    <a href="{{ route('teacher.profile.edit') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-edit w-4 h-4 mr-3"></i>
                        Edit Profil
                    </a>
                    <a href="{{ route('teacher.profile.security') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-shield-alt w-4 h-4 mr-3"></i>
                        Keamanan
                    </a>
                    <div class="border-t border-gray-200"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleProfileDropdown() {
    const dropdown = document.getElementById('profile-dropdown');
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('profile-dropdown');
        const button = event.target.closest('button[onclick="toggleProfileDropdown()"]');
    
        if (!button && !dropdown.contains(event.target)) {
        dropdown.classList.add('hidden');
    }
});
</script>
