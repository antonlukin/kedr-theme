<?php
/**
 * No content template
 *
 * @package kedr-theme
 * @since 2.0
 */
?>

<div class="message">
    <h1 class="message__title"><?php esc_html_e( 'Страница не найдена', 'kedr-theme' ); ?></h1>

    <div class="message__content">
        <p><?php echo wp_kses_post( __( 'Возможно ссылка, по которой вы перешли, не работает, или страница была удалена.', 'kedr-theme' ) ); ?></p>
    </div>
</div>
