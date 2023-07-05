<?php
/**
 * Filters to foreign plugins
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Remove class from coauthors links
 */
add_filter(
    'coauthors_posts_link',
    function( $args ) {
        $args['class'] = null;

        return $args;
    }
);
