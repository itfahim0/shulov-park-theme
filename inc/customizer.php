<?php
/**
 * Shulov Park - Customizer Options Panel Definitions
 *
 * @package Shulov_Park
 */

if ( ! function_exists( 'shulov_park_customize_register' ) ) :
function shulov_park_customize_register( $wp_customize ) {
    
    /**
     * 1. CREATE MAIN PANEL
     */
    $wp_customize->add_panel( 'shulov_park_options', array(
        'title'       => __( 'Shulov Park Options', 'shulov-park' ),
        'description' => __( 'Manage dynamic branding, settings and section values for Shulov Park theme.', 'shulov-park' ),
        'priority'    => 130,
    ) );

    /**
     * 2. CONTACT INFO & SOCIAL MEDIA SECTION
     */
    $wp_customize->add_section( 'shulov_park_contact_section', array(
        'title'    => __( 'Contact Info & Socials', 'shulov-park' ),
        'panel'    => 'shulov_park_options',
        'priority' => 10,
    ) );

    // Store Phone Number
    $wp_customize->add_setting( 'shulov_park_phone', array(
        'default'           => '+880 1234 567 890',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'shulov_park_phone', array(
        'label'    => __( 'Support Phone Number', 'shulov-park' ),
        'section'  => 'shulov_park_contact_section',
        'type'     => 'text',
    ) );

    // Store Support Email
    $wp_customize->add_setting( 'shulov_park_email', array(
        'default'           => 'support@shulovpark.com',
        'sanitize_callback' => 'sanitize_email',
    ) );
    $wp_customize->add_control( 'shulov_park_email', array(
        'label'    => __( 'Support Email Address', 'shulov-park' ),
        'section'  => 'shulov_park_contact_section',
        'type'     => 'email',
    ) );

    // Store Address
    $wp_customize->add_setting( 'shulov_park_address', array(
        'default'           => 'Shulov Park, Dhaka, Bangladesh',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'shulov_park_address', array(
        'label'    => __( 'Store Physical Address', 'shulov-park' ),
        'section'  => 'shulov_park_contact_section',
        'type'     => 'textarea',
    ) );

    // Facebook Link
    $wp_customize->add_setting( 'shulov_park_facebook', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'shulov_park_facebook', array(
        'label'    => __( 'Facebook Page URL', 'shulov-park' ),
        'section'  => 'shulov_park_contact_section',
        'type'     => 'url',
    ) );

    // Instagram Link
    $wp_customize->add_setting( 'shulov_park_instagram', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'shulov_park_instagram', array(
        'label'    => __( 'Instagram Profile URL', 'shulov-park' ),
        'section'  => 'shulov_park_contact_section',
        'type'     => 'url',
    ) );

    // YouTube Link
    $wp_customize->add_setting( 'shulov_park_youtube', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'shulov_park_youtube', array(
        'label'    => __( 'YouTube Channel URL', 'shulov-park' ),
        'section'  => 'shulov_park_contact_section',
        'type'     => 'url',
    ) );

    /**
     * 3. FLASH SALE COUNTDOWN SECTION Settings
     */
    $wp_customize->add_section( 'shulov_park_flash_sale_section', array(
        'title'    => __( 'Flash Sale Section', 'shulov-park' ),
        'panel'    => 'shulov_park_options',
        'priority' => 20,
    ) );

    // Flash Sale Active
    $wp_customize->add_setting( 'shulov_park_flash_active', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'shulov_park_flash_active', array(
        'label'    => __( 'Enable Flash Sale Section', 'shulov-park' ),
        'section'  => 'shulov_park_flash_sale_section',
        'type'     => 'checkbox',
    ) );

    // Flash Sale Title
    $wp_customize->add_setting( 'shulov_park_flash_title', array(
        'default'           => 'ফ্ল্যাশ সেল!',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'shulov_park_flash_title', array(
        'label'    => __( 'Section Title (Bangla)', 'shulov-park' ),
        'section'  => 'shulov_park_flash_sale_section',
        'type'     => 'text',
    ) );

    // Flash Sale Subtitle
    $wp_customize->add_setting( 'shulov_park_flash_subtitle', array(
        'default'           => 'দারুণ সব অফার সীমিত সময়ের জন্য',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'shulov_park_flash_subtitle', array(
        'label'    => __( 'Section Subtitle (Bangla)', 'shulov-park' ),
        'section'  => 'shulov_park_flash_sale_section',
        'type'     => 'text',
    ) );

    // Flash Sale Target Countdown Date
    // Format: YYYY-MM-DDTHH:MM:SS
    $wp_customize->add_setting( 'shulov_park_flash_date', array(
        'default'           => date( 'Y-m-d\T23:59:59', strtotime( '+5 days' ) ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'shulov_park_flash_date', array(
        'label'       => __( 'Deadline Date & Time', 'shulov-park' ),
        'description' => __( 'Format: YYYY-MM-DDTHH:MM:SS (e.g. 2026-06-25T23:59:59)', 'shulov-park' ),
        'section'     => 'shulov_park_flash_sale_section',
        'type'        => 'text',
    ) );

    /**
     * 4. MOBILE APP STORE LINKS SECTION
     */
    $wp_customize->add_section( 'shulov_park_mobile_app_section', array(
        'title'    => __( 'Mobile App Mockup & Links', 'shulov-park' ),
        'panel'    => 'shulov_park_options',
        'priority' => 30,
    ) );

    // App Promo Title
    $wp_customize->add_setting( 'shulov_park_app_title', array(
        'default'           => 'ঘরে বসেই কেনাকাটা করুন',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'shulov_park_app_title', array(
        'label'    => __( 'Promo Title (Bangla)', 'shulov-park' ),
        'section'  => 'shulov_park_mobile_app_section',
        'type'     => 'text',
    ) );

    // App Promo Description
    $wp_customize->add_setting( 'shulov_park_app_desc', array(
        'default'           => 'সহজে, দ্রুত, নিরাপদে আপনার প্রতিদিনের গ্রোসারি ও ডেইলি এসেনশিয়াল আইটেম অর্ডার করতে ডাউনলোড করুন শুলভ পার্ক অ্যাপ।',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'shulov_park_app_desc', array(
        'label'    => __( 'Promo Description (Bangla)', 'shulov-park' ),
        'section'  => 'shulov_park_mobile_app_section',
        'type'     => 'textarea',
    ) );

    // Play Store URL
    $wp_customize->add_setting( 'shulov_park_playstore', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'shulov_park_playstore', array(
        'label'    => __( 'Google Play Store URL', 'shulov-park' ),
        'section'  => 'shulov_park_mobile_app_section',
        'type'     => 'url',
    ) );

    // Apple App Store URL
    $wp_customize->add_setting( 'shulov_park_appstore', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'shulov_park_appstore', array(
        'label'    => __( 'Apple App Store URL', 'shulov-park' ),
        'section'  => 'shulov_park_mobile_app_section',
        'type'     => 'url',
    ) );

    /**
     * 5. STORE OPERATION HOURS SECTION
     */
    $wp_customize->add_section( 'shulov_park_store_hours_section', array(
        'title'    => __( 'Footer Store Operation Hours', 'shulov-park' ),
        'panel'    => 'shulov_park_options',
        'priority' => 40,
    ) );

    // Weekdays Hours
    $wp_customize->add_setting( 'shulov_park_hours_weekdays', array(
        'default'           => 'শনিবার - বৃহস্পতিবার: সকাল ৮:০০ - রাত ১০:০০',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'shulov_park_hours_weekdays', array(
        'label'    => __( 'Weekdays Hours (Bangla)', 'shulov-park' ),
        'section'  => 'shulov_park_store_hours_section',
        'type'     => 'text',
    ) );

    // Friday Hours
    $wp_customize->add_setting( 'shulov_park_hours_friday', array(
        'default'           => 'শুক্রবার: দুপুর ৩:০০ - রাত ১০:০০',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'shulov_park_hours_friday', array(
        'label'    => __( 'Friday Hours (Bangla)', 'shulov-park' ),
        'section'  => 'shulov_park_store_hours_section',
        'type'     => 'text',
    ) );

    // Delivery Hours
    $wp_customize->add_setting( 'shulov_park_delivery_time', array(
        'default'           => '২৪/৭ হোম ডেলিভারি সুবিধা',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'shulov_park_delivery_time', array(
        'label'    => __( 'Delivery Info text (Bangla)', 'shulov-park' ),
        'section'  => 'shulov_park_store_hours_section',
        'type'     => 'text',
    ) );
}
endif;
add_action( 'customize_register', 'shulov_park_customize_register' );
