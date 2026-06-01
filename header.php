<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <!-- Main Top Header -->
    <div class="container">
        <div class="header-main">
            
            <!-- Left Logo -->
            <div class="site-logo">
                <?php 
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
                    echo '<h1 class="site-title" style="color:var(--primary); font-size:26px;">' . get_bloginfo( 'name' ) . '</h1>';
                    echo '</a>';
                }
                ?>
            </div>

            <!-- Central Product Search -->
            <div class="header-search">
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" id="woocommerce-product-search-field-header" class="search-field" placeholder="<?php echo esc_attr__( 'প্রয়োজনীয় পণ্যটি খুঁজুন...', 'shulov-park' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
                        <button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <input type="hidden" name="post_type" value="product" />
                    </form>
                <?php else : ?>
                    <?php get_search_form(); ?>
                <?php endif; ?>
            </div>

            <!-- Right Action Links -->
            <div class="header-icons">
                <!-- User Account Links -->
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="header-icon" title="<?php esc_attr_e('আমার অ্যাকাউন্ট','shulov-park'); ?>">
                        <i class="fa-regular fa-user"></i>
                        <span>অ্যাকাউন্ট</span>
                    </a>
                <?php endif; ?>

                <!-- Wishlist (YITH WooCommerce Wishlist integration) -->
                <a href="<?php echo esc_url( has_nav_menu('primary') ? '#' : '#' ); // Can assign dynamically if needed ?>" class="header-icon wishlist-contents" title="<?php esc_attr_e('ইচ্ছা তালিকা','shulov-park'); ?>">
                    <i class="fa-regular fa-heart"></i>
                    <span>উইশলিস্ট</span>
                    <span class="wishlist-count"><?php echo esc_html( shulov_park_get_wishlist_count() ); ?></span>
                </a>

                <!-- Shopping Basket (WooCommerce Cart integration) -->
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-icon cart-contents" title="<?php esc_attr_e('শপিং ব্যাগ','shulov-park'); ?>">
                        <i class="fa-solid fa-basket-shopping"></i>
                        <span>কার্ট</span>
                        <span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                    </a>
                <?php endif; ?>
                
                <!-- Mobile Burger Trigger -->
                <div class="mobile-nav-toggle">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Bottom Navigation Bar -->
    <div class="header-nav-bottom">
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
                    // Fallback gorgeous nav list
                    echo '<ul id="primary-menu" class="menu">';
                    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">হোম</a></li>';
                    if ( class_exists( 'WooCommerce' ) ) {
                        echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">শপ</a></li>';
                        echo '<li><a href="' . esc_url( get_post_type_archive_link( 'product' ) ) . '?product_cat=grocery">গ্রোসারি</a></li>';
                        echo '<li><a href="' . esc_url( get_post_type_archive_link( 'product' ) ) . '?product_cat=vegetables">তাজা সবজি</a></li>';
                        echo '<li><a href="' . esc_url( get_post_type_archive_link( 'product' ) ) . '?product_cat=dairy">দুগ্ধজাত পণ্য</a></li>';
                    }
                    echo '<li><a href="' . esc_url( home_url( '/contact' ) ) . '">যোগাযোগ</a></li>';
                    echo '</ul>';
                }
                ?>
            </nav>
        </div>
    </div>
</header>
