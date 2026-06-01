<?php
/**
 * Shulov Park - WooCommerce Layout Template Wrapper
 *
 * This file handles all standard WooCommerce page structures (e.g. Shop, Category archives, Single product view)
 * by enclosing WooCommerce content in our premium custom styled theme container grids.
 *
 * @package Shulov_Park
 */

get_header();
?>

<div class="container section-padding">
    <main id="primary" class="site-main woocommerce-main-wrapper">
        <?php 
        if ( have_posts() ) {
            woocommerce_content(); 
        } else {
            echo '<p>' . esc_html__( 'কোনো পণ্য পাওয়া যায়নি।', 'shulov-park' ) . '</p>';
        }
        ?>
    </main>
</div>

<?php
get_footer();
