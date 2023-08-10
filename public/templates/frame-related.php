<?php
/**
 * Related block template
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-related__wrapper">
    <?php if ( has_post_thumbnail() ) : ?>
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
    <?php endif; ?>

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

        if ( has_excerpt() ) {
            printf(
                '<div class="frame-related__content-excerpt">%s</div>',
                wp_kses_post( apply_filters( 'the_excerpt', get_the_excerpt() ) )
            );
        }
        ?>
    </div>
</div>