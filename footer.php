<?php
/**
 * Shulov Park - Theme Footer Template
 * Modernized with Vite + Tailwind CSS, slide-out AJAX cart drawers, and product Quick Views.
 *
 * @package Shulov_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Retrieve customizer/admin settings parameters with elegant fallbacks
$phone     = shulov_get_setting( 'shulov_park_phone', '+880 1234 567 890' );
$email     = shulov_get_setting( 'shulov_park_email', 'support@shulovpark.com' );
$address   = shulov_get_setting( 'shulov_park_address', 'Shulov Park, Dhaka, Bangladesh' );
$facebook  = shulov_get_setting( 'shulov_park_facebook', '#' );
$instagram = shulov_get_setting( 'shulov_park_instagram', '#' );
$youtube   = shulov_get_setting( 'shulov_park_youtube', '#' );

$hours_weekdays = shulov_get_setting( 'shulov_park_hours_weekdays', 'শনিবার - বৃহস্পতিবার: সকাল ৮:০০ - রাত ১০:০০' );
$hours_friday   = shulov_get_setting( 'shulov_park_hours_friday', 'শুক্রবার: দুপুর ৩:০০ - রাত ১০:০০' );
$delivery_time  = shulov_get_setting( 'shulov_park_delivery_time', '২৪/৭ হোম ডেলিভারি সুবিধা' );
?>

<footer class="site-footer bg-[#111B15] dark:bg-[#0A0F0C] text-neutral-border pt-16 transition-smooth">
    <!-- Top Widgets Grid -->
    <div class="container">
        <div class="footer-top grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-10">
            
            <!-- Column 1: Contact Info & Socials -->
            <div class="footer-widget text-sm">
                <!-- Footer Brand Logo fallback -->
                <div class="footer-logo mb-6">
                    <?php 
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        $logo_url = get_template_directory_uri() . '/assets/images/logo.png';
                        echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="block">';
                        echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="max-h-14 w-auto object-contain brightness-0 invert" />';
                        echo '</a>';
                    }
                    ?>
                </div>
                <p class="flex items-center gap-2 mb-3"><i class="fa-solid fa-location-dot text-accent"></i> <?php echo esc_html( $address ); ?></p>
                <p class="flex items-center gap-2 mb-3"><i class="fa-solid fa-phone text-accent"></i> <?php echo esc_html( $phone ); ?></p>
                <p class="flex items-center gap-2 mb-3"><i class="fa-solid fa-envelope text-accent"></i> <?php echo esc_html( $email ); ?></p>
                
                <div class="social-links flex gap-3 mt-6">
                    <?php if ( ! empty($facebook) ) : ?>
                        <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" class="w-9 h-9 rounded-full bg-white/5 hover:bg-primary hover:text-white flex items-center justify-center transition-smooth" title="Facebook"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                    <?php endif; ?>
                    <?php if ( ! empty($instagram) ) : ?>
                        <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" class="w-9 h-9 rounded-full bg-white/5 hover:bg-primary hover:text-white flex items-center justify-center transition-smooth" title="Instagram"><i class="fa-brands fa-instagram text-sm"></i></a>
                    <?php endif; ?>
                    <?php if ( ! empty($youtube) ) : ?>
                        <a href="<?php echo esc_url( $youtube ); ?>" target="_blank" class="w-9 h-9 rounded-full bg-white/5 hover:bg-primary hover:text-white flex items-center justify-center transition-smooth" title="YouTube"><i class="fa-brands fa-youtube text-sm"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Column 2: Quick Navigation Links -->
            <div class="footer-widget text-sm">
                <h3 class="text-white font-bold text-lg mb-6 pb-2 border-b-2 border-accent border-solid max-w-[60px]">সহজ লিংক</h3>
                <?php
                if ( has_nav_menu( 'footer' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer-links-list space-y-3'
                    ) );
                } else {
                    echo '<ul class="space-y-3 list-none p-0">';
                    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '" class="text-[#94A3B8] hover:text-accent-light hover:pl-1 transition-smooth text-sm">আমাদের কথা</a></li>';
                    if ( class_exists( 'WooCommerce' ) ) {
                        echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="text-[#94A3B8] hover:text-accent-light hover:pl-1 transition-smooth text-sm">শপ পেজ</a></li>';
                        echo '<li><a href="' . esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) . '" class="text-[#94A3B8] hover:text-accent-light hover:pl-1 transition-smooth text-sm">অ্যাকাউন্ট</a></li>';
                    }
                    echo '<li><a href="#" class="text-[#94A3B8] hover:text-accent-light hover:pl-1 transition-smooth text-sm">গোপনীয়তা নীতি</a></li>';
                    echo '<li><a href="#" class="text-[#94A3B8] hover:text-accent-light hover:pl-1 transition-smooth text-sm">শর্তাবলী ও নিয়ম</a></li>';
                    echo '<li><a href="#" class="text-[#94A3B8] hover:text-accent-light hover:pl-1 transition-smooth text-sm">রিটার্ন ও রিফান্ড নীতি</a></li>';
                    echo '</ul>';
                }
                ?>
            </div>

            <!-- Column 3: Store Operation Hours -->
            <div class="footer-widget text-sm">
                <h3 class="text-white font-bold text-lg mb-6 pb-2 border-b-2 border-accent border-solid max-w-[60px]">অপারেটিং সময়</h3>
                <ul class="space-y-3 list-none p-0">
                    <li class="flex items-center gap-2"><i class="fa-regular fa-clock text-accent"></i> <?php echo esc_html( $hours_weekdays ); ?></li>
                    <li class="flex items-center gap-2"><i class="fa-regular fa-clock text-accent"></i> <?php echo esc_html( $hours_friday ); ?></li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-truck text-accent"></i> <?php echo esc_html( $delivery_time ); ?></li>
                </ul>
            </div>
            
            <!-- Column 4: Newsletter Dynamic Signup -->
            <div class="footer-widget text-sm">
                <h3 class="text-white font-bold text-lg mb-6 pb-2 border-b-2 border-accent border-solid max-w-[60px]">নিউজলেটার</h3>
                <p class="mb-4 leading-relaxed">আমাদের অফার ও দৈনন্দিন পণ্যের লেটেস্ট ডিসকাউন্টের আপডেট পেতে সাবস্ক্রাইব করুন।</p>
                <form class="newsletter-form flex border border-solid border-neutral-muted/20 rounded overflow-hidden">
                    <input type="email" class="flex-1 py-2.5 px-4 bg-transparent outline-none border-none text-white text-sm" placeholder="আপনার ইমেইল..." required>
                    <button type="submit" class="bg-primary hover:bg-primary-hover text-white py-2 px-4 cursor-pointer transition-smooth border-none flex items-center justify-center"><i class="fa-regular fa-paper-plane"></i></button>
                </form>
            </div>
            
        </div>
    </div>
    
    <!-- Localized Trust Badges (bKash, Nagad, Rocket, Visa, Mastercard) -->
    <div class="payment-gateways-container bg-[#0E1611] dark:bg-[#070B08] py-5 border-t border-solid border-white/5 transition-smooth">
        <div class="container">
            <div class="gateways-wrapper flex justify-between items-center flex-wrap gap-4">
                <div class="gateways-text text-neutral-muted text-xs md:text-sm">
                    আমরাই দিচ্ছি <strong class="text-[#94A3B8]">নিরাপদ ও নির্ভরযোগ্য</strong> পেমেন্ট গেটওয়ে সুবিধা:
                </div>
                <div class="gateways-list flex gap-3 flex-wrap">
                    <span class="gateway-item bkash text-xs font-semibold py-1.5 px-3 bg-white/5 border border-solid border-white/5 rounded text-[#94A3B8] transition-smooth cursor-default hover:bg-[#e2136e] hover:text-white">bKash</span>
                    <span class="gateway-item nagad text-xs font-semibold py-1.5 px-3 bg-white/5 border border-solid border-white/5 rounded text-[#94A3B8] transition-smooth cursor-default hover:bg-[#ec1c24] hover:text-white">Nagad</span>
                    <span class="gateway-item rocket text-xs font-semibold py-1.5 px-3 bg-white/5 border border-solid border-white/5 rounded text-[#94A3B8] transition-smooth cursor-default hover:bg-[#8c3494] hover:text-white">Rocket</span>
                    <span class="gateway-item visa text-xs font-semibold py-1.5 px-3 bg-white/5 border border-solid border-white/5 rounded text-[#94A3B8] transition-smooth cursor-default hover:bg-[#1A1F71] hover:text-white">VISA</span>
                    <span class="gateway-item mastercard text-xs font-semibold py-1.5 px-3 bg-white/5 border border-solid border-white/5 rounded text-[#94A3B8] transition-smooth cursor-default hover:bg-[#EB001B] hover:text-white">MasterCard</span>
                    <span class="gateway-item cod text-xs font-semibold py-1.5 px-3 bg-white/5 border border-solid border-white/5 rounded text-[#94A3B8] transition-smooth cursor-default hover:bg-primary hover:text-white hover:border-accent">ক্যাশ অন ডেলিভারি</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Copyright Bottom Bar -->
    <div class="footer-bottom bg-[#0A0F0C] dark:bg-[#050806] py-5 border-t border-solid border-white/5 transition-smooth">
        <div class="container">
            <div class="footer-bottom-content flex justify-between items-center flex-wrap gap-4 text-xs md:text-sm text-neutral-muted">
                <p>&copy; <?php echo date('Y'); ?> <strong class="text-[#94A3B8]"><?php bloginfo( 'name' ); ?></strong>. সর্বস্বত্ব সংরক্ষিত।</p>
                <p>কারিগরি সহায়তায়: <a href="https://github.com/itfahim0" target="_blank" class="text-accent hover:text-accent-light font-semibold">@itfahim0</a></p>
            </div>
        </div>
    </div>
</footer>

<!-- SLIDE-OUT GLASSMORPHIC MINI-CART DRAWER -->
<div id="cart-drawer-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[9998] opacity-0 pointer-events-none transition-opacity duration-300"></div>
<div id="mini-cart-drawer" class="fixed top-0 right-0 h-full w-full sm:w-[450px] z-[9999] bg-white dark:bg-neutral-900 border-l border-neutral-border dark:border-neutral-800 shadow-2xl translate-x-full transition-transform duration-300 flex flex-col justify-between">
    <!-- Drawer Header -->
    <div class="p-6 border-b border-solid border-neutral-border dark:border-neutral-800 flex justify-between items-center bg-neutral-light dark:bg-neutral-900">
        <h3 class="text-base md:text-lg font-bold text-neutral-dark dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-basket-shopping text-primary dark:text-primary-light"></i>
            <?php esc_html_e( 'আপনার শপিং ব্যাগ', 'shulov-park' ); ?>
        </h3>
        <button id="close-cart-drawer" class="text-neutral-dark dark:text-white hover:text-danger text-2xl transition-smooth focus:outline-none p-1 cursor-pointer bg-transparent border-none">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    
    <!-- Drawer Body Container (Loads Ajax item list) -->
    <div id="cart-drawer-items-container" class="flex-1 overflow-y-auto">
        <!-- AJAX loads markup here -->
    </div>
</div>

<!-- PRODUCT QUICK VIEW MODAL (AJAX DRIVEN) -->
<div id="quick-view-modal" class="fixed inset-0 z-[10000] flex items-center justify-center p-4 md:p-6 opacity-0 pointer-events-none transition-opacity duration-300">
    <div id="quick-view-overlay" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    
    <div class="modal-scale bg-white dark:bg-neutral-900 border border-solid border-neutral-border dark:border-neutral-800 rounded-md shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto relative z-10 p-6 md:p-8 scale-95 opacity-0 transition-all duration-300">
        <!-- Close Button -->
        <button id="close-quick-view" class="absolute top-4 right-4 text-neutral-dark dark:text-white hover:text-danger text-xl md:text-2xl transition-smooth focus:outline-none p-1 z-20 cursor-pointer bg-transparent border-none">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <!-- Modal Dynamic Content Container -->
        <div id="quick-view-modal-content">
            <!-- AJAX loads product view here -->
        </div>
    </div>
</div>

<!-- ORDER TRACKING MODAL -->
<div id="order-track-modal" class="fixed inset-0 z-[10000] flex items-center justify-center p-4 md:p-6 opacity-0 pointer-events-none transition-opacity duration-300">
    <div id="order-track-overlay" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    
    <div class="modal-scale bg-white dark:bg-neutral-900 border border-solid border-neutral-border dark:border-neutral-800 rounded-md shadow-2xl w-full max-w-lg relative z-10 p-6 md:p-8 scale-95 opacity-0 transition-all duration-300">
        <!-- Close Button -->
        <button id="close-order-track" class="absolute top-4 right-4 text-neutral-dark dark:text-white hover:text-danger text-xl transition-smooth focus:outline-none p-1 z-20 cursor-pointer bg-transparent border-none">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <h3 class="text-lg md:text-xl font-bold text-primary dark:text-primary-light mb-6 flex items-center gap-2 border-b border-solid border-neutral-border dark:border-neutral-800 pb-3">
            <i class="fa-solid fa-truck-fast"></i>
            অর্ডার ট্র্যাক করুন
        </h3>
        
        <div id="order-track-modal-content">
            <?php if ( is_user_logged_in() ) : ?>
                <p class="text-sm text-neutral-muted mb-4">আপনার অর্ডার নম্বর অথবা মোবাইল নম্বরটি নিচে লিখুন:</p>
                <form id="order-track-form" class="space-y-4">
                    <div class="relative">
                        <input type="text" id="order-track-query" class="w-full py-2.5 px-4 border border-solid border-neutral-border dark:border-neutral-800 rounded outline-none focus:border-primary dark:focus:border-primary-light bg-transparent text-neutral-dark dark:text-white text-sm" placeholder="যেমন: ১২৩৪৫ অথবা ০১৭১২৩৪৫৬৭৮" required autocomplete="off">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-primary hover:bg-primary-hover text-white font-semibold rounded transition-smooth flex items-center justify-center gap-2 border-none cursor-pointer text-sm">
                        <i class="fa-solid fa-search"></i>
                        ট্র্যাক করুন
                    </button>
                </form>
                <div id="order-track-result" class="mt-6 max-h-[300px] overflow-y-auto hidden"></div>
            <?php else : ?>
                <div class="text-center py-6">
                    <i class="fa-solid fa-circle-exclamation text-yellow-500 text-4xl mb-4"></i>
                    <p class="text-neutral-dark dark:text-white font-semibold mb-2">লগইন করা নেই</p>
                    <p class="text-sm text-neutral-muted mb-6">আপনার অর্ডার ট্র্যাক করতে প্রথমে আপনাকে লগইন করতে হবে।</p>
                    <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="inline-block py-2.5 px-6 bg-primary hover:bg-primary-hover text-white font-semibold rounded transition-smooth text-sm border-none">
                        লগইন পেজে যান
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
