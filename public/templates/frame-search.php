<?php
/**
 * Frame template with search results
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-search__content">
    <?php
    the_post_info(
        'category',
        '<div class="frame-search__content-category">',
        '</div>'
    );

    printf(
        '<a class="frame-search__content-title" href="%s">%s</a>',
        esc_url( get_permalink() ),
        esc_html( get_the_title() )
    );

    the_post_info(
        'excerpt',
        '<div class="frame-search__content-excerpt">',
        '</div>'
    );

    the_post_info(
        'date',
        '<div class="frame-search__content-date">',
        '</div>'
    );
    ?>
</div>
