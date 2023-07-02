<?php
/**
 * Widget template with 3 cards in a row
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="widget-triple__wrapper">
    <div class="widget-triple__image">
        <?php
        the_post_thumbnail(
            'card',
            array(
                'class'   => 'widget-triple__image-thumbnail',
                'loading' => 'lazy',
            )
        );
        ?>
    </div>

    <div class="widget-triple__content">
        <?php
        the_post_info(
            'category',
            '<div class="widget-triple__content-category">',
            '</div>'
        );

        printf(
            '<a class="widget-triple__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        the_post_info(
            'excerpt',
            '<div class="widget-triple__content-excerpt">',
            '</div>'
        );

        the_post_info(
            'authors',
            '<div class="widget-triple__content-authors">',
            '</div>'
        );
        ?>
    </div>
</div>