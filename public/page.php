<?php
/**
 * Page templates
 *
 * @package kedr-theme
 * @since 2.0
 */

get_header(); ?>

<section class="content">
    <?php
    while ( have_posts() ) :
        the_post();
        get_template_part( 'templates/content', 'page' );
    endwhile;
    ?>
</section>

<?php
get_footer();