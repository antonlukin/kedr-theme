<?php
/**
 * The template for displaying region pages
 *
 * @package kedr-theme
 * @since 2.0
 */

get_header(); ?>

<section class="content region">
    <div class="region__double">
        <div class="region__content">
            <?php the_archive_title(); ?>
            <?php the_archive_description(); ?>
            <?php
            kedr_theme_info(
                'region_about_link',
                '<a class="button region__content-button" type="button" href="',
                '">О регионе</a>'
            );
            ?>
        </div>
        <figure class="region__image">
            <?php
            kedr_theme_info(
                'region_thumbnail'
            );
            ?>
        </figure>
    </div>

    <div class="region__map">
        <?php
        get_template_part( 'templates/frame', 'map' );
        ?>
    </div>

    <?php
    get_template_part( 'templates/frame', 'region-articles' );
    ?>
</section>

<?php get_footer(); ?>
