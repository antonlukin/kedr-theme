<?php
/**
 * The template for displaying categories that have subcategories
 *
 * @package kedr-theme
 * @since 2.0
 */

get_header(); ?>

<?php if ( get_the_archive_title() ) : ?>
    <div class="caption">
        <?php
            the_archive_title();
        ?>
    </div>
<?php endif; ?>

<section class="frame-subcats">
    <?php the_widget( 'Kedr_Widget_Subcats' ); ?>
</section>

<?php
get_footer();
