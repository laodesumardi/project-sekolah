<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Portal Guru') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional CSS -->
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Mobile optimizations */
        @media (max-width: 1024px) {
            .lg\:block {
                display: none !important;
            }
        }

        /* Dark mode support */
        .dark {
            color-scheme: dark;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @include('teacher.layouts.sidebar')

        <!-- Main content -->
        <div class="flex-1 flex flex-col lg:ml-64">
            <!-- Top navigation -->
            @include('teacher.layouts.topbar')

            <!-- Page content -->
            <main class="flex-1 p-6 pb-20 lg:pb-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Navigation -->
    @include('teacher.layouts.mobile-nav')

    <!-- Floating Action Button -->
    @include('teacher.layouts.floating-action-button')

    <!-- Scripts -->
    <script>
        // Global JavaScript functions
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });

        // Real-time updates (placeholder for future WebSocket implementation)
        function startRealTimeUpdates() {
            // This would be implemented with WebSocket or Server-Sent Events
            console.log('Real-time updates started');
        }

        // Initialize real-time updates
        startRealTimeUpdates();
    </script>

    <!-- Additional JavaScript -->
    @stack('scripts')
</body>
</html>