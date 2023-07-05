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
        the_post_info(
            'category',
            '<div class="frame-video__content-category">',
            '</div>'
        );

        printf(
            '<a class="frame-video__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        the_post_info(
            'excerpt',
            '<div class="frame-video__content-excerpt">',
            '</div>'
        );

        the_post_info(
            'authors',
            '<div class="frame-video__content-authors">',
            '</div>'
        );
        ?>
    </div>

    <div class="frame-video__player">
        <?php
        the_post_thumbnail(
            'single',
            array(
                'class'   => 'frame-video__player-thumbnail',
                'loading' => 'lazy',
            )
        );
        ?>
    </div>
</div>
