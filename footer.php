<?php
/**
 * Shulov Park - Theme Footer Template
 *
 * @package Shulov_Park
 */

// Retrieve customizer parameters with elegant fallbacks
$phone     = get_theme_mod( 'shulov_park_phone', '+880 1234 567 890' );
$email     = get_theme_mod( 'shulov_park_email', 'support@shulovpark.com' );
$address   = get_theme_mod( 'shulov_park_address', 'Shulov Park, Dhaka, Bangladesh' );
$facebook  = get_theme_mod( 'shulov_park_facebook', '#' );
$instagram = get_theme_mod( 'shulov_park_instagram', '#' );
$youtube   = get_theme_mod( 'shulov_park_youtube', '#' );

$hours_weekdays = get_theme_mod( 'shulov_park_hours_weekdays', 'শনিবার - বৃহস্পতিবার: সকাল ৮:০০ - রাত ১০:০০' );
$hours_friday   = get_theme_mod( 'shulov_park_hours_friday', 'শুক্রবার: দুপুর ৩:০০ - রাত ১০:০০' );
$delivery_time  = get_theme_mod( 'shulov_park_delivery_time', '২৪/৭ হোম ডেলিভারি সুবিধা' );
?>

<footer class="site-footer">
    <!-- Top Widgets Grid -->
    <div class="container">
        <div class="footer-top">
            
            <!-- Column 1: Contact Info & Socials -->
            <div class="footer-widget">
                <h3>যোগাযোগ</h3>
                <p><i class="fa-solid fa-location-dot"></i> <?php echo esc_html( $address ); ?></p>
                <p><i class="fa-solid fa-phone"></i> <?php echo esc_html( $phone ); ?></p>
                <p><i class="fa-solid fa-envelope"></i> <?php echo esc_html( $email ); ?></p>
                
                <div class="social-links">
                    <?php if ( ! empty($facebook) ) : ?>
                        <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if ( ! empty($instagram) ) : ?>
                        <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if ( ! empty($youtube) ) : ?>
                        <a href="<?php echo esc_url( $youtube ); ?>" target="_blank" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Column 2: Quick Navigation Links -->
            <div class="footer-widget">
                <h3>সহজ লিংক</h3>
                <?php
                if ( has_nav_menu( 'footer' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer-links-list'
                    ) );
                } else {
                    echo '<ul>';
                    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">আমাদের কথা</a></li>';
                    if ( class_exists( 'WooCommerce' ) ) {
                        echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">শপ পেজ</a></li>';
                        echo '<li><a href="' . esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) . '">অ্যাকাউন্ট</a></li>';
                    }
                    echo '<li><a href="#">গোপনীয়তা নীতি</a></li>';
                    echo '<li><a href="#">শর্তাবলী ও নিয়ম</a></li>';
                    echo '<li><a href="#">রিটার্ন ও রিফান্ড নীতি</a></li>';
                    echo '</ul>';
                }
                ?>
            </div>

            <!-- Column 3: Store Operation Hours -->
            <div class="footer-widget">
                <h3>অপারেটিং সময়</h3>
                <ul>
                    <li><i class="fa-regular fa-clock"></i> <?php echo esc_html( $hours_weekdays ); ?></li>
                    <li><i class="fa-regular fa-clock"></i> <?php echo esc_html( $hours_friday ); ?></li>
                    <li><i class="fa-solid fa-truck"></i> <?php echo esc_html( $delivery_time ); ?></li>
                </ul>
            </div>
            
            <!-- Column 4: Newsletter Dynamic Signup -->
            <div class="footer-widget">
                <h3>নিউজলেটার</h3>
                <p>আমাদের অফার ও দৈনন্দিন পণ্যের লেটেস্ট ডিসকাউন্টের আপডেট পেতে সাবস্ক্রাইব করুন।</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="আপনার ইমেইল..." required>
                    <button type="submit"><i class="fa-regular fa-paper-plane"></i></button>
                </form>
            </div>
            
        </div>
    </div>
    
    <!-- Custom Localized Trust Badges (bKash, Nagad, Rocket, Visa, Mastercard) -->
    <div class="payment-gateways-container">
        <div class="container">
            <div class="gateways-wrapper">
                <div class="gateways-text">
                    আমরাই দিচ্ছি <strong>নিরাপদ ও নির্ভরযোগ্য</strong> পেমেন্ট গেটওয়ে সুবিধা:
                </div>
                <div class="gateways-list">
                    <span class="gateway-item bkash">bKash</span>
                    <span class="gateway-item nagad">Nagad</span>
                    <span class="gateway-item rocket">Rocket</span>
                    <span class="gateway-item visa">VISA</span>
                    <span class="gateway-item mastercard">MasterCard</span>
                    <span class="gateway-item cod">ক্যাশ অন ডেলিভারি</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Copyright Bottom Bar -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p>&copy; <?php echo date('Y'); ?> <strong><?php bloginfo( 'name' ); ?></strong>. সর্বস্বত্ব সংরক্ষিত।</p>
                <p>কারিগরি সহায়তায়: <a href="https://github.com/itfahim0" target="_blank" style="color:var(--accent); font-weight:600;">@itfahim0</a></p>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
