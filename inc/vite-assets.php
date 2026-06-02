<?php
/**
 * Vite + Tailwind Asset Loader Engine
 * Handles development HMR (Hot Module Replacement) and production compilation loading with cache busting.
 *
 * @package Shulov_Park
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Check if the Vite dev server is active and reachable
 * Sets a static variable so we only query once per page request
 */
function shulov_park_is_vite_dev() {
    static $is_dev = null;
    
    if ( $is_dev !== null ) {
        return $is_dev;
    }

    // Allow overriding via constant in wp-config.php or functions.php
    if ( defined( 'SHULOV_PARK_VITE_DEV' ) ) {
        $is_dev = SHULOV_PARK_VITE_DEV;
        return $is_dev;
    }

    // Default: try to connect to Vite server with a short timeout to prevent blocking.
    // Using 127.0.0.1 instead of localhost avoids slow DNS lookup on Windows.
    $url = 'http://127.0.0.1:5173';
    $response = wp_remote_get( $url, array( 'timeout' => 0.2, 'sslverify' => false ) );
    
    if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
        $is_dev = true;
    } else {
        $is_dev = false;
    }

    return $is_dev;
}

/**
 * Enqueue theme assets via Vite or production distribution
 */
function shulov_park_enqueue_vite_assets() {
    $theme_dir = get_template_directory_uri();
    $theme_path = get_template_directory();

    if ( shulov_park_is_vite_dev() ) {
        // --- DEVELOPMENT MODE (Vite Dev Server) ---
        // Enqueue Vite Client (crucial for HMR)
        wp_enqueue_script( 'vite-client', 'http://localhost:5173/@vite/client', array(), null, false );
        
        // Enqueue the entrypoint JS which loads our CSS dynamically in development
        wp_enqueue_script( 'shulov-park-vite', 'http://localhost:5173/assets/src/js/main.js', array( 'jquery', 'swiper-js' ), null, true );
        
        $localize_handle = 'shulov-park-vite';
    } else {
        // --- PRODUCTION MODE (Compiled Dist Assets) ---
        // Locate the Vite manifest file. Vite v5 puts it in assets/dist/.vite/manifest.json by default, 
        // but we look in both assets/dist/manifest.json and assets/dist/.vite/manifest.json to be highly robust.
        $manifest_paths = array(
            $theme_path . '/assets/dist/.vite/manifest.json',
            $theme_path . '/assets/dist/manifest.json'
        );
        
        $manifest = array();
        
        foreach ( $manifest_paths as $path ) {
            if ( file_exists( $path ) ) {
                $manifest_content = file_get_contents( $path );
                if ( $manifest_content ) {
                    $manifest = json_decode( $manifest_content, true );
                    break;
                }
            }
        }
        
        // Fallback checks if manifest exists and registers main.js file
        if ( ! empty( $manifest ) && isset( $manifest['assets/src/js/main.js'] ) ) {
            $main_asset = $manifest['assets/src/js/main.js'];
            
            // Enqueue primary production compiled JS
            $js_file = 'assets/dist/' . $main_asset['file'];
            wp_enqueue_script( 'shulov-park-prod-js', $theme_dir . '/' . $js_file, array( 'jquery', 'swiper-js' ), SHULOV_PARK_VERSION, true );
            
            // Enqueue production compiled CSS (Vite extracts imported CSS into CSS chunk arrays)
            if ( ! empty( $main_asset['css'] ) ) {
                foreach ( $main_asset['css'] as $index => $css_chunk ) {
                    $css_file = 'assets/dist/' . $css_chunk;
                    wp_enqueue_style( 'shulov-park-prod-css-' . $index, $theme_dir . '/' . $css_file, array(), SHULOV_PARK_VERSION );
                }
            }
            
            $localize_handle = 'shulov-park-prod-js';
        } else {
            // Disaster recovery fallback: If Vite is not running and manifest fails, load theme stylesheet if available
            wp_enqueue_style( 'shulov-park-fallback-css', $theme_dir . '/assets/dist/css/main.css', array(), SHULOV_PARK_VERSION );
            wp_enqueue_script( 'shulov-park-fallback-js', $theme_dir . '/assets/dist/js/main.js', array( 'jquery', 'swiper-js' ), SHULOV_PARK_VERSION, true );
            
            $localize_handle = 'shulov-park-fallback-js';
        }
    }

    // Localize Script to securely share Ajax configurations and security nonces with Javascript
    wp_localize_script( 
        $localize_handle, 
        'shulovThemeVars', 
        array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'shulov_park_secure_action_nonce' )
        ) 
    );
}
add_action( 'wp_enqueue_scripts', 'shulov_park_enqueue_vite_assets' );

/**
 * Filter enqueued script tags to add type="module" to script handles loaded via Vite
 * Modern ES6 Module loading is mandatory for Vite assets
 */
function shulov_park_modify_script_tags( $tag, $handle, $src ) {
    $vite_handles = array( 'vite-client', 'shulov-park-vite' );
    
    if ( in_array( $handle, $vite_handles, true ) ) {
        return sprintf( "<script type=\"module\" src=\"%s\" id=\"%s-js\"></script>\n", esc_url( $src ), esc_attr( $handle ) );
    }
    
    return $tag;
}
add_filter( 'script_loader_tag', 'shulov_park_modify_script_tags', 10, 3 );
