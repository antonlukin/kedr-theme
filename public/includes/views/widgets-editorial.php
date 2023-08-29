<div class="kedr-widgets-linkset" data-name="<?php echo esc_attr( $this->get_field_name( 'posts' ) ); ?>[]">
    <header>
        <?php
        printf(
            '<label for="%s">%s</label>',
            esc_attr( $this->get_field_id( 'link' ) ),
            esc_html__( 'Ссылка на запись с этого сайта:', 'kedr-theme' )
        );

        printf(
            '<input id="%s" type="text" value="">',
            esc_attr( $this->get_field_id( 'link' ) )
        );

        printf(
            '<button class="button" type="button">%s</button>',
            esc_html__( 'Добавить', 'kedr-theme' )
        );
        ?>
    </header>

    <ul>
        <?php foreach ( $instance['posts'] as $item ) : ?>
        <li>
            <?php
            printf(
                '<img src="%s" alt="">',
                esc_url( get_the_post_thumbnail_url( $item ) )
            );

            printf(
                '<a href="%s" target="_blank" rel="noopener">%s</a>',
                esc_url( get_permalink( $item ) ),
                esc_html( get_the_title( $item ) )
            );

            printf(
                '<button type="button" title="%s"></button>',
                esc_html__( 'Удалить запись', 'kedr-theme' )
            );

            printf(
                '<input type="hidden" name="%s[]" value="%d">',
                esc_attr( $this->get_field_name( 'posts' ) ),
                esc_attr( $item )
            );
            ?>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
