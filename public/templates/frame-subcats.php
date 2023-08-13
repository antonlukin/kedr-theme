<?php
/**
 * Widget template for video post
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-subcats__wrapper">
    <figure class="frame-subcats__image">
        <?php
        if ( ! empty( $args['image'] ) ) :
            printf(
                '<img class="frame-subcats__image-thumbnail" src="%s" alt="%s">',
                esc_url( $args['image'] ),
                esc_html( get_cat_name( $args['category'] ) )
            );
        endif;
        ?>
    </figure>

    <?php
    printf(
        '<a class="frame-subcats__title" href="%s">%s</a>',
        esc_url( get_category_link( $args['category'] ) ),
        esc_html( get_cat_name( $args['category'] ) )
    );
    ?>
</div>
