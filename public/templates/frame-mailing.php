<?php
/**
 * Widget with subscribe to mailing form
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="frame-mailing__wrapper">
    <?php
    printf(
        '<p class="frame-mailing__caption">%s</p>',
        esc_html__( 'Подпишитесь на рассылку «Кедр.Медиа»', 'kedr-theme' )
    )
    ?>

    <form class="frame-mailing__form form" action="/" method="POST" data-requests="mailing">
        <?php
        printf(
            '<input class="frame-mailing__form-input input" type="email" name="email" required placeholder="%s">',
            esc_html__( 'Введите ваш e-mail', 'kedr-theme' )
        );

        printf(
            '<button class="frame-mailing__form-button button" type="submit">%s</button>',
            esc_html__( 'Подписаться', 'kedr-theme' )
        );
        ?>

        <p class="frame-mailing__form-message form__message"></p>
    </form>
</div>