/**
 * Performance Optimization Script
 * Optimizes website performance with various techniques
 */

// Lazy loading for images
document.addEventListener('DOMContentLoaded', function() {
    // Lazy load images
    const images = document.querySelectorAll('img[data-src]');
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

    images.forEach(img => imageObserver.observe(img));

    // Preload critical resources
    preloadCriticalResources();
    
    // Optimize scroll performance
    optimizeScrollPerformance();
    
    // Cache frequently accessed elements
    cacheElements();
});

// Preload critical resources
function preloadCriticalResources() {
    const criticalResources = [
        '/css/app.css',
        '/js/app.js',
        '/images/logo.png'
    ];

    criticalResources.forEach(resource => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.href = resource;
        link.as = resource.endsWith('.css') ? 'style' : resource.endsWith('.js') ? 'script' : 'image';
        document.head.appendChild(link);
    });
}

// Optimize scroll performance
function optimizeScrollPerformance() {
    let ticking = false;
    
    function updateScroll() {
        // Throttle scroll events
        if (!ticking) {
            requestAnimationFrame(() => {
                // Handle scroll-based animations
                handleScrollAnimations();
                ticking = false;
            });
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', updateScroll, { passive: true });
}

// Handle scroll animations
function handleScrollAnimations() {
    const elements = document.querySelectorAll('.animate-on-scroll');
    elements.forEach(element => {
        const rect = element.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            element.classList.add('animated');
        }
    });
}

// Cache frequently accessed elements
function cacheElements() {
    window.cachedElements = {
        header: document.querySelector('header'),
        navigation: document.querySelector('nav'),
        main: document.querySelector('main'),
        footer: document.querySelector('footer')
    };
}

// Optimize form submissions
function optimizeFormSubmissions() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner"></span> Memproses...';
            }
        });
    });
}

// Optimize image loading
function optimizeImageLoading() {
    // Convert images to WebP if supported
    if (supportsWebP()) {
        const images = document.querySelectorAll('img[data-webp]');
        images.forEach(img => {
            img.src = img.dataset.webp;
        });
    }
    
    // Add loading="lazy" to images below the fold
    const images = document.querySelectorAll('img:not([loading])');
    images.forEach((img, index) => {
        if (index > 2) { // Skip first 3 images (above the fold)
            img.loading = 'lazy';
        }
    });
}

// Check WebP support
function supportsWebP() {
    const canvas = document.createElement('canvas');
    canvas.width = 1;
    canvas.height = 1;
    return canvas.toDataURL('image/webp').indexOf('data:image/webp') === 0;
}

// Optimize AJAX requests
function optimizeAjaxRequests() {
    // Add request caching
    const requestCache = new Map();
    
    function cachedFetch(url, options = {}) {
        const cacheKey = url + JSON.stringify(options);
        
        if (requestCache.has(cacheKey)) {
            return Promise.resolve(requestCache.get(cacheKey));
        }
        
        return fetch(url, options)
            .then(response => response.json())
            .then(data => {
                requestCache.set(cacheKey, data);
                return data;
            });
    }
    
    // Expose to global scope
    window.cachedFetch = cachedFetch;
}

// Initialize optimizations
document.addEventListener('DOMContentLoaded', function() {
    optimizeFormSubmissions();
    optimizeImageLoading();
    optimizeAjaxRequests();
});

// Performance monitoring
function monitorPerformance() {
    // Monitor Core Web Vitals
    if ('PerformanceObserver' in window) {
        // Largest Contentful Paint
        new PerformanceObserver((list) => {
            const entries = list.getEntries();
            const lastEntry = entries[entries.length - 1];
            console.log('LCP:', lastEntry.startTime);
        }).observe({ entryTypes: ['largest-contentful-paint'] });

        // First Input Delay
        new PerformanceObserver((list) => {
            const entries = list.getEntries();
            entries.forEach(entry => {
                console.log('FID:', entry.processingStart - entry.startTime);
            });
        }).observe({ entryTypes: ['first-input'] });

        // Cumulative Layout Shift
        new PerformanceObserver((list) => {
            const entries = list.getEntries();
            entries.forEach(entry => {
                if (!entry.hadRecentInput) {
                    console.log('CLS:', entry.value);
                }
            });
        }).observe({ entryTypes: ['layout-shift'] });
    }
}

// Initialize performance monitoring
monitorPerformance();

