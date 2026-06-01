<?php
/**
 * Shulov Park Theme Functions & Setup Definitions
 *
 * @package Shulov_Park
 */

if ( ! defined( 'SHULOV_PARK_VERSION' ) ) {
    define( 'SHULOV_PARK_VERSION', '2.1.0' );
}

/**
 * 1. THEME BASIC SETUP
 */
if ( ! function_exists( 'shulov_park_setup' ) ) :
function shulov_park_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Enable custom logo support
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 220,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // Register Nav Menus
    register_nav_menus(
        array(
            'primary' => esc_html__( 'Primary Menu', 'shulov-park' ),
            'footer'  => esc_html__( 'Footer Menu', 'shulov-park' ),
        )
    );

    // Add support for core custom backgrounds, HTML5 markup, selective refresh.
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'
    ) );

    // Declare WooCommerce support and options
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 320,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 1,
            'default_columns' => 4,
            'min_columns'     => 1,
            'max_columns'     => 6,
        ),
    ) );
    
    // Add default product gallery zoom, lightbox and slider supports
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
endif;
add_action( 'after_setup_theme', 'shulov_park_setup' );

/**
 * 2. ENQUEUE STYLES & SCRIPTS
 */
if ( ! function_exists( 'shulov_park_scripts' ) ) :
function shulov_park_scripts() {
    // Google Fonts (Poppins for English, Hind Siliguri for Bangla)
    wp_enqueue_style( 'shulov-park-fonts', 'https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap', array(), null );
    
    // FontAwesome Icons
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );
    
    // Swiper CSS (For premium hero slides and testimonials)
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', array(), '10.0.0' );

    // Theme Main Stylesheet
    wp_enqueue_style( 'shulov-park-style', get_stylesheet_uri(), array(), SHULOV_PARK_VERSION );

    // Swiper Javascript
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '10.0.0', true );
    
    // Custom Theme Script
    wp_enqueue_script( 'shulov-park-script', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), SHULOV_PARK_VERSION, true );
    
    // Inline script to initialize Swiper slider
    $swiper_init = "
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swiper !== 'undefined') {
                var heroSwiper = new Swiper('.hero-slider', {
                    loop: true,
                    speed: 800,
                    autoplay: {
                        delay: 6000,
                        disableOnInteraction: false,
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
            }
        });
    ";
    wp_add_inline_script( 'swiper-js', $swiper_init );
}
endif;
add_action( 'wp_enqueue_scripts', 'shulov_park_scripts' );

/**
 * 3. WOOCOMMERCE LAYOUT COMPATIBILITY
 */
// Remove default WooCommerce structural wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Inject premium custom theme structural wrappers
if ( ! function_exists( 'shulov_park_wrapper_start' ) ) :
function shulov_park_wrapper_start() {
    echo '<div class="container section-padding"><main id="main" class="site-main">';
}
endif;
add_action( 'woocommerce_before_main_content', 'shulov_park_wrapper_start', 10 );

if ( ! function_exists( 'shulov_park_wrapper_end' ) ) :
function shulov_park_wrapper_end() {
    echo '</main></div>';
}
endif;
add_action( 'woocommerce_after_main_content', 'shulov_park_wrapper_end', 10 );

/**
 * 4. DYNAMIC AJAX MINI-CART UPDATE
 * Automatically updates cart item counts in the header via AJAX.
 */
if ( ! function_exists( 'shulov_park_cart_count_fragments' ) ) :
function shulov_park_cart_count_fragments( $fragments ) {
    ob_start();
    ?>
    <span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
    <?php
    $fragments['span.cart-count'] = ob_get_clean();
    return $fragments;
}
endif;
add_filter( 'woocommerce_add_to_cart_fragments', 'shulov_park_cart_count_fragments' );

/**
 * 5. RETRIEVE YITH WISHLIST ITEM COUNT
 */
if ( ! function_exists( 'shulov_park_get_wishlist_count' ) ) :
function shulov_park_get_wishlist_count() {
    if ( function_exists( 'yith_wcwl_count_products' ) ) {
        return yith_wcwl_count_products();
    }
    return 0;
}
endif;

/**
 * 6. CUSTOM STYLING OVERRIDES FOR THEME UTILITIES
 */
// Set default currency symbol to Bangladesh Taka (৳)
add_filter( 'woocommerce_currency_symbol', 'shulov_park_bdt_currency_symbol', 10, 2 );
function shulov_park_bdt_currency_symbol( $currency_symbol, $currency ) {
    if ( $currency === 'BDT' ) {
        return '৳';
    }
    return $currency_symbol;
}

/**
 * 7. THEME CUSTOMIZER CONFIGURATIONS
 */
require get_template_directory() . '/inc/customizer.php';
