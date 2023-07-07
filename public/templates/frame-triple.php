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
    </figure>

    <div class="frame-triple__content">
        <?php
        the_post_info(
            'category',
            '<div class="frame-triple__content-category">',
            '</div>'
        );

        printf(
            '<a class="frame-triple__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        the_post_info(
            'excerpt',
            '<div class="frame-triple__content-excerpt">',
            '</div>'
        );

        the_post_info(
            'authors',
            '<div class="frame-triple__content-authors">',
            '</div>'
        );
        ?>
    </div>
</div>