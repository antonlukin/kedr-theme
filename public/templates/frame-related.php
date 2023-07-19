<?php
/**
 * Widget template for related post
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-related__wrapper">
    <figure class="frame-related__image">
        <?php
        the_post_thumbnail(
            'single',
            array(
                'class'   => 'frame-related__image-thumbnail',
                'loading' => 'lazy',
            )
        );
        ?>
    </figure>

    <div class="frame-related__content">
        <?php
        printf(
            '<p class="frame-related__content-caption">%s</p>',
            esc_html__( 'Читайте также', 'kedr-theme' )
        );

        printf(
            '<a class="frame-related__content-title" href="%s" target="_blank" rel="noopener">%s</a>',
            esc_url( get_permalink() ),
            esc_html( get_the_title() )
        );

        the_post_info(
            'excerpt',
            '<div class="frame-related__content-excerpt">',
            '</div>'
        );
        ?>
    </div>
</div>
