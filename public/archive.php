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
            the_archive_description();
        ?>
    </div>
<?php endif; ?>

<?php if ( have_posts() ) : ?>
    <section class="widget-double">
        <?php
        while ( have_posts() ) :
            the_post();
            get_template_part( 'templates/widget', 'double' );
        endwhile;
        ?>
    </section>

    <nav class="navigate">
        <?php
            previous_posts_link( esc_html__( 'Предыдущие', 'knife-theme' ) );
            next_posts_link( esc_html__( 'Следующие', 'knife-theme' ) );
        ?>
    </nav>
<?php endif; ?>

<?php
get_footer();
