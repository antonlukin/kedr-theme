<?php
/**
 * Help element
 * Add help block to post editor
 *
 * @package kedr-theme
 * @version 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Blocks_Help {
    /**
     * Init function instead of constructor
     */
    public static function load_module() {
        add_action( 'init', array( __CLASS__, 'register_block' ) );
    }

    /**
     * Register new help block
     */
    public static function register_block() {
        $slug = 'help';

        // Get assets arguments
        $asset = require __DIR__ . "/build/{$slug}/index.asset.php";

        wp_register_script(
            'kedr-theme-' . $slug,
            get_stylesheet_directory_uri() . "/blocks/build/{$slug}/index.js",
            $asset['dependencies'],
            $asset['version'],
            true
        );

        wp_register_style(
            'kedr-theme-' . $slug,
            get_stylesheet_directory_uri() . "/blocks/build/{$slug}/index.css",
            array(),
            $asset['version']
        );

        register_block_type(
            __DIR__ . "/build/{$slug}",
            array(
                'editor_script' => 'kedr-theme-' . $slug,
                'editor_style'  => 'kedr-theme-' . $slug,
            )
        );
    }
}

/**
 * Load current module environment
 */
Kedr_Blocks_Help::load_module();
