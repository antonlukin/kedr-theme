<?php
/**
 * Subcats widget
 *
 * @package kedr-theme
 * @since 2.0
 */

class Kedr_Widget_Subcats extends WP_Widget {
    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'subcats',
            'description'                 => esc_html__( 'Отображает виджет подкатегорий в виде карточек', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_subcats', esc_html__( 'Подкатегории', 'kedr-theme' ), $widget_ops );
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

        $children = array();

        if ( method_exists( 'Kedr_Modules_Subcats', 'get_subcategories' ) ) {
            $children = Kedr_Modules_Subcats::get_subcategories();
        }

        foreach ( $children as $category ) :
            $image = null;

            if ( method_exists( 'Kedr_Modules_Subcats', 'get_image' ) ) {
                $image = Kedr_Modules_Subcats::get_image( $category );
            }

            $options = compact( 'category', 'image' );
            get_template_part( 'templates/frame', 'subcats', $options );
        endforeach;
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
}

/**
 * It is time to register widget
 */
add_action(
    'widgets_init',
    function() {
        register_widget( 'Kedr_Widget_Subcats' );
    }
);
