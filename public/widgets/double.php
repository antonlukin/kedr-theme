<?php
/**
 * Double cards widget
 *
 * @package kedr-theme
 * @since 2.0
 */

class Kedr_Widget_Double extends WP_Widget {
    /**
     * Widget post types
     */
    private $post_type = array( 'post' );

    /**
     * Categories to show in double
     */
    private $category = array( 'explain', 'opinions', 'stories', 'research', 'interview', 'to-read' );

    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'double',
            'description'                 => esc_html__( 'Выводит карточки по 2 в ряд', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_double', esc_html__( 'Двойные карточки', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        $defaults = array(
            'title'          => '',
            'posts_per_page' => 2,
            'self_hide'      => 1,
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        // Using exclude global query var to avoid posts duplicate
        $exclude = $this->get_excluded_posts( $args['id'] );

        // Create new WP_Query by instance vars
        $query = new WP_Query( $this->get_query( $instance, $exclude ) );

        if ( $query->have_posts() ) {
            echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput

            while ( $query->have_posts() ) {
                $query->the_post();
                get_template_part( 'templates/frame', 'double' );
            }

            wp_reset_postdata();

            echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
        }

        $this->set_excluded_posts( $args['id'], wp_list_pluck( $query->posts, 'ID' ) );
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field( $new_instance['title'] );

        $instance['self_hide'] = 0;
        if ( ! empty( $new_instance['self_hide'] ) ) {
            $instance['self_hide'] = 1;
        }

        // Use int to avoid phpcs error
        $instance['posts_per_page'] = (int) $new_instance['posts_per_page'];

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'title'          => '',
            'posts_per_page' => 2,
            'self_hide'      => 1,
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
            '<p><label for="%1$s">%3$s</label> <input class="tiny-text" id="%1$s" name="%2$s" type="number" min="2" max="10" value="%4$s"> <small>%5$s</small></p>',
            esc_attr( $this->get_field_id( 'posts_per_page' ) ),
            esc_attr( $this->get_field_name( 'posts_per_page' ) ),
            esc_html__( 'Количество записей:', 'kedr-theme' ),
            esc_attr( $instance['posts_per_page'] ),
            esc_html__( '(четное количество)', 'kedr-theme' )
        );

        printf(
            '<p><input type="checkbox" id="%1$s" name="%2$s" value="1" class="checkbox"%4$s><label for="%1$s">%3$s</label></p>',
            esc_attr( $this->get_field_id( 'self_hide' ) ),
            esc_attr( $this->get_field_name( 'self_hide' ) ),
            esc_html__( 'Скрывать ссылку на себя внутри записи', 'kedr-theme' ),
            checked( $instance['self_hide'], 1, false )
        );
    }

    /**
     * Generate query params from instance args
     */
    private function get_query( $instance, $exclude = array() ) {
        $query = array(
            'posts_per_page'      => $instance['posts_per_page'],
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

        if ( ! empty( $instance['self_hide'] ) && is_singular() ) {
            $exclude[] = get_queried_object_id();
        }

        if ( ! empty( $exclude ) ) {
            $query['post__not_in'] = $exclude;
        }

        return $query;
    }

    /**
     * Find all excluded posts by sidebar id
     */
    private function get_excluded_posts( $sidebar ) {
        $exclude = get_query_var( 'widget_exclude', array() );

        if ( empty( $exclude[ $sidebar ] ) ) {
            return array();
        }

        return $exclude[ $sidebar ];
    }

    /**
     * Set new excluded posts by sidebar id
     */
    private function set_excluded_posts( $sidebar, $ids ) {
        $exclude = get_query_var( 'widget_exclude', array() );

        if ( empty( $exclude[ $sidebar ] ) ) {
            $exclude[ $sidebar ] = array();
        }

        $exclude[ $sidebar ] = array_merge( $exclude[ $sidebar ], $ids );

        set_query_var( 'widget_exclude', $exclude );
    }
}

/**
 * It is time to register widget
 */
add_action(
    'widgets_init',
    function() {
        register_widget( 'Kedr_Widget_Double' );
    }
);
