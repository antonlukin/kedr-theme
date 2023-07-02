<?php
/**
 * Widget template with recent news
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="widget-news__content widget-news__content--<?php echo esc_attr( $args['class'] ); ?>">
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="widget-news__image">
            <?php
            the_post_thumbnail(
                'card',
                array(
                    'class'   => 'widget-news__image-thumbnail',
                    'loading' => 'lazy',
                )
            );
            ?>
        </div>
    <?php endif; ?>

    <?php
    the_post_info(
        'category',
        '<div class="widget-news__content-category">',
        '</div>'
    );

    printf(
        '<a class="widget-news__content-title" href="%s">%s</a>',
        esc_url( get_permalink() ),
        esc_html( get_the_title() )
    );

    the_post_info(
        'date',
        '<div class="widget-news__content-date">',
        '</div>'
    );
    ?>
</div>
