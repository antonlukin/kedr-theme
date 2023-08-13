<?php
/**
 * Widget template for video post
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-video__wrapper">
    <div class="frame-video__content">
        <?php
        kedr_theme_info(
            'category',
            '<div class="frame-video__content-category">',
            '</div>'
        );

        printf(
            '<a class="frame-video__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        kedr_theme_info(
            'videolead',
            '<div class="frame-video__content-videolead">',
            '</div>'
        );

        kedr_theme_info(
            'authors',
            '<div class="frame-video__content-authors">',
            '</div>'
        );
        ?>
    </div>

    <?php
    kedr_theme_info(
        'video',
        '<div class="frame-video__player">',
        '</div>'
    );
    ?>
</div>
