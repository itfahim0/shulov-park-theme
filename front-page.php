<?php
/**
 * The front-page template file.
 * Handles the complete premium grocery storefront homepage layout.
 *
 * @package Shulov_Park
 */

get_header();

// Retrieve Customizer Dynamic deadline
$flash_active   = get_theme_mod( 'shulov_park_flash_active', true );
$flash_title    = get_theme_mod( 'shulov_park_flash_title', 'ফ্ল্যাশ সেল!' );
$flash_subtitle = get_theme_mod( 'shulov_park_flash_subtitle', 'দারুণ সব অফার সীমিত সময়ের জন্য' );
$flash_deadline = get_theme_mod( 'shulov_park_flash_date', date( 'Y-m-d\T23:59:59', strtotime( '+5 days' ) ) );

$app_title = get_theme_mod( 'shulov_park_app_title', 'ঘরে বসেই কেনাকাটা করুন' );
$app_desc  = get_theme_mod( 'shulov_park_app_desc', 'সহজে, দ্রুত, নিরাপদে আপনার প্রতিদিনের গ্রোসারি ও ডেইলি এসেনশিয়াল আইটেম অর্ডার করতে ডাউনলোড করুন শুলভ পার্ক অ্যাপ।' );
$playstore = get_theme_mod( 'shulov_park_playstore', '#' );
$appstore  = get_theme_mod( 'shulov_park_appstore', '#' );

$shop_url = class_exists( 'WooCommerce' ) ? esc_url( wc_get_page_permalink( 'shop' ) ) : '#';
?>

<main id="primary" class="site-main">

    <!-- 1. HERO SLIDER SECTION (SWIPER JS) -->
    <section class="container hero-slider-container">
        <div class="swiper hero-slider">
            <div class="swiper-wrapper">
                
                <!-- Slide 1 (Image 4: Deep Green / Gold Supermarket basket) -->
                <div class="swiper-slide">
                    <a href="<?php echo $shop_url; ?>" class="hero-slide-item" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-slide-4.png');">
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-content">
                            <!-- Accessibility & SEO Headings (Screen Reader only if banner text is graphic) -->
                            <h2 class="screen-reader-text">প্রতিদিনের কেনাকাটা হোক সহজ, সাশ্রয়ী ও নির্ভরযোগ্য</h2>
                            <p class="screen-reader-text">মানসম্মত পণ্য, সেরা দাম, দ্রুত ডেলিভারি</p>
                            <span class="btn btn-accent">এখনই অর্ডার করুন <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </a>
                </div>

                <!-- Slide 2 (Image 2: fresh vegetables banner with basket) -->
                <div class="swiper-slide">
                    <a href="<?php echo $shop_url; ?>" class="hero-slide-item" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-slide-1.jpg');">
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-content">
                            <h2 class="screen-reader-text">আপনার প্রতিদিনের বিশ্বস্ত সঙ্গী</h2>
                            <p class="screen-reader-text">তাজা পণ্য, সেরা দাম, আপনার জন্য</p>
                            <span class="btn btn-accent">পণ্য দেখুন <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </a>
                </div>

                <!-- Slide 3 (Image 3: clean bag full of grocery fruits and vegetables) -->
                <div class="swiper-slide">
                    <a href="<?php echo $shop_url; ?>" class="hero-slide-item light-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-slide-2.png');">
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-content">
                            <h2 class="screen-reader-text">তাজা পণ্য, সুস্থ জীবন</h2>
                            <p class="screen-reader-text">নিত্যদিনের সকল প্রয়োজন এক ছাদের নিচে</p>
                            <span class="btn btn-primary">ক্যাটাগরি দেখুন <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </a>
                </div>

                <!-- Slide 4 (Image 5: Yellow app promo slide) -->
                <div class="swiper-slide">
                    <a href="<?php echo $shop_url; ?>" class="hero-slide-item light-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-slide-3.png');">
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-content">
                            <h2 class="screen-reader-text">ঘরে বসেই কেনাকাটা করুন</h2>
                            <p class="screen-reader-text">দ্রুত ডেলিভারি, নিরাপদ প্যাকেজিং</p>
                            <span class="btn btn-primary">শপ নাও <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </a>
                </div>
                
            </div>
            <!-- Add Pagination bullets -->
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- 2. FEATURED CATEGORIES SECTION -->
    <section class="container section-padding">
        <h2 class="section-title">পপুলার ক্যাটাগরি</h2>
        <div class="categories-grid">
            <?php
            // Array of 8 featured grocery categories with their custom FontAwesome icons
            $featured_categories = array(
                array(
                    'slug'  => 'grocery',
                    'title' => 'গ্রোসারি',
                    'icon'  => 'fa-basket-shopping'
                ),
                array(
                    'slug'  => 'vegetables',
                    'title' => 'তাজা সবজি',
                    'icon'  => 'fa-carrot'
                ),
                array(
                    'slug'  => 'fruits',
                    'title' => 'ফলমূল',
                    'icon'  => 'fa-apple-whole'
                ),
                array(
                    'slug'  => 'dairy',
                    'title' => 'দুগ্ধজাত পণ্য',
                    'icon'  => 'fa-cow'
                ),
                array(
                    'slug'  => 'beverages',
                    'title' => 'পানীয়',
                    'icon'  => 'fa-bottle-water'
                ),
                array(
                    'slug'  => 'snacks',
                    'title' => 'স্ন্যাকস',
                    'icon'  => 'fa-cookie-bite'
                ),
                array(
                    'slug'  => 'cosmetics',
                    'title' => 'প্রসাধন',
                    'icon'  => 'fa-soap'
                ),
                array(
                    'slug'  => 'household',
                    'title' => 'গৃহস্থালী',
                    'icon'  => 'fa-broom'
                ),
            );

            foreach ( $featured_categories as $cat ) :
                // Construct standard category archive URL
                $cat_url = class_exists( 'WooCommerce' ) ? esc_url( get_term_link( $cat['slug'], 'product_cat' ) ) : '#';
                if ( is_wp_error( $cat_url ) ) {
                    $cat_url = $shop_url . '?product_cat=' . $cat['slug'];
                }
                ?>
                <a href="<?php echo $cat_url; ?>" class="category-card">
                    <div class="category-icon-wrapper">
                        <i class="fa-solid <?php echo esc_attr( $cat['icon'] ); ?>"></i>
                    </div>
                    <span class="category-title"><?php echo esc_html( $cat['title'] ); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 3. BEST SELLING PRODUCTS (DYNAMIC GRID) -->
    <section class="container section-padding" style="background:var(--white); border-radius:var(--radius-lg); padding:50px 40px; box-shadow:var(--shadow-soft);">
        <h2 class="section-title">বেস্ট সেলিং প্রোডাক্টস</h2>
        <?php
        if ( class_exists( 'WooCommerce' ) ) {
            // Render WooCommerce Best Selling loop using official shortcode
            echo do_shortcode( '[products limit="8" columns="4" best_selling="true" visibility="featured"]' );
        } else {
            echo '<div style="text-align:center; padding: 20px; color:var(--text-muted); font-size:16px;">শপে পণ্য দেখতে WooCommerce সক্রিয় করুন।</div>';
        }
        ?>
    </section>

    <!-- 4. FLASH SALE SECTION (COUNTDOWN TIMER) -->
    <?php if ( $flash_active ) : ?>
        <section class="container section-padding">
            <div class="flash-sale-wrapper">
                <div class="flash-sale-text">
                    <h2 class="flash-sale-title"><?php echo esc_html( $flash_title ); ?></h2>
                    <p class="flash-sale-subtitle"><?php echo esc_html( $flash_subtitle ); ?></p>
                </div>
                
                <!-- Timer hook elements linking to custom JS -->
                <div id="countdown" class="countdown-container" data-deadline="<?php echo esc_attr( $flash_deadline ); ?>">
                    <div class="countdown-box">
                        <span class="countdown-number day-num">00</span>
                        <span class="countdown-label">দিন</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-number hour-num">00</span>
                        <span class="countdown-label">ঘণ্টা</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-number min-num">00</span>
                        <span class="countdown-label">মিনিট</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-number sec-num">00</span>
                        <span class="countdown-label">সেকেন্ড</span>
                    </div>
                </div>
            </div>
            
            <!-- On Sale Products Row -->
            <div style="margin-top: 35px;">
                <?php
                if ( class_exists( 'WooCommerce' ) ) {
                    // Render sale items dynamically
                    echo do_shortcode( '[products limit="4" columns="4" on_sale="true"]' );
                }
                ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- 5. FEATURED BRANDS SECTION -->
    <section class="container section-padding">
        <h2 class="section-title">পপুলার ব্র্যান্ডস</h2>
        <div class="brands-grid">
            <?php
            $brands = array('Radhuni', 'Pran', 'Teer', 'Aarong', 'Fresh', 'Pushti');
            foreach ( $brands as $brand ) :
                ?>
                <div class="brand-card">
                    <!-- Text representation or dummy logo styling -->
                    <span style="font-weight:700; color:var(--text-muted); font-size:18px; letter-spacing:1px;"><?php echo esc_html($brand); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 6. WHY CHOOSE US BLOCK -->
    <section class="container section-padding">
        <h2 class="section-title">কেন আমরা সেরা?</h2>
        <div class="why-us-grid">
            <div class="why-card">
                <i class="fa-solid fa-shield-halved why-icon"></i>
                <h4 class="why-title">১০০% খাঁটি পণ্য</h4>
                <p class="why-desc">সরাসরি উৎপাদক ও বিশ্বস্ত ডিস্ট্রিবিউটর থেকে সংগ্রহকৃত মূল পণ্য।</p>
            </div>
            <div class="why-card">
                <i class="fa-solid fa-tags why-icon"></i>
                <h4 class="why-title">সেরা দামের গ্যারান্টি</h4>
                <p class="why-desc">অন্য যেকোনো সুপার শপ বা বাজার থেকে সাশ্রয়ী দামে সেরা জিনিস।</p>
            </div>
            <div class="why-card">
                <i class="fa-solid fa-truck-fast why-icon"></i>
                <h4 class="why-title">দ্রুত হোম ডেলিভারি</h4>
                <p class="why-desc">ঢাকা শহরের যেকোনো প্রান্তে দ্রুত ও নিরাপদ হোম ডেলিভারি সুবিধা।</p>
            </div>
            <div class="why-card">
                <i class="fa-solid fa-credit-card why-icon"></i>
                <h4 class="why-title">নিরাপদ পেমেন্ট</h4>
                <p class="why-desc">বিকাশ, নগদ, রকেট, কার্ড এবং ক্যাশ অন ডেলিভারি পেমেন্ট সুবিধা।</p>
            </div>
            <div class="why-card">
                <i class="fa-solid fa-headset why-icon"></i>
                <h4 class="why-title">২৪/৭ কাস্টমার সাপোর্ট</h4>
                <p class="why-desc">যেকোনো প্রয়োজনে আমাদের কাস্টমার কেয়ার সর্বদা প্রস্তুত।</p>
            </div>
        </div>
    </section>

    <!-- 7. TESTIMONIALS SECTION -->
    <section class="container section-padding" style="background:#EBF3EF; border-radius:var(--radius-lg); padding:50px 40px; box-shadow:var(--shadow-soft);">
        <h2 class="section-title">ক্রেতাদের মতামত</h2>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="testimonial-text">"শুলভ পার্কের পণ্য এবং ডেলিভারি সার্ভিস অসাধারণ! তাজা সবজি ও খাঁটি ঘি আমি নিয়মিত অর্ডার করি। কোয়ালিটি নিয়ে কোনো কমপ্লেন নেই।"</p>
                <div class="testimonial-user">
                    <div class="testimonial-avatar">ত</div>
                    <div class="testimonial-name">তানভীর রহমান, ঢাকা</div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="testimonial-text">"করোনার পর থেকেই অনলাইন গ্রোসারি ব্যবহার করছি, তবে এদের রেট বাজারের সাধারণ খুচরা মূল্যের চেয়ে অনেক শুলভ। প্যাকজিং খুবই ভালো ছিল।"</p>
                <div class="testimonial-user">
                    <div class="testimonial-avatar">ন</div>
                    <div class="testimonial-name">নুসরাত সুলতানা, উত্তরা</div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <p class="testimonial-text">"বিকাশ দিয়ে পে করার সাথে সাথে কনফার্মেশন মেসেজ পাই এবং ৪ ঘণ্টার মধ্যে ডেলিভারি সম্পন্ন হয়। আইটেম মিসিং ছিল না।"</p>
                <div class="testimonial-user">
                    <div class="testimonial-avatar">ম</div>
                    <div class="testimonial-name">মাহমুদ হাসান, ধানমন্ডি</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. MOBILE APP PROMOTION SECTION -->
    <section class="container section-padding">
        <div class="app-promotion-box">
            <div class="app-promo-content">
                <h2 class="app-promo-title"><?php echo esc_html( $app_title ); ?></h2>
                <p class="app-promo-desc"><?php echo esc_html( $app_desc ); ?></p>
                <div class="app-buttons">
                    <a href="<?php echo esc_url( $playstore ); ?>" target="_blank" class="app-btn">
                        <i class="fa-brands fa-google-play"></i>
                        <div>
                            <small style="display:block; font-size:10px; opacity:0.8;">GET IT ON</small>
                            Google Play
                        </div>
                    </a>
                    <a href="<?php echo esc_url( $appstore ); ?>" target="_blank" class="app-btn">
                        <i class="fa-brands fa-apple"></i>
                        <div>
                            <small style="display:block; font-size:10px; opacity:0.8;">Download on the</small>
                            App Store
                        </div>
                    </a>
                </div>
            </div>
            <div class="app-promo-image">
                <!-- Displays mockup image inside slider yellow banners or fallback graphic icon -->
                <i class="fa-solid fa-mobile-screen-button" style="font-size: 180px; color:var(--accent-light); opacity:0.85;"></i>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer();
