<?php
/**
 * Automated SEO JSON-LD Schema Markup Generator
 * Dynamically registers Schema structures for Organization, WebSite, and WooCommerce Products.
 *
 * @package Shulov_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$schema = array();

// 1. ORGANIZATION & WEBSITE SCHEMA (Printed on Front Page)
if ( is_front_page() || is_home() ) {
    $org_name = shulov_get_setting( 'shulov_seo_org_name', get_bloginfo( 'name' ) );
    $org_logo = shulov_get_setting( 'shulov_seo_org_logo' );
    $phone    = shulov_get_setting( 'shulov_park_phone', '+880 1234 567 890' );
    $email    = shulov_get_setting( 'shulov_park_email', 'support@shulovpark.com' );
    $address  = shulov_get_setting( 'shulov_park_address', 'Shulov Park, Dhaka, Bangladesh' );
    
    // Default logo fallback
    if ( empty( $org_logo ) && has_custom_logo() ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo_data = wp_get_attachment_image_src( $custom_logo_id, 'full' );
        $org_logo = $logo_data ? $logo_data[0] : '';
    }

    $schema[] = array(
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        '@id'      => esc_url( home_url( '/#organization' ) ),
        'name'     => esc_html( $org_name ),
        'url'      => esc_url( home_url( '/' ) ),
        'logo'     => esc_url( $org_logo ),
        'contactPoint' => array(
            '@type'            => 'ContactPoint',
            'telephone'        => esc_html( $phone ),
            'contactType'      => 'customer service',
            'email'            => sanitize_email( $email ),
            'availableLanguage' => array( 'Bengali', 'English' )
        ),
        'address' => array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => esc_html( $address ),
            'addressLocality' => 'Dhaka',
            'addressCountry'  => 'BD'
        )
    );

    $schema[] = array(
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        '@id'      => esc_url( home_url( '/#website' ) ),
        'name'     => esc_html( get_bloginfo( 'name' ) ),
        'url'      => esc_url( home_url( '/' ) ),
        'description' => esc_html( get_bloginfo( 'description' ) ),
        'potentialAction' => array(
            '@type'       => 'SearchAction',
            'target'      => esc_url( home_url( '/?s={search_term_string}&post_type=product' ) ),
            'query-input' => 'required name=search_term_string'
        )
    );
}

// 2. PRODUCT SCHEMA (Printed on Single WooCommerce Product Pages)
if ( is_product() && class_exists( 'WooCommerce' ) ) {
    $product_object = wc_get_product( get_the_ID() );
    if ( is_a( $product_object, 'WC_Product' ) ) {
        $product_id   = $product_object->get_id();
        $title        = $product_object->get_name();
        $short_desc   = $product_object->get_short_description();
        $sku          = $product_object->get_sku();
        $image_id     = $product_object->get_image_id();
        $image_url    = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : wc_placeholder_img_src();
        $price        = $product_object->get_price();
        $currency     = get_woocommerce_currency();
        $stock_status = $product_object->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';
        
        $product_schema = array(
            '@context'    => 'https://schema.org',
            '@type'       => 'Product',
            '@id'         => esc_url( get_permalink( $product_id ) . '#product' ),
            'name'        => esc_html( $title ),
            'image'       => esc_url( $image_url ),
            'description' => esc_html( ! empty( $short_desc ) ? strip_tags( $short_desc ) : $title ),
            'offers' => array(
                '@type'         => 'Offer',
                'price'         => esc_attr( $price ),
                'priceCurrency' => esc_attr( $currency ),
                'availability'  => esc_url( $stock_status ),
                'url'           => esc_url( get_permalink( $product_id ) ),
                'priceValidUntil' => date( 'Y-m-d', strtotime( '+1 year' ) ),
                'valueAddedTaxIncluded' => 'true'
            )
        );

        if ( ! empty( $sku ) ) {
            $product_schema['sku'] = esc_html( $sku );
        }

        // Add rating if available
        $rating = $product_object->get_average_rating();
        $count  = $product_object->get_rating_count();
        if ( $rating > 0 && $count > 0 ) {
            $product_schema['aggregateRating'] = array(
                '@type'       => 'AggregateRating',
                'ratingValue' => esc_attr( $rating ),
                'reviewCount' => esc_attr( $count ),
                'bestRating'  => '5',
                'worstRating' => '1'
            );
        }

        $schema[] = $product_schema;
    }
}

// 3. PRINT MARKUP IF SET
if ( ! empty( $schema ) ) {
    echo "\n<!-- Automated Rich Schema markup by Antigravity Theme Architect -->\n";
    echo '<script type="application/ld+json">' . json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . "</script>\n";
}
