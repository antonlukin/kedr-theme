<?php
/**
 * Widget template for photostory post
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="widget-photostory__wrapper">
    <div class="widget-photostory__image">
        <?php
        the_post_thumbnail(
            'single',
            array(
                'class'   => 'widget-photostory__image-thumbnail',
                'loading' => 'lazy',
            )
        );
        ?>
    </div>

    <div class="widget-photostory__content">
        <?php
        the_post_info(
            'category',
            '<div class="widget-photostory__content-category">',
            '</div>'
        );

        printf(
            '<a class="widget-photostory__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        the_post_info(
            'excerpt',
            '<div class="widget-photostory__content-excerpt">',
            '</div>'
        );

        the_post_info(
            'authors',
            '<div class="widget-photostory__content-authors">',
            '</div>'
        );
        ?>
    </div>
</div>
