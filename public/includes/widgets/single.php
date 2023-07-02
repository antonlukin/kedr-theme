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
            'link' => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        $exclude = get_query_var( 'widget_exclude', array() );
        $post_id = $this->find_postid( $instance['link'] );

        $query = new WP_Query(
            array(
                'posts_per_page'      => 1,
                'post_status'         => 'publish',
                'post_type'           => 'any',
                'ignore_sticky_posts' => true,
                'post__in'            => array( $post_id ),
            )
        );

        if ( $query->have_posts() ) {
            echo $args['before_widget']; // phpcs:ignore

            $query->the_post();

            get_template_part( 'templates/widget-single' );

            set_query_var( 'widget_exclude', array_merge( $exclude, wp_list_pluck( $query->posts, 'ID' ) ) );
            wp_reset_postdata();

            echo $args['after_widget']; // phpcs:ignore
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance          = $old_instance;
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
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"><small>%5$s</small></p>',
            esc_attr( $this->get_field_id( 'link' ) ),
            esc_attr( $this->get_field_name( 'link' ) ),
            esc_html__( 'Ссылка:', 'kedr-theme' ),
            esc_attr( $instance['link'] ),
            esc_html__( 'На запись c этого сайта', 'kedr-theme' )
        );

        $post_id = $this->find_postid( $instance['link'] );

        if ( empty( $post_id ) ) {
            printf(
                '<p><span class="dashicons dashicons-warning"></span> <strong>%s</strong></p>',
                esc_html__( 'Запись не найдена', 'kedr-theme' )
            );
        }
    }

    /**
     * Try to find post ID by teaser link.
     */
    private function find_postid( $link ) {
        return url_to_postid( wp_make_link_relative( $link ) );
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
