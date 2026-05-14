<?php
/**
 * Shulov Park functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme Setup
 */
function shulov_park_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary Menu', 'shulov-park' ),
			'footer' => esc_html__( 'Footer Menu', 'shulov-park' ),
		)
	);

	// WooCommerce support
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 300,
		'gallery_thumbnail_image_width' => 100,
		'single_image_width' => 600,
	) );
	
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'shulov_park_setup' );

/**
 * Enqueue scripts and styles.
 */
function shulov_park_scripts() {
	// Fonts (Inter)
	wp_enqueue_style( 'shulov-park-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null );
	
	// Main Style
	wp_enqueue_style( 'shulov-park-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );

}
add_action( 'wp_enqueue_scripts', 'shulov_park_scripts' );

/**
 * Buy Now Button Customization
 */
function shulov_park_redirect_to_checkout_after_buy_now( $url ) {
	if ( isset( $_REQUEST['buy_now'] ) && $_REQUEST['buy_now'] == '1' ) {
		return wc_get_checkout_url();
	}
	return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'shulov_park_redirect_to_checkout_after_buy_now', 9999 );

function shulov_park_loop_buy_now_button( $html, $product, $args ) {
	if ( $product->is_type( 'simple' ) && $product->is_in_stock() ) {
		$checkout_url = wc_get_checkout_url();
		$buy_now_url = '?add-to-cart=' . $product->get_id() . '&buy_now=1';
		
		// Note: We intentionally DO NOT add the 'ajax_add_to_cart' class so it forces a page reload & redirect.
		$html .= '<a href="' . esc_url( $buy_now_url ) . '" class="button btn-buy-now" style="margin-top:5px;">Buy Now</a>';
	}
	return $html;
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'shulov_park_loop_buy_now_button', 10, 3 );

/**
 * Customizer Options for Footer Payment Details
 */
function shulov_park_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'shulov_park_footer_options', array(
		'title'       => __( 'Footer Options', 'shulov-park' ),
		'priority'    => 130,
	) );

	// Accepted Payments Text
	$wp_customize->add_setting( 'footer_payment_text', array(
		'default'   => 'Accepted Payments:',
		'transport' => 'refresh',
	) );
	$wp_customize->add_control( 'footer_payment_text', array(
		'label'    => __( 'Payment Text', 'shulov-park' ),
		'section'  => 'shulov_park_footer_options',
		'type'     => 'text',
	) );

	// Support Phone
	$wp_customize->add_setting( 'footer_support_phone', array(
		'default'   => '+880 1234-567890',
		'transport' => 'refresh',
	) );
	$wp_customize->add_control( 'footer_support_phone', array(
		'label'    => __( 'Support Phone', 'shulov-park' ),
		'section'  => 'shulov_park_footer_options',
		'type'     => 'text',
	) );
}
add_action( 'customize_register', 'shulov_park_customize_register' );
