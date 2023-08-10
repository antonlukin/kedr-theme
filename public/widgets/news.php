<?php
/**
 * News widget
 *
 * @package kedr-theme
 * @since 2.0
 */


class Kedr_Widget_News extends WP_Widget {
    /**
     * Widget post types
     */
    private $post_type = array( 'post' );

    /**
     * Categories to show in news
     */
    private $category = array( 'news' );

    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'news',
            'description'                 => esc_html__( 'Выводит последние новости', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_news', esc_html__( 'Новости', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        $defaults = array(
            'title'    => '',
            'featured' => 1,
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        // Create WP_Query with common news posts
        $common = new WP_Query( $this->get_common_query( $instance ) );

        // Create WP_Query with single featured news post
        $featured = new WP_Query( $this->get_featured_query( $instance ) );

        if ( $common->have_posts() ) {
            echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput

            while ( $featured && $featured->have_posts() ) {
                $featured->the_post();
                get_template_part( 'templates/frame', 'news', array( 'class' => 'featured' ) );
            }

            while ( $common->have_posts() ) {
                $common->the_post();
                get_template_part( 'templates/frame', 'news', array( 'class' => 'common' ) );
            }

            wp_reset_postdata();

            echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance             = $old_instance;
        $instance['title']    = sanitize_text_field( $new_instance['title'] );
        $instance['featured'] = absint( $new_instance['featured'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'title'    => '',
            'featured' => 1,
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

        // Enable featured news
        printf(
            '<p><input type="checkbox" id="%1$s" name="%2$s" value="1" class="checkbox"%4$s><label for="%1$s">%3$s</label></p>',
            esc_attr( $this->get_field_id( 'featured' ) ),
            esc_attr( $this->get_field_name( 'featured' ) ),
            esc_html__( 'Отображать Главную новость', 'kedr-theme' ),
            checked( $instance['featured'], 1, false )
        );
    }

    /**
     * Generate query params from instance args
     */
    private function get_common_query( $instance ) {
        $query = array(
            'posts_per_page'      => 6,
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

        if ( ! empty( $instance['featured'] ) && property_exists( 'Kedr_Blocks_Topnews', 'meta' ) ) {
            $query['posts_per_page'] = 4;

            $query['meta_query'] = array( // phpcs:ignore
                array(
                    'key'     => Kedr_Blocks_Topnews::$meta,
                    'compare' => 'NOT EXISTS',
                ),
            );
        }

        return $query;
    }

    /**
     * Generate query params from instance args
     */
    private function get_featured_query( $instance ) {
        if ( empty( $instance['featured'] ) || ! property_exists( 'Kedr_Blocks_Topnews', 'meta' ) ) {
            return null;
        }

        $query = array(
            'posts_per_page'      => 1,
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
            'meta_query'          => array( // phpcs:ignore
                array(
                    'key'     => Kedr_Blocks_Topnews::$meta,
                    'compare' => 'EXISTS',
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
        register_widget( 'Kedr_Widget_News' );
    }
);
