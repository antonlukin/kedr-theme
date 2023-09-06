<?php
/**
 * News manager
 * Manage news category
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_News {
    /**
     * Unique slug using for news category url
     *
     * @access  public
     * @var     string
     */
    public static $slug = 'news';

    /**
     * Init function instead of constructor
     */
    public static function load_module() {
        add_filter( 'archive_template', array( __CLASS__, 'include_archive' ) );
        add_filter( 'single_template', array( __CLASS__, 'include_single' ) );
        add_action( 'pre_get_posts', array( __CLASS__, 'remove_from_archives' ) );
    }

    /**
     * Include custom archive template for news
     */
    public static function include_archive( $template ) {
        if ( ! is_feed() && is_category( self::$slug ) ) {
            $new_template = locate_template( array( 'templates/archive-news.php' ) );

            if ( ! empty( $new_template ) ) {
                return $new_template;
            }
        }

        return $template;
    }

    /**
     * Include custom single template for news
     */
    public static function include_single( $template ) {
        if ( ! is_feed() && in_category( self::$slug ) ) {
            $new_template = locate_template( array( 'templates/single-news.php' ) );

            if ( ! empty( $new_template ) ) {
                return $new_template;
            }
        }

        return $template;
    }

    /**
     * Remove news from authors and tag archives
     */
    public static function remove_from_archives( $query ) {
        if ( ! $query->is_main_query() ) {
            return;
        }

        if ( $query->is_author() || $query->is_tag() ) {
            $query->tax_query->queries[] = array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => self::$slug,
                'operator' => 'NOT IN',
            );

            $query->query_vars['tax_query'] = $query->tax_query->queries; // phpcs:ignore
        }
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_News::load_module();
