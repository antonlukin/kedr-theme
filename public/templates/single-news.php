<?php
/**
 * Template for display single post
 *
 * @package kedr-theme
 * @since 2.0
 */

get_header(); ?>

<section class="content">
    <?php
    while ( have_posts() ) :
        the_post();
        get_template_part( 'templates/content', 'news' );
    endwhile;

    if ( is_active_sidebar( 'kedr-bottom' ) ) :
        dynamic_sidebar( 'kedr-bottom' );
    endif;
    ?>
</section>

<?php
get_footer();