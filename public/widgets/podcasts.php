<?php
/**
 * Podcasts widget
 *
 * @package kedr-theme
 * @since 2.0
 */


class Kedr_Widget_Podcasts extends WP_Widget {
    /**
     * Widget post types
     */
    private $post_type = array( 'post' );

    /**
     * Categories to show in podcasts widget
     */
    private $category = 'podcast';

    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'podcasts',
            'description'                 => esc_html__( 'Выводит список последних подкастов', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_podcasts', esc_html__( 'Подкасты', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        $defaults = array(
            'title' => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        // Create WP_Query podcasts posts
        $query = new WP_Query( $this->get_query( $instance ) );

        if ( $query->have_posts() ) {
            echo $args['before_widget']; // phpcs:ignore

            $options = array(
                'query'   => $query,
                'total'   => $query->found_posts,
                'title'   => __( 'Подкаст', 'kedr-theme' ),
                'link'    => get_category_link( get_category_by_slug( $this->category ) ),
                'counter' => 0,
            );

            get_template_part( 'templates/frame', 'podcasts', $options );

            echo $args['after_widget']; // phpcs:ignore
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance          = $old_instance;
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

    /**
     * Generate query params from instance args
     */
    private function get_query( $instance ) {
        $query = array(
            'posts_per_page'      => 4,
            'post_type'           => $this->post_type,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'tax_query'           => array( // phpcs:ignore
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => $this->category,
                ),
            ),
        );

        return $query;
    }
}


/**
 * It is time to register widget
 */
add_action(
    'widgets_init',
    function() {
        register_widget( 'Kedr_Widget_Podcasts' );
    }
);
