<?php
/**
 * Widget template with podcasts
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="widget-podcasts__wrapper">
    <div class="widget-podcasts__caption">
        <?php
        printf(
            '<a class="widget-podcasts__caption-title" href="%s">%s</a>',
            esc_url( $args['link'] ),
            esc_html( $args['title'] )
        );
        ?>
    </div>

    <div class="widget-podcasts__grid">
        <?php while ( $args['query']->have_posts() ) : ?>
            <?php $args['query']->the_post(); ?>

            <div class="widget-podcasts__item">
                <div class="widget-podcasts__image">
                    <?php
                    the_post_thumbnail(
                        'card',
                        array(
                            'class'   => 'widget-podcasts__image-thumbnail',
                            'loading' => 'lazy',
                        )
                    );
                    ?>
                </div>

                <div class="widget-podcasts__content">
                    <?php
                    printf(
                        '<p class="widget-podcasts__content-category">%s %d</p>',
                        esc_html__( 'Выпуск', 'kedr-theme' ),
                        absint( $args['total'] - $args['counter']++ )
                    );

                    printf(
                        '<a class="widget-podcasts__content-title" href="%s">%s</a>',
                        esc_url( get_permalink() ),
                        esc_html( get_the_title() )
                    );
                    ?>
                </div>
            </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>
