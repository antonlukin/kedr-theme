<?php
/**
 * Category video handlers
 *
 * @package kedr-theme
 * @since 2.3
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Video {
    /**
     * Unique slug using for video category
     */
    public static $slug = 'video';

    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_filter( 'category_template', array( __CLASS__, 'include_archive' ) );
        add_action( 'template_redirect', array( __CLASS__, 'check_access' ) );
    }

    /**
     * Check if user has access to video category
     */
    public static function check_access() {
        if ( is_user_logged_in() ) {
            return;
        }

        if ( is_category( self::$slug ) || ( is_single() && has_category( self::$slug ) ) ) {
            global $wp_query;
            $wp_query->set_404();
            status_header( 404 );
            nocache_headers();
        }
    }

    /**
     * Include custom archive template for video posts
     */
    public static function include_archive( $template ) {
        if ( ! is_feed() && is_category( self::$slug ) ) {
            $new_template = locate_template( array( 'templates/category-video.php' ) );

            if ( ! empty( $new_template ) ) {
                return $new_template;
            }
        }

        return $template;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Video::load_module();
