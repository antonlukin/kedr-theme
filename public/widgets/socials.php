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
            'caption'    => '',
            'disclaimer' => '',
            'term_id'    => 0,
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput

        if ( ! empty( $instance['caption'] ) ) {
            printf(
                '<p class="frame-socials__caption">%s</p>',
                esc_html( $instance['caption'] )
            );
        }

        wp_nav_menu(
            array(
                'menu'       => $instance['term_id'],
                'depth'      => 1,
                'echo'       => true,
                'items_wrap' => '<ul class="frame-socials__menu">%3$s</ul>',
                'container'  => false,
            )
        );

        if ( ! empty( $instance['disclaimer'] ) ) {
            printf(
                '<p class="frame-socials__disclaimer">%s</p>',
                esc_html( $instance['disclaimer'] )
            );
        }

        echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance['caption']    = sanitize_text_field( $new_instance['caption'] );
        $instance['term_id']    = absint( $new_instance['term_id'] );
        $instance['disclaimer'] = sanitize_text_field( $new_instance['disclaimer'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'caption'    => '',
            'disclaimer' => '',
            'term_id'    => 0,
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        if ( empty( $instance['caption'] ) ) {
            $instance['caption'] = esc_html__( 'Подпишитесь на социальные сети', 'kedr-theme' );
        }

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"><small>%5$s</small></p>',
            esc_attr( $this->get_field_id( 'caption' ) ),
            esc_attr( $this->get_field_name( 'caption' ) ),
            esc_html__( 'Заголовок:', 'kedr-theme' ),
            esc_attr( $instance['caption'] ),
            esc_html__( 'Отобразится на странице', 'kedr-theme' )
        );

        $list = array();

        foreach ( wp_get_nav_menus() as $menu ) {
            $list[] = sprintf(
                '<option value="%d"%s>%s</option>',
                esc_attr( $menu->term_id ),
                selected( $instance['term_id'], $menu->term_id, false ),
                esc_html( $menu->name )
            );
        }

        printf(
            '<p><select name="%s" class="widefat">%s</select></p>',
            esc_attr( $this->get_field_name( 'term_id' ) ),
        implode( '', $list ) // phpcs:ignore
        );

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"><small>%5$s</small></p>',
            esc_attr( $this->get_field_id( 'disclaimer' ) ),
            esc_attr( $this->get_field_name( 'disclaimer' ) ),
            esc_html__( 'Дисклеймер:', 'kedr-theme' ),
            esc_attr( $instance['disclaimer'] ),
            esc_html__( 'Курсивом под ссылками', 'kedr-theme' )
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
