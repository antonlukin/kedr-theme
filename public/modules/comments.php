<?php
/**
 * Comments filters
 * Disable comments everywhere
 *
 * @package kedr-theme
 * @since 2.0
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Comments {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_filter( 'wp_headers', array( __CLASS__, 'filter_wp_headers' ) );
        add_action( 'template_redirect', array( __CLASS__, 'filter_query' ), 9 );
        add_action( 'template_redirect', array( __CLASS__, 'filter_admin_bar' ) );
        add_action( 'admin_init', array( __CLASS__, 'filter_admin_bar' ) );
        add_filter( 'rest_endpoints', array( __CLASS__, 'filter_rest_endpoints' ) );
        add_filter( 'xmlrpc_methods', array( __CLASS__, 'disable_xmlrc_comments' ) );
        add_filter( 'rest_pre_insert_comment', array( __CLASS__, 'disable_rest_api_comments' ), 10, 2 );
        add_filter( 'comments_open', '__return_false', 20, 2 );
        add_filter( 'pings_open', '__return_false', 20, 2 );
        add_filter( 'comments_array', '__return_empty_array', 10, 2 );

        add_action( 'admin_menu', array( __CLASS__, 'filter_admin_menu' ) );
        add_filter( 'pre_option_default_pingback_flag', '__return_zero' );
        add_action( 'init', array( __CLASS__, 'remove_post_type_supports' ) );
    }

    /**
     * Remove post type supports
     */
    public static function remove_post_type_supports() {
        foreach ( get_post_types() as $post_type ) {
            if ( post_type_supports( $post_type, 'comments' ) ) {
                remove_post_type_support( $post_type, 'comments' );
                remove_post_type_support( $post_type, 'trackbacks' );
            }
        }
    }

    /**
     * Remove comments menu page
     */
    public static function filter_admin_menu() {
        remove_menu_page( 'edit-comments.php' );
    }

    /**
     * Remove the X-Pingback HTTP header
     */
    public static function filter_wp_headers( $headers ) {
        unset( $headers['X-Pingback'] );
        return $headers;
    }

    /**
     * Issue a 403 for all comment feed requests.
     */
    public static function filter_query() {
        if ( is_comment_feed() ) {
            wp_die( esc_html__( 'Комментарии закрыты', 'kedr-theme' ), '', array( 'response' => 403 ) );
        }
    }

    /**
     * Remove comment links from the admin bar.
     */
    public static function filter_admin_bar() {
        if ( is_admin_bar_showing() ) {
            remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
        }
    }

    /**
     * Remove the comments endpoint for the REST API
     */
    public static function filter_rest_endpoints( $endpoints ) {
        if ( isset( $endpoints['comments'] ) ) {
            unset( $endpoints['comments'] );
        }
        if ( isset( $endpoints['/wp/v2/comments'] ) ) {
            unset( $endpoints['/wp/v2/comments'] );
        }
        if ( isset( $endpoints['/wp/v2/comments/(?P<id>[\d]+)'] ) ) {
            unset( $endpoints['/wp/v2/comments/(?P<id>[\d]+)'] );
        }
        return $endpoints;
    }

    /**
     * remove method wp.newComment
     */
    public static function disable_xmlrc_comments( $methods ) {
        unset( $methods['wp.newComment'] );
        return $methods;
    }

    /**
     * Disable rest API comments
     */
    public static function disable_rest_api_comments() {
        return false;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Comments::load_module();
