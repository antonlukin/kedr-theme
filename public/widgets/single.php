<?php
/**
 * Single widget
 *
 * @package kedr-theme
 * @since 2.0
 */

class Kedr_Widget_Single extends WP_Widget {
    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'single',
            'description'                 => esc_html__( 'Выводит широкую одиночную запись', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_single', esc_html__( 'На всю ширину', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        $defaults = array(
            'posts' => array(),
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        if ( empty( $instance['posts'] ) ) {
            return;
        }

        $query = new WP_Query(
            array(
                'posts_per_page'      => 1,
                'post_status'         => 'publish',
                'post_type'           => 'any',
                'ignore_sticky_posts' => true,
                'post__in'            => $instance['posts'],
            )
        );

        if ( $query->have_posts() ) {
            echo $args['before_widget']; // phpcs:ignore

            $query->the_post();
            get_template_part( 'templates/frame', 'single' );

            wp_reset_postdata();

            echo $args['after_widget']; // phpcs:ignore
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['posts'] = array();

        if ( ! empty( $new_instance['posts'] ) ) {
            $instance['posts'] = array_map( 'absint', $new_instance['posts'] );
        }

        $instance['posts'] = array_splice( $instance['posts'], -1 );

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'posts' => array(),
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

        include get_template_directory() . '/includes/views/widgets-linkset.php';
    }
}

/**
 * It is time to register widget
 */
add_action(
    'widgets_init',
    function() {
        register_widget( 'Kedr_Widget_Single' );
    }
);
