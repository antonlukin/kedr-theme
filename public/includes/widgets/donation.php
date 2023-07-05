<?php
/**
 * Widget with donation link button
 *
 * @package kedr-theme
 * @since 2.0
 */


class Kedr_Widget_Donation extends WP_Widget {
    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'donation',
            'description'                 => esc_html__( 'Выводит кнопку со ссылкой на страницу донатов', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_donation', esc_html__( 'Кнопка донатов', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        $defaults = array(
            'link'  => '',
            'label' => '',
        );

        echo $args['before_widget']; // phpcs:ignore

        printf(
            '<a class="frame-donation__button button" href="%s" target="_blank" rel="noopener">%s</a>',
            esc_attr( $instance['link'] ),
            esc_html( $instance['label'] )
        );

        echo $args['after_widget']; // phpcs:ignore
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance['label'] = sanitize_text_field( $new_instance['label'] );
        $instance['link']  = sanitize_text_field( $new_instance['link'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'link'  => '',
            'label' => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        if ( empty( $instance['label'] ) ) {
            $instance['label'] = esc_html__( 'Поддержите «Кедр.Медиа»', 'kedr-theme' );
        }

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
            esc_attr( $this->get_field_id( 'label' ) ),
            esc_attr( $this->get_field_name( 'label' ) ),
            esc_html__( 'Текст на кнопке:', 'kedr-theme' ),
            esc_attr( $instance['label'] )
        );

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
            esc_attr( $this->get_field_id( 'link' ) ),
            esc_attr( $this->get_field_name( 'link' ) ),
            esc_html__( 'Ссылка на страницу:', 'kedr-theme' ),
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
        register_widget( 'Kedr_Widget_Donation' );
    }
);
