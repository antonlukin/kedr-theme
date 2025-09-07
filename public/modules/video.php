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

        add_action( 'pre_get_posts', array( __CLASS__, 'exclude_from_public_queries' ) );
        add_filter( 'rest_post_query', array( __CLASS__, 'exclude_from_rest' ), 10, 2 );
    }

    /**
     * Get cached term id for the video category
     */
    private static function get_video_term_id() {
        if ( ! is_null( self::$term_id_cache ) ) {
            return self::$term_id_cache;
        }

        $term = get_category_by_slug( self::$slug );

        self::$term_id_cache = $term ? (int) $term->term_id : 0;

        return self::$term_id_cache;
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

        if ( is_feed() && is_category( self::$slug ) ) {
            global $wp_query;

            $wp_query->set_404();
            status_header( 404 );
            nocache_headers();
        }
    }

    /**
     * Exclude video posts from main public queries (home, archives, search, feeds) for guests
     */
    public static function exclude_from_public_queries( $query ) {
        if ( is_admin() || ! $query->is_main_query() || is_user_logged_in() ) {
            return;
        }

        if ( $query->is_home() || $query->is_archive() || $query->is_search() || $query->is_feed() ) {
            $term_id = self::get_video_term_id();

            if ( $term_id ) {
                $not_in   = (array) $query->get( 'category__not_in', array() );
                $not_in[] = (int) $term_id;
                $not_in   = array_values( array_unique( array_map( 'intval', $not_in ) ) );
                $query->set( 'category__not_in', $not_in );
            }
        }
    }

    /**
     * Exclude video posts from REST API collections for guests
     */
    public static function exclude_from_rest( $args ) {
        if ( is_user_logged_in() ) {
            return $args;
        }

        $term_id = self::get_video_term_id();

        if ( $term_id ) {
            $args['category__not_in'] = isset( $args['category__not_in'] ) ? (array) $args['category__not_in'] : array();

            $args['category__not_in'][] = (int) $term_id;

            $args['category__not_in'] = array_values( array_unique( array_map( 'intval', $args['category__not_in'] ) ) );
        }

        return $args;
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
