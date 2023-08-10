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

class Kedr_Modules_Global {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_filter( 'get_the_archive_title', array( __CLASS__, 'update_archive_title' ) );
        add_filter( 'body_class', array( __CLASS__, 'update_body_classes' ) );
        add_filter( 'post_class', array( __CLASS__, 'update_post_classes' ), 10, 2 );
        add_action( 'sanitize_file_name', array( __CLASS__, 'sanitize_file_name' ), 12 );
        add_action( 'next_posts_link_attributes', array( __CLASS__, 'update_next_posts_link' ) );
        add_action( 'get_header', array( __CLASS__, 'remove_adminbar_styles' ) );
        add_filter( 'feed_links_show_comments_feed', '__return_false' );
        add_filter( 'posts_search', array( __CLASS__, 'hide_empty_search' ), 10, 2 );

        add_action( 'admin_init', array( __CLASS__, 'hide_dashboard_widgets' ) );

        // Remove auto suggestions
        add_filter( 'do_redirect_guess_404_permalink', '__return_false' );

        // Remove emojis handlers
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

        // Remove wp_head default actions
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'adjacent_posts_rel_link' );
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
        remove_action( 'wp_head', 'wp_resource_hints', 2 );
        remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
        remove_action( 'wp_head', 'wp_site_icon', 99 );
    }

    /**
     * Hide useless dashboard widgets
     */
    public static function hide_dashboard_widgets() {
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
    }

    /**
     * Halt the main query in the case of an empty search
     */
    public static function hide_empty_search( $search, $query ) {
        if ( is_admin() ) {
            return $search;
        }

        if ( empty( $search ) && $query->is_search() && $query->is_main_query() ) {
            return $search . ' AND 0=1 ';
        }

        return $search;
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

        if ( ! have_posts() ) {
            $classes[] = 'is-empty';
        }

        return $classes;
    }

    /**
     * Remove admin-bar styles
     */
    public static function remove_adminbar_styles() {
        remove_action( 'wp_head', '_admin_bar_bump_cb' );
    }

    /**
     * Set custom post classes using only post format
     */
    public static function update_post_classes( $classes, $name ) {
        $type = get_post_type();

        if ( $type !== 'post' ) {
            $name[] = 'post--' . $type;
        }

        if ( has_post_format() ) {
            $name[] = 'post--' . get_post_format();
        }

        if ( has_post_thumbnail() ) {
            $name[] = 'post--thumbnail';
        }

        return $name;
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
Kedr_Modules_Global::load_module();
