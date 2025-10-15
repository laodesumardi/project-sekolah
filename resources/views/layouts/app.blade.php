<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SMP Negeri 01 Namrole')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ \App\Helpers\ImageHelper::getLogoUrl() }}">
    <link rel="icon" type="image/x-icon" href="{{ \App\Helpers\ImageHelper::getFaviconUrl() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700|inter:300,400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom CSS -->
    <style>
        .smooth-scroll {
            scroll-behavior: smooth;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #0a1628 0%, #13315c 100%);
        }
        
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .counter {
            font-variant-numeric: tabular-nums;
        }
        
        /* Hero Background dengan Gambar dari Admin Panel */
        .hero-background {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        .hero-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }
        
        .hero-background .relative {
            position: relative;
            z-index: 2;
        }
        
        /* Overlay tambahan untuk kontras yang lebih baik */
        .hero-background-overlay {
            background: rgba(0, 0, 0, 0.1);
        }
        
        /* Responsive background */
        @media (max-width: 768px) {
            .hero-background {
                background-attachment: scroll;
            }
        }
        
        /* Animasi fade in untuk background */
        @keyframes fadeInBackground {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .hero-background {
            animation: fadeInBackground 1s ease-in-out;
        }
        
        /* Page Header Background untuk halaman lain */
        .page-header-background {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        .page-header-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        
        .page-header-background .relative {
            position: relative;
            z-index: 2;
        }
        
        /* Overlay tambahan untuk kontras yang lebih baik */
        .page-header-overlay {
            background: rgba(0, 0, 0, 0.2);
        }
        
        /* Responsive background */
        @media (max-width: 768px) {
            .page-header-background {
                background-attachment: scroll;
            }
        }
        
        /* Animasi fade in untuk page header */
        @keyframes fadeInPageHeader {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .page-header-background {
            animation: fadeInPageHeader 1s ease-in-out;
        }
        
        /* Section Images Styles */
        .section-images-container {
            margin: 2rem 0;
        }
        
        .section-image-card {
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        
        .section-image-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .section-image-card img {
            transition: transform 0.3s ease;
        }
        
        .section-image-card:hover img {
            transform: scale(1.1);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .section-images-container .grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Background Section Styles */
        .background-section {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        .background-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }
        
        .background-section .relative {
            position: relative;
            z-index: 2;
        }
        
        /* Overlay tambahan untuk kontras yang lebih baik */
        .background-section-overlay {
            background: rgba(0, 0, 0, 0.1);
        }
        
        /* Responsive background */
        @media (max-width: 768px) {
            .background-section {
                background-attachment: scroll;
            }
        }
        
        /* Animasi fade in untuk background section */
        @keyframes fadeInBackgroundSection {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .background-section {
            animation: fadeInBackgroundSection 1s ease-in-out;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        @include('components.navbar')

        <!-- Page Heading -->
        @hasSection('header')
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('components.footer')
    </div>

    <!-- JavaScript for animations and interactions -->
    <script>
        // Optimized smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Optimized counter animation with throttling
        function animateCounter(element, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const current = Math.floor(progress * (end - start) + start);
                element.textContent = current.toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Optimized Intersection Observer with throttling
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target.querySelector('.counter-number');
                    if (counter && !counter.dataset.animated) {
                        const endValue = parseInt(counter.dataset.end);
                        animateCounter(counter, 0, endValue, 2000);
                        counter.dataset.animated = 'true';
                    }
                }
            });
        }, observerOptions);

        // Observe all stat cards with performance optimization
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach(card => {
            observer.observe(card);
        });

        // Mobile menu toggle with performance optimization
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenu) {
                mobileMenu.classList.toggle('hidden');
            }
        }

        // Optimized click outside handler
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuButton = document.getElementById('mobile-menu-button');
            
            if (mobileMenu && menuButton && 
                !mobileMenu.contains(event.target) && 
                !menuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Performance optimization: Debounce scroll events
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }
            scrollTimeout = setTimeout(function() {
                // Add any scroll-based functionality here
            }, 10);
        });

        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    </script>
</body>
</html>