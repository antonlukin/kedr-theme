<?php
/**
 * Search filters
 * Update default search behavior
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Search {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_action( 'init', array( __CLASS__, 'add_search_page' ) );
        add_action( 'template_redirect', array( __CLASS__, 'redirect_search_url' ) );

        add_filter( 'document_title_parts', array( __CLASS__, 'update_search_title' ) );
    }

    /**
     * Add page with empty searching form
     */
    public static function add_search_page() {
        add_rewrite_rule(
            '^search/?$',
            'index.php?s=',
            'top'
        );
    }

    /**
     * Redirect search url
     */
    public static function redirect_search_url() {
        if ( is_search() && ! empty( $_GET['s'] ) ) {
            wp_safe_redirect( home_url( '/search/' ) . rawurlencode( get_query_var( 's' ) ) );
            exit;
        }
    }

    public static function update_search_title( $title ) {
        if ( is_search() && empty( get_search_query() ) ) {
            $title['title'] = esc_html__( 'Поиск по сайту', 'kedr-theme' );
        }

        return $title;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Search::load_module();
