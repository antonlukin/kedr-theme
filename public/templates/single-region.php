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
            <div>
                <?php the_archive_description(); ?>
            </div>
                <?php
                kedr_theme_info(
                    'region_about_link',
                    '<a class="button region__content-button" type="button" href="',
                    '">О регионе</a>'
                );
                ?>
        </div>
        <div class="region__image">
            <img class="region__image-thumbnail" src=
                <?php
                echo esc_url( get_template_directory_uri() . '/assets/images/region-placeholder.jpg' );
                ?>
            >
        </div>
    </div>

    <?php
    get_template_part( 'templates/frame', 'region-articles' );
    ?>
</section>

<?php get_footer(); ?>
