<?php
/**
 * Widget for custom banner with a link and image
 *
 * @package kedr-theme
 * @since 2.0
 */


class Kedr_Widget_Banner extends WP_Widget {
    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'banner',
            'description'                 => esc_html__( 'Выводит произвольный баннер.', 'kedr-theme' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct( 'kedr_widget_banner', esc_html__( 'Баннер', 'kedr-theme' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget.
     */
    public function widget( $args, $instance ) {
        $defaults = array(
            'title'  => '',
            'link'   => '',
            'image'  => '',
            'mobile' => '',
            'target' => 1,
        );

        if ( ! empty( $instance['link'] ) && ! empty( $instance['image'] ) ) {
            echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput

            $target = null;

            if ( $instance['target'] === 1 ) {
                $target = 'target="_blank" rel="noopener"';
            }

            $images = array();

            if ( ! empty( $instance['mobile'] ) ) {
                $images[] = sprintf(
                    '<img class="frame-banner__mobile" src="%s" alt="%s">',
                    esc_attr( $instance['mobile'] ),
                    esc_attr( $instance['title'] )
                );
            }

            if ( ! empty( $instance['image'] ) ) {
                $images[] = sprintf(
                    '<img class="frame-banner__image" src="%s" alt="%s">',
                    esc_attr( $instance['image'] ),
                    esc_attr( $instance['title'] )
                );
            }

            // phpcs:disable WordPress.Security.EscapeOutput
            printf(
                '<a class="frame-banner__link" href="%s" %s>%s</a>',
                esc_attr( $instance['link'] ),
                $target,
                implode( ' ', $images )
            );
            // phpcs:enable WordPress.Security.EscapeOutput

            echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance['title']  = sanitize_text_field( $new_instance['title'] );
        $instance['link']   = sanitize_text_field( $new_instance['link'] );
        $instance['image']  = sanitize_text_field( $new_instance['image'] );
        $instance['mobile'] = sanitize_text_field( $new_instance['mobile'] );
        $instance['target'] = ! empty( $new_instance['target'] ) ? 1 : 0;

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        $defaults = array(
            'title'  => '',
            'link'   => '',
            'image'  => '',
            'mobile' => '',
            'target' => 1,
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
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
            esc_attr( $this->get_field_id( 'link' ) ),
            esc_attr( $this->get_field_name( 'link' ) ),
            esc_html__( 'Ссылка с баннера:', 'kedr-theme' ),
            esc_attr( $instance['link'] )
        );

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
            esc_attr( $this->get_field_id( 'image' ) ),
            esc_attr( $this->get_field_name( 'image' ) ),
            esc_html__( 'Ссылка на изображение:', 'kedr-theme' ),
            esc_attr( $instance['image'] )
        );

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"><small>%5$s</small></p>',
            esc_attr( $this->get_field_id( 'mobile' ) ),
            esc_attr( $this->get_field_name( 'mobile' ) ),
            esc_html__( 'Ссылка на мобильное изображение:', 'kedr-theme' ),
            esc_attr( $instance['mobile'] ),
            esc_html__( 'Необязательное поле', 'kedr-theme' )
        );

        printf(
            '<p><input type="checkbox" id="%1$s" name="%2$s" class="checkbox"%4$s><label for="%1$s">%3$s</label></p>',
            esc_attr( $this->get_field_id( 'target' ) ),
            esc_attr( $this->get_field_name( 'target' ) ),
            esc_html__( 'Открывать в новой вкладке', 'kedr-theme' ),
            checked( $instance['target'], 1, false )
        );
    }
}


/**
 * It is time to register widget
 */
add_action(
    'widgets_init',
    function() {
        register_widget( 'Kedr_Widget_Banner' );
    }
);
