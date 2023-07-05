<?php
/**
 * Template for showing site front-page
 *
 * @package kedr-theme
 * @since 2.0
 */

get_header();

if ( is_active_sidebar( 'kedr-frontal' ) ) :
    dynamic_sidebar( 'kedr-frontal' );
endif;

get_footer();
