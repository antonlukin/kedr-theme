<?php
/**
 * Widget template for single post
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-single__wrapper">
    <div class="frame-single__content">
        <?php
        kedr_theme_info(
            'category',
            '<div class="frame-single__content-category">',
            '</div>'
        );

        printf(
            '<a class="frame-single__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        kedr_theme_info(
            'excerpt',
            '<div class="frame-single__content-excerpt">',
            '</div>'
        );

        kedr_theme_info(
            'authors',
            '<div class="frame-single__content-authors">',
            '</div>'
        );
        ?>
    </div>

    <figure class="frame-single__image">
        <?php
        the_post_thumbnail(
            'single',
            array(
                'class'   => 'frame-single__image-thumbnail',
                'loading' => 'lazy',
            )
        );
        ?>

        <?php
        if ( isset( $args['add_region_label'] ) && $args['add_region_label'] ) {
            kedr_theme_info(
                'region',
                '<p class="frame-single__region">',
                '</p>'
            );
        }
        ?>

    </figure>
</div>
