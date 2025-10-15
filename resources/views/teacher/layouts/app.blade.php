<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard Guru</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <style>
        .sidebar-transition {
            transition: all 0.3s ease;
        }
        
        .sidebar-hidden {
            transform: translateX(-100%);
        }
        
        .sidebar-visible {
            transform: translateX(0);
        }
        
        .main-content-transition {
            transition: margin-left 0.3s ease;
        }
        
        .main-content-expanded {
            margin-left: 0;
        }
        
        .main-content-collapsed {
            margin-left: 0;
        }
        
        @media (min-width: 768px) {
            .main-content-expanded {
                margin-left: 16rem;
            }
            
            .sidebar-visible {
                transform: translateX(0);
            }
            
            .sidebar-hidden {
                transform: translateX(-100%);
            }
        }
        
        @media (max-width: 767px) {
            .sidebar-visible {
                transform: translateX(0);
            }
            
            .sidebar-hidden {
                transform: translateX(-100%);
            }
        }
        
        .notification-transition {
            transition: all 0.3s ease;
        }

        .notification-enter {
            transform: translateX(100%);
            opacity: 0;
        }
        
        .notification-enter-active {
            transform: translateX(0);
            opacity: 1;
        }
        
        .notification-exit {
            transform: translateX(0);
            opacity: 1;
        }
        
        .notification-exit-active {
            transform: translateX(100%);
            opacity: 0;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg sidebar-transition sidebar-visible md:translate-x-0">
        @include('teacher.layouts.sidebar')
        </div>

        <!-- Main Content -->
        <div id="main-content" class="flex-1 main-content-transition main-content-expanded md:ml-64">
            <!-- Top Navigation -->
            <div class="bg-white shadow-sm border-b border-gray-200">
            @include('teacher.layouts.topbar')
            </div>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('warning') }}</span>
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('info') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Scripts -->
    <script>
        // Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (window.innerWidth < 768) {
                // Mobile behavior
                if (sidebar.classList.contains('sidebar-visible')) {
                    sidebar.classList.remove('sidebar-visible');
                    sidebar.classList.add('sidebar-hidden');
                overlay.classList.remove('hidden');
                } else {
                    sidebar.classList.remove('sidebar-hidden');
                    sidebar.classList.add('sidebar-visible');
                    overlay.classList.add('hidden');
                }
            } else {
                // Desktop behavior
                if (sidebar.classList.contains('sidebar-visible')) {
                    sidebar.classList.remove('sidebar-visible');
                    sidebar.classList.add('sidebar-hidden');
                    mainContent.classList.remove('main-content-expanded');
                    mainContent.classList.add('main-content-collapsed');
                } else {
                    sidebar.classList.remove('sidebar-hidden');
                    sidebar.classList.add('sidebar-visible');
                    mainContent.classList.remove('main-content-collapsed');
                    mainContent.classList.add('main-content-expanded');
                }
            }
        }

        // Close sidebar on overlay click
        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            if (window.innerWidth < 768) {
                toggleSidebar();
            }
        });

        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && window.innerWidth < 768) {
            const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('sidebar-visible')) {
                    toggleSidebar();
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (window.innerWidth >= 768) {
                // Desktop: show sidebar by default
                sidebar.classList.remove('sidebar-hidden');
                sidebar.classList.add('sidebar-visible');
                mainContent.classList.remove('main-content-collapsed');
                mainContent.classList.add('main-content-expanded');
                overlay.classList.add('hidden');
            } else {
                // Mobile: hide sidebar by default
                sidebar.classList.remove('sidebar-visible');
                sidebar.classList.add('sidebar-hidden');
                overlay.classList.add('hidden');
            }
        });

        // Auto-hide flash messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);

        // Notification system
        function showNotification(message, type = 'info', duration = 5000) {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            
            const typeClasses = {
                'success': 'bg-green-500 text-white',
                'error': 'bg-red-500 text-white',
                'warning': 'bg-yellow-500 text-white',
                'info': 'bg-blue-500 text-white'
            };
            
            notification.className = `px-6 py-3 rounded-lg shadow-lg notification-transition ${typeClasses[type] || typeClasses.info}`;
            notification.innerHTML = `
                <div class="flex items-center justify-between">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Auto remove after duration
            setTimeout(function() {
                if (notification.parentNode) {
                    notification.style.transition = 'opacity 0.3s ease';
                    notification.style.opacity = '0';
                    setTimeout(function() {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 300);
                }
            }, duration);
        }

        // Global notification function
        window.showNotification = showNotification;
    </script>

    @stack('scripts')
</body>
</html>
