<?php
/**
 * Template for showing site front-page
 *
 * @package kedr-theme
 * @since 2.0
 */

get_header(); ?>

<?php
if ( is_active_sidebar( 'kedr-frontal' ) ) :
    dynamic_sidebar( 'kedr-frontal' );
endif;
?>

<?php
get_footer();
