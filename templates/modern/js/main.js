/**
 * WebEngine CMS - Modern Template JavaScript
 * https://webenginecms.org/
 * 
 * @version 1.2.6
 * @author WebEngine CMS Team
 * @copyright (c) 2013-2025 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */

(function() {
    'use strict';

    // Global variables
    let serverTimeOffset = 0;
    let particlesInstance = null;

    // Initialize everything when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializePreloader();
        initializeNavigation();
        initializeTimeUpdates();
        initializeScrollToTop();
        initializeParticles();
        initializeAnimations();
        initializeTooltips();
        initializeModals();
        initializeForms();
        
        // Remove preloader after everything is loaded
        window.addEventListener('load', function() {
            setTimeout(hidePreloader, 500);
        });
    });

    /**
     * Preloader functionality
     */
    function initializePreloader() {
        const preloader = document.getElementById('preloader');
        if (!preloader) return;

        // Hide preloader on page load
        function hidePreloader() {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 300);
        }

        // Expose globally for window.onload
        window.hidePreloader = hidePreloader;
    }

    /**
     * Navigation functionality
     */
    function initializeNavigation() {
        const navbar = document.querySelector('.navbar');
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');
        
        if (!navbar) return;

        // Navbar scroll behavior
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Add background on scroll
            if (scrollTop > 50) {
                navbar.style.background = 'rgba(15, 23, 42, 0.98)';
            } else {
                navbar.style.background = 'rgba(15, 23, 42, 0.95)';
            }
            
            lastScrollTop = scrollTop;
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                if (!navbar.contains(e.target)) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                        hide: true
                    });
                }
            }
        });

        // Active nav link highlighting
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        const currentPath = window.location.pathname;
        
        navLinks.forEach(link => {
            const linkPath = new URL(link.href).pathname;
            if (currentPath === linkPath || (linkPath !== '/' && currentPath.startsWith(linkPath))) {
                link.classList.add('active');
            }
        });
    }

    /**
     * Time updates functionality
     */
    function initializeTimeUpdates() {
        updateServerTime();
        setInterval(updateServerTime, 1000);
    }

    function updateServerTime() {
        const now = new Date();
        const serverTime = new Date(now.getTime() + serverTimeOffset);
        
        const timeString = serverTime.toLocaleTimeString('en-US', {
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        
        const dateString = serverTime.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
        
        // Update server time displays
        const serverTimeElements = [
            document.getElementById('serverTime'),
            document.getElementById('footerServerTime'),
            document.getElementById('tServerTime')
        ];
        
        serverTimeElements.forEach(element => {
            if (element) {
                element.textContent = timeString;
            }
        });
        
        // Update server date displays
        const serverDateElements = [
            document.getElementById('tServerDate')
        ];
        
        serverDateElements.forEach(element => {
            if (element) {
                element.textContent = dateString;
            }
        });
        
        // Update local time
        const localTimeElement = document.getElementById('tLocalTime');
        const localDateElement = document.getElementById('tLocalDate');
        
        if (localTimeElement) {
            localTimeElement.textContent = now.toLocaleTimeString('en-US', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }
        
        if (localDateElement) {
            localDateElement.textContent = now.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }
    }

    /**
     * Scroll to top functionality
     */
    function initializeScrollToTop() {
        const scrollToTopBtn = document.getElementById('scrollToTop') || document.getElementById('backToTopBtn');
        
        if (!scrollToTopBtn) return;

        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.style.display = 'flex';
                scrollToTopBtn.style.opacity = '1';
            } else {
                scrollToTopBtn.style.opacity = '0';
                setTimeout(() => {
                    if (window.pageYOffset <= 300) {
                        scrollToTopBtn.style.display = 'none';
                    }
                }, 300);
            }
        });

        // Scroll to top on click
        scrollToTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /**
     * Particles background
     */
    function initializeParticles() {
        const particlesElement = document.getElementById('particles');
        if (!particlesElement || typeof particlesJS === 'undefined') return;

        particlesJS('particles', {
            particles: {
                number: {
                    value: 50,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#6366f1'
                },
                shape: {
                    type: 'circle'
                },
                opacity: {
                    value: 0.3,
                    random: true,
                    anim: {
                        enable: true,
                        speed: 1,
                        opacity_min: 0.1,
                        sync: false
                    }
                },
                size: {
                    value: 3,
                    random: true,
                    anim: {
                        enable: true,
                        speed: 2,
                        size_min: 0.5,
                        sync: false
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#6366f1',
                    opacity: 0.2,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 1,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out',
                    attract: {
                        enable: false
                    }
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: true,
                        mode: 'repulse'
                    },
                    onclick: {
                        enable: true,
                        mode: 'push'
                    },
                    resize: true
                },
                modes: {
                    repulse: {
                        distance: 100,
                        duration: 0.4
                    },
                    push: {
                        particles_nb: 4
                    }
                }
            },
            retina_detect: true
        });
    }

    /**
     * Animations
     */
    function initializeAnimations() {
        // Fade in elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements for animation
        const animatedElements = document.querySelectorAll('.card, .sidebar-widget, .content-wrapper');
        animatedElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Add CSS class for fade in animation
        const style = document.createElement('style');
        style.textContent = `
            .fade-in {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Tooltips
     */
    function initializeTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    /**
     * Modals
     */
    function initializeModals() {
        // Auto-focus first input in modals
        document.addEventListener('shown.bs.modal', function(e) {
            const firstInput = e.target.querySelector('input, textarea, select');
            if (firstInput) {
                firstInput.focus();
            }
        });

        // Close modal on backdrop click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-backdrop')) {
                const modal = bootstrap.Modal.getInstance(e.target.previousElementSibling);
                if (modal) {
                    modal.hide();
                }
            }
        });
    }

    /**
     * Forms
     */
    function initializeForms() {
        // Add floating labels effect
        const formInputs = document.querySelectorAll('.form-control');
        formInputs.forEach(input => {
            // Add focus/blur handlers for floating label effect
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });

            // Set initial state
            if (input.value) {
                input.parentElement.classList.add('focused');
            }
        });

        // Form validation
        const forms = document.querySelectorAll('.needs-validation');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    }

    /**
     * Utility functions
     */
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // Expose utility functions globally
    window.ModernTemplate = {
        debounce: debounce,
        throttle: throttle,
        updateServerTime: updateServerTime,
        setServerTimeOffset: function(offset) {
            serverTimeOffset = offset;
        }
    };

    // Handle logout confirmation
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('logout') || e.target.closest('.logout')) {
            if (!confirm('Are you sure you want to logout?')) {
                e.preventDefault();
            }
        }
    });

    // Handle external links
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a[target="_blank"]');
        if (link && link.hostname !== window.location.hostname) {
            if (!confirm('You are about to leave this website. Continue?')) {
                e.preventDefault();
            }
        }
    });

    // Add loading states to buttons
    document.addEventListener('click', function(e) {
        const button = e.target.closest('.btn[type="submit"]');
        if (button && !button.disabled) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
            button.disabled = true;
            
            // Reset after 5 seconds if form doesn't redirect
            setTimeout(() => {
                if (button) {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            }, 5000);
        }
    });

    // Performance monitoring
    if ('performance' in window) {
        window.addEventListener('load', function() {
            setTimeout(() => {
                const perfData = performance.timing;
                const loadTime = perfData.loadEventEnd - perfData.navigationStart;
                console.log(`Page loaded in ${loadTime}ms`);
                
                // Update page load time in footer if element exists
                const loadTimeElement = document.getElementById('pageLoadTime');
                if (loadTimeElement) {
                    loadTimeElement.textContent = (loadTime / 1000).toFixed(3);
                }
            }, 0);
        });
    }

})();