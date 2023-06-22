<?php
/**
 * Filters to foreign plugins
 *
 * @package kedr-theme
 * @since 2.0
 */


add_filter(
    'coauthors_posts_link',
    function( $args ) {
        $args['class'] = null;

        return $args;
    }
);
