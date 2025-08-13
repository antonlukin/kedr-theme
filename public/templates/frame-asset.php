<?php
/**
 * Widget template for video asset
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-asset__wrapper">
    <div class="frame-asset__content">
        <?php
        kedr_theme_info(
            'video',
            '<div class="frame-asset__player">',
            '</div>'
        );

        kedr_theme_info(
            'category',
            '<div class="frame-asset__content-category">',
            '</div>'
        );

        printf(
            '<a class="frame-asset__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        kedr_theme_info(
            'excerpt',
            '<div class="frame-asset__content-excerpt">',
            '</div>'
        );

        kedr_theme_info(
            'authors',
            '<div class="frame-asset__content-authors">',
            '</div>'
        );
        ?>
    </div>
</div>
