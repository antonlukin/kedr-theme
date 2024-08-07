<?php
/**
 * The template for displaying archive pages
 *
 * @package kedr-theme
 * @since 2.0
 */

get_header(); ?>

<?php if ( have_posts() && get_the_archive_title() ) : ?>
    <div class="caption">
        <?php
            the_archive_title();
        ?>
    </div>
<?php endif; ?>

<?php if ( have_posts() ) : ?>
    <section class="frame-double">
        <?php
        while ( have_posts() ) :
            the_post();
            // temporary hide posts region-about
            if ( get_post_type() === 'region-about' ) {
                continue;
            }
            get_template_part( 'templates/frame', 'double' );
        endwhile;
        ?>
    </section>

    <nav class="navigate">
        <?php next_posts_link( esc_html__( 'Следуюшая страница', 'kedr-theme' ) ); ?>
    </nav>
<?php endif; ?>

<?php
get_footer();
