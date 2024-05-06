<?php
/**
 * Podcast episode number to show in widgets
 * Add custom textbox field to post settings sidebar.
 *
 * @package kedr-theme
 * @version 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Blocks_Castlead {
    /**
     * Post meta title to store featured news
     */
    public static $meta = '_kedr_castlead';

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

        add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_assets' ) );
    }

    /**
     * Add Gutenberg scripts
     */
    public static function enqueue_assets() {
        $slug = 'castlead';

        // Get assets arguments
        $asset = require __DIR__ . "/build/{$slug}/index.asset.php";

        wp_register_script(
            'kedr-theme-' . $slug,
            get_stylesheet_directory_uri() . "/blocks/build/{$slug}/index.js",
            $asset['dependencies'],
            $asset['version'],
            true
        );

        $category = get_category_by_slug( 'podcast' );

        if ( $category === false ) {
            return;
        }

        wp_localize_script(
            'kedr-theme-' . $slug,
            'kedr_theme_' . $slug,
            array(
                'term' => $category->term_id,
                'meta' => self::$meta,
            )
        );

        wp_enqueue_script( 'kedr-theme-' . $slug );
    }
}

/**
 * Load current module environment
 */
Kedr_Blocks_Castlead::load_module();
