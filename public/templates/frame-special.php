<?php
/**
 * Widget template with 3 cards in a row
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-special__wrapper">
    <div class="frame-special__caption">
        <?php
        printf(
            '<a class="frame-special__caption-title" href="%s">%s</a>',
            esc_url( get_term_link( $args['term'] ) ),
            esc_html( $args['term']->name )
        );

        printf(
            '<div class="frame-special__caption-description">%s</div>',
            term_description( $args['term'] )
        );
        ?>
    </div>

    <div class="frame-special__grid">
        <?php while ( $args['query']->have_posts() ) : ?>
            <?php $args['query']->the_post(); ?>

            <div class="frame-special__item">
                <figure class="frame-special__image">
                    <?php
                    the_post_thumbnail(
                        'card',
                        array(
                            'class'   => 'frame-special__image-thumbnail',
                            'loading' => 'lazy',
                        )
                    );
                    ?>
                </figure>

                <div class="frame-special__content">
                    <?php
                    printf(
                        '<a class="frame-special__content-title" href="%s">%s</a>',
                        esc_url( get_permalink() ),
                        esc_html( get_the_title() )
                    );

                    kedr_theme_info(
                        'excerpt',
                        '<div class="frame-special__content-excerpt">',
                        '</div>'
                    );

                    kedr_theme_info(
                        'authors',
                        '<div class="frame-special__content-authors">',
                        '</div>'
                    );
                    ?>
                </div>
            </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>
