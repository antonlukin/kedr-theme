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

class Kedr_News_Filters {
    /**
     * Unique slug using for news category url
     *
     * @access  public
     * @var     string
     */
    public static $news_slug = 'news';

    /**
     * Init function instead of constructor
     */
    public static function load_module() {
        add_filter( 'archive_template', array( __CLASS__, 'include_archive' ) );
        add_action( 'pre_get_posts', array( __CLASS__, 'update_count' ) );
    }

    /**
     * Include custom archive template for news
     */
    public static function include_archive( $template ) {
        if ( ! is_feed() && is_category( self::$news_slug ) ) {
            $new_template = locate_template( array( 'templates/archive-news.php' ) );

            if ( ! empty( $new_template ) ) {
                return $new_template;
            }
        }

        return $template;
    }

    /**
     * Change posts_per_page for news category archive template
     */
    public static function update_count( $query ) {
        if ( $query->is_main_query() && get_query_var( 'category_name' ) === self::$news_slug ) {
            $query->set( 'posts_per_page', 18 );
        }
    }
}


/**
 * Load current module environment
 */
Kedr_News_Filters::load_module();
