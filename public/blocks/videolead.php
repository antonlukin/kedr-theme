<?php
/**
 * Alternative lead for posts
 * Add custom textbox field to post settings sidebar.
 *
 * @package kedr-theme
 * @version 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Blocks_Videolead {
    /**
     * Post meta title to store featured news
     */
    public static $meta = '_kedr_videolead';

    /**
     * Init function instead of constructor
     */
    public static function load_module() {
        add_action( 'init', array( __CLASS__, 'register_block' ) );
    }

    /**
     * Register new Gutenberg plugin
     */
    public static function register_block() {
        register_post_meta(
            'post',
            self::$meta,
            array(
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_textarea_field',
                'show_in_rest'      => true,
                'single'            => true,
                'auth_callback'     => function() {
                    return current_user_can( 'edit_posts' );
                },
            )
        );

        add_filter( 'update_post_metadata', array( __CLASS__, 'remove_empty_meta' ), 10, 5 );
        add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_assets' ) );
    }

    /**
     * Remove empty topnews meta value
     */
    public static function remove_empty_meta( $check, $id, $key, $value, $prev ) {
        if ( $key === self::$meta && empty( $value ) ) {
            delete_post_meta( $id, $key, $prev );
            return true;
        }

        return null;
    }

    /**
     * Add Gutenberg scripts for topnews option
     */
    public static function enqueue_assets() {
        $slug = 'videolead';

        // Get assets arguments
        $asset = require __DIR__ . "/build/{$slug}/index.asset.php";

        wp_register_script(
            'kedr-theme-' . $slug,
            get_stylesheet_directory_uri() . "/blocks/build/{$slug}/index.js",
            $asset['dependencies'],
            $asset['version'],
            true
        );

        wp_localize_script(
            'kedr-theme-' . $slug,
            'kedr_theme_' . $slug,
            array(
                'meta' => self::$meta,
            )
        );

        wp_enqueue_script( 'kedr-theme-' . $slug );
    }
}

/**
 * Load current module environment
 */
Kedr_Blocks_Videolead::load_module();
