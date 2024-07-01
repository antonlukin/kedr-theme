<?php
/**
 * The template for displaying region pages
 *
 * @package kedr-theme
 * @since 2.0
 */

get_header(); ?>

<section class="content region">
    <div class="region__wrapper">
        <div class="region__content">
            <?php the_archive_title(); ?>
            <div>
                <?php the_archive_description(); ?>
            </div>
            <a class="button region__content-button" type="button" href="<?
                the_permalink();
            ?>">О регионе</a>
        </div>
        <div class="region__image">
            <img class="region__image-thumbnail" src="<?php echo get_template_directory_uri() . '/assets/images/region-placeholder.jpg'; ?>">
        </div>
    </div>

    <?php
    if ( is_active_sidebar( 'kedr-bottom' ) ) :
        dynamic_sidebar( 'kedr-bottom' );
        endif;
    ?>
</section>

<?php get_footer(); ?>
