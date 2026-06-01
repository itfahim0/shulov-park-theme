/**
 * Shulov Park - Core Theme JavaScript
 * Implements sticky header, mobile nav toggle, real-time Flash Sale countdown, and ajax feedback.
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

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
        // Toggle mobile menu visibility
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

        // Close menu on clicking outside
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 992 && bottomNav.style.display === 'block') {
                if (!bottomNav.contains(e.target) && !menuToggle.contains(e.target)) {
                    bottomNav.style.display = 'none';
                    menuToggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
                }
            }
        });

        // Handle resize events
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
    // 3. DYNAMIC FLASH SALE COUNTDOWN TIMER
    // ==========================================
    const countdownElement = document.getElementById('countdown');
    if (countdownElement) {
        // Retrieve deadline from data attribute or fallback to 7 days from now
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
                // Timer expired
                countdownElement.innerHTML = '<div class="countdown-expired" style="color:var(--white); font-weight:bold; font-size:18px;">অফারটি শেষ হয়ে গেছে!</div>';
                clearInterval(countdownInterval);
                return;
            }

            // Calculate units
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            // Render numbers with double digits
            const dStr = days < 10 ? '0' + days : days;
            const hStr = hours < 10 ? '0' + hours : hours;
            const mStr = minutes < 10 ? '0' + minutes : minutes;
            const sStr = seconds < 10 ? '0' + seconds : seconds;

            // Target HTML selectors
            const dayNum = countdownElement.querySelector('.day-num');
            const hourNum = countdownElement.querySelector('.hour-num');
            const minNum = countdownElement.querySelector('.min-num');
            const secNum = countdownElement.querySelector('.sec-num');

            if (dayNum && hourNum && minNum && secNum) {
                dayNum.textContent = dStr;
                hourNum.textContent = hStr;
                minNum.textContent = mStr;
                secNum.textContent = sStr;
            } else {
                // If standard boxes do not exist yet, build layout dynamically
                countdownElement.innerHTML = `
                    <div class="countdown-box">
                        <span class="countdown-number day-num">${dStr}</span>
                        <span class="countdown-label">দিন</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-number hour-num">${hStr}</span>
                        <span class="countdown-label">ঘণ্টা</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-number min-num">${mStr}</span>
                        <span class="countdown-label">মিনিট</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-number sec-num">${sStr}</span>
                        <span class="countdown-label">সেকেন্ড</span>
                    </div>
                `;
            }
        };

        // Run immediately then tick
        updateCountdown();
        const countdownInterval = setInterval(updateCountdown, 1000);
    }

    // ==========================================
    // 4. INTERACTIVE NEWSLETTER FORM FEEDBACK
    // ==========================================
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        const input = newsletterForm.querySelector('input[type="email"]');
        const button = newsletterForm.querySelector('button');
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (input && input.value.trim() !== '') {
                const originalContent = newsletterForm.innerHTML;
                
                // Show gorgeous success state in Bengali
                newsletterForm.style.background = 'var(--accent-bg)';
                newsletterForm.style.border = '1px dashed var(--primary)';
                newsletterForm.innerHTML = `
                    <div style="padding: 10px 15px; color: var(--primary); font-weight: 600; text-align: center; width: 100%;">
                        <i class="fa-solid fa-circle-check"></i> ধন্যবাদ! আপনার সাবস্ক্রিপশন সফল হয়েছে।
                    </div>
                `;
                
                // Restore form after 5 seconds
                setTimeout(function() {
                    newsletterForm.style.background = '';
                    newsletterForm.style.border = '';
                    newsletterForm.innerHTML = originalContent;
                    
                    // Re-bind listeners after restoring innerHTML
                    const newInput = newsletterForm.querySelector('input[type="email"]');
                    const newBtn = newsletterForm.querySelector('button');
                    if (newBtn && newInput) {
                        newBtn.addEventListener('click', arguments.callee);
                    }
                }, 5000);
            } else {
                input.style.borderColor = 'var(--danger)';
                input.placeholder = 'দয়া করে একটি সঠিক ইমেইল দিন';
                setTimeout(() => {
                    input.style.borderColor = '';
                    input.placeholder = 'Your Email';
                }, 3000);
            }
        });
    }
});
