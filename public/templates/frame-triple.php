<?php
/**
 * Widget template with 3 cards in a row
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-triple__wrapper">
    <figure class="frame-triple__image">
        <?php
        the_post_thumbnail(
            'card',
            array(
                'class'   => 'frame-triple__image-thumbnail',
                'loading' => 'lazy',
            )
        );
        ?>

        <?php
        if ( isset( $args['add_region_label'] ) && $args['add_region_label'] ) {
            kedr_theme_info(
                'region',
                '<p class="frame-triple__region">',
                '</p>'
            );
        }
        ?>
    </figure>

    <div class="frame-triple__content">
        <?php
        kedr_theme_info(
            'category',
            '<div class="frame-triple__content-category">',
            '</div>'
        );

        printf(
            '<a class="frame-triple__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        kedr_theme_info(
            'excerpt',
            '<div class="frame-triple__content-excerpt">',
            '</div>'
        );

        kedr_theme_info(
            'authors',
            '<div class="frame-triple__content-authors">',
            '</div>'
        );
        ?>
    </div>
</div>
