<?php
/**
 * Widget with subscribe to mailing form
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="widget-mailing__wrapper">
    <?php
    printf(
        '<p class="widget-mailing__caption">%s</p>',
        esc_html__( 'Подпишитесь на рассылку «Кедр.Медиа»', 'kedr-theme' )
    )
    ?>

    <form class="widget-mailing__form" action="" method="POST">
        <?php
        printf(
            '<input class="widget-mailing__form-input input" type="text" placeholder="%s">',
            esc_html__( 'Введите ваш e-mail', 'kedr-theme' )
        );

        printf(
            '<button class="widget-mailing__form-button button" type="submit">%s</button>',
            esc_html__( 'Подписаться', 'kedr-theme' )
        );
        ?>
    </form>
</div>