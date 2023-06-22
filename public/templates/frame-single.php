<?php
/**
 * Frame template for single post
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-single__wrapper">
    <div class="frame-single__image">
        <?php
        the_post_thumbnail(
            'single',
            array(
                'class'   => 'frame-single__image-thumbnail',
                'loading' => 'lazy',
            )
        );
        ?>
    </div>

    <div class="frame-single__content">
        <?php
        the_post_info(
            'category',
            '<div class="frame-single__content-category">',
            '</div>'
        );

        printf(
            '<a class="frame-single__content-link" href="%s">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        the_post_info(
            'excerpt',
            '<div class="frame-single__content-excerpt">',
            '</div>'
        );

        the_post_info(
            'authors',
            '<div class="frame-single__content-authors">',
            '</div>'
        );
        ?>
    </div>
</div>
