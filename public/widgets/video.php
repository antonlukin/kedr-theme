<?php
/**
 * Video widget
 *
 * @package kedr-theme
 * @since 2.0
 */

class Kedr_Widget_Video extends WP_Widget {
    /**
     * Widget post types
     */
    private $post_type = array( 'post' );

    /**
     * Categories to show in photostory widget
     */
    private $category = 'videos';

    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'video',
            'description'                 => esc_html__( 'Выводит выбранное видео', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_video', esc_html__( 'Видео', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        $defaults = array(
            'title'   => '',
            'post_id' => 0,
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        $query = new WP_Query(
            array(
                'posts_per_page'      => 1,
                'post_type'           => $this->post_type,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'post__in'            => array( $instance['post_id'] ),
            )
        );

        if ( $query->have_posts() ) {
            echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput

            while ( $query->have_posts() ) {
                $query->the_post();

                $options = array(
                    'video' => $this->get_video_url( get_the_content() ),
                );

                get_template_part( 'templates/frame', 'video', $options );
            }

            wp_reset_postdata();

            echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance            = $old_instance;
        $instance['title']   = sanitize_text_field( $new_instance['title'] );
        $instance['post_id'] = absint( $new_instance['post_id'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'title'   => '',
            'post_id' => 0,
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

        $posts = get_posts(
            array(
                'posts_per_page'      => 50,
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
                'fields'              => 'ids',
            )
        );

        $list = array();

        foreach ( $posts as $post ) {
            $list[] = sprintf(
                '<option value="%d"%s>%s</option>',
                esc_attr( $post ),
                selected( $instance['post_id'], $post, false ),
                esc_html( get_the_title( $post ) )
            );
        }

        printf(
            '<p><select name="%s" class="widefat">%s</select></p>',
            esc_attr( $this->get_field_name( 'post_id' ) ),
            implode( '', $list ) // phpcs:ignore WordPress.Security.EscapeOutput
        );
    }

    /**
     * Get url to YouTube video from content blocks
     */
    private function get_video_url( $content ) {
        if ( ! has_blocks( $content ) ) {
            return null;
        }

        $blocks = parse_blocks( $content );

        foreach ( $blocks as $block ) {
            if ( empty( $block['blockName'] ) || $block['blockName'] !== 'core/embed' ) {
                continue;
            }

            if ( empty( $block['attrs']['providerNameSlug'] ) ) {
                continue;
            }

            if ( $block['attrs']['providerNameSlug'] !== 'youtube' ) {
                continue;
            }

            if ( empty( $block['attrs']['url'] ) ) {
                continue;
            }

            return $block['attrs']['url'];
        }

        return null;
    }
}

/**
 * It is time to register widget
 */
add_action(
    'widgets_init',
    function() {
        register_widget( 'Kedr_Widget_Video' );
    }
);
