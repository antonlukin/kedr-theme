<?php
/**
 * Widget template for photostory post
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-photostory__wrapper">
    <figure class="frame-photostory__image">
        <?php
        the_post_thumbnail(
            'single',
            array(
                'class'   => 'frame-photostory__image-thumbnail',
                'loading' => 'lazy',
            )
        );
        ?>
    </figure>

    <div class="frame-photostory__content">
        <?php
        the_post_info(
            'category',
            '<div class="frame-photostory__content-category">',
            '</div>'
        );

        printf(
            '<a class="frame-photostory__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        the_post_info(
            'excerpt',
            '<div class="frame-photostory__content-excerpt">',
            '</div>'
        );

        the_post_info(
            'authors',
            '<div class="frame-photostory__content-authors">',
            '</div>'
        );
        ?>
    </div>
</div>
