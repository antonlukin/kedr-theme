<?php
/**
 * The template for displaying news archive
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
    <section class="frame-news frame-news--archive">
        <?php
        while ( have_posts() ) :
            the_post();

            $options = array( 'class' => 'common' );
            get_template_part( 'templates/frame', 'news', $options );
        endwhile;
        ?>
    </section>

    <nav class="navigate">
        <?php next_posts_link( esc_html__( 'Следующие', 'knife-theme' ) ); ?>
    </nav>
<?php endif; ?>

<?php
get_footer();
