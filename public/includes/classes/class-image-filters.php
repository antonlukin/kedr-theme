<?php
/**
 * Image filters
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Image_Filters {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_action( 'after_setup_theme', array( __CLASS__, 'add_image_sizes' ) );
        add_action( 'template_redirect', array( __CLASS__, 'redirect_attachments' ) );
        add_filter( 'max_srcset_image_width', array( __CLASS__, 'set_srcset_width' ) );
        add_filter( 'jpeg_quality', array( __CLASS__, 'improve_jpeg' ) );
    }

    /**
     * Add custom image sizes
     */
    public static function add_image_sizes() {
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 300, 300, true );

        add_image_size( 'card', 800, 9999, false );
        add_image_size( 'wide', 1200, 9999, false );
        add_image_size( 'single', 900, 600, false );
    }

    /**
     * Little bit increase jpeg quality
     */
    public static function improve_jpeg() {
        return 80;
    }

    /**
     * Filters the maximum image width to be included in a 'srcset' attribute
     */
    public static function set_srcset_width( $width ) {
        $width = 1200;

        return $width;
    }

    /**
     * Disable post attachment pages
     */
    public static function redirect_attachments() {
        if ( ! is_attachment() ) {
            return;
        }

        global $wp_query;

        $wp_query->set_404();
        status_header( 404 );
    }
}

/**
 * Load current module environment
 */
Kedr_Image_Filters::load_module();
