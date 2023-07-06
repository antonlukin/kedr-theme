<?php
/**
 * Custom theme template tags
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! function_exists( 'the_post_info' ) ) :
    /**
     * Public templates function to show post info option like category or authors
     */
    function the_post_info( $option, $before = '', $after = '' ) {
        if ( $option === 'category' ) {
            $categories = get_the_category();

            if ( empty( $categories ) ) {
                return null;
            }

            $category = $categories[0];

            // Get only one category
            $cat_id = $category->term_id;

            if ( ! empty( $category->parent ) ) {
                $ancestors = get_ancestors( $category->term_id, 'category' );

                // Get top level category id
                $cat_id = end( $ancestors );
            }

            $output = sprintf(
                '<a href="%s" title="%s">%s</a>',
                esc_url( get_category_link( $cat_id ) ),
                esc_html__( 'Открыть все записи из категории', 'kedr-theme' ),
                esc_html( get_cat_name( $cat_id ) )
            );
        }

        if ( $option === 'authors' ) {
            $output = coauthors_posts_links( ', ', ', ', null, null, false );
        }

        if ( $option === 'excerpt' && has_excerpt() ) {
            $output = apply_filters( 'the_excerpt', get_the_excerpt() );
        }

        if ( $option === 'date' ) {
            $output = get_the_date();
        }

        if ( ! empty( $output ) ) {
            $output = $before . $output . $after;

            echo $output; // phpcs:ignore WordPress.Security.EscapeOutput
        }
    }
endif;


if ( ! function_exists( 'get_the_partial' ) ) :
    /**
     * Public templates function to get correct partial according post format and post thumbnail
     */
    function get_the_partial() {
        if ( has_post_format() ) {
            return get_post_format();
        }

        if ( has_post_thumbnail() ) {
            return 'article';
        }

        return null;
    }
endif;
