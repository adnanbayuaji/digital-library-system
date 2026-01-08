/**
 * Custom JavaScript for Digital Library System
 * Responsive and Mobile Enhancements
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        
        // Mobile Menu Toggle
        initMobileMenu();
        
        // Table Responsive Enhancements
        enhanceResponsiveTables();
        
        // Touch-friendly interactions
        enhanceTouchInteractions();
        
        // Viewport height fix for mobile browsers
        fixMobileViewport();
    });

    /**
     * Initialize mobile menu functionality
     */
    function initMobileMenu() {
        const menuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (!menuToggle || !mobileMenu) {
            return;
        }
        
        // Toggle menu on button click
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isShowing = mobileMenu.classList.contains('show');
            
            if (isShowing) {
                mobileMenu.classList.remove('show');
                document.body.classList.remove('menu-open');
            } else {
                mobileMenu.classList.add('show');
                document.body.classList.add('menu-open');
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (mobileMenu.classList.contains('show') && 
                !mobileMenu.contains(e.target) && 
                !menuToggle.contains(e.target)) {
                mobileMenu.classList.remove('show');
                document.body.classList.remove('menu-open');
            }
        });
        
        // Close menu when clicking a link
        const menuLinks = mobileMenu.querySelectorAll('.nav-link');
        menuLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                setTimeout(function() {
                    mobileMenu.classList.remove('show');
                    document.body.classList.remove('menu-open');
                }, 100);
            });
        });
        
        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('show')) {
                mobileMenu.classList.remove('show');
                document.body.classList.remove('menu-open');
            }
        });
    }

    /**
     * Enhance responsive tables
     */
    function enhanceResponsiveTables() {
        const tables = document.querySelectorAll('.table-responsive');
        
        tables.forEach(function(wrapper) {
            const table = wrapper.querySelector('table');
            if (!table) return;
            
            // Add scroll indicator
            if (table.scrollWidth > wrapper.clientWidth) {
                wrapper.classList.add('has-scroll');
                
                // Create scroll hint
                const hint = document.createElement('div');
                hint.className = 'scroll-hint';
                hint.innerHTML = '<i class="bi bi-arrow-left-right"></i> Scroll';
                wrapper.appendChild(hint);
                
                // Remove hint after first scroll
                wrapper.addEventListener('scroll', function() {
                    hint.style.display = 'none';
                }, { once: true });
            }
        });
    }

    /**
     * Enhance touch interactions for mobile
     */
    function enhanceTouchInteractions() {
        // Make buttons more touch-friendly
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(function(button) {
            button.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.95)';
            });
            
            button.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });
        
        // Prevent double-tap zoom on buttons
        buttons.forEach(function(button) {
            let lastTap = 0;
            button.addEventListener('touchend', function(e) {
                const currentTime = new Date().getTime();
                const tapLength = currentTime - lastTap;
                if (tapLength < 500 && tapLength > 0) {
                    e.preventDefault();
                }
                lastTap = currentTime;
            });
        });
    }

    /**
     * Fix viewport height for mobile browsers
     */
    function fixMobileViewport() {
        // Set CSS variable for actual viewport height
        const setVh = function() {
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', vh + 'px');
        };
        
        setVh();
        window.addEventListener('resize', setVh);
        window.addEventListener('orientationchange', setVh);
    }

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        const links = document.querySelectorAll('a[href^="#"]');
        links.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

})();
