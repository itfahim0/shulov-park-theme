<?php
/**
 * Reusable Product Card Template Part
 * Renders a gorgeous, responsive product card with lazy loading, wishlist hooks, and quick view hooks.
 *
 * @package Shulov_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;

if ( ! $product ) {
    return;
}

$product_id   = $product->get_id();
$title        = $product->get_name();
$permalink    = $product->get_permalink();
$image        = wp_get_attachment_image_src( $product->get_image_id(), 'medium' );
$img_src      = $image ? $image[0] : wc_placeholder_img_src();
$price_html   = $product->get_price_html();
$rating       = $product->get_average_rating();
$rating_count = $product->get_rating_count();

// ACF Custom Fields integration
$custom_badge = shulov_get_setting( 'shulov_custom_badge', '', $product_id );
$is_featured  = (bool) shulov_get_setting( 'shulov_is_featured_banner', false, $product_id );

// Custom Wishlist Check
$in_wishlist = shulov_park_is_product_in_wishlist( $product_id );
?>

<div class="product-card-item group relative flex flex-col justify-between p-4 bg-white dark:bg-neutral-900 border <?php echo $is_featured ? 'border-accent border-2 shadow-hover' : 'border-neutral-border dark:border-neutral-800'; ?> rounded-md shadow-soft hover:shadow-hover hover:-translate-y-2 transition-smooth lazy-load">
    
    <!-- Top Actions / Badges Row -->
    <div class="absolute top-3 left-3 right-3 z-10 flex justify-between items-start pointer-events-none">
        <div class="flex flex-col gap-1 pointer-events-auto">
            <!-- WooCommerce Native Sale Badge -->
            <?php if ( $product->is_on_sale() ) : ?>
                <span class="bg-accent text-white text-xs font-bold px-2.5 py-1 rounded shadow-md">
                    <?php esc_html_e( 'ছাড়!', 'shulov-park' ); ?>
                </span>
            <?php endif; ?>

            <!-- Programmatic ACF Custom Badge -->
            <?php if ( ! empty( $custom_badge ) ) : ?>
                <span class="bg-primary text-white text-xs font-semibold px-2.5 py-1 rounded shadow-md">
                    <?php echo esc_html( $custom_badge ); ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- Wishlist toggle hook -->
        <button class="wishlist-toggle-trigger pointer-events-auto w-8 h-8 rounded-full bg-white dark:bg-neutral-800 shadow-soft hover:bg-neutral-light dark:hover:bg-neutral-700 flex items-center justify-center text-neutral-dark dark:text-white transition-smooth" data-product-id="<?php echo esc_attr( $product_id ); ?>" title="<?php echo $in_wishlist ? esc_attr__( 'উইশলিস্ট থেকে বাদ দিন', 'shulov-park' ) : esc_attr__( 'উইশলিস্টে রাখুন', 'shulov-park' ); ?>">
            <i class="<?php echo $in_wishlist ? 'fa-solid fa-heart text-red-500' : 'fa-regular fa-heart'; ?>"></i>
        </button>
    </div>

    <!-- Product Image (Link) with elegant observer-based lazy loading -->
    <a href="<?php echo esc_url( $permalink ); ?>" class="block overflow-hidden rounded-sm mb-4 aspect-square flex items-center justify-center bg-neutral-light dark:bg-neutral-800">
        <img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" data-src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="object-contain w-auto h-36 md:h-40 group-hover:scale-105 transition-smooth" />
    </a>

    <!-- Meta details -->
    <div class="flex-1 flex flex-col justify-between">
        <div>
            <!-- Category Tag -->
            <span class="text-xs font-medium text-primary dark:text-primary-light mb-1 block">
                <?php
                $categories = wc_get_product_category_list( $product_id, ', ', '', '' );
                echo wp_kses_post( $categories ? strip_tags( $categories ) : __( 'গ্রোসারি', 'shulov-park' ) );
                ?>
            </span>

            <!-- Title -->
            <h3 class="text-sm md:text-base font-semibold text-neutral-dark dark:text-white line-clamp-2 mb-2 group-hover:text-primary dark:group-hover:text-primary-light transition-smooth min-h-[40px] leading-tight">
                <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
            </h3>

            <!-- Rating Stars -->
            <div class="flex items-center gap-1 mb-3">
                <div class="flex text-accent text-xs">
                    <?php
                    for ( $i = 1; $i <= 5; $i ++ ) {
                        if ( $i <= $rating ) {
                            echo '<i class="fa-solid fa-star"></i>';
                        } elseif ( $i - 0.5 <= $rating ) {
                            echo '<i class="fa-solid fa-star-half-stroke"></i>';
                        } else {
                            echo '<i class="fa-regular fa-star"></i>';
                        }
                    }
                    ?>
                </div>
                <?php if ( $rating_count > 0 ) : ?>
                    <span class="text-xs text-neutral-muted dark:text-neutral-muted">(<?php echo esc_html( $rating_count ); ?>)</span>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <!-- Price Block -->
            <div class="text-primary dark:text-primary-light font-bold text-base md:text-lg mb-4 flex items-center justify-center gap-1 border-t border-dashed border-neutral-border dark:border-neutral-800 pt-3">
                <?php echo wp_kses_post( $price_html ); ?>
            </div>

            <!-- Action buttons grid -->
            <div class="grid grid-cols-5 gap-2">
                <!-- AJAX Quick View Toggle Button -->
                <button class="quick-view-trigger col-span-1 rounded bg-neutral-light dark:bg-neutral-800 hover:bg-primary dark:hover:bg-primary hover:text-white text-neutral-dark dark:text-white flex items-center justify-center transition-smooth" data-product-id="<?php echo esc_attr( $product_id ); ?>" title="<?php esc_attr_e( 'ঝটপট দেখুন', 'shulov-park' ); ?>">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </button>

                <!-- Standard WooCommerce Add to Cart button (Tailwind styled) -->
                <div class="col-span-4 add-to-cart-container">
                    <?php
                    woocommerce_template_loop_add_to_cart( array(
                        'class' => implode( ' ', array_filter( array(
                            'button',
                            'product_type_' . $product->get_type(),
                            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                            $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                            'w-full flex items-center justify-center gap-2 py-2 px-3 bg-primary hover:bg-primary-hover text-white text-xs md:text-sm font-semibold rounded shadow-soft hover:shadow-hover hover:scale-[1.02] transition-smooth border-none'
                        ) ) )
                    ) );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
