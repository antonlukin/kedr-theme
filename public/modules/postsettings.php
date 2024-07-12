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
            return 'ecomap';
        }

        if ( is_post_type_archive( 'region-about' ) ) {
            return 'ecomap';
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

    public static function get_regions() {
        $args    = array( 'name' => Kedr_Modules_Regions::$taxonomy );
        $regions = get_terms(
            array(
                'taxonomy'   => Kedr_Modules_Regions::$taxonomy,
                'hide_empty' => false,
            )
        );

        return $regions;
    }

    /**
     * Get taxonomy articles
     */
    public static function get_taxonomy_articles() {
        global $wp;
        if ( isset( $wp->query_vars['region'] ) ) {
            $tax_slug = $wp->query_vars['region'];
        } else {
            $terms    = get_terms( Kedr_Modules_Regions::$taxonomy );
            $tax_slug = wp_list_pluck( $terms, 'slug' );
        }

        $tax_query = array(
            'taxonomy' => Kedr_Modules_Regions::$taxonomy,
            'field'    => 'slug',
            'terms'    => $tax_slug,
        );

        $args = array(
            'post_type'      => array( 'post' ),
            'posts_per_page' => 6,
            'tax_query'      => array( $tax_query ),
        );

        return new WP_Query( $args );
    }

    /**
     * Should add region labels on posts or not
     */
    public static function get_add_region_label() {
        $add_region_label = true;
        global $wp;
        if ( isset( $wp->query_vars['region'] ) ) {
            $add_region_label = false;
        }

        return $add_region_label;
    }

    public static function get_post_row_size( $total_posts, $posts_left ) {
        if ( $posts_left <= 0 ) {
            return 0;
        }
        if ( $total_posts === $posts_left ) {
            return 1;
        }
        if ( $posts_left <= 3 ) {
            return $posts_left;
        }
        if ( $posts_left === 4 ) {
            return 2;
        }
        return 3;
    }
}
