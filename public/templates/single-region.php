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
            <h1 class="region__content-title"><?php echo get_queried_object()->name; ?></h1>
            <div>
                <?php echo get_queried_object()->description; ?>
            </div>
            <a class="button region__content-button" type="button" href="<?
                echo get_permalink();
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
