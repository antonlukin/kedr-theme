<?php
/**
 * Recent posts from eco map.
 * Add ecomacp block to the post.
 *
 * @package kedr-theme
 * @since 2.3
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Blocks_EcoMap {
    /**
     * Init function instead of constructor
     */
    public static function load_module() {
        add_action( 'init', array( __CLASS__, 'register_block' ) );
    }

    /**
     * Register new related block
     */
    public static function register_block() {
        $slug = 'ecomap';

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
                'editor_script'   => 'kedr-theme-' . $slug,
                'render_callback' => array( __CLASS__, 'render_block' ),
            )
        );
    }

    /**
     * Render ecomap block
     */
    public static function render_block() {
        if ( ! property_exists( 'Kedr_Modules_Regions', 'taxonomy' ) ) {
            return null;
        }

        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 2,
            'tax_query'      => array( // phpcs:ignore
                array(
                    'taxonomy' => Kedr_Modules_Regions::$taxonomy,
                    'operator' => 'EXISTS',
                ),
            ),
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        if ( get_the_ID() ) {
            $args['post__not_in'] = array( get_the_ID() );
        }

        $query = new WP_Query( $args );

        if ( ! $query->have_posts() ) {
            return null;
        }

        ob_start();

        get_template_part( 'templates/frame', 'ecomap', compact( 'query' ) );

        $output = sprintf(
            '<div class="frame-ecomap wp-block-kedr-ecomap">%s</div>',
            ob_get_clean()
        );

        return $output;
    }
}

/**
 * Load current module environment
 */
Kedr_Blocks_EcoMap::load_module();
