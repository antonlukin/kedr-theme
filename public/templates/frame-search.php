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
    kedr_theme_info(
        'category',
        '<div class="frame-search__content-category">',
        '</div>'
    );

    printf(
        '<a class="frame-search__content-title" href="%s">%s</a>',
        esc_url( get_permalink() ),
        esc_html( get_the_title() )
    );

    kedr_theme_info(
        'excerpt',
        '<div class="frame-search__content-excerpt">',
        '</div>'
    );
    ?>

    <div class="frame-search__content-meta">
        <?php
        kedr_theme_info(
            'date',
            '<div class="frame-search__content-date">',
            '</div>'
        );

        kedr_theme_info(
            'authors',
            '<div class="frame-search__content-authors">',
            '</div>'
        );
        ?>
    </div>
</div>
