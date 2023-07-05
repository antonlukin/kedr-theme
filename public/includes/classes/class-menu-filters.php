<?php
/**
 * Menu manager
 * Filters that upgrade theme menus
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Menu_Filters {
    /**
     * Use this method instead of constructor to avoid setting multiple hooks
     */
    public static function load_module() {
        add_action( 'after_setup_theme', array( __CLASS__, 'register_menus' ) );
        add_filter( 'nav_menu_css_class', array( __CLASS__, 'update_css_classes' ), 10, 3 );
        add_filter( 'nav_menu_link_attributes', array( __CLASS__, 'update_link_attributes' ), 10, 3 );
        add_filter( 'nav_menu_item_title', array( __CLASS__, 'update_item_title' ), 10, 3 );
        add_filter( 'nav_menu_item_id', '__return_empty_string' );
    }

    /**
     * Register theme menus
     */
    public static function register_menus() {
        register_nav_menus(
            array(
                'main'   => esc_html__( 'Меню в шапке сайта', 'kedr-theme' ),
                'social' => esc_html__( 'Меню социальных ссылок', 'kedr-theme' ),
                'footer' => esc_html__( 'Меню в подвале', 'kedr-theme' ),
            )
        );
    }

    /**
     * Add class to menu item link
     */
    public static function update_link_attributes( $atts, $item, $args ) {
        $atts['class'] = 'menu__item-link';

        if ( $args->theme_location === 'social' ) {
            $atts['class'] = 'social__item-link';
        }

        return $atts;
    }

    /**
     * We have to change titles to icons in social menu
     * Add additional class from interface
     */
    public static function update_item_title( $title, $item, $args ) {
        if ( $args->theme_location !== 'social' ) {
            return $title;
        }

        $classes = (array) get_post_meta( $item->ID, '_menu_item_classes', true );

        // Set network from title
        $network = sanitize_key( $title );

        if ( ! empty( $classes[0] ) ) {
            $network = sanitize_key( $classes[0] );
        }

        $icon = sprintf(
            '<svg class="social__item-icon social__item-icon--%s"><use xlink:href="%s"></use></svg>',
            esc_attr( $network ),
            esc_url( get_template_directory_uri() . '/assets/images/icons-sprite.svg#kedr-icon-' . $network )
        );

        $title = sprintf(
            '<span class="social__item-title">%s</span>',
            esc_html( $title )
        );

        return $icon . $title;
    }

    /**
     * Change default menu items classes
     */
    public static function update_css_classes( $classes, $item, $args ) {
        $classes = array();

        // Skip interface classes for social menu
        if ( $args->theme_location === 'social' ) {
            $classes[] = 'social__item';

            return $classes;
        }

        $classes[] = 'menu__item';

        // Add custom classes from interface
        $custom = (array) get_post_meta( $item->ID, '_menu_item_classes', true );

        foreach ( $custom as $class ) {
            if ( ! empty( $class ) ) {
                $classes[] = $class;
            }
        }

        return $classes;
    }
}


/**
 * Load current module environment
 */
Kedr_Menu_Filters::load_module();
