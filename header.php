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

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'shulov-park' ); ?></a>

	<header id="masthead" class="site-header">
		<!-- Top Row: Logo, Search, Icons -->
		<div class="header-top">
			<div class="container header-top-inner">
				<div class="site-branding">
					<?php
					if ( has_custom_logo() ) :
						the_custom_logo();
					else :
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" style="color: var(--primary-color); font-weight: 700; text-decoration: none;">সু-লভ পার্ক</a></h1>
						<?php
					endif;
					?>
				</div><!-- .site-branding -->

				<div class="header-search">
					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<input type="search" class="search-field" placeholder="<?php echo esc_attr__( 'Search products...', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
							<button type="submit">🔍</button>
							<input type="hidden" name="post_type" value="product" />
						</form>
					<?php else: ?>
						<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<input type="search" class="search-field" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s" />
							<button type="submit">🔍</button>
						</form>
					<?php endif; ?>
				</div><!-- .header-search -->
	            
				<div class="header-actions">
					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="header-icon-link">
							<span class="icon">👤</span>
							<span class="text">Sign In</span>
						</a>
						<a class="header-icon-link cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'shulov-park'); ?>">
							<span class="icon">🛒<span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span></span>
							<span class="text">Cart</span>
						</a>
					<?php endif; ?>
				</div><!-- .header-actions -->
			</div><!-- .container -->
		</div><!-- .header-top -->

		<!-- Bottom Row: Categories Nav -->
		<div class="header-bottom">
			<div class="container">
				<nav id="site-navigation" class="main-navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'fallback_cb'    => false, // Don't fall back to wp_page_menu
						)
					);
					?>
				</nav><!-- #site-navigation -->
			</div>
		</div><!-- .header-bottom -->
	</header><!-- #masthead -->
