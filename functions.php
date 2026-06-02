<?php
/**
 * Shulov Park Theme Functions & Setup Definitions
 * Modernized with Vite + Tailwind CSS and performance-optimized eCommerce components.
 *
 * @package Shulov_Park
 */

if ( ! defined( 'SHULOV_PARK_VERSION' ) ) {
    define( 'SHULOV_PARK_VERSION', '2.1.0' );
}

/**
 * 0. LOAD CORE MODERN ARCHITECTURE ENGINES
 */
require get_template_directory() . '/inc/vite-assets.php';
require get_template_directory() . '/inc/acf-settings.php';
require get_template_directory() . '/inc/ajax-actions.php';


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

    // Add theme support for wide alignments (Gutenberg)
    add_theme_support( 'align-wide' );
    
    // Make theme translation ready
    load_theme_textdomain( 'shulov-park', get_template_directory() . '/languages' );
}
endif;
add_action( 'after_setup_theme', 'shulov_park_setup' );


/**
 * 2. ENQUEUE STYLES & SCRIPTS (Refactored)
 */
if ( ! function_exists( 'shulov_park_scripts' ) ) :
function shulov_park_scripts() {
    // Google Fonts (Poppins for English, Hind Siliguri for Bangla)
    wp_enqueue_style( 'shulov-park-fonts', 'https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap', array(), null );
    
    // FontAwesome Icons
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );
    
    // Swiper CSS (For premium hero slides and testimonials)
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', array(), '10.0.0' );

    // NOTE: Duplicate original style.css and theme.js asset enqueues are REMOVED here.
    // They are securely handled dynamically by the Vite Dev Server and Compiled Hashed Assets inside inc/vite-assets.php

    // Swiper Javascript
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '10.0.0', true );
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
    echo '<div class="container py-8"><main id="main" class="site-main">';
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
 * 5. RETRIEVE YITH WISHLIST OR CUSTOM WISHLIST ITEM COUNT
 */
if ( ! function_exists( 'shulov_park_get_wishlist_count' ) ) :
function shulov_park_get_wishlist_count() {
    // 1. Fallback to custom cookie wishlist count if active
    if ( function_exists( 'shulov_park_get_custom_wishlist_count' ) ) {
        $custom_count = shulov_park_get_custom_wishlist_count();
        if ( $custom_count > 0 ) {
            return $custom_count;
        }
    }
    
    // 2. Fallback to YITH WooCommerce Wishlist integration
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


/**
 * 8. ELITE LIGHTHOUSE PERFORMANCE OPTIMIZATIONS
 * Targeting 90+ score on Mobile and Desktop audits.
 */

/**
 * Preconnect to high-traffic DNS origins in HTML head
 */
function shulov_park_preconnect_dns() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" />' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
    echo '<link rel="preconnect" href="https://cdnjs.cloudflare.com" />' . "\n";
    echo '<link rel="preconnect" href="https://cdn.jsdelivr.net" />' . "\n";
}
add_action( 'wp_head', 'shulov_park_preconnect_dns', 2 );

/**
 * Dequeue Gutenberg Block Styles on standard WooCommerce front pages where not utilized
 * Saves roughly 50-80KB of unused render-blocking CSS!
 */
function shulov_park_dequeue_unused_block_styles() {
    if ( is_front_page() || is_shop() || is_product() || is_cart() || is_checkout() ) {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_dequeue_style( 'wc-blocks-style' );
    }
}
add_action( 'wp_enqueue_scripts', 'shulov_park_dequeue_unused_block_styles', 100 );

/**
 * Filter script loading to append defer="defer" to all enqueued non-critical scripts
 * Reduces render-blocking resource blockages significantly!
 */
function shulov_park_defer_scripts( $tag, $handle, $src ) {
    // Avoid deferring core jquery or admin panel scripts
    if ( is_admin() ) {
        return $tag;
    }
    
    $non_critical_handles = array(
        'swiper-js',
        'shulov-park-prod-js',
        'shulov-park-fallback-js'
    );
    
    if ( in_array( $handle, $non_critical_handles, true ) ) {
        return sprintf( "<script defer src=\"%s\" id=\"%s-js\"></script>\n", esc_url( $src ), esc_attr( $handle ) );
    }
    
    return $tag;
}
add_filter( 'script_loader_tag', 'shulov_park_defer_scripts', 10, 3 );

/**
 * 9. DYNAMIC SHIPPING RATES BASED ON DISTRICT (Inside/Outside Dhaka)
 * Checks the selected state/district on checkout and dynamically applies Inside/Outside Dhaka rates.
 */
function shulov_park_dynamic_district_shipping( $rates, $package ) {
    $state = isset( $package['destination']['state'] ) ? $package['destination']['state'] : '';
    
    // Dhaka codes in WooCommerce core: 'BD-13' (Dhaka District) or if it's explicitly 'Dhaka'
    $is_dhaka = ( $state === 'BD-13' || strcasecmp( $state, 'Dhaka' ) === 0 || $state === 'BD-05' );
    
    $found_custom_rate = false;
    foreach ( $rates as $rate_id => $rate ) {
        $label = strtolower( $rate->get_label() );
        
        if ( strpos( $label, 'inside' ) !== false || strpos( $label, 'ঢাকা' ) !== false ) {
            if ( ! $is_dhaka ) {
                unset( $rates[ $rate_id ] );
            } else {
                $found_custom_rate = true;
            }
        } elseif ( strpos( $label, 'outside' ) !== false || strpos( $label, 'ঢাকার বাইরে' ) !== false ) {
            if ( $is_dhaka ) {
                unset( $rates[ $rate_id ] );
            } else {
                $found_custom_rate = true;
            }
        }
    }
    
    // Fallback: If no shipping rates are configured in the admin dashboard,
    // we programmatically add a shipping method to avoid "No shipping options available" error!
    if ( empty( $rates ) || ! $found_custom_rate ) {
        $rates = array();
        
        $shipping_label = $is_dhaka ? __( 'Inside Dhaka (ঢাকার ভেতরে)', 'shulov-park' ) : __( 'Outside Dhaka (ঢাকার বাইরে)', 'shulov-park' );
        $shipping_cost  = $is_dhaka ? 60 : 120;
        
        $rate_id = 'dynamic_flat_rate';
        $custom_rate = new WC_Shipping_Rate(
            $rate_id,
            $shipping_label,
            $shipping_cost,
            array(),
            'flat_rate'
        );
        
        $rates[ $rate_id ] = $custom_rate;
    }
    
    return $rates;
}
add_filter( 'woocommerce_package_rates', 'shulov_park_dynamic_district_shipping', 10, 2 );

/**
 * 10. BUY NOW REDIRECT AND BUTTON HOOKS
 */
add_filter( 'woocommerce_add_to_cart_redirect', 'shulov_park_buy_now_redirect_handler' );
function shulov_park_buy_now_redirect_handler( $url ) {
    if ( isset( $_REQUEST['buy_now'] ) || isset( $_POST['buy_now'] ) ) {
        return wc_get_checkout_url();
    }
    return $url;
}

add_action( 'woocommerce_after_add_to_cart_button', 'shulov_park_add_buy_now_button_single', 10 );
function shulov_park_add_buy_now_button_single() {
    global $product;
    if ( ! $product || ! $product->is_purchasable() || ! $product->is_in_stock() ) {
        return;
    }
    echo '<button type="submit" name="buy_now" value="1" class="button buy-now-button bg-accent hover:bg-accent-hover text-white font-bold py-3 px-6 rounded transition-smooth border-none cursor-pointer flex items-center justify-center gap-2">';
    echo '<i class="fa-solid fa-bolt"></i> ' . esc_html__( 'এখনই কিনুন', 'shulov-park' );
    echo '</button>';
}

