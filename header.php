<?php
/**
 * Shulov Park - Theme Header Template
 * Modernized with Vite + Tailwind CSS, Server-Side Dark Mode synchronization, and SEO hooks.
 *
 * @package Shulov_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Retrieve server-side cookie to determine if Dark Mode is active (avoids screen flickering)
$is_dark = isset( $_COOKIE['theme_dark'] ) && $_COOKIE['theme_dark'] === 'yes';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo $is_dark ? 'dark' : ''; ?>">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php 
    // Inject Automated JSON-LD SEO Structured Data
    get_template_part( 'template-parts/common/schema' ); 
    ?>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class( $is_dark ? 'dark' : '' ); ?>>
<?php wp_body_open(); ?>

<header class="site-header transition-smooth dark:bg-neutral-900 dark:border-neutral-800">
    <!-- Main Top Header -->
    <div class="container">
        <div class="header-main py-4">
            
            <!-- Left Logo -->
            <div class="site-logo">
                <?php 
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    $logo_url = get_template_directory_uri() . '/assets/images/logo.png';
                    echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="block">';
                    echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="max-h-16 w-auto object-contain" />';
                    echo '</a>';
                }
                ?>
            </div>

            <!-- Central Product Search -->
            <div class="header-search flex-1 max-w-[580px]">
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <form role="search" method="get" class="woocommerce-product-search flex border-2 border-primary dark:border-primary-light rounded-full overflow-hidden bg-white dark:bg-neutral-800" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" id="woocommerce-product-search-field-header" class="search-field flex-1 py-2.5 px-6 border-none outline-none text-neutral-dark dark:text-white bg-transparent" placeholder="<?php echo esc_attr__( 'প্রয়োজনীয় পণ্যটি খুঁজুন...', 'shulov-park' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
                        <button type="submit" class="bg-primary hover:bg-primary-hover dark:bg-primary-light dark:hover:bg-primary text-white border-none py-2 px-6 transition-smooth cursor-pointer" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <input type="hidden" name="post_type" value="product" />
                    </form>
                <?php else : ?>
                    <?php get_search_form(); ?>
                <?php endif; ?>
            </div>

            <!-- Right Action Links -->
            <div class="header-icons flex items-center gap-6">
                <!-- Dark Mode Toggle Switch -->
                <button id="dark-mode-toggle" class="header-icon bg-transparent border-none cursor-pointer p-1 text-neutral-dark dark:text-white hover:text-primary transition-smooth focus:outline-none" title="<?php esc_attr_e('ডার্ক মোড টগল করুন','shulov-park'); ?>">
                    <?php if ( $is_dark ) : ?>
                        <i class="fa-regular fa-sun text-xl text-yellow-400 animate-spin-slow"></i>
                    <?php else : ?>
                        <i class="fa-regular fa-moon text-xl"></i>
                    <?php endif; ?>
                </button>

                <!-- User Account Links -->
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="header-icon text-neutral-dark dark:text-white hover:text-primary flex flex-col items-center relative text-[11px]" title="<?php esc_attr_e('আমার অ্যাকাউন্ট','shulov-park'); ?>">
                        <i class="fa-regular fa-user text-xl text-primary dark:text-primary-light mb-0.5"></i>
                        <span>অ্যাকাউন্ট</span>
                    </a>
                <?php endif; ?>

                <!-- Wishlist contents linked dynamically -->
                <a href="#" class="header-icon wishlist-contents text-neutral-dark dark:text-white hover:text-primary flex flex-col items-center relative text-[11px]" title="<?php esc_attr_e('ইচ্ছা তালিকা','shulov-park'); ?>">
                    <i class="fa-regular fa-heart text-xl text-primary dark:text-primary-light mb-0.5"></i>
                    <span>উইশলিস্ট</span>
                    <span class="wishlist-count absolute -top-1.5 right-1 bg-accent text-white text-[10px] w-4.5 h-4.5 rounded-full flex items-center justify-center font-bold shadow-sm"><?php echo esc_html( shulov_park_get_wishlist_count() ); ?></span>
                </a>

                <!-- Shopping Basket (WooCommerce Cart Trigger) -->
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-icon cart-contents text-neutral-dark dark:text-white hover:text-primary flex flex-col items-center relative text-[11px]" title="<?php esc_attr_e('শপিং ব্যাগ','shulov-park'); ?>">
                        <i class="fa-solid fa-basket-shopping text-xl text-primary dark:text-primary-light mb-0.5"></i>
                        <span>কার্ট</span>
                        <span class="cart-count absolute -top-1.5 right-1 bg-accent text-white text-[10px] w-4.5 h-4.5 rounded-full flex items-center justify-center font-bold shadow-sm"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                    </a>
                <?php endif; ?>
                
                <!-- Mobile Burger Trigger -->
                <div class="mobile-nav-toggle lg:hidden text-primary dark:text-primary-light text-2xl cursor-pointer">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Bottom Navigation Bar -->
    <div class="header-nav-bottom bg-primary dark:bg-neutral-900 border-t border-neutral-border dark:border-neutral-800 shadow-inner">
        <div class="container">
            <nav class="main-navigation" id="site-navigation">
                <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                            'fallback_cb'    => false,
                        )
                    );
                } else {
                    // Fallback nav list
                    echo '<ul id="primary-menu" class="menu flex gap-8 list-none py-3">';
                    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '" class="text-white hover:text-accent-light dark:hover:text-primary-light font-semibold text-sm transition-smooth">হোম</a></li>';
                    if ( class_exists( 'WooCommerce' ) ) {
                        echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="text-white hover:text-accent-light dark:hover:text-primary-light font-semibold text-sm transition-smooth">শপ</a></li>';
                        echo '<li><a href="' . esc_url( get_post_type_archive_link( 'product' ) ) . '?product_cat=grocery" class="text-white hover:text-accent-light dark:hover:text-primary-light font-semibold text-sm transition-smooth">গ্রোসারি</a></li>';
                        echo '<li><a href="' . esc_url( get_post_type_archive_link( 'product' ) ) . '?product_cat=vegetables" class="text-white hover:text-accent-light dark:hover:text-primary-light font-semibold text-sm transition-smooth">তাজা সবজি</a></li>';
                        echo '<li><a href="' . esc_url( get_post_type_archive_link( 'product' ) ) . '?product_cat=dairy" class="text-white hover:text-accent-light dark:hover:text-primary-light font-semibold text-sm transition-smooth">দুগ্ধজাত পণ্য</a></li>';
                    }
                    echo '<li><a href="' . esc_url( home_url( '/contact' ) ) . '" class="text-white hover:text-accent-light dark:hover:text-primary-light font-semibold text-sm transition-smooth">যোগাযোগ</a></li>';
                    echo '</ul>';
                }
                ?>
            </nav>
        </div>
    </div>
</header>
