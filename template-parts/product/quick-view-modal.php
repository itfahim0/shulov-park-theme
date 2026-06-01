<?php
/**
 * AJAX Product Quick View Template Part
 * Outputs detailed product specifications and add-to-cart forms inside the quick view modal container.
 *
 * @package Shulov_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product, $post;

if ( ! $product ) {
    return;
}

$product_id        = $product->get_id();
$title             = $product->get_name();
$image_ids         = $product->get_gallery_image_ids();
$primary_image_src = wp_get_attachment_image_src( $product->get_image_id(), 'large' );
$img_url           = $primary_image_src ? $primary_image_src[0] : wc_placeholder_img_src();
$rating            = $product->get_average_rating();
$rating_count      = $product->get_rating_count();
$short_desc        = $product->get_short_description();
$sku               = $product->get_sku();
?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 items-center">
    
    <!-- Left Column: Product Image Gallery -->
    <div class="flex items-center justify-center p-4 bg-neutral-light dark:bg-neutral-800 rounded-md border border-neutral-border dark:border-neutral-800">
        <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="object-contain w-auto max-h-64 md:max-h-80 rounded-sm" />
    </div>

    <!-- Right Column: Product Core Specifications -->
    <div class="flex flex-col justify-between h-full">
        <div>
            <!-- Category Tag -->
            <span class="text-xs font-semibold text-primary dark:text-primary-light uppercase tracking-wider block mb-2">
                <?php
                $categories = wc_get_product_category_list( $product_id, ', ', '', '' );
                echo wp_kses_post( $categories ? strip_tags( $categories ) : __( 'গ্রোসারি', 'shulov-park' ) );
                ?>
            </span>

            <!-- Product Title -->
            <h2 class="text-xl md:text-2xl font-bold text-neutral-dark dark:text-white leading-tight mb-2">
                <?php echo esc_html( $title ); ?>
            </h2>

            <!-- Rating Stars -->
            <div class="flex items-center gap-2 mb-4">
                <div class="flex text-accent text-sm">
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
                    <span class="text-xs text-neutral-muted dark:text-neutral-muted">(<?php echo esc_html( $rating_count ); ?> <?php esc_html_e( 'ক্রেতার রিভিউ', 'shulov-park' ); ?>)</span>
                <?php endif; ?>
            </div>

            <!-- Price -->
            <div class="text-2xl font-bold text-primary dark:text-primary-light mb-4 pb-3 border-b border-neutral-border dark:border-neutral-800">
                <?php echo wp_kses_post( $product->get_price_html() ); ?>
            </div>

            <!-- Description -->
            <div class="text-sm text-neutral-muted dark:text-neutral-muted mb-6 leading-relaxed">
                <?php 
                if ( ! empty( $short_desc ) ) {
                    echo wp_kses_post( $short_desc ); 
                } else {
                    esc_html_e( 'এই পণ্যটির কোনো বিবরণ নেই। এটি একটি অত্যন্ত মানসম্মত এবং খাঁটি পণ্য যা দৈনন্দিন জীবনের সব চাহিদা মেটাবে।', 'shulov-park' );
                }
                ?>
            </div>
        </div>

        <div>
            <!-- Add to Cart Block (Supports both simple and variable options via native hooks) -->
            <div class="quick-view-add-to-cart-form mb-6">
                <?php
                // Force WooCommerce single add to cart form rendering inside AJAX frame
                woocommerce_template_single_add_to_cart();
                ?>
            </div>

            <!-- Meta attributes -->
            <div class="text-xs text-neutral-muted dark:text-neutral-muted flex flex-col gap-1 border-t border-neutral-border dark:border-neutral-800 pt-4">
                <?php if ( ! empty( $sku ) ) : ?>
                    <span><strong><?php esc_html_e( 'পণ্য আইডি (SKU):', 'shulov-park' ); ?></strong> <?php echo esc_html( $sku ); ?></span>
                <?php endif; ?>
                <span><strong><?php esc_html_e( 'স্টক অবস্থা:', 'shulov-park' ); ?></strong> 
                    <?php 
                    if ( $product->is_in_stock() ) {
                        echo '<span class="text-success font-semibold">' . esc_html__( 'স্টকে আছে', 'shulov-park' ) . '</span>';
                    } else {
                        echo '<span class="text-danger font-semibold">' . esc_html__( 'স্টক শেষ', 'shulov-park' ) . '</span>';
                    }
                    ?>
                </span>
            </div>
        </div>

    </div>
</div>
