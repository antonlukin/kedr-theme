<?php
/**
 * Related posts element
 * Add related block to post
 *
 * @package kedr-theme
 * @version 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Blocks_Related {
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
        register_block_type(
            __DIR__ . '/build/related',
            array(
                'render_callback' => array( __CLASS__, 'render_block' ),
            )
        );
    }

    /**
     * Render related block
     */
    public static function render_block( $attributes ) {
        if ( empty( $attributes['link'] ) ) {
            return null;
        }

        $post_id = url_to_postid( $attributes['link'] );

        if ( empty( $post_id ) ) {
            return null;
        }

        $query = self::get_related_query( $post_id );

        if ( ! $query->have_posts() ) {
            return null;
        }

        ob_start();

        $query->the_post();

        get_template_part( 'templates/frame', 'related' );
        wp_reset_postdata();

        $output = sprintf(
            '<div class="frame-related wp-block-kedr-related">%s</div>',
            ob_get_clean()
        );

        return $output;
    }

    /**
     * Get related post query
     */
    private static function get_related_query( $post_id ) {
        $query = new WP_Query(
            array(
                'posts_per_page'      => 1,
                'post_status'         => 'publish',
                'post_type'           => 'any',
                'ignore_sticky_posts' => true,
                'post__in'            => array( $post_id ),
            )
        );

        return $query;
    }
}

/**
 * Load current module environment
 */
Kedr_Blocks_Related::load_module();
