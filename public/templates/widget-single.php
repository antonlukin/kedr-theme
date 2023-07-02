<?php
/**
 * Widget template for single post
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="widget-single__wrapper">
    <div class="widget-single__image">
        <?php
        the_post_thumbnail(
            'single',
            array(
                'class'   => 'widget-single__image-thumbnail',
                'loading' => 'lazy',
            )
        );
        ?>
    </div>

    <div class="widget-single__content">
        <?php
        the_post_info(
            'category',
            '<div class="widget-single__content-category">',
            '</div>'
        );

        printf(
            '<a class="widget-single__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        the_post_info(
            'excerpt',
            '<div class="widget-single__content-excerpt">',
            '</div>'
        );

        the_post_info(
            'authors',
            '<div class="widget-single__content-authors">',
            '</div>'
        );
        ?>
    </div>
</div>
