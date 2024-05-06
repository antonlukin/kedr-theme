<?php
/**
 * Featured news block
 * Add checkbox to editor screen to mark news as featured
 *
 * @package kedr-theme
 * @version 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Blocks_Topnews {
    /**
     * Post meta title to store featured news
     */
    public static $meta = '_kedr_topnews';

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
                'type'              => 'boolean',
                'sanitize_callback' => 'absint',
                'show_in_rest'      => true,
                'single'            => true,
                'auth_callback'     => function() {
                    return current_user_can( 'edit_posts' );
                },
            )
        );

        add_filter( 'update_post_metadata', array( __CLASS__, 'remove_empty_meta' ), 15, 4 );
        add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_assets' ) );
    }

    /**
     * Remove empty topnews meta value
     */
    public static function remove_empty_meta( $check, $id, $key, $value ) {
        if ( $key === self::$meta && empty( $value ) ) {
            delete_post_meta( $id, $key );
            return true;
        }

        return null;
    }

    /**
     * Add Gutenberg scripts
     */
    public static function enqueue_assets() {
        $slug = 'topnews';

        // Get assets arguments
        $asset = require __DIR__ . "/build/{$slug}/index.asset.php";

        wp_register_script(
            'kedr-theme-' . $slug,
            get_stylesheet_directory_uri() . "/blocks/build/{$slug}/index.js",
            $asset['dependencies'],
            $asset['version'],
            true
        );

        $category = get_category_by_slug( 'news' );

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

        wp_enqueue_style(
            'kedr-theme-' . $slug,
            get_stylesheet_directory_uri() . "/blocks/build/{$slug}/index.css",
            array(),
            $asset['version']
        );
    }
}

/**
 * Load current module environment
 */
Kedr_Blocks_Topnews::load_module();
