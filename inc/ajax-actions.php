<?php
/**
 * Shulov Park Theme AJAX Actions Engine
 * Implements secure, nonce-verified WooCommerce AJAX interactions for Cart, Wishlist, and Quick View.
 *
 * @package Shulov_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * 1. PRODUCT QUICK VIEW AJAX CALLBACK
 * Securely outputs product details and add-to-cart form templates dynamically.
 */
function shulov_park_quick_view_callback() {
    // Nonce verification for security hardening
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'shulov_park_secure_action_nonce' ) ) {
        wp_send_json_error( array( 'message' => __( 'Security verification failed.', 'shulov-park' ) ) );
    }

    $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    if ( ! $product_id ) {
        wp_send_json_error( array( 'message' => __( 'Invalid product ID.', 'shulov-park' ) ) );
    }

    // Set the global post reference to this product
    global $post, $product;
    $post = get_post( $product_id );
    $product = wc_get_product( $product_id );

    if ( ! $product ) {
        wp_send_json_error( array( 'message' => __( 'Product not found.', 'shulov-park' ) ) );
    }

    setup_postdata( $post );

    ob_start();
    // Render Quick View layout using the quick view template part
    get_template_part( 'template-parts/product/quick-view-modal' );
    $html = ob_get_clean();

    wp_reset_postdata();

    wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_shulov_park_quick_view', 'shulov_park_quick_view_callback' );
add_action( 'wp_ajax_nopriv_shulov_park_quick_view', 'shulov_park_quick_view_callback' );


/**
 * 2. REFRESH CART DRAWER CONTENTS CALLBACK
 * Securely returns rendered cart item listings.
 */
function shulov_park_cart_drawer_update_callback() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'shulov_park_secure_action_nonce' ) ) {
        wp_send_json_error( array( 'message' => __( 'Security verification failed.', 'shulov-park' ) ) );
    }

    ob_start();
    get_template_part( 'template-parts/common/mini-cart-drawer' );
    $html = ob_get_clean();

    wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_shulov_park_cart_drawer_update', 'shulov_park_cart_drawer_update_callback' );
add_action( 'wp_ajax_nopriv_shulov_park_cart_drawer_update', 'shulov_park_cart_drawer_update_callback' );


/**
 * 3. UPDATE ITEM QUANTITY IN CART DRAWER
 */
function shulov_park_cart_drawer_update_quantity_callback() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'shulov_park_secure_action_nonce' ) ) {
        wp_send_json_error( array( 'message' => __( 'Security verification failed.', 'shulov-park' ) ) );
    }

    $cart_key = sanitize_text_field( $_POST['cart_key'] );
    $quantity = absint( $_POST['quantity'] );

    if ( ! empty( $cart_key ) && $quantity > 0 ) {
        WC()->cart->set_quantity( $cart_key, $quantity );
        
        // Regenerate standard WooCommerce fragments so header totals refresh
        $fragments = WC_AJAX::get_refreshed_fragments();
        wp_send_json_success( array(
            'fragments' => $fragments,
            'cart_hash' => WC()->cart->get_cart_hash()
        ) );
    }

    wp_send_json_error();
}
add_action( 'wp_ajax_shulov_park_cart_drawer_update_quantity', 'shulov_park_cart_drawer_update_quantity_callback' );
add_action( 'wp_ajax_nopriv_shulov_park_cart_drawer_update_quantity', 'shulov_park_cart_drawer_update_quantity_callback' );


/**
 * 4. REMOVE ITEM FROM CART DRAWER
 */
function shulov_park_cart_drawer_remove_item_callback() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'shulov_park_secure_action_nonce' ) ) {
        wp_send_json_error( array( 'message' => __( 'Security verification failed.', 'shulov-park' ) ) );
    }

    $cart_key = sanitize_text_field( $_POST['cart_key'] );

    if ( ! empty( $cart_key ) ) {
        WC()->cart->remove_cart_item( $cart_key );
        
        $fragments = WC_AJAX::get_refreshed_fragments();
        wp_send_json_success( array(
            'fragments' => $fragments,
            'cart_hash' => WC()->cart->get_cart_hash()
        ) );
    }

    wp_send_json_error();
}
add_action( 'wp_ajax_shulov_park_cart_drawer_remove_item', 'shulov_park_cart_drawer_remove_item_callback' );
add_action( 'wp_ajax_nopriv_shulov_park_cart_drawer_remove_item', 'shulov_park_cart_drawer_remove_item_callback' );


/**
 * 5. SECURE WISHLIST TOGGLE CALLBACK (COOKIE DRIVEN)
 * Dynamic plugin-free wishlist handler
 */
function shulov_park_wishlist_toggle_callback() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'shulov_park_secure_action_nonce' ) ) {
        wp_send_json_error( array( 'message' => __( 'Security verification failed.', 'shulov-park' ) ) );
    }

    $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    if ( ! $product_id ) {
        wp_send_json_error();
    }

    // Get current wishlist items from cookies
    $wishlist = array();
    if ( ! empty( $_COOKIE['shulov_wishlist'] ) ) {
        $wishlist = json_decode( stripslashes( $_COOKIE['shulov_wishlist'] ), true );
    }
    if ( ! is_array( $wishlist ) ) {
        $wishlist = array();
    }

    $in_wishlist = false;
    
    // Toggle operations
    if ( in_array( $product_id, $wishlist ) ) {
        $wishlist = array_diff( $wishlist, array( $product_id ) );
        $in_wishlist = false;
    } else {
        $wishlist[] = $product_id;
        $in_wishlist = true;
    }

    // Re-index array values and encode
    $wishlist = array_values( $wishlist );
    setcookie( 'shulov_wishlist', json_encode( $wishlist ), time() + ( 30 * 24 * 60 * 60 ), '/' );

    wp_send_json_success( array(
        'in_wishlist' => $in_wishlist,
        'count'       => count( $wishlist )
    ) );
}
add_action( 'wp_ajax_shulov_park_wishlist_toggle', 'shulov_park_wishlist_toggle_callback' );
add_action( 'wp_ajax_nopriv_shulov_park_wishlist_toggle', 'shulov_park_wishlist_toggle_callback' );


/**
 * Cookie-based wishlist count checker
 */
function shulov_park_get_custom_wishlist_count() {
    if ( ! empty( $_COOKIE['shulov_wishlist'] ) ) {
        $wishlist = json_decode( stripslashes( $_COOKIE['shulov_wishlist'] ), true );
        if ( is_array( $wishlist ) ) {
            return count( $wishlist );
        }
    }
    return 0;
}

/**
 * Check if a product ID is in the custom wishlist cookie
 */
function shulov_park_is_product_in_wishlist( $product_id ) {
    if ( ! empty( $_COOKIE['shulov_wishlist'] ) ) {
        $wishlist = json_decode( stripslashes( $_COOKIE['shulov_wishlist'] ), true );
        if ( is_array( $wishlist ) && in_array( $product_id, $wishlist ) ) {
            return true;
        }
    }
    return false;
}
