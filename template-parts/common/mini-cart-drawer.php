<?php
/**
 * Slide-out AJAX Mini Cart Drawer Template Part
 * Renders the shopping cart items list, quantity editors, and subtotal options.
 *
 * @package Shulov_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'WooCommerce' ) ) {
    return;
}

$cart = WC()->cart;
$cart_items = $cart->get_cart();
?>

<div class="flex flex-col h-full justify-between">
    
    <!-- Cart Items Scrollable Container -->
    <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
        <?php if ( empty( $cart_items ) ) : ?>
            <!-- EMPTY CART STATE -->
            <div class="flex flex-col items-center justify-center h-64 text-center">
                <i class="fa-solid fa-basket-shopping text-6xl text-neutral-muted dark:text-neutral-700 mb-4 animate-pulse"></i>
                <h3 class="text-lg font-bold text-neutral-dark dark:text-white mb-2">
                    <?php esc_html_e( 'আপনার শপিং ব্যাগটি খালি!', 'shulov-park' ); ?>
                </h3>
                <p class="text-xs text-neutral-muted dark:text-neutral-muted max-w-[200px] mb-6">
                    <?php esc_html_e( 'আজকের তাজা গ্রোসারি ও ডেইলি অফারগুলো দেখতে আমাদের শপ ব্রাউজ করুন।', 'shulov-park' ); ?>
                </p>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-primary py-2 px-6 rounded text-sm font-semibold transition-smooth border-none">
                    <?php esc_html_e( 'কেনাকাটা শুরু করুন', 'shulov-park' ); ?>
                </a>
            </div>
        <?php else : ?>
            
            <!-- LIST OF CART ITEMS -->
            <?php
            foreach ( $cart_items as $cart_item_key => $cart_item ) :
                $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                    $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                    $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'thumbnail' ), $cart_item, $cart_item_key );
                    $product_price     = $cart->get_product_price( $_product );
                    $product_subtotal  = $cart->get_product_subtotal( $_product, $cart_item['quantity'] );
                    ?>
                    
                    <div class="cart-drawer-item flex gap-4 p-3 bg-neutral-light dark:bg-neutral-800 rounded border border-neutral-border dark:border-neutral-800 hover:border-primary-light transition-smooth relative">
                        <!-- Product Thumbnail -->
                        <div class="w-16 h-16 flex-shrink-0 bg-white dark:bg-neutral-900 rounded overflow-hidden flex items-center justify-center p-1 border border-neutral-border dark:border-neutral-800">
                            <?php echo wp_kses_post( $thumbnail ); ?>
                        </div>

                        <!-- Product info specs -->
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="text-xs md:text-sm font-semibold text-neutral-dark dark:text-white line-clamp-1 leading-snug pr-4">
                                    <a href="<?php echo esc_url( $product_permalink ); ?>" class="hover:text-primary transition-smooth">
                                        <?php echo esc_html( $product_name ); ?>
                                    </a>
                                </h4>
                                <span class="text-xs text-neutral-muted dark:text-neutral-muted block mt-0.5">
                                    <?php echo wp_kses_post( $product_price ); ?>
                                </span>
                            </div>

                            <!-- Qty adjuster row -->
                            <div class="flex items-center justify-between mt-2">
                                <div class="flex items-center border border-neutral-border dark:border-neutral-700 rounded bg-white dark:bg-neutral-900 overflow-hidden">
                                    <button class="drawer-qty-minus w-6 h-6 flex items-center justify-center text-xs text-neutral-muted hover:bg-neutral-light dark:hover:bg-neutral-800 transition-smooth" type="button">-</button>
                                    <input class="drawer-qty-input w-8 h-6 text-center text-xs border-none outline-none font-semibold text-neutral-dark dark:text-white bg-transparent" type="number" value="<?php echo esc_attr( $cart_item['quantity'] ); ?>" data-cart-key="<?php echo esc_attr( $cart_item_key ); ?>" readonly />
                                    <button class="drawer-qty-plus w-6 h-6 flex items-center justify-center text-xs text-neutral-muted hover:bg-neutral-light dark:hover:bg-neutral-800 transition-smooth" type="button">+</button>
                                </div>
                                
                                <span class="text-xs md:text-sm font-bold text-primary dark:text-primary-light">
                                    <?php echo wp_kses_post( $product_subtotal ); ?>
                                </span>
                            </div>
                        </div>

                        <!-- Quick Delete Button -->
                        <button class="drawer-item-remove absolute top-2 right-2 text-neutral-muted hover:text-danger text-xs p-1 transition-smooth" data-cart-key="<?php echo esc_attr( $cart_item_key ); ?>" title="<?php esc_attr_e( 'আইটেম বাদ দিন', 'shulov-park' ); ?>">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>

                    <?php
                endif;
            endforeach;
            ?>
        <?php endif; ?>
    </div>

    <!-- Cart Footer Section (Totals and Actions) -->
    <?php if ( ! empty( $cart_items ) ) : ?>
        <div class="p-6 bg-neutral-light dark:bg-neutral-900 border-t border-neutral-border dark:border-neutral-800 space-y-4">
            <!-- Dynamic Subtotal -->
            <div class="flex justify-between items-center text-neutral-dark dark:text-white font-bold">
                <span class="text-sm md:text-base"><?php esc_html_e( 'সর্বমোট (Subtotal):', 'shulov-park' ); ?></span>
                <span class="text-lg md:text-xl text-primary dark:text-primary-light">
                    <?php echo wp_kses_post( $cart->get_cart_subtotal() ); ?>
                </span>
            </div>
            
            <p class="text-[11px] text-neutral-muted dark:text-neutral-muted text-center italic">
                <?php esc_html_e( '* শিপিং চার্জ এবং ট্যাক্স চেকআউটের সময় হিসেব করা হবে।', 'shulov-park' ); ?>
            </p>

            <!-- Buttons Grid -->
            <div class="grid grid-cols-2 gap-3">
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="w-full py-2.5 px-4 text-center rounded bg-transparent hover:bg-neutral-border border-2 border-primary hover:border-primary-hover text-primary font-semibold text-xs md:text-sm transition-smooth">
                    <?php esc_html_e( 'কার্ট দেখুন', 'shulov-park' ); ?>
                </a>
                <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="w-full py-2.5 px-4 text-center rounded bg-primary hover:bg-primary-hover text-white font-semibold text-xs md:text-sm shadow-soft hover:shadow-hover hover:scale-[1.02] border-none transition-smooth">
                    <?php esc_html_e( 'চেকআউট করুন', 'shulov-park' ); ?>
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>
