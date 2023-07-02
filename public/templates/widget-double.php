<?php
/**
 * Widget template with 2 cards in a row
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="widget-double__wrapper">
    <div class="widget-double__image">
        <?php
        the_post_thumbnail(
            'card',
            array(
                'class'   => 'widget-double__image-thumbnail',
                'loading' => 'lazy',
            )
        );
        ?>
    </div>

    <div class="widget-double__content">
        <?php
        the_post_info(
            'category',
            '<div class="widget-double__content-category">',
            '</div>'
        );

        printf(
            '<a class="widget-double__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        the_post_info(
            'excerpt',
            '<div class="widget-double__content-excerpt">',
            '</div>'
        );

        the_post_info(
            'authors',
            '<div class="widget-double__content-authors">',
            '</div>'
        );
        ?>
    </div>
</div>