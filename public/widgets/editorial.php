<?php
/**
 * Editorial widget
 *
 * @package kedr-theme
 * @since 2.0
 */

class Kedr_Widget_Editorial extends WP_Widget {
    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'editorial',
            'description'                 => esc_html__( 'Выводит список выбранных записей', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_editorial', esc_html__( 'Выбор редакции', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        $defaults = array(
            'caption' => '',
            'posts'   => array(),
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        if ( empty( $instance['posts'] ) ) {
            return;
        }

        $query = new WP_Query(
            array(
                'post_status'         => 'publish',
                'post_type'           => 'any',
                'ignore_sticky_posts' => true,
                'post__in'            => $instance['posts'],
            )
        );

        if ( $query->have_posts() ) {
            echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput

            $options = array(
                'query' => $query,
                'title' => esc_html( $instance['caption'] ),
            );

            get_template_part( 'templates/frame', 'editorial', $options );

            echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['caption'] = sanitize_text_field( $new_instance['caption'] );
        $instance['posts']   = array();

        if ( ! empty( $new_instance['posts'] ) ) {
            $instance['posts'] = array_map( 'absint', $new_instance['posts'] );
        }

        $instance['posts'] = array_unique( $instance['posts'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'caption' => '',
            'posts'   => array(),
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        if ( empty( $instance['caption'] ) ) {
            $instance['caption'] = esc_html__( 'Выбор редакции', 'kedr-theme' );
        }

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"><small>%5$s</small></p>',
            esc_attr( $this->get_field_id( 'caption' ) ),
            esc_attr( $this->get_field_name( 'caption' ) ),
            esc_html__( 'Название блока:', 'kedr-theme' ),
            esc_attr( $instance['caption'] ),
            esc_html__( 'Отобразится над списком записей', 'kedr-theme' )
        );

        include get_template_directory() . '/includes/views/widgets-linkset.php';
    }
}

/**
 * It is time to register widget
 */
add_action(
    'widgets_init',
    function() {
        register_widget( 'Kedr_Widget_Editorial' );
    }
);
