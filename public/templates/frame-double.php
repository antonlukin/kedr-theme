<?php
/**
 * Widget template with 2 cards in a row
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-double__wrapper">
    <figure class="frame-double__image">
        <?php
        the_post_thumbnail(
            'card',
            array(
                'class'   => 'frame-double__image-thumbnail',
                'loading' => 'lazy',
            )
        );
        ?>
    </figure>

    <div class="frame-double__content">
        <?php
        kedr_theme_info(
            'category',
            '<div class="frame-double__content-category">',
            '</div>'
        );

        printf(
            '<a class="frame-double__content-title" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        kedr_theme_info(
            'excerpt',
            '<div class="frame-double__content-excerpt">',
            '</div>'
        );

        kedr_theme_info(
            'authors',
            '<div class="frame-double__content-authors">',
            '</div>'
        );
        ?>
    </div>
</div>