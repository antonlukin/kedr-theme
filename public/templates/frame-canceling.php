<?php
/**
 * Widget with form for canceling donations
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<form class="frame-canceling__form form" action="/" method="POST" data-requests="canceling">
    <?php
    printf(
        '<input class="frame-canceling__form-input input" type="text" name="first" required pattern="\d{6}" placeholder="%s">',
        esc_html__( 'Первые 6 цифр', 'kedr-theme' )
    );

    printf(
        '<input class="frame-canceling__form-input input" type="text" name="last" required pattern="\d{4}" placeholder="%s">',
        esc_html__( 'Последние 4 цифры', 'kedr-theme' )
    );

    printf(
        '<button class="frame-canceling__form-button button" type="submit">%s</button>',
        esc_html__( 'Отправить', 'kedr-theme' )
    );
    ?>

    <p class="frame-canceling__form-message form__message"></p>
</form>