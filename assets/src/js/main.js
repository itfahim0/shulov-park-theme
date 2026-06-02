import '../css/main.css';

/**
 * Shulov Park - Core Theme modern JavaScript Bundled Entrypoint
 * Handles: Sticky Header, Mobile menu, Countdown, Dark Mode persistence,
 * AJAX cart drawer triggers, AJAX product quick view modal, and lazy loading.
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Global variables from localized WordPress script
    const ajaxUrl = typeof shulovThemeVars !== 'undefined' ? shulovThemeVars.ajaxUrl : '/wp-admin/admin-ajax.php';
    const securityNonce = typeof shulovThemeVars !== 'undefined' ? shulovThemeVars.nonce : '';

    // ==========================================
    // 0. HERO SLIDER SWIPER INITIALIZATION
    // ==========================================
    const initHeroSlider = function() {
        const swiperLib = window.Swiper || (typeof Swiper !== 'undefined' ? Swiper : null);
        
        if (swiperLib) {
            console.log("Shulov Park: Swiper library detected. Initializing hero slider...");
            new swiperLib('.hero-slider', {
                loop: true,
                speed: 800,
                observer: true,       // Watches for changes in slide elements
                observeParents: true, // Watches for parent elements dimension adjustments
                autoplay: {
                    delay: 4000,      // Slides every 4 seconds
                    disableOnInteraction: false,
                    pauseOnMouseEnter: false // Keeps sliding even if hovered
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                }
            });
            console.log("Shulov Park: Hero slider autoplay successfully initialized.");
        } else {
            // Retry in 100ms if Swiper script is still executing asynchronously
            console.log("Shulov Park: Waiting for Swiper library to load...");
            setTimeout(initHeroSlider, 100);
        }
    };
    initHeroSlider();

    // ==========================================
    // 1. STICKY HEADER TRANSITIONS
    // ==========================================
    const header = document.querySelector('.site-header');
    if (header) {
        const headerOffset = header.offsetTop + 100;
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > headerOffset) {
                header.classList.add('is-sticky');
            } else {
                header.classList.remove('is-sticky');
            }
        });
    }

    // ==========================================
    // 2. MOBILE NAVIGATION DRAWER
    // ==========================================
    const menuToggle = document.querySelector('.mobile-nav-toggle');
    const bottomNav = document.querySelector('.header-nav-bottom');
    
    if (menuToggle && bottomNav) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            if (bottomNav.style.display === 'block') {
                bottomNav.style.display = 'none';
                menuToggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
            } else {
                bottomNav.style.display = 'block';
                menuToggle.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            }
        });

        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 992 && bottomNav.style.display === 'block') {
                if (!bottomNav.contains(e.target) && !menuToggle.contains(e.target)) {
                    bottomNav.style.display = 'none';
                    menuToggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
                }
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                bottomNav.style.display = 'block';
                menuToggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
            } else {
                bottomNav.style.display = 'none';
            }
        });
    }

    // ==========================================
    // 3. COOKIE-PERSISTENT DARK MODE ENGINE
    // ==========================================
    const darkToggle = document.getElementById('dark-mode-toggle');
    
    // Cookie Helper to sync dark theme state directly with PHP server
    const setCookie = (name, value, days = 305) => {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};path=/;expires=${date.toUTCString()};SameSite=Lax`;
    };

    if (darkToggle) {
        darkToggle.addEventListener('click', function() {
            const isDark = document.documentElement.classList.contains('dark');
            
            if (isDark) {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark');
                darkToggle.innerHTML = '<i class="fa-regular fa-moon text-xl"></i>';
                setCookie('theme_dark', 'no');
            } else {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
                darkToggle.innerHTML = '<i class="fa-regular fa-sun text-xl text-yellow-400 animate-spin-slow"></i>';
                setCookie('theme_dark', 'yes');
            }
        });
    }

    // ==========================================
    // 4. DYNAMIC FLASH SALE COUNTDOWN TIMER
    // ==========================================
    const countdownElement = document.getElementById('countdown');
    if (countdownElement) {
        let deadline = countdownElement.getAttribute('data-deadline');
        if (!deadline) {
            const fallbackDate = new Date();
            fallbackDate.setDate(fallbackDate.getDate() + 7);
            deadline = fallbackDate.toISOString();
        }

        const targetTime = new Date(deadline).getTime();

        const updateCountdown = function() {
            const now = new Date().getTime();
            const difference = targetTime - now;

            if (difference <= 0) {
                countdownElement.innerHTML = '<div class="countdown-expired text-white font-bold text-lg py-4 w-full text-center">অফারটি শেষ হয়ে গেছে!</div>';
                clearInterval(countdownInterval);
                return;
            }

            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            const dStr = days < 10 ? '0' + days : days;
            const hStr = hours < 10 ? '0' + hours : hours;
            const mStr = minutes < 10 ? '0' + minutes : minutes;
            const sStr = seconds < 10 ? '0' + seconds : seconds;

            const dayNum = countdownElement.querySelector('.day-num');
            const hourNum = countdownElement.querySelector('.hour-num');
            const minNum = countdownElement.querySelector('.min-num');
            const secNum = countdownElement.querySelector('.sec-num');

            if (dayNum && hourNum && minNum && secNum) {
                dayNum.textContent = dStr;
                hourNum.textContent = hStr;
                minNum.textContent = mStr;
                secNum.textContent = sStr;
            }
        };

        updateCountdown();
        const countdownInterval = setInterval(updateCountdown, 1000);
    }

    // ==========================================
    // 5. INTERACTIVE NEWSLETTER FORM FEEDBACK
    // ==========================================
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const input = newsletterForm.querySelector('input[type="email"]');
            if (input && input.value.trim() !== '') {
                const originalContent = newsletterForm.innerHTML;
                
                newsletterForm.style.background = 'var(--accent-bg)';
                newsletterForm.style.border = '1px dashed var(--primary)';
                newsletterForm.innerHTML = `
                    <div class="py-2 px-4 text-primary dark:text-primary-light font-semibold text-center w-full">
                        <i class="fa-solid fa-circle-check"></i> ধন্যবাদ! আপনার সাবস্ক্রিপশন সফল হয়েছে।
                    </div>
                `;
                
                setTimeout(function() {
                    newsletterForm.style.background = '';
                    newsletterForm.style.border = '';
                    newsletterForm.innerHTML = originalContent;
                }, 5000);
            } else if (input) {
                input.style.borderColor = 'var(--danger)';
                input.placeholder = 'দয়া করে একটি সঠিক ইমেইল দিন';
                setTimeout(() => {
                    input.style.borderColor = '';
                    input.placeholder = 'Your Email';
                }, 3000);
            }
        });
    }

    // ==========================================
    // 6. WOOCOMMERCE AJAX MINI-CART DRAWER
    // ==========================================
    const cartDrawer = document.getElementById('mini-cart-drawer');
    const cartDrawerOverlay = document.getElementById('cart-drawer-overlay');
    const openCartButtons = document.querySelectorAll('.cart-contents, .cart-contents-drawer-trigger');
    const closeCartButton = document.getElementById('close-cart-drawer');

    const toggleCartDrawer = () => {
        if (!cartDrawer) return;
        const isOpen = !cartDrawer.classList.contains('translate-x-full');
        if (isOpen) {
            cartDrawer.classList.add('translate-x-full');
            cartDrawerOverlay.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        } else {
            cartDrawer.classList.remove('translate-x-full');
            cartDrawerOverlay.classList.remove('opacity-0', 'pointer-events-none');
            document.body.classList.add('overflow-hidden');
            refreshCartDrawerContents();
        }
    };

    if (openCartButtons.length > 0) {
        openCartButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                toggleCartDrawer();
            });
        });
    }

    if (closeCartButton) {
        closeCartButton.addEventListener('click', toggleCartDrawer);
    }
    if (cartDrawerOverlay) {
        cartDrawerOverlay.addEventListener('click', toggleCartDrawer);
    }

    // Auto-open drawer when WooCommerce finishes AJAX add-to-cart
    jQuery(document.body).on('added_to_cart', function(event, fragments, cart_hash, button) {
        // Auto-open cart drawer to wow the user with a fluid sliding UI
        if (cartDrawer && cartDrawer.classList.contains('translate-x-full')) {
            toggleCartDrawer();
        } else {
            refreshCartDrawerContents();
        }
    });

    const refreshCartDrawerContents = () => {
        const drawerBody = document.getElementById('cart-drawer-items-container');
        if (!drawerBody) return;

        drawerBody.innerHTML = '<div class="flex justify-center items-center h-48"><div class="spinner"></div></div>';

        jQuery.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'shulov_park_cart_drawer_update',
                nonce: securityNonce
            },
            success: function(response) {
                if (response.success) {
                    drawerBody.innerHTML = response.data.html;
                    
                    // Bind quantity selectors inside drawer dynamically
                    bindDrawerQuantityControls();
                } else {
                    drawerBody.innerHTML = '<div class="p-8 text-center text-red-500">কার্ট লোড করতে ব্যর্থ হয়েছে।</div>';
                }
            },
            error: function() {
                drawerBody.innerHTML = '<div class="p-8 text-center text-red-500">সংযোগ ত্রুটি ঘটেছে।</div>';
            }
        });
    };

    const bindDrawerQuantityControls = () => {
        // 1. Bind Quantity Inputs (+/- buttons)
        const qtyInputs = document.querySelectorAll('#mini-cart-drawer .drawer-qty-input');
        qtyInputs.forEach(input => {
            const key = input.getAttribute('data-cart-key');
            const minusBtn = input.parentElement.querySelector('.drawer-qty-minus');
            const plusBtn = input.parentElement.querySelector('.drawer-qty-plus');

            const updateQty = (newVal) => {
                if (newVal < 1) return;
                input.value = newVal;
                
                jQuery.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'shulov_park_cart_drawer_update_quantity',
                        cart_key: key,
                        quantity: newVal,
                        nonce: securityNonce
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update fragments (totals in header cart icons, count, and cart body)
                            if (response.data.fragments) {
                                jQuery(document.body).trigger('removed_from_cart', [response.data.fragments, response.data.cart_hash]);
                            }
                            refreshCartDrawerContents();
                        }
                    }
                });
            };

            if (minusBtn) {
                minusBtn.addEventListener('click', () => updateQty(parseInt(input.value) - 1));
            }
            if (plusBtn) {
                plusBtn.addEventListener('click', () => updateQty(parseInt(input.value) + 1));
            }
        });

        // 2. Bind Remove Buttons independently to ensure all items can be removed
        const removeBtns = document.querySelectorAll('#mini-cart-drawer .drawer-item-remove');
        removeBtns.forEach(removeBtn => {
            removeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const key = removeBtn.getAttribute('data-cart-key');
                if (!key) return;

                removeBtn.classList.add('opacity-50', 'pointer-events-none');

                jQuery.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'shulov_park_cart_drawer_remove_item',
                        cart_key: key,
                        nonce: securityNonce
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.data.fragments) {
                                jQuery(document.body).trigger('removed_from_cart', [response.data.fragments, response.data.cart_hash]);
                            }
                            refreshCartDrawerContents();
                        }
                    }
                });
            });
        });
    };

    // ==========================================
    // 7. DYNAMIC AJAX PRODUCT QUICK VIEW
    // ==========================================
    const quickViewModal = document.getElementById('quick-view-modal');
    const quickViewOverlay = document.getElementById('quick-view-overlay');
    const quickViewContent = document.getElementById('quick-view-modal-content');
    const closeQuickViewBtn = document.getElementById('close-quick-view');

    const toggleQuickView = (isOpen) => {
        if (!quickViewModal) return;
        if (isOpen) {
            quickViewModal.classList.remove('opacity-0', 'pointer-events-none');
            quickViewModal.querySelector('.modal-scale').classList.remove('scale-95', 'opacity-0');
            quickViewModal.querySelector('.modal-scale').classList.add('scale-100', 'opacity-100');
            document.body.classList.add('overflow-hidden');
        } else {
            quickViewModal.classList.add('opacity-0', 'pointer-events-none');
            quickViewModal.querySelector('.modal-scale').classList.add('scale-95', 'opacity-0');
            quickViewModal.querySelector('.modal-scale').classList.remove('scale-100', 'opacity-100');
            document.body.classList.remove('overflow-hidden');
            setTimeout(() => {
                quickViewContent.innerHTML = '';
            }, 300);
        }
    };

    // Bind click trigger globally for product quick views
    document.body.addEventListener('click', function(e) {
        const trigger = e.target.closest('.quick-view-trigger');
        if (!trigger) return;
        e.preventDefault();

        const productId = trigger.getAttribute('data-product-id');
        if (!productId) return;

        toggleQuickView(true);
        quickViewContent.innerHTML = '<div class="flex justify-center items-center h-64"><div class="spinner"></div></div>';

        jQuery.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'shulov_park_quick_view',
                product_id: productId,
                nonce: securityNonce
            },
            success: function(response) {
                if (response.success) {
                    quickViewContent.innerHTML = response.data.html;
                    
                    // Trigger WooCommerce simple variations script init if variable product
                    if (typeof wc_add_to_cart_variation_params !== 'undefined') {
                        jQuery(quickViewContent).find('.variations_form').each(function() {
                            jQuery(this).wc_variation_form();
                        });
                    }
                } else {
                    quickViewContent.innerHTML = '<div class="p-8 text-center text-red-500">পণ্য তথ্য লোড করা যায়নি।</div>';
                }
            },
            error: function() {
                quickViewContent.innerHTML = '<div class="p-8 text-center text-red-500">সংযোগ ত্রুটি ঘটেছে।</div>';
            }
        });
    });

    if (closeQuickViewBtn) {
        closeQuickViewBtn.addEventListener('click', () => toggleQuickView(false));
    }
    if (quickViewOverlay) {
        quickViewOverlay.addEventListener('click', () => toggleQuickView(false));
    }

    // ==========================================
    // 8. INTERACTIVE LAZY LOADING & Micro-Animations
    // ==========================================
    const lazyItems = document.querySelectorAll('.lazy-load');
    if ('IntersectionObserver' in window) {
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -50px 0px',
            threshold: 0.1
        };

        const lazyObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const item = entry.target;
                    
                    // If image, swap dataset src
                    const img = item.querySelector('img[data-src]');
                    if (img) {
                        img.src = img.getAttribute('data-src');
                        img.onload = () => img.removeAttribute('data-src');
                    }
                    
                    item.classList.add('loaded');
                    lazyObserver.unobserve(item);
                }
            });
        }, observerOptions);

        lazyItems.forEach(item => {
            lazyObserver.observe(item);
        });
    } else {
        // Fallback for browsers without observer support
        lazyItems.forEach(item => {
            const img = item.querySelector('img[data-src]');
            if (img) {
                img.src = img.getAttribute('data-src');
            }
            item.classList.add('loaded');
        });
    }

    // ==========================================
    // 9. DYNAMIC AJAX WISHLIST TOGGLES
    // ==========================================
    document.body.addEventListener('click', function(e) {
        const trigger = e.target.closest('.wishlist-toggle-trigger');
        if (!trigger) return;
        e.preventDefault();

        const productId = trigger.getAttribute('data-product-id');
        if (!productId) return;

        trigger.classList.add('opacity-50', 'pointer-events-none');
        const icon = trigger.querySelector('i');
        const originalClass = icon.className;
        icon.className = 'fa-solid fa-circle-notch animate-spin';

        jQuery.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'shulov_park_wishlist_toggle',
                product_id: productId,
                nonce: securityNonce
            },
            success: function(response) {
                trigger.classList.remove('opacity-50', 'pointer-events-none');
                if (response.success) {
                    if (response.data.in_wishlist) {
                        icon.className = 'fa-solid fa-heart text-red-500 animate-bounce';
                        trigger.setAttribute('title', 'উইশলিস্ট থেকে বাদ দিন');
                    } else {
                        icon.className = 'fa-regular fa-heart';
                        trigger.setAttribute('title', 'উইশলিস্টে রাখুন');
                    }
                    
                    // Update header wishlist counters
                    const counters = document.querySelectorAll('.wishlist-count');
                    counters.forEach(c => {
                        c.textContent = response.data.count;
                        c.classList.add('animate-bounce');
                        setTimeout(() => c.classList.remove('animate-bounce'), 1000);
                    });
                } else {
                    icon.className = originalClass;
                }
            },
            error: function() {
                trigger.classList.remove('opacity-50', 'pointer-events-none');
                icon.className = originalClass;
            }
        });
    });

    // ==========================================
    // 10. AUTOMATIC CHECKOUT REFRESH ON DISTRICT CHANGE
    // ==========================================
    jQuery(document.body).on('change', 'select.state_select, #billing_state, #shipping_state', function() {
        jQuery(document.body).trigger('update_checkout');
    });
});
