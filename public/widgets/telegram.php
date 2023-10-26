<?php
/**
 * Widget for Telegram popup promotion
 *
 * @package kedr-theme
 * @since 2.0
 */

class Kedr_Widget_Telegram extends WP_Widget {
    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'telegram',
            'description'                 => esc_html__( 'Выводит попап с промо подписки на Telegram.', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_telegram', esc_html__( 'Подписка на Telegram', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        $defaults = array(
            'title' => '',
            'link'  => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput

        $options = array(
            'link' => $instance['link'],
        );

        get_template_part( 'templates/frame', 'telegram', $options );

        echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['link']  = sanitize_text_field( $new_instance['link'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'link'  => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"><small>%5$s</small></p>',
            esc_attr( $this->get_field_id( 'title' ) ),
            esc_attr( $this->get_field_name( 'title' ) ),
            esc_html__( 'Заголовок:', 'kedr-theme' ),
            esc_attr( $instance['title'] ),
            esc_html__( 'Не будет отображаться на странице', 'kedr-theme' )
        );

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"</p>',
            esc_attr( $this->get_field_id( 'link' ) ),
            esc_attr( $this->get_field_name( 'link' ) ),
            esc_html__( 'Ссылка с виджета:', 'kedr-theme' ),
            esc_attr( $instance['link'] )
        );
    }
}

/**
 * It is time to register widget
 */
add_action(
    'widgets_init',
    function() {
        register_widget( 'Kedr_Widget_Telegram' );
    }
);
