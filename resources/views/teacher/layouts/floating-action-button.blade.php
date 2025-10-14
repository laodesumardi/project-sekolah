<!-- Floating Action Button -->
<div class="fixed bottom-20 right-4 z-30 lg:hidden">
    <div class="relative">
        <!-- Main FAB -->
        <button id="fab-main" onclick="toggleFAB()" class="w-14 h-14 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
            <svg id="fab-icon" class="w-6 h-6 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </button>

        <!-- FAB Menu -->
        <div id="fab-menu" class="hidden absolute bottom-16 right-0 space-y-2">
            <!-- Upload Tugas -->
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-700 bg-white px-3 py-1 rounded-full shadow-sm whitespace-nowrap">Upload Tugas</span>
                <button class="w-12 h-12 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                </button>
            </div>

            <!-- Lihat Materi -->
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-700 bg-white px-3 py-1 rounded-full shadow-sm whitespace-nowrap">Lihat Materi</span>
                <button class="w-12 h-12 bg-purple-600 text-white rounded-full shadow-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </button>
            </div>

            <!-- Lihat Jadwal -->
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-700 bg-white px-3 py-1 rounded-full shadow-sm whitespace-nowrap">Lihat Jadwal</span>
                <button class="w-12 h-12 bg-orange-600 text-white rounded-full shadow-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </button>
            </div>

            <!-- Hubungi Wali Kelas -->
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-700 bg-white px-3 py-1 rounded-full shadow-sm whitespace-nowrap">Hubungi Wali Kelas</span>
                <button class="w-12 h-12 bg-indigo-600 text-white rounded-full shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </button>
            </div>

            <!-- Ajukan Izin -->
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-700 bg-white px-3 py-1 rounded-full shadow-sm whitespace-nowrap">Ajukan Izin</span>
                <button class="w-12 h-12 bg-red-600 text-white rounded-full shadow-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFAB() {
    const fabMenu = document.getElementById('fab-menu');
    const fabIcon = document.getElementById('fab-icon');
    
    fabMenu.classList.toggle('hidden');
    
    if (fabMenu.classList.contains('hidden')) {
        fabIcon.style.transform = 'rotate(0deg)';
    } else {
        fabIcon.style.transform = 'rotate(45deg)';
    }
}

// Close FAB menu when clicking outside
document.addEventListener('click', function(event) {
    const fabMain = document.getElementById('fab-main');
    const fabMenu = document.getElementById('fab-menu');
    
    if (!fabMain.contains(event.target) && !fabMenu.contains(event.target)) {
        fabMenu.classList.add('hidden');
        document.getElementById('fab-icon').style.transform = 'rotate(0deg)';
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(event) {
    // Ctrl/Cmd + K for quick actions
    if ((event.ctrlKey || event.metaKey) && event.key === 'k') {
        event.preventDefault();
        toggleFAB();
    }
});
</script>

