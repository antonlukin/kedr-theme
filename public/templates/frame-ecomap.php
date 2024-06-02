<?php
/**
 * EcoMap block template
 *
 * @package kedr-theme
 * @since 2.3
 */
?>

<div class="frame-ecomap__wrapper">
    <div class="frame-ecomap__caption">
        <?php
        printf(
            '<p class="frame-ecomap__caption-title">%s</p>',
            esc_html__( 'Другие материалы «Экокарты»', 'kedr-theme' )
        );
        ?>
    </div>

    <div class="frame-ecomap__grid">
        <?php while ( $args['query']->have_posts() ) : ?>
            <?php $args['query']->the_post(); ?>

            <div class="frame-ecomap__item">
                <?php
                kedr_theme_info(
                    'region',
                    '<p class="frame-ecomap__region">',
                    '</p>'
                );
                ?>

                <div class="frame-ecomap__content">
                    <?php
                    printf(
                        '<a class="frame-ecomap__content-title" href="%s">%s</a>',
                        esc_url( get_permalink() ),
                        esc_html( get_the_title() )
                    );

                    kedr_theme_info(
                        'excerpt',
                        '<div class="frame-ecomap__content-excerpt">',
                        '</div>'
                    );
                    ?>
                </div>
            </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>