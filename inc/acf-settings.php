<?php
/**
 * Advanced Custom Fields (ACF) & Native Theme Settings Engine
 * Integrates programmatic ACF fields alongside a beautiful native Admin Settings Page as a seamless fallback.
 *
 * @package Shulov_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Universal setting getter helper.
 * Resolves settings from ACF (if active), native Options API, or Customizer (theme mods) with standard defaults.
 */
function shulov_get_setting( $setting_key, $default_value = '' ) {
    // 1. Try to fetch from ACF first if plugin is active
    if ( function_exists( 'get_field' ) ) {
        // ACF option pages usually save options with the 'option' identifier
        $acf_val = get_field( $setting_key, 'option' );
        if ( ! empty( $acf_val ) ) {
            return $acf_val;
        }
    }

    // 2. Try fetching from the native Options API (saved by our Admin Settings Panel)
    $opt_val = get_option( $setting_key );
    if ( $opt_val !== false && $opt_val !== '' ) {
        return $opt_val;
    }

    // 3. Fallback to standard Customizer Theme Mod (used by original code)
    return get_theme_mod( $setting_key, $default_value );
}

/**
 * 1. ACF PROGRAMMATIC FIELDS REGISTRATION
 * Registers fields programmatically for homepage configurations and custom product badges.
 */
function shulov_park_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return; // Skip if ACF is not active
    }

    // Register ACF fields for Products (e.g. custom product badge)
    acf_add_local_field_group( array(
        'key' => 'group_shulov_product_meta',
        'title' => __( 'Product Premium Details', 'shulov-park' ),
        'fields' => array(
            array(
                'key' => 'field_shulov_custom_badge',
                'label' => __( 'Custom Badge text', 'shulov-park' ),
                'name' => 'shulov_custom_badge',
                'type' => 'text',
                'instructions' => __( 'Specify custom badge text to show over product cards (e.g. তাজা সংগ্রহ, ৫% ছাড়)', 'shulov-park' ),
                'required' => 0,
                'placeholder' => __( 'তাজা সংগ্রহ', 'shulov-park' ),
            ),
            array(
                'key' => 'field_shulov_is_featured_banner',
                'label' => __( 'Show in Premium Grid Highlight', 'shulov-park' ),
                'name' => 'shulov_is_featured_banner',
                'type' => 'true_false',
                'instructions' => __( 'Check this to highlight this product with a gold border inside archives', 'shulov-park' ),
                'default_value' => 0,
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ) );
}
add_action( 'acf/init', 'shulov_park_register_acf_fields' );


/**
 * 2. NATIVE ADMIN THEME SETTINGS PAGE (Settings API)
 * Sets up a beautiful custom dashboard under Settings > Shulov Park Settings
 */
function shulov_park_add_settings_menu() {
    add_options_page(
        __( 'Shulov Park Settings', 'shulov-park' ),
        __( 'Shulov Park Theme', 'shulov-park' ),
        'manage_options',
        'shulov-park-settings',
        'shulov_park_render_settings_page'
    );
}
add_action( 'admin_menu', 'shulov_park_add_settings_menu' );

/**
 * Register settings, sections, and fields
 */
function shulov_park_register_theme_settings() {
    // 1. Section: Contact & Brand Info
    add_settings_section(
        'shulov_contact_section',
        __( 'Contact Info & Social Media Links', 'shulov-park' ),
        '__return_empty_string',
        'shulov-park-settings'
    );

    $contact_fields = array(
        'shulov_park_phone'     => __( 'Support Phone Number', 'shulov-park' ),
        'shulov_park_email'     => __( 'Support Email Address', 'shulov-park' ),
        'shulov_park_address'   => __( 'Store Physical Address', 'shulov-park' ),
        'shulov_park_facebook'  => __( 'Facebook Page URL', 'shulov-park' ),
        'shulov_park_instagram' => __( 'Instagram Profile URL', 'shulov-park' ),
        'shulov_park_youtube'   => __( 'YouTube Channel URL', 'shulov-park' ),
    );

    foreach ( $contact_fields as $key => $label ) {
        register_setting( 'shulov_settings_group', $key, array( 'sanitize_callback' => 'sanitize_text_field' ) );
        add_settings_field(
            $key,
            $label,
            'shulov_render_text_field',
            'shulov-park-settings',
            'shulov_contact_section',
            array( 'label_for' => $key )
        );
    }

    // 2. Section: Operating Hours
    add_settings_section(
        'shulov_hours_section',
        __( 'Store Operating Hours', 'shulov-park' ),
        '__return_empty_string',
        'shulov-park-settings'
    );

    $hours_fields = array(
        'shulov_park_hours_weekdays' => __( 'Weekdays Hours (Bangla)', 'shulov-park' ),
        'shulov_park_hours_friday'   => __( 'Friday Hours (Bangla)', 'shulov-park' ),
        'shulov_park_delivery_time'  => __( 'Delivery Info Text (Bangla)', 'shulov-park' ),
    );

    foreach ( $hours_fields as $key => $label ) {
        register_setting( 'shulov_settings_group', $key, array( 'sanitize_callback' => 'sanitize_text_field' ) );
        add_settings_field(
            $key,
            $label,
            'shulov_render_text_field',
            'shulov-park-settings',
            'shulov_hours_section',
            array( 'label_for' => $key )
        );
    }

    // 3. Section: Flash Sale Countdown Settings
    add_settings_section(
        'shulov_flash_section',
        __( 'Flash Sale Settings', 'shulov-park' ),
        '__return_empty_string',
        'shulov-park-settings'
    );

    register_setting( 'shulov_settings_group', 'shulov_park_flash_active', array( 'sanitize_callback' => 'wp_validate_boolean' ) );
    add_settings_field(
        'shulov_park_flash_active',
        __( 'Enable Flash Sale Section', 'shulov-park' ),
        'shulov_render_checkbox_field',
        'shulov-park-settings',
        'shulov_flash_section',
        array( 'label_for' => 'shulov_park_flash_active' )
    );

    register_setting( 'shulov_settings_group', 'shulov_park_flash_title', array( 'sanitize_callback' => 'sanitize_text_field' ) );
    add_settings_field(
        'shulov_park_flash_title',
        __( 'Flash Sale Title', 'shulov-park' ),
        'shulov_render_text_field',
        'shulov-park-settings',
        'shulov_flash_section',
        array( 'label_for' => 'shulov_park_flash_title' )
    );

    register_setting( 'shulov_settings_group', 'shulov_park_flash_date', array( 'sanitize_callback' => 'sanitize_text_field' ) );
    add_settings_field(
        'shulov_park_flash_date',
        __( 'Flash Sale Target Date & Time (YYYY-MM-DDTHH:MM:SS)', 'shulov-park' ),
        'shulov_render_text_field',
        'shulov-park-settings',
        'shulov_flash_section',
        array( 'label_for' => 'shulov_park_flash_date' )
    );

    // 4. Section: Premium Custom SEO Details
    add_settings_section(
        'shulov_seo_section',
        __( 'Theme SEO Schema Config', 'shulov-park' ),
        '__return_empty_string',
        'shulov-park-settings'
    );

    register_setting( 'shulov_settings_group', 'shulov_seo_org_name', array( 'sanitize_callback' => 'sanitize_text_field' ) );
    add_settings_field(
        'shulov_seo_org_name',
        __( 'Organization Name for JSON-LD', 'shulov-park' ),
        'shulov_render_text_field',
        'shulov-park-settings',
        'shulov_seo_section',
        array( 'label_for' => 'shulov_seo_org_name' )
    );

    register_setting( 'shulov_settings_group', 'shulov_seo_org_logo', array( 'sanitize_callback' => 'esc_url_raw' ) );
    add_settings_field(
        'shulov_seo_org_logo',
        __( 'Organization Logo URL (Fallback)', 'shulov-park' ),
        'shulov_render_text_field',
        'shulov-park-settings',
        'shulov_seo_section',
        array( 'label_for' => 'shulov_seo_org_logo' )
    );
}
add_action( 'admin_init', 'shulov_park_register_theme_settings' );

/**
 * Text field renderer
 */
function shulov_render_text_field( $args ) {
    $option_id = $args['label_for'];
    $val = get_option( $option_id, get_theme_mod( $option_id ) );
    
    // Add default fallbacks for original properties
    if ( $val === false ) {
        $fallbacks = array(
            'shulov_park_phone'          => '+880 1234 567 890',
            'shulov_park_email'          => 'support@shulovpark.com',
            'shulov_park_address'        => 'Shulov Park, Dhaka, Bangladesh',
            'shulov_park_facebook'       => '#',
            'shulov_park_instagram'      => '#',
            'shulov_park_youtube'        => '#',
            'shulov_park_hours_weekdays' => 'শনিবার - বৃহস্পতিবার: সকাল ৮:০০ - রাত ১০:০০',
            'shulov_park_hours_friday'   => 'শুক্রবার: দুপুর ৩:০০ - রাত ১০:০০',
            'shulov_park_delivery_time'  => '২৪/৭ হোম ডেলিভারি সুবিধা',
            'shulov_park_flash_title'    => 'ফ্ল্যাশ সেল!',
            'shulov_park_flash_date'     => date( 'Y-m-d\T23:59:59', strtotime( '+5 days' ) ),
            'shulov_seo_org_name'        => get_bloginfo( 'name' ),
        );
        $val = isset( $fallbacks[ $option_id ] ) ? $fallbacks[ $option_id ] : '';
    }

    echo sprintf( '<input type="text" id="%1$s" name="%1$s" value="%2$s" class="regular-text" />', esc_attr( $option_id ), esc_attr( $val ) );
}

/**
 * Checkbox field renderer
 */
function shulov_render_checkbox_field( $args ) {
    $option_id = $args['label_for'];
    $val = get_option( $option_id, get_theme_mod( $option_id, true ) );
    
    echo sprintf( '<input type="checkbox" id="%1$s" name="%1$s" value="1" %2$s />', esc_attr( $option_id ), checked( 1, $val, false ) );
}

/**
 * Render Settings Page markup
 */
function shulov_park_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Add gorgeous notice feedback on settings saves
    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'shulov_messages', 'shulov_message', __( 'Settings Saved Successfully', 'shulov-park' ), 'updated' );
    }
    
    settings_errors( 'shulov_messages' );
    ?>
    <div class="wrap" style="background:#fff; padding:30px 40px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.05); max-width:850px; margin-top:20px;">
        <h1 style="color:#0F6B35; font-weight:700; font-size:28px; margin-bottom:10px; display:flex; align-items:center; gap:10px;">
            <span style="background:#0F6B35; color:#fff; width:42px; height:42px; display:inline-flex; align-items:center; justify-content:center; border-radius:10px; font-size:22px;">S</span>
            <?php echo esc_html( get_admin_page_title() ); ?>
        </h1>
        <p style="color:#64748B; font-size:14px; margin-bottom:30px; border-bottom:1px solid #F1F5F9; padding-bottom:15px;">
            Upgrade Settings, operating hours, counting deadlines, and SEO profiles for the luxury <strong>Shulov Park Storefront</strong> theme.
        </p>

        <form action="options.php" method="post">
            <?php
            settings_fields( 'shulov_settings_group' );
            do_settings_sections( 'shulov-park-settings' );
            submit_button( __( 'সংরক্ষণ করুন', 'shulov-park' ), 'primary', 'submit', true, array( 'style' => 'background:#0F6B35; border-color:#0F6B35; font-size:14px; padding:6px 24px; border-radius:6px; box-shadow:0 4px 10px rgba(15,107,53,0.15);' ) );
            ?>
        </form>
    </div>
    <?php
}
