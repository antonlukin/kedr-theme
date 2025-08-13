<?php
/**
 * The template for displaying video category archive
 *
 * @package kedr-theme
 * @since 2.3
 */

get_header(); ?>

<?php if ( have_posts() && get_the_archive_title() ) : ?>
    <div class="caption">
        <?php
            the_archive_title();
        ?>
    </div>
<?php endif; ?>

<?php
if ( is_active_sidebar( 'kedr-video' ) ) :
    dynamic_sidebar( 'kedr-video' );
endif;
?>

<?php if ( have_posts() ) : ?>
    <section class="frame-asset">
        <?php
        while ( have_posts() ) :
            the_post();
            get_template_part( 'templates/frame', 'asset' );
        endwhile;
        ?>
    </section>

    <nav class="navigate navigate--more">
        <?php next_posts_link( esc_html__( 'Показать еще', 'kedr-theme' ) ); ?>
    </nav>
<?php endif; ?>

<?php
get_footer();
?>
