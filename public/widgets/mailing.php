<?php
/**
 * Email subscription form widget
 *
 * @package kedr-theme
 * @since 2.0
 */


class Kedr_Widget_Mailing extends WP_Widget {
    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'mailing',
            'description'                 => esc_html__( 'Выводит форму подписки на email-рассылку', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_mailing', esc_html__( 'Подписка на рассылку', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget']; // phpcs:ignore

        get_template_part( 'templates/frame', 'mailing' );

        echo $args['after_widget']; // phpcs:ignore
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance['title'] = sanitize_text_field( $new_instance['title'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        // Widget title
        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"><small>%5$s</small></p>',
            esc_attr( $this->get_field_id( 'title' ) ),
            esc_attr( $this->get_field_name( 'title' ) ),
            esc_html__( 'Заголовок:', 'kedr-theme' ),
            esc_attr( $instance['title'] ),
            esc_html__( 'Не будет отображаться на странице', 'kedr-theme' )
        );
    }
}


/**
 * It is time to register widget
 */
add_action(
    'widgets_init',
    function() {
        register_widget( 'Kedr_Widget_Mailing' );
    }
);
