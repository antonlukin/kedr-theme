<?php
/**
 * Blocks filters
 * All filters to replace core blocks default behavior
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Blocks {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_action( 'after_setup_theme', array( __CLASS__, 'register_custom_blocks' ) );
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'remove_block_styles' ) );

        add_filter( 'allowed_block_types_all', array( __CLASS__, 'disable_core_blocks' ), 20 );
        add_filter( 'block_type_metadata_settings', array( __CLASS__, 'remove_gallery_gaps' ) );
    }

    /**
     * Add custom blocks
     */
    public static function register_custom_blocks() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        $include = get_template_directory() . '/blocks/';

        foreach ( glob( $include . '*.php' ) as $widget ) {
            include_once $include . basename( $widget );
        }
    }

    /**
     * Remove default inline core/gallery block gap styles
     */
    public static function remove_gallery_gaps( $args ) {
        $callback = 'block_core_gallery_render';

        if ( isset( $args['render_callback'] ) && $args['render_callback'] === $callback ) {
            $args['render_callback'] = null;
        }

        return $args;
    }

    /**
     * Remove default Gutenberg styles and fonts
     */
    public static function remove_block_styles() {
        wp_dequeue_style( 'global-styles' );
        wp_dequeue_style( 'wp-webfonts' );
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
    }

    /**
     * Disable some core blocks
     */
    public static function disable_core_blocks( $allowed ) {
        $blocks = array_keys( WP_Block_Type_Registry::get_instance()->get_all_registered() );

        // Alloweed core blocks
        $allowed = array(
            'core/paragraph',
            'core/image',
            'core/embed',
            'core/separator',
            'core/spacer',
            'core/html',
            'core/code',
            'core/video',
            'core/audio',
            'core/quote',
            'core/list',
            'core/list-item',
            'core/gallery',
            'core/heading',
            'core/block',
            'core/details',
            'core/media-text',
        );

        $whitelist = array();

        foreach ( $blocks as $block ) {
            list( $prefix, ) = explode( '/', $block );

            if ( $prefix !== 'core' || in_array( $block, $allowed, true ) ) {
                $whitelist[] = $block;
            }
        }

        return $whitelist;
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Blocks::load_module();
