<?php
/**
 * Custom theme template tags
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! function_exists( 'the_post_info' ) ) :
    /**
     * Public templates function to show post info option like category or authors
     */
    function the_post_info( $option, $before = '', $after = '' ) {
        if ( $option === 'category' ) {
            $category = get_the_category();

            $output = sprintf(
                '<a href="%s" title="%s">%s</a>',
                esc_url( get_category_link( $category[0] ) ),
                esc_html__( 'Открыть все записи из категории', 'kedr-theme' ),
                esc_html( $category[0]->name )
            );
        }

        if ( $option === 'authors' ) {
            $output = coauthors_posts_links( ',', ',', null, null, false );
        }

        if ( $option === 'excerpt' ) {
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
