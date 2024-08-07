<?php
/**
 * Postinfo filters
 * Helper class for template-tags to get post info inside loop
 * Use get_ prefix for public methods
 *
 * @package kedr-theme
 * @since 2.0
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Postsettings {
    /**
     * Get navigation mod
     */
    public static function get_navigation_mod( $output = '' ) {

        if ( is_tax( 'region' ) ) {
            // temporary hide on taxonomy page
            // return 'ecomap';
            return $output;
        }
        global $wp;

        if ( isset( $wp->query_vars['region'] ) ) {
            $tax_slug = $wp->query_vars['region'];

            $args = array(
                'post_type'      => Kedr_Modules_Region_About::$post_type,
                'posts_per_page' => 1,
                'tax_query'      => array(
                    array(
                        'taxonomy' => Kedr_Modules_Regions::$taxonomy,
                        'field'    => 'slug',
                        'terms'    => $tax_slug,
                    ),
                ),
            );

            $query = new WP_Query( $args );
            if ( ! empty( $query->posts ) ) {
                if ( get_post_permalink() === get_permalink( $query->posts[0] ) ) {
                    return 'ecomap';
                }
            }
        }
        return $output;
    }
}
