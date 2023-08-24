<?php
/**
 * Hide comments panel.
 *
 * @package kedr-theme
 * @version 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Blocks_Comments {
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
        add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_assets' ) );
    }

    /**
     * Add Gutenberg scripts for topnews option
     */
    public static function enqueue_assets() {
        $slug = 'comments';

        // Get assets arguments
        $asset = require __DIR__ . "/build/{$slug}/index.asset.php";

        wp_register_script(
            'kedr-theme-' . $slug,
            get_stylesheet_directory_uri() . "/blocks/build/{$slug}/index.js",
            $asset['dependencies'],
            $asset['version'],
            true
        );

        wp_enqueue_script( 'kedr-theme-' . $slug );
    }
}

/**
 * Load current module environment
 */
Kedr_Blocks_Comments::load_module();
