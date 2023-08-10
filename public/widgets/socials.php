<?php
/**
 * Widget with social subscribe links
 *
 * @package kedr-theme
 * @since 2.0
 */


class Kedr_Widget_Socials extends WP_Widget {
    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'socials',
            'description'                 => esc_html__( 'Выводит список ссылок на соцсети для подписки', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_socials', esc_html__( 'Подписка на соцсети', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        $defaults = array(
            'caption' => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        if ( has_nav_menu( 'social' ) ) {
            echo $args['before_widget']; // phpcs:ignore

            printf(
                '<p class="frame-socials__caption">%s</p>',
                esc_html( $instance['caption'] )
            );

            wp_nav_menu(
                array(
                    'theme_location' => 'social',
                    'depth'          => 1,
                    'echo'           => true,
                    'items_wrap'     => '<ul class="frame-socials__menu social">%3$s</ul>',
                    'container'      => false,
                )
            );

            echo $args['after_widget']; // phpcs:ignore
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance['caption'] = sanitize_text_field( $new_instance['caption'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'caption' => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        if ( empty( $instance['caption'] ) ) {
            $instance['caption'] = esc_html__( 'Подпишитесь на социальные сети', 'kedr-theme' );
        }

        // Widget title
        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"><small>%5$s</small></p>',
            esc_attr( $this->get_field_id( 'caption' ) ),
            esc_attr( $this->get_field_name( 'caption' ) ),
            esc_html__( 'Заголовок:', 'kedr-theme' ),
            esc_attr( $instance['caption'] ),
            esc_html__( 'Отобразится на странице', 'kedr-theme' )
        );
    }
}


/**
 * It is time to register widget
 */
add_action(
    'widgets_init',
    function() {
        register_widget( 'Kedr_Widget_Socials' );
    }
);
