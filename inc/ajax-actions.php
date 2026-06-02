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

/**
 * 6. CUSTOM ORDER TRACKING AJAX CALLBACK
 * Securely retrieves details of orders matching Order ID or Mobile Number for logged-in users.
 */
function shulov_park_order_track_callback() {
    // Nonce verification
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'shulov_park_secure_action_nonce' ) ) {
        wp_send_json_error( array( 'message' => __( 'সিকিউরিটি ভেরিফিকেশন ব্যর্থ হয়েছে। অনুগ্রহ করে পেজটি রিফ্রেশ করুন।', 'shulov-park' ) ) );
    }

    // Require authentication
    if ( ! is_user_logged_in() ) {
        wp_send_json_error( array( 'message' => __( 'আপনার অর্ডার ট্র্যাক করতে অনুগ্রহ করে প্রথমে লগইন করুন।', 'shulov-park' ) ) );
    }

    $query = isset( $_POST['query'] ) ? sanitize_text_field( $_POST['query'] ) : '';
    if ( empty( $query ) ) {
        wp_send_json_error( array( 'message' => __( 'অনুগ্রহ করে একটি সঠিক অর্ডার আইডি অথবা মোবাইল নম্বর প্রদান করুন।', 'shulov-park' ) ) );
    }

    $current_user_id = get_current_user_id();
    
    // Find matching orders
    $matching_orders = array();

    // Check if query could be a direct Order ID
    if ( is_numeric( $query ) ) {
        $order_id = absint( $query );
        $order = wc_get_order( $order_id );
        if ( $order && $order->get_customer_id() === $current_user_id ) {
            $matching_orders[] = $order;
        }
    }

    // If no order found directly, search user's orders by phone or ID
    if ( empty( $matching_orders ) ) {
        $user_orders = wc_get_orders( array(
            'customer' => $current_user_id,
            'limit'    => -1,
        ) );

        // Helper to normalize phone numbers (compare last 10 digits)
        $normalize_phone = function( $phone ) {
            $digits = preg_replace( '/\D/', '', $phone );
            return strlen( $digits ) >= 10 ? substr( $digits, -10 ) : $digits;
        };

        $normalized_query_phone = $normalize_phone( $query );

        foreach ( $user_orders as $order ) {
            $order_id_str = (string) $order->get_id();
            $billing_phone = $normalize_phone( $order->get_billing_phone() );
            $shipping_phone = $normalize_phone( $order->get_shipping_phone() );

            if ( $order_id_str === $query || 
                 ( ! empty( $normalized_query_phone ) && ( $billing_phone === $normalized_query_phone || $shipping_phone === $normalized_query_phone ) ) ) {
                $matching_orders[] = $order;
            }
        }
    }

    if ( empty( $matching_orders ) ) {
        wp_send_json_error( array( 'message' => __( 'দুঃখিত, এই আইডি বা মোবাইল নম্বর দিয়ে কোনো অর্ডার পাওয়া যায়নি অথবা অর্ডারটি আপনার অ্যাকাউন্টের সাথে যুক্ত নয়।', 'shulov-park' ) ) );
    }

    // Map order statuses to Bangla translations
    $status_translations = array(
        'pending'    => 'পেমেন্টের জন্য অপেক্ষমাণ (Pending payment)',
        'processing' => 'প্রক্রিয়াধীন (Processing)',
        'on-hold'    => 'হোল্ডে রাখা হয়েছে (On hold)',
        'completed'  => 'সম্পন্ন হয়েছে (Completed)',
        'cancelled'  => 'বাতিল করা হয়েছে (Cancelled)',
        'refunded'   => 'রিফান্ড করা হয়েছে (Refunded)',
        'failed'     => 'ব্যর্থ হয়েছে (Failed)',
        'checkout-draft' => 'ড্রাফট (Draft)',
    );

    ob_start();
    ?>
    <div class="space-y-6">
        <?php foreach ( $matching_orders as $order ) : 
            $status = $order->get_status();
            $status_lbl = isset( $status_translations[ $status ] ) ? $status_translations[ $status ] : $status;
            
            // Setup status badge styling class
            $badge_class = 'bg-neutral-light text-neutral-dark dark:bg-neutral-800 dark:text-neutral-350';
            if ( $status === 'completed' ) {
                $badge_class = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300';
            } elseif ( in_array( $status, array( 'processing', 'on-hold' ) ) ) {
                $badge_class = 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300';
            } elseif ( $status === 'pending' ) {
                $badge_class = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300';
            } elseif ( in_array( $status, array( 'cancelled', 'failed' ) ) ) {
                $badge_class = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300';
            }
            ?>
            <div class="p-4 border border-solid border-neutral-border dark:border-neutral-800 rounded bg-neutral-light/30 dark:bg-neutral-900/50">
                <div class="flex justify-between items-center flex-wrap gap-2 border-b border-solid border-neutral-border dark:border-neutral-800 pb-3 mb-3">
                    <div>
                        <h4 class="text-sm md:text-base font-bold text-neutral-dark dark:text-white">
                            <?php printf( esc_html__( 'অর্ডার আইডি: #%s', 'shulov-park' ), esc_html( $order->get_id() ) ); ?>
                        </h4>
                        <span class="text-xs text-neutral-muted">
                            <?php echo esc_html( $order->get_date_created()->date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) ); ?>
                        </span>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded font-semibold <?php echo esc_attr( $badge_class ); ?>">
                        <?php echo esc_html( $status_lbl ); ?>
                    </span>
                </div>

                <!-- Products Purchased -->
                <div class="mb-4">
                    <h5 class="text-xs font-bold text-neutral-dark dark:text-white mb-2"><?php esc_html_e( 'ক্রয়কৃত পণ্যসমূহ:', 'shulov-park' ); ?></h5>
                    <ul class="space-y-1 pl-4 list-disc text-xs text-neutral-muted">
                        <?php foreach ( $order->get_items() as $item_id => $item ) : ?>
                            <li>
                                <strong class="text-neutral-dark dark:text-white"><?php echo esc_html( $item->get_name() ); ?></strong> 
                                x <?php echo esc_html( $item->get_quantity() ); ?> 
                                (<strong class="text-primary dark:text-primary-light"><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></strong>)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Total and Shipping -->
                <div class="text-xs border-t border-dashed border-neutral-border dark:border-neutral-800 pt-3 flex justify-between items-center">
                    <div>
                        <span class="text-neutral-muted block">পেমেন্ট মাধ্যম: <?php echo esc_html( $order->get_payment_method_title() ); ?></span>
                        <span class="text-neutral-muted block">শিপিং ঠিকানা: <?php echo esc_html( $order->get_shipping_address_1() ); ?></span>
                    </div>
                    <div class="text-right">
                        <span class="text-neutral-muted block"><?php esc_html_e( 'সর্বমোট:', 'shulov-park' ); ?></span>
                        <strong class="text-sm md:text-base text-primary dark:text-primary-light font-bold">
                            <?php echo wp_kses_post( $order->get_formatted_order_total() ); ?>
                        </strong>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    $html = ob_get_clean();
    wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_shulov_park_order_track', 'shulov_park_order_track_callback' );

