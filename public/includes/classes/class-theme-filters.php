<?php
/**
 * Theme filters
 * Common snippets for theme modifications
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Theme_Filters {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_filter( 'get_the_archive_title', array( __CLASS__, 'update_archive_title' ) );
        add_filter( 'body_class', array( __CLASS__, 'update_body_classes' ) );
        add_action( 'sanitize_file_name', array( __CLASS__, 'sanitize_file_name' ), 12 );
        add_action( 'next_posts_link_attributes', array( __CLASS__, 'update_next_posts_link' ) );

        // Remove auto suggestions
        add_filter( 'do_redirect_guess_404_permalink', '__return_false' );
    }

    /**
     * Update annoying body classes
     *
     * @link https://github.com/WordPress/WordPress/blob/81500e50eff289e2f5601135707c22c03625a192/wp-includes/post-template.php#L590
     */
    public static function update_body_classes() {
        $classes = array();

        if ( is_single() ) {
            $classes[] = 'is-single';
        }

        if ( is_archive() ) {
            $classes[] = 'is-archive';
        }

        if ( is_admin_bar_showing() ) {
            $classes[] = 'is-adminbar';
        }

        if ( is_front_page() ) {
            $classes[] = 'is-front';
        }

        if ( is_singular( 'page' ) && ! is_front_page() ) {
            $classes[] = 'is-page';
        }

        if ( is_singular( 'post' ) ) {
            $classes[] = 'is-post';
        }

        return $classes;
    }

    /**
     * Fix non-latin file name chars
     * Process right after https://github.com/antonlukin/rus-package
     */
    public static function sanitize_file_name( $name ) {
        return preg_replace( '#[^a-z0-9.-_]#i', '-', $name );
    }

    /**
     * Custom archive title
     */
    public static function update_archive_title() {
        if ( is_category() ) {
            return sprintf(
                '<h1 class="caption__title caption__title--category">%s</h1>',
                single_term_title( '', false )
            );
        }

        if ( is_author() ) {
            return sprintf(
                '<h1 class="caption__title caption__title--author">%s</h1>',
                get_the_author()
            );
        }

        if ( is_post_type_archive() ) {
            return sprintf(
                '<h1 class="caption__title">%s</h1>',
                post_type_archive_title( '', false )
            );
        }

        if ( is_tag() || is_tax() ) {
            return sprintf(
                '<h1 class="caption__title">%s</h1>',
                single_term_title( '', false )
            );
        }

        return sprintf( '<h1 class="caption__title">%s</h1>', $title );
    }

    /**
     * Filters the anchor tag attributes for the next posts page link.
     */
    public static function update_next_posts_link() {
        return 'class="naviate__button button"';
    }
}

/**
 * Load current module environment
 */
Kedr_Theme_Filters::load_module();
