<?php
/**
 * Widget template for 6 cards with caption
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-editorial__wrapper">
    <div class="frame-editorial__caption">
        <?php
        printf(
            '<p class="frame-editorial__caption-title">%s</p>',
            esc_html( $args['title'] )
        );
        ?>
    </div>

    <div class="frame-editorial__grid">
        <?php while ( $args['query']->have_posts() ) : ?>
            <?php $args['query']->the_post(); ?>

            <div class="frame-editorial__content">
                <?php
                kedr_theme_info(
                    'category',
                    '<div class="frame-editorial__content-category">',
                    '</div>'
                );

                printf(
                    '<a class="frame-editorial__content-title" href="%s">%s</a>',
                    esc_url( get_permalink() ),
                    esc_html( get_the_title() )
                );

                kedr_theme_info(
                    'excerpt',
                    '<div class="frame-editorial__content-excerpt">',
                    '</div>'
                );
                kedr_theme_info(
                    'authors',
                    '<div class="frame-editorial__content-authors">',
                    '</div>'
                );
                ?>
            </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>
