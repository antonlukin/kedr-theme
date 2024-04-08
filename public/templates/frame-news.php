<div class="frame-news__content frame-news__content--<?php echo esc_attr( $args['class'] ); ?>">
    <?php
    kedr_theme_info(
        'category',
        '<div class="frame-news__content-category">',
        '</div>'
    );

    printf(
        '<a class="frame-news__content-title" href="%s">%s</a>',
        esc_url( get_permalink() ),
        esc_html( get_the_title() )
    );

    kedr_theme_info(
        'date',
        '<div class="frame-news__content-date">',
        '</div>'
    );
    ?>
</div>
