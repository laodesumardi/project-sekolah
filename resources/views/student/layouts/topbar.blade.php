<!-- Top navigation -->
<div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
    <!-- Mobile menu button -->
    <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" onclick="toggleMobileMenu()">
        <span class="sr-only">Open sidebar</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    <!-- Separator -->
    <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true"></div>

    <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
        <!-- Global search -->
        <form class="relative flex flex-1" action="#" method="GET">
            <label for="search-field" class="sr-only">Search</label>
            <svg class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
            </svg>
            <input id="search-field" class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm" placeholder="Cari materi, tugas..." type="search" name="search">
        </form>

        <div class="flex items-center gap-x-4 lg:gap-x-6">
            <!-- Notifications -->
            <div class="relative">
                <button type="button" onclick="toggleNotificationDropdown()" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500 relative">
                    <span class="sr-only">View notifications</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <!-- Notification badge -->
                    <span id="notification-badge" class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">3</span>
                </button>
                
                <!-- Notification dropdown -->
                <div id="notification-dropdown" class="hidden absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900">Notifikasi</h3>
                            <a href="{{ route('student.notifications.index') }}" class="text-xs text-blue-600 hover:text-blue-500">Lihat semua</a>
                        </div>
                    </div>
                    <div id="notification-list" class="max-h-64 overflow-y-auto">
                        <!-- Notifications will be loaded here -->
                    </div>
                    <div class="px-4 py-2 border-t border-gray-200">
                        <button onclick="markAllNotificationsRead()" class="text-xs text-gray-600 hover:text-gray-500">Tandai semua dibaca</button>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="relative">
                <button type="button" onclick="toggleMessageDropdown()" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500 relative">
                    <span class="sr-only">View messages</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <!-- Message badge -->
                    <span id="message-badge" class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-blue-600 rounded-full">2</span>
                </button>
                
                <!-- Message dropdown -->
                <div id="message-dropdown" class="hidden absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900">Pesan</h3>
                            <a href="{{ route('student.messages.index') }}" class="text-xs text-blue-600 hover:text-blue-500">Lihat semua</a>
                        </div>
                    </div>
                    <div id="message-list" class="max-h-64 overflow-y-auto">
                        <!-- Messages will be loaded here -->
                    </div>
                    <div class="px-4 py-2 border-t border-gray-200">
                        <button onclick="markAllMessagesRead()" class="text-xs text-gray-600 hover:text-gray-500">Tandai semua dibaca</button>
                    </div>
                </div>
            </div>

            <!-- Separator -->
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200" aria-hidden="true"></div>

            <!-- Profile dropdown -->
            <div class="relative">
                <button type="button" class="-m-1.5 flex items-center p-1.5" onclick="toggleProfileDropdown()">
                    <span class="sr-only">Open user menu</span>
                    @if(Auth::user()->profile)
                        <img class="h-8 w-8 rounded-full bg-gray-50" src="{{ Auth::user()->profile->profile_picture_url }}" alt="{{ Auth::user()->name }}">
                    @else
                        <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-sm"></i>
                        </div>
                    @endif
                    <span class="hidden lg:flex lg:items-center">
                        <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{ Auth::user()->name }}</span>
                        <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>

                <!-- Profile dropdown menu -->
                <div id="profile-dropdown" class="hidden absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                    <a href="{{ route('student.profil.index') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">View Profile</a>
                    <a href="{{ route('student.profil.edit') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Edit Profile</a>
                    <a href="{{ route('student.profil.security') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Security</a>
                    <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Help Center</a>
                    <div class="border-t border-gray-100"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Logout</button>
                    </form>
                </div>
            </div>

            <!-- Dark mode toggle -->
            <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500" onclick="toggleDarkMode()">
                <span class="sr-only">Toggle dark mode</span>
                <svg id="sun-icon" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                </svg>
                <svg id="moon-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
function toggleMobileMenu() {
    // Mobile menu toggle logic
    console.log('Toggle mobile menu');
}

function toggleProfileDropdown() {
    const dropdown = document.getElementById('profile-dropdown');
    dropdown.classList.toggle('hidden');
}

function toggleNotificationDropdown() {
    const dropdown = document.getElementById('notification-dropdown');
    const messageDropdown = document.getElementById('message-dropdown');
    
    // Close message dropdown if open
    messageDropdown.classList.add('hidden');
    
    // Toggle notification dropdown
    dropdown.classList.toggle('hidden');
    
    // Load notifications if opening
    if (!dropdown.classList.contains('hidden')) {
        loadNotifications();
    }
}

function toggleMessageDropdown() {
    const dropdown = document.getElementById('message-dropdown');
    const notificationDropdown = document.getElementById('notification-dropdown');
    
    // Close notification dropdown if open
    notificationDropdown.classList.add('hidden');
    
    // Toggle message dropdown
    dropdown.classList.toggle('hidden');
    
    // Load messages if opening
    if (!dropdown.classList.contains('hidden')) {
        loadMessages();
    }
}

function loadNotifications() {
    fetch('/siswa/notifikasi/recent')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('notification-list');
            container.innerHTML = '';
            
            if (data.notifications && data.notifications.length > 0) {
                data.notifications.forEach(notification => {
                    const notificationElement = createNotificationElement(notification);
                    container.appendChild(notificationElement);
                });
            } else {
                container.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada notifikasi</div>';
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            document.getElementById('notification-list').innerHTML = '<div class="px-4 py-3 text-sm text-red-500 text-center">Gagal memuat notifikasi</div>';
        });
}

function loadMessages() {
    fetch('/siswa/pesan/recent')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('message-list');
            container.innerHTML = '';
            
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(message => {
                    const messageElement = createMessageElement(message);
                    container.appendChild(messageElement);
                });
            } else {
                container.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada pesan</div>';
            }
        })
        .catch(error => {
            console.error('Error loading messages:', error);
            document.getElementById('message-list').innerHTML = '<div class="px-4 py-3 text-sm text-red-500 text-center">Gagal memuat pesan</div>';
        });
}

function createNotificationElement(notification) {
    const div = document.createElement('div');
    div.className = `px-4 py-3 hover:bg-gray-50 cursor-pointer ${!notification.is_read ? 'bg-blue-50' : ''}`;
    div.innerHTML = `
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5a1.5 1.5 0 01-1.5-1.5V6a1.5 1.5 0 011.5-1.5h15A1.5 1.5 0 0121 6v12a1.5 1.5 0 01-1.5 1.5h-15z" />
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">${notification.title}</p>
                <p class="text-xs text-gray-500 truncate">${notification.message}</p>
                <p class="text-xs text-gray-400 mt-1">${formatTime(notification.created_at)}</p>
            </div>
            ${!notification.is_read ? '<div class="w-2 h-2 bg-blue-600 rounded-full"></div>' : ''}
        </div>
    `;
    
    div.addEventListener('click', () => {
        window.location.href = '/siswa/notifikasi';
    });
    
    return div;
}

function createMessageElement(message) {
    const div = document.createElement('div');
    div.className = `px-4 py-3 hover:bg-gray-50 cursor-pointer ${!message.is_read ? 'bg-blue-50' : ''}`;
    div.innerHTML = `
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <img class="w-8 h-8 rounded-full" src="${message.from_avatar}" alt="${message.from}">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">${message.from}</p>
                <p class="text-xs text-gray-500 truncate">${message.subject}</p>
                <p class="text-xs text-gray-400 mt-1">${formatTime(message.created_at)}</p>
            </div>
            ${!message.is_read ? '<div class="w-2 h-2 bg-blue-600 rounded-full"></div>' : ''}
        </div>
    `;
    
    div.addEventListener('click', () => {
        window.location.href = '/siswa/pesan';
    });
    
    return div;
}

function markAllNotificationsRead() {
    fetch('/siswa/notifikasi/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update badge
            document.getElementById('notification-badge').classList.add('hidden');
            // Reload notifications
            loadNotifications();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function markAllMessagesRead() {
    fetch('/siswa/pesan/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update badge
            document.getElementById('message-badge').classList.add('hidden');
            // Reload messages
            loadMessages();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function formatTime(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInMinutes = Math.floor((now - date) / (1000 * 60));
    
    if (diffInMinutes < 1) return 'Baru saja';
    if (diffInMinutes < 60) return `${diffInMinutes} menit yang lalu`;
    
    const diffInHours = Math.floor(diffInMinutes / 60);
    if (diffInHours < 24) return `${diffInHours} jam yang lalu`;
    
    const diffInDays = Math.floor(diffInHours / 24);
    if (diffInDays < 7) return `${diffInDays} hari yang lalu`;
    
    return date.toLocaleDateString('id-ID');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const notificationDropdown = document.getElementById('notification-dropdown');
    const messageDropdown = document.getElementById('message-dropdown');
    const notificationButton = event.target.closest('[onclick="toggleNotificationDropdown()"]');
    const messageButton = event.target.closest('[onclick="toggleMessageDropdown()"]');
    
    if (!notificationButton && !notificationDropdown.contains(event.target)) {
        notificationDropdown.classList.add('hidden');
    }
    
    if (!messageButton && !messageDropdown.contains(event.target)) {
        messageDropdown.classList.add('hidden');
    }
});

// Auto-refresh notification and message counts
setInterval(() => {
    fetch('/siswa/notifikasi/unread-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notification-badge');
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        })
        .catch(error => console.error('Error updating notification count:', error));
    
    fetch('/siswa/pesan/unread-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('message-badge');
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        })
        .catch(error => console.error('Error updating message count:', error));
}, 30000); // Update every 30 seconds

function toggleDarkMode() {
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');
    
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        sunIcon.classList.add('hidden');
        moonIcon.classList.remove('hidden');
    } else {
        document.documentElement.classList.add('dark');
        sunIcon.classList.remove('hidden');
        moonIcon.classList.add('hidden');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('profile-dropdown');
    const button = event.target.closest('button');
    
    if (!button || !button.onclick || button.onclick.toString().indexOf('toggleProfileDropdown') === -1) {
        dropdown.classList.add('hidden');
    }
});
</script>
