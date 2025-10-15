// Mobile-specific JavaScript optimizations for SMP Negeri 01 Namrole

// Mobile detection
const isMobile = () => {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || 
           window.innerWidth <= 768;
};

// Touch detection
const isTouchDevice = () => {
    return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
};

// Mobile menu optimization
class MobileMenu {
    constructor() {
        this.menu = document.getElementById('mobile-menu');
        this.toggle = document.getElementById('mobile-menu-toggle');
        this.overlay = document.getElementById('mobile-menu-overlay');
        this.isOpen = false;
        
        this.init();
    }
    
    init() {
        if (this.toggle) {
            this.toggle.addEventListener('click', () => this.toggleMenu());
        }
        
        if (this.overlay) {
            this.overlay.addEventListener('click', () => this.closeMenu());
        }
        
        // Close menu on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeMenu();
            }
        });
        
        // Close menu on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768 && this.isOpen) {
                this.closeMenu();
            }
        });
    }
    
    toggleMenu() {
        if (this.isOpen) {
            this.closeMenu();
        } else {
            this.openMenu();
        }
    }
    
    openMenu() {
        if (this.menu) {
            this.menu.classList.add('show');
            this.menu.style.transform = 'translateX(0)';
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        }
    }
    
    closeMenu() {
        if (this.menu) {
            this.menu.classList.remove('show');
            this.menu.style.transform = 'translateX(100%)';
            this.isOpen = false;
            document.body.style.overflow = '';
        }
    }
}

// Mobile form optimization
class MobileForm {
    constructor() {
        this.forms = document.querySelectorAll('form');
        this.init();
    }
    
    init() {
        this.forms.forEach(form => {
            this.optimizeForm(form);
        });
    }
    
    optimizeForm(form) {
        // Add mobile-friendly classes
        form.classList.add('mobile-form');
        
        // Optimize input fields
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.classList.add('mobile-form-input');
            
            // Add touch-friendly attributes
            if (input.type === 'text' || input.type === 'email' || input.type === 'tel') {
                input.setAttribute('autocomplete', 'on');
                input.setAttribute('autocorrect', 'on');
                input.setAttribute('autocapitalize', 'on');
            }
            
            // Optimize for mobile keyboards
            if (input.type === 'email') {
                input.setAttribute('inputmode', 'email');
            } else if (input.type === 'tel') {
                input.setAttribute('inputmode', 'tel');
            } else if (input.type === 'number') {
                input.setAttribute('inputmode', 'numeric');
            }
        });
        
        // Add mobile-friendly labels
        const labels = form.querySelectorAll('label');
        labels.forEach(label => {
            label.classList.add('mobile-form-label');
        });
    }
}

// Mobile image optimization
class MobileImageOptimizer {
    constructor() {
        this.images = document.querySelectorAll('img');
        this.init();
    }
    
    init() {
        this.images.forEach(img => {
            this.optimizeImage(img);
        });
    }
    
    optimizeImage(img) {
        // Add mobile-friendly classes
        img.classList.add('mobile-img-responsive');
        
        // Lazy loading for mobile
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const image = entry.target;
                        if (image.dataset.src) {
                            image.src = image.dataset.src;
                            image.classList.remove('lazy');
                            observer.unobserve(image);
                        }
                    }
                });
            });
            
            observer.observe(img);
        }
        
        // Add error handling
        img.addEventListener('error', () => {
            img.src = '/images/placeholder.jpg';
            img.alt = 'Image not available';
        });
    }
}

// Mobile scroll optimization
class MobileScrollOptimizer {
    constructor() {
        this.lastScrollTop = 0;
        this.scrollTimeout = null;
        this.init();
    }
    
    init() {
        // Throttle scroll events for better performance
        window.addEventListener('scroll', () => {
            if (this.scrollTimeout) {
                clearTimeout(this.scrollTimeout);
            }
            
            this.scrollTimeout = setTimeout(() => {
                this.handleScroll();
            }, 16); // ~60fps
        });
    }
    
    handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const navbar = document.querySelector('nav');
        
        if (navbar) {
            if (scrollTop > this.lastScrollTop && scrollTop > 100) {
                // Scrolling down
                navbar.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                navbar.style.transform = 'translateY(0)';
            }
        }
        
        this.lastScrollTop = scrollTop;
    }
}

// Mobile touch optimization
class MobileTouchOptimizer {
    constructor() {
        this.init();
    }
    
    init() {
        // Add touch-friendly classes to interactive elements
        const interactiveElements = document.querySelectorAll('button, a, input, select, textarea');
        interactiveElements.forEach(element => {
            element.classList.add('touch-target');
        });
        
        // Optimize touch events
        this.optimizeTouchEvents();
    }
    
    optimizeTouchEvents() {
        // Add touch feedback
        document.addEventListener('touchstart', (e) => {
            const target = e.target.closest('button, a, input, select, textarea');
            if (target) {
                target.classList.add('touch-active');
            }
        });
        
        document.addEventListener('touchend', (e) => {
            const target = e.target.closest('button, a, input, select, textarea');
            if (target) {
                target.classList.remove('touch-active');
            }
        });
    }
}

// Mobile performance optimization
class MobilePerformanceOptimizer {
    constructor() {
        this.init();
    }
    
    init() {
        // Optimize animations for mobile
        this.optimizeAnimations();
        
        // Optimize images
        this.optimizeImages();
        
        // Optimize fonts
        this.optimizeFonts();
    }
    
    optimizeAnimations() {
        // Reduce motion for users who prefer it
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.style.setProperty('--animation-duration', '0.01ms');
        }
    }
    
    optimizeImages() {
        // Add loading="lazy" to images below the fold
        const images = document.querySelectorAll('img');
        images.forEach((img, index) => {
            if (index > 2) { // Skip first few images
                img.setAttribute('loading', 'lazy');
            }
        });
    }
    
    optimizeFonts() {
        // Preload important fonts
        const fontPreload = document.createElement('link');
        fontPreload.rel = 'preload';
        fontPreload.href = '/fonts/Poppins-Regular.woff2';
        fontPreload.as = 'font';
        fontPreload.type = 'font/woff2';
        fontPreload.crossOrigin = 'anonymous';
        document.head.appendChild(fontPreload);
    }
}

// Mobile accessibility optimization
class MobileAccessibilityOptimizer {
    constructor() {
        this.init();
    }
    
    init() {
        // Add skip links
        this.addSkipLinks();
        
        // Optimize focus management
        this.optimizeFocus();
        
        // Add ARIA labels
        this.addAriaLabels();
    }
    
    addSkipLinks() {
        const skipLink = document.createElement('a');
        skipLink.href = '#main-content';
        skipLink.textContent = 'Skip to main content';
        skipLink.className = 'mobile-sr-only focus-visible:not-sr-only';
        skipLink.style.cssText = `
            position: absolute;
            top: -40px;
            left: 6px;
            background: #000;
            color: #fff;
            padding: 8px;
            text-decoration: none;
            z-index: 1000;
        `;
        
        skipLink.addEventListener('focus', () => {
            skipLink.style.top = '6px';
        });
        
        skipLink.addEventListener('blur', () => {
            skipLink.style.top = '-40px';
        });
        
        document.body.insertBefore(skipLink, document.body.firstChild);
    }
    
    optimizeFocus() {
        // Add focus indicators
        const focusableElements = document.querySelectorAll('button, a, input, select, textarea');
        focusableElements.forEach(element => {
            element.classList.add('mobile-focus-visible');
        });
    }
    
    addAriaLabels() {
        // Add ARIA labels to interactive elements
        const buttons = document.querySelectorAll('button:not([aria-label])');
        buttons.forEach(button => {
            if (!button.textContent.trim()) {
                button.setAttribute('aria-label', 'Button');
            }
        });
    }
}

// Mobile viewport optimization
class MobileViewportOptimizer {
    constructor() {
        this.init();
    }
    
    init() {
        // Set viewport meta tag
        this.setViewportMeta();
        
        // Handle orientation changes
        this.handleOrientationChange();
        
        // Optimize for different screen sizes
        this.optimizeScreenSizes();
    }
    
    setViewportMeta() {
        let viewport = document.querySelector('meta[name="viewport"]');
        if (!viewport) {
            viewport = document.createElement('meta');
            viewport.name = 'viewport';
            document.head.appendChild(viewport);
        }
        
        viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes';
    }
    
    handleOrientationChange() {
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                // Recalculate layout after orientation change
                window.dispatchEvent(new Event('resize'));
            }, 100);
        });
    }
    
    optimizeScreenSizes() {
        // Add responsive classes based on screen size
        const updateScreenSize = () => {
            const width = window.innerWidth;
            document.documentElement.classList.remove('mobile', 'tablet', 'desktop');
            
            if (width <= 768) {
                document.documentElement.classList.add('mobile');
            } else if (width <= 1024) {
                document.documentElement.classList.add('tablet');
            } else {
                document.documentElement.classList.add('desktop');
            }
        };
        
        updateScreenSize();
        window.addEventListener('resize', updateScreenSize);
    }
}

// Initialize mobile optimizations when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Only initialize mobile optimizations on mobile devices
    if (isMobile()) {
        new MobileMenu();
        new MobileForm();
        new MobileImageOptimizer();
        new MobileScrollOptimizer();
        new MobileTouchOptimizer();
        new MobilePerformanceOptimizer();
        new MobileAccessibilityOptimizer();
        new MobileViewportOptimizer();
    }
});

// Export for use in other modules
window.MobileOptimizations = {
    isMobile,
    isTouchDevice,
    MobileMenu,
    MobileForm,
    MobileImageOptimizer,
    MobileScrollOptimizer,
    MobileTouchOptimizer,
    MobilePerformanceOptimizer,
    MobileAccessibilityOptimizer,
    MobileViewportOptimizer
};
