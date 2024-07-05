<?php
/**
 * Required footer file
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<?php
get_template_part( 'templates/footer', kedr_theme_get( 'navigation_mod' ) );
?>

<?php
if ( is_active_sidebar( 'kedr-flexible' ) ) :
    dynamic_sidebar( 'kedr-flexible' );
endif;
?>

<?php wp_footer(); ?>
</body>
</html>
