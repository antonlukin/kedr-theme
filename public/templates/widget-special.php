<?php
/**
 * Widget template with 3 cards in a row
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="widget-special__wrapper">
    <div class="widget-special__caption">
        <?php
        printf(
            '<a class="widget-special__caption-title" href="%s">%s</a>',
            esc_url( get_term_link( $args['term'] ) ),
            esc_html( $args['term']->name )
        );

        printf(
            '<div class="widget-special__caption-description">%s</div>',
            term_description( $args['term'] )
        );
        ?>
    </div>

    <div class="widget-special__grid">
        <?php while ( $args['query']->have_posts() ) : ?>
            <?php $args['query']->the_post(); ?>

            <div class="widget-special__item">
                <div class="widget-special__image">
                    <?php
                    the_post_thumbnail(
                        'card',
                        array(
                            'class'   => 'widget-special__image-thumbnail',
                            'loading' => 'lazy',
                        )
                    );
                    ?>
                </div>

                <div class="widget-special__content">
                    <?php
                    printf(
                        '<a class="widget-special__content-title" href="%s">%s</a>',
                        esc_url( get_permalink() ),
                        esc_html( get_the_title() )
                    );

                    the_post_info(
                        'excerpt',
                        '<div class="widget-special__content-excerpt">',
                        '</div>'
                    );

                    the_post_info(
                        'authors',
                        '<div class="widget-special__content-authors">',
                        '</div>'
                    );
                    ?>
                </div>
            </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>
