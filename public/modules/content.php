<?php
/**
 * Content filters
 * Fix small content problems on post save
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Content {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_filter( 'content_save_pre', array( __CLASS__, 'remove_linked_space' ) );
        add_filter( 'content_save_pre', array( __CLASS__, 'add_links_target' ) );
    }

    /**
     * Remove linked spaces
     */
    public static function remove_linked_space( $content ) {
        $content = preg_replace( '~(<a[^>]+>)(\s+)(.*?</a>)~is', '$2$1$3', wp_unslash( $content ) );

        return wp_slash( $content );
    }

    /**
     * Add target attr to links
     */
    public static function add_links_target( $content ) {
        $content = links_add_target( wp_unslash( $content ) );

        return wp_slash( $content );
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Content::load_module();
