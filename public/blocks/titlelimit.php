<?php
/**
 * Title limit filter
 *
 * @package kedr-theme
 * @version 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Blocks_Titlelimit {
    /**
     * Init function instead of constructor
     */
    public static function load_module() {
        add_action( 'init', array( __CLASS__, 'register_block' ) );
    }

    /**
     * Register new speech block
     */
    public static function register_block() {
        $slug = 'titlelimit';

        // Get assets arguments
        $asset = require __DIR__ . "/build/{$slug}/index.asset.php";

        wp_register_script(
            'kedr-theme-' . $slug,
            get_stylesheet_directory_uri() . "/blocks/build/{$slug}/index.js",
            $asset['dependencies'],
            $asset['version'],
            true
        );

        register_block_type(
            __DIR__ . "/build/{$slug}",
            array(
                'editor_script' => 'kedr-theme-' . $slug,
            )
        );
    }
}

/**
 * Load current module environment
 */
Kedr_Blocks_Titlelimit::load_module();
