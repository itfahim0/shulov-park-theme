<?php
/**
 * The front-page template file.
 * Refactored to utilize custom WP_Query loops with reusable product cards, Tailwind CSS grid systems, and settings engines.
 *
 * @package Shulov_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();

// Retrieve settings/customizer values with dual fallbacks
$flash_active   = shulov_get_setting( 'shulov_park_flash_active', true );
$flash_title    = shulov_get_setting( 'shulov_park_flash_title', 'ফ্ল্যাশ সেল!' );
$flash_subtitle = shulov_get_setting( 'shulov_park_flash_subtitle', 'দারুণ সব অফার সীমিত সময়ের জন্য' );
$flash_deadline = shulov_get_setting( 'shulov_park_flash_date', date( 'Y-m-d\T23:59:59', strtotime( '+5 days' ) ) );

$app_title = shulov_get_setting( 'shulov_park_app_title', 'ঘরে বসেই কেনাকাটা করুন' );
$app_desc  = shulov_get_setting( 'shulov_park_app_desc', 'সহজে, দ্রুত, নিরাপদে আপনার প্রতিদিনের গ্রোসারি ও ডেইলি এসেনশিয়াল আইটেম অর্ডার করতে ডাউনলোড করুন শুলভ পার্ক অ্যাপ।' );
$playstore = shulov_get_setting( 'shulov_park_playstore', '#' );
$appstore  = shulov_get_setting( 'shulov_park_appstore', '#' );

$shop_url = class_exists( 'WooCommerce' ) ? esc_url( wc_get_page_permalink( 'shop' ) ) : '#';
?>

<main id="primary" class="site-main transition-smooth py-6">

    <!-- 1. HERO SLIDER SECTION (SWIPER JS) -->
    <section class="container hero-slider-container mb-12">
        <div class="swiper hero-slider">
            <div class="swiper-wrapper">
                
                <!-- Slide 1 (Deep Green / Gold Supermarket basket) -->
                <div class="swiper-slide">
                    <a href="<?php echo $shop_url; ?>" class="hero-slide-item" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide-4.png');">
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-content">
                            <h2 class="screen-reader-text">প্রতিদিনের কেনাকাটা হোক সহজ, সাশ্রয়ী ও নির্ভরযোগ্য</h2>
                            <p class="screen-reader-text">মানসম্মত পণ্য, সেরা দাম, দ্রুত ডেলিভারি</p>
                            <span class="btn btn-accent border-none shadow-md">এখনই অর্ডার করুন <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </a>
                </div>

                <!-- Slide 2 (Fresh vegetables banner with basket) -->
                <div class="swiper-slide">
                    <a href="<?php echo $shop_url; ?>" class="hero-slide-item" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide-1.jpg');">
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-content">
                            <h2 class="screen-reader-text">আপনার প্রতিদিনের বিশ্বস্ত সঙ্গী</h2>
                            <p class="screen-reader-text">তাজা পণ্য, সেরা দাম, আপনার জন্য</p>
                            <span class="btn btn-accent border-none shadow-md">পণ্য দেখুন <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </a>
                </div>

                <!-- Slide 3 (Clean bag full of grocery fruits and vegetables) -->
                <div class="swiper-slide">
                    <a href="<?php echo $shop_url; ?>" class="hero-slide-item light-bg" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide-2.png');">
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-content">
                            <h2 class="screen-reader-text">তাজা পণ্য, সুস্থ জীবন</h2>
                            <p class="screen-reader-text">নিত্যদিনের সকল প্রয়োজন এক ছাদের নিচে</p>
                            <span class="btn btn-primary border-none shadow-md">ক্যাটাগরি দেখুন <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </a>
                </div>

                <!-- Slide 4 (Yellow app promo slide) -->
                <div class="swiper-slide">
                    <a href="<?php echo $shop_url; ?>" class="hero-slide-item light-bg" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide-3.png');">
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-content">
                            <h2 class="screen-reader-text">ঘরে বসেই কেনাকাটা করুন</h2>
                            <p class="screen-reader-text">দ্রুত ডেলিভারি, নিরাপদ প্যাকেজিং</p>
                            <span class="btn btn-primary border-none shadow-md">শপ নাও <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </a>
                </div>
                
            </div>
            <!-- Add Pagination bullets -->
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- 2. FEATURED CATEGORIES SECTION -->
    <section class="container mb-16">
        <h2 class="section-title dark:text-white"><?php esc_html_e( 'পপুলার ক্যাটাগরি', 'shulov-park' ); ?></h2>
        <div class="categories-grid grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
            <?php
            $featured_categories = array(
                array( 'slug' => 'grocery', 'title' => 'গ্রোসারি', 'icon' => 'fa-basket-shopping' ),
                array( 'slug' => 'vegetables', 'title' => 'তাজা সবজি', 'icon' => 'fa-carrot' ),
                array( 'slug' => 'fruits', 'title' => 'ফলমূল', 'icon' => 'fa-apple-whole' ),
                array( 'slug' => 'dairy', 'title' => 'দুগ্ধজাত পণ্য', 'icon' => 'fa-cow' ),
                array( 'slug' => 'beverages', 'title' => 'পানীয়', 'icon' => 'fa-bottle-water' ),
                array( 'slug' => 'snacks', 'title' => 'স্ন্যাকস', 'icon' => 'fa-cookie-bite' ),
                array( 'slug' => 'cosmetics', 'title' => 'প্রসাধন', 'icon' => 'fa-soap' ),
                array( 'slug' => 'household', 'title' => 'গৃহস্থালী', 'icon' => 'fa-broom' ),
            );

            foreach ( $featured_categories as $cat ) :
                $cat_link = class_exists( 'WooCommerce' ) ? get_term_link( $cat['slug'], 'product_cat' ) : '#';
                $cat_url  = ( ! is_wp_error( $cat_link ) && ! empty( $cat_link ) ) ? esc_url( $cat_link ) : $shop_url . '?product_cat=' . $cat['slug'];
                ?>
                <a href="<?php echo esc_url( $cat_url ); ?>" class="category-card p-5 bg-white dark:bg-neutral-900 border border-neutral-border dark:border-neutral-800 rounded-md flex flex-col items-center gap-3 hover:-translate-y-1.5 shadow-soft hover:shadow-hover hover:border-primary-light transition-smooth">
                    <div class="category-icon-wrapper w-14 h-14 rounded-full bg-primary/10 dark:bg-primary-light/10 text-primary dark:text-primary-light flex items-center justify-center text-xl transition-smooth">
                        <i class="fa-solid <?php echo esc_attr( $cat['icon'] ); ?>"></i>
                    </div>
                    <span class="category-title text-sm font-semibold text-neutral-dark dark:text-white transition-smooth"><?php echo esc_html( $cat['title'] ); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 3. BEST SELLING PRODUCTS (DYNAMIC WP_QUERY LOOP) -->
    <section class="container p-8 md:p-12 mb-16 bg-white dark:bg-neutral-900 border border-neutral-border dark:border-neutral-800 rounded-lg shadow-soft transition-smooth">
        <h2 class="section-title dark:text-white"><?php esc_html_e( 'বেস্ট সেলিং প্রোডাক্টস', 'shulov-park' ); ?></h2>
        
        <?php
        if ( class_exists( 'WooCommerce' ) ) {
            $best_selling_query = new WP_Query( array(
                'post_type'      => 'product',
                'posts_per_page' => 8,
                'meta_key'       => 'total_sales',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
            ) );

            if ( $best_selling_query->have_posts() ) :
                echo '<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">';
                while ( $best_selling_query->have_posts() ) : $best_selling_query->the_post();
                    global $product;
                    $product = wc_get_product( get_the_ID() );
                    get_template_part( 'template-parts/product/product-card' );
                endwhile;
                echo '</div>';
                wp_reset_postdata();
            else :
                echo '<div class="text-center py-6 text-neutral-muted">' . esc_html__( 'কোনো প্রোডাক্ট পাওয়া যায়নি।', 'shulov-park' ) . '</div>';
            endif;
        } else {
            echo '<div class="text-center py-6 text-neutral-muted">' . esc_html__( 'পণ্য প্রদর্শন করতে WooCommerce সক্রিয় করুন।', 'shulov-park' ) . '</div>';
        }
        ?>
    </section>

    <!-- 4. FLASH SALE SECTION (COUNTDOWN TIMER) -->
    <?php if ( $flash_active ) : ?>
        <section class="container mb-16">
            <div class="flash-sale-wrapper p-8 md:p-12 bg-gradient-to-r from-primary to-primary-light dark:from-neutral-900 dark:to-neutral-800 border dark:border-neutral-800 rounded-lg flex justify-between items-center flex-wrap gap-8 shadow-soft relative overflow-hidden transition-smooth">
                <div class="flash-sale-text relative z-10">
                    <h2 class="flash-sale-title text-accent-light dark:text-primary-light font-bold text-3xl mb-2"><?php echo esc_html( $flash_title ); ?></h2>
                    <p class="flash-sale-subtitle text-white dark:text-neutral-muted text-sm md:text-base"><?php echo esc_html( $flash_subtitle ); ?></p>
                </div>
                
                <!-- Countdown Box elements -->
                <div id="countdown" class="countdown-container flex gap-3 relative z-10" data-deadline="<?php echo esc_attr( $flash_deadline ); ?>">
                    <div class="countdown-box min-w-[70px] p-3 bg-white dark:bg-neutral-900 border dark:border-neutral-800 rounded shadow-md text-center hover:-translate-y-1 transition-smooth">
                        <span class="countdown-number day-num text-xl md:text-2xl font-bold text-primary dark:text-primary-light leading-none mb-1">00</span>
                        <span class="countdown-label text-[10px] text-neutral-muted block">দিন</span>
                    </div>
                    <div class="countdown-box min-w-[70px] p-3 bg-white dark:bg-neutral-900 border dark:border-neutral-800 rounded shadow-md text-center hover:-translate-y-1 transition-smooth">
                        <span class="countdown-number hour-num text-xl md:text-2xl font-bold text-primary dark:text-primary-light leading-none mb-1">00</span>
                        <span class="countdown-label text-[10px] text-neutral-muted block">ঘণ্টা</span>
                    </div>
                    <div class="countdown-box min-w-[70px] p-3 bg-white dark:bg-neutral-900 border dark:border-neutral-800 rounded shadow-md text-center hover:-translate-y-1 transition-smooth">
                        <span class="countdown-number min-num text-xl md:text-2xl font-bold text-primary dark:text-primary-light leading-none mb-1">00</span>
                        <span class="countdown-label text-[10px] text-neutral-muted block">মিনিট</span>
                    </div>
                    <div class="countdown-box min-w-[70px] p-3 bg-white dark:bg-neutral-900 border dark:border-neutral-800 rounded shadow-md text-center hover:-translate-y-1 transition-smooth">
                        <span class="countdown-number sec-num text-xl md:text-2xl font-bold text-primary dark:text-primary-light leading-none mb-1">00</span>
                        <span class="countdown-label text-[10px] text-neutral-muted block">সেকেন্ড</span>
                    </div>
                </div>
            </div>
            
            <!-- On Sale Products Row (Dynamic WP_Query) -->
            <div class="mt-8">
                <?php
                if ( class_exists( 'WooCommerce' ) ) {
                    $sale_ids = wc_get_product_ids_on_sale();
                    
                    $on_sale_query = new WP_Query( array(
                        'post_type'      => 'product',
                        'posts_per_page' => 4,
                        'post__in'       => ! empty( $sale_ids ) ? $sale_ids : array( 0 ),
                    ) );

                    if ( $on_sale_query->have_posts() ) :
                        echo '<div class="grid grid-cols-2 md:grid-cols-4 gap-6">';
                        while ( $on_sale_query->have_posts() ) : $on_sale_query->the_post();
                            global $product;
                            $product = wc_get_product( get_the_ID() );
                            get_template_part( 'template-parts/product/product-card' );
                        endwhile;
                        echo '</div>';
                        wp_reset_postdata();
                    endif;
                }
                ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- 5. FEATURED BRANDS SECTION -->
    <section class="container mb-16">
        <h2 class="section-title dark:text-white"><?php esc_html_e( 'পপুলার ব্র্যান্ডস', 'shulov-park' ); ?></h2>
        <div class="brands-grid flex flex-wrap justify-between items-center gap-4">
            <?php
            $brands = array('Radhuni', 'Pran', 'Teer', 'Aarong', 'Fresh', 'Pushti');
            foreach ( $brands as $brand ) :
                ?>
                <div class="brand-card flex-1 min-w-[140px] p-5 bg-white dark:bg-neutral-900 border border-neutral-border dark:border-neutral-800 rounded-md shadow-soft flex items-center justify-center transition-smooth">
                    <span class="brand-name font-bold text-lg tracking-wider"><?php echo esc_html($brand); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 6. WHY CHOOSE US BLOCK -->
    <section class="container mb-16">
        <h2 class="section-title dark:text-white"><?php esc_html_e( 'কেন আমরা সেরা?', 'shulov-park' ); ?></h2>
        <div class="why-us-grid grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <div class="why-card p-6 bg-white dark:bg-neutral-900 border border-neutral-border dark:border-neutral-800 rounded shadow-soft text-center hover:-translate-y-1 hover:border-primary-light transition-smooth">
                <i class="fa-solid fa-shield-halved text-primary dark:text-primary-light text-3xl mb-4 transition-smooth"></i>
                <h4 class="why-title text-sm font-semibold text-neutral-dark dark:text-white mb-2">১০০% খাঁটি পণ্য</h4>
                <p class="why-desc text-xs text-neutral-muted dark:text-neutral-muted leading-relaxed">সরাসরি উৎপাদক ও বিশ্বস্ত ডিস্ট্রিবিউটর থেকে সংগ্রহকৃত মূল পণ্য।</p>
            </div>
            <div class="why-card p-6 bg-white dark:bg-neutral-900 border border-neutral-border dark:border-neutral-800 rounded shadow-soft text-center hover:-translate-y-1 hover:border-primary-light transition-smooth">
                <i class="fa-solid fa-tags text-primary dark:text-primary-light text-3xl mb-4 transition-smooth"></i>
                <h4 class="why-title text-sm font-semibold text-neutral-dark dark:text-white mb-2">সেরা দামের গ্যারান্টি</h4>
                <p class="why-desc text-xs text-neutral-muted dark:text-neutral-muted leading-relaxed">অন্য যেকোনো সুপার শপ বা বাজার থেকে সাশ্রয়ী দামে সেরা জিনিস।</p>
            </div>
            <div class="why-card p-6 bg-white dark:bg-neutral-900 border border-neutral-border dark:border-neutral-800 rounded shadow-soft text-center hover:-translate-y-1 hover:border-primary-light transition-smooth">
                <i class="fa-solid fa-truck-fast text-primary dark:text-primary-light text-3xl mb-4 transition-smooth"></i>
                <h4 class="why-title text-sm font-semibold text-neutral-dark dark:text-white mb-2">দ্রুত হোম ডেলিভারি</h4>
                <p class="why-desc text-xs text-neutral-muted dark:text-neutral-muted leading-relaxed">ঢাকা শহরের যেকোনো প্রান্তে দ্রুত ও নিরাপদ হোম ডেলিভারি সুবিধা।</p>
            </div>
            <div class="why-card p-6 bg-white dark:bg-neutral-900 border border-neutral-border dark:border-neutral-800 rounded shadow-soft text-center hover:-translate-y-1 hover:border-primary-light transition-smooth">
                <i class="fa-solid fa-credit-card text-primary dark:text-primary-light text-3xl mb-4 transition-smooth"></i>
                <h4 class="why-title text-sm font-semibold text-neutral-dark dark:text-white mb-2">নিরাপদ পেমেন্ট</h4>
                <p class="why-desc text-xs text-neutral-muted dark:text-neutral-muted leading-relaxed">বিকাশ, নগদ, রকেট, কার্ড এবং ক্যাশ অন ডেলিভারি পেমেন্ট সুবিধা।</p>
            </div>
            <div class="why-card p-6 bg-white dark:bg-neutral-900 border border-neutral-border dark:border-neutral-800 rounded shadow-soft text-center hover:-translate-y-1 hover:border-primary-light transition-smooth">
                <i class="fa-solid fa-headset text-primary dark:text-primary-light text-3xl mb-4 transition-smooth"></i>
                <h4 class="why-title text-sm font-semibold text-neutral-dark dark:text-white mb-2">২৪/৭ কাস্টমার সাপোর্ট</h4>
                <p class="why-desc text-xs text-neutral-muted dark:text-neutral-muted leading-relaxed">যেকোনো প্রয়োজনে আমাদের কাস্টমার কেয়ার সর্বদা প্রস্তুত।</p>
            </div>
        </div>
    </section>

    <!-- 7. TESTIMONIALS SECTION -->
    <section class="container p-8 md:p-12 mb-16 bg-[#EBF3EF] dark:bg-neutral-800/40 border border-neutral-border/20 dark:border-neutral-800 rounded-lg shadow-soft transition-smooth">
        <h2 class="section-title dark:text-white"><?php esc_html_e( 'ক্রেতাদের মতামত', 'shulov-park' ); ?></h2>
        <div class="testimonials-grid grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="testimonial-card relative p-8 bg-white dark:bg-neutral-900 border border-neutral-border dark:border-neutral-800 rounded shadow-soft">
                <div class="testimonial-stars text-accent-light text-xs mb-3">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="testimonial-text text-sm italic text-neutral-dark dark:text-neutral-muted leading-relaxed mb-6">"শুলভ পার্কের পণ্য এবং ডেলিভারি সার্ভিস অসাধারণ! তাজা সবজি ও খাঁটি ঘি আমি নিয়মিত অর্ডার করি। কোয়ালিটি নিয়ে কোনো কমপ্লেন নেই।"</p>
                <div class="testimonial-user flex items-center gap-3">
                    <div class="testimonial-avatar w-10 h-10 rounded-full bg-primary/10 text-primary dark:bg-primary-light/10 dark:text-primary-light flex items-center justify-center font-bold text-sm">ত</div>
                    <div class="testimonial-name font-semibold text-neutral-dark dark:text-white text-sm">তানভীর রহমান, ঢাকা</div>
                </div>
            </div>
            <div class="testimonial-card relative p-8 bg-white dark:bg-neutral-900 border border-neutral-border dark:border-neutral-800 rounded shadow-soft">
                <div class="testimonial-stars text-accent-light text-xs mb-3">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="testimonial-text text-sm italic text-neutral-dark dark:text-neutral-muted leading-relaxed mb-6">"করোনার পর থেকেই অনলাইন গ্রোসারি ব্যবহার করছি, তবে এদের রেট বাজারের সাধারণ খুচরা মূল্যের চেয়ে অনেক শুলভ। প্যাকজিং খুবই ভালো ছিল।"</p>
                <div class="testimonial-user flex items-center gap-3">
                    <div class="testimonial-avatar w-10 h-10 rounded-full bg-primary/10 text-primary dark:bg-primary-light/10 dark:text-primary-light flex items-center justify-center font-bold text-sm">ন</div>
                    <div class="testimonial-name font-semibold text-neutral-dark dark:text-white text-sm">নুসরাত সুলতানা, উত্তরা</div>
                </div>
            </div>
            <div class="testimonial-card relative p-8 bg-white dark:bg-neutral-900 border border-neutral-border dark:border-neutral-800 rounded shadow-soft">
                <div class="testimonial-stars text-accent-light text-xs mb-3">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                </div>
                <p class="testimonial-text text-sm italic text-neutral-dark dark:text-neutral-muted leading-relaxed mb-6">"বিকাশ দিয়ে পে করার সাথে সাথে কনফার্মেশন মেসেজ পাই এবং ৪ ঘণ্টার মধ্যে ডেলিভারি সম্পন্ন হয়। আইটেম মিসিং ছিল না।"</p>
                <div class="testimonial-user flex items-center gap-3">
                    <div class="testimonial-avatar w-10 h-10 rounded-full bg-primary/10 text-primary dark:bg-primary-light/10 dark:text-primary-light flex items-center justify-center font-bold text-sm">ম</div>
                    <div class="testimonial-name font-semibold text-neutral-dark dark:text-white text-sm">মাহমুদ হাসান, ধানমন্ডি</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. MOBILE APP PROMOTION SECTION -->
    <section class="container mb-12">
        <div class="app-promotion-box p-8 md:p-12 bg-gradient-to-r from-[#1E3A1E] to-primary dark:from-neutral-900 dark:to-neutral-800 border dark:border-neutral-800 rounded-lg flex justify-between items-center flex-wrap gap-10 shadow-soft transition-smooth">
            <div class="app-promo-content flex-1 min-w-[300px]">
                <h2 class="app-promo-title text-accent-light dark:text-primary-light font-bold text-3xl mb-4"><?php echo esc_html( $app_title ); ?></h2>
                <p class="app-promo-desc text-white/90 dark:text-neutral-muted text-sm md:text-base leading-relaxed mb-6 max-w-[500px]"><?php echo esc_html( $app_desc ); ?></p>
                <div class="app-buttons flex flex-wrap gap-4">
                    <a href="<?php echo esc_url( $playstore ); ?>" target="_blank" class="app-btn bg-black text-white hover:text-accent-light dark:hover:text-primary-light py-2.5 px-5 rounded border border-solid border-[#333] inline-flex items-center gap-3 text-xs md:text-sm font-semibold shadow transition-smooth">
                        <i class="fa-brands fa-google-play text-xl"></i>
                        <div class="text-left">
                            <small class="block text-[8px] opacity-70 uppercase leading-none mb-0.5">GET IT ON</small>
                            Google Play
                        </div>
                    </a>
                    <a href="<?php echo esc_url( $appstore ); ?>" target="_blank" class="app-btn bg-black text-white hover:text-accent-light dark:hover:text-primary-light py-2.5 px-5 rounded border border-solid border-[#333] inline-flex items-center gap-3 text-xs md:text-sm font-semibold shadow transition-smooth">
                        <i class="fa-brands fa-apple text-xl"></i>
                        <div class="text-left">
                            <small class="block text-[8px] opacity-70 uppercase leading-none mb-0.5">Download on the</small>
                            App Store
                        </div>
                    </a>
                </div>
            </div>
            <div class="app-promo-image flex-1 min-w-[280px] flex justify-center">
                <i class="fa-solid fa-mobile-screen-button text-[180px] text-accent-light/10 dark:text-primary-light/10 animate-bounce transition-smooth"></i>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
