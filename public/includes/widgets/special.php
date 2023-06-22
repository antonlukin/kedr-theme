<?php
/**
 * Special projects widget
 *
 * @package kedr-theme
 * @since 2.0
 */


class Kedr_Widget_Special extends WP_Widget {
    /**
     * Widget post types
     */
    private $post_type = array( 'post' );

    /**
     * Widget special project taxonomy
     */
    private $taxonomy = 'project';

    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'special',
            'description'                 => esc_html__( 'Выводит виджет с записями спецпроекта', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_special', esc_html__( 'Спецпроект', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        $defaults = array(
            'title' => '',
            'term'  => 0,
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        // Create new WP_Query by instance vars
        $query = new WP_Query( $this->get_query( $instance ) );

        // get term object by id
        $term = get_term_by( 'id', $instance['term'], $this->taxonomy );

        if ( $query->have_posts() ) {
            echo $args['before_widget']; // phpcs:ignore

            get_template_part( '/templates/frame-special', null, compact( 'term', 'query' ) );

            echo $args['after_widget']; // phpcs:ignore
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['term']  = absint( $new_instance['term'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'term'  => 0,
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

        $termlist = wp_dropdown_categories(
            array(
                'taxonomy'   => $this->taxonomy,
                'class'      => 'widefat',
                'name'       => esc_attr( $this->get_field_name( 'term' ) ),
                'selected'   => $instance['term'],
                'hide_empty' => false,
                'required'   => true,
                'echo'       => false,
            )
        );

        printf(
            '<p class="kedr-widget-termlist" id="%s">%s</p>',
            esc_attr( $this->get_field_id( 'termlist' ) ),
            $termlist // phpcs:ignore
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
                    'taxonomy' => $this->taxonomy,
                    'field'    => 'id',
                    'terms'    => $instance['term'],
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
        register_widget( 'Kedr_Widget_Special' );
    }
);
