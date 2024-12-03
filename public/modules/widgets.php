<?php
/**
 * Common widgets handler
 * Use for cross-widget functions
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Widgets {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_action( 'after_setup_theme', array( __CLASS__, 'include_widgets' ) );
        add_action( 'widgets_init', array( __CLASS__, 'register_sidebars' ) );
        add_action( 'widgets_init', array( __CLASS__, 'unregister_defaults' ), 1 );
        add_filter( 'widget_title', '__return_empty_string' );

        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
        add_action( 'dynamic_sidebar_before', array( __CLASS__, 'exclude_single_widget' ) );

        add_action( 'wp_ajax_kedr_widgets', array( __CLASS__, 'handle_ajax' ) );
    }

    /**
     * Exclude single widget from post lists
     */
    public static function exclude_single_widget( $sidebar ) {
        $exclude = get_query_var( 'widget_exclude', array() );

        if ( empty( $exclude[ $sidebar ] ) ) {
            $exclude[ $sidebar ] = array();
        }

        $single = new Kedr_Widget_Single();

        // Get all settings of single widget
        $settings = $single->get_settings();

        $widgets = wp_get_sidebars_widgets();

        if ( empty( $widgets[ $sidebar ] ) ) {
            $widgets[ $sidebar ] = array();
        }

        foreach ( $widgets[ $sidebar ] as $id ) {
            if ( substr( $id, 0, strlen( $single->id_base ) ) !== $single->id_base ) {
                continue;
            }

            $index = str_replace( $single->id_base . '-', '', $id );

            if ( is_array( $settings[ $index ]['posts'] ) ) {
                $exclude[ $sidebar ] = array_merge( $exclude[ $sidebar ], $settings[ $index ]['posts'] );
            }
        }

        $exclude[ $sidebar ] = array_unique( $exclude[ $sidebar ] );

        set_query_var( 'widget_exclude', $exclude );
    }

    /**
     * Register widget areas
     */
    public static function register_sidebars() {
        register_sidebar(
            array(
                'name'          => esc_html__( 'Главная страница', 'kedr-theme' ),
                'id'            => 'kedr-frontal',
                'description'   => esc_html__( 'Добавленные виджеты появятся на главной странице.', 'kedr-theme' ),
                'before_widget' => '<div class="frame-%2$s">',
                'after_widget'  => '</div>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__( 'Подвал внутренней страницы', 'kedr-theme' ),
                'id'            => 'kedr-bottom',
                'description'   => esc_html__( 'Добавленные виджеты появятся внизу на странице поста.', 'kedr-theme' ),
                'before_widget' => '<div class="frame-%2$s frame-%2$s--bottom">',
                'after_widget'  => '</div>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__( 'Сразу под постом', 'kedr-theme' ),
                'id'            => 'kedr-inpost',
                'description'   => esc_html__( 'Добавленные виджеты появятся сразу после текста записи в общем белом блоке.', 'kedr-theme' ),
                'before_widget' => '<div class="frame-%2$s frame-%2$s--inpost">',
                'after_widget'  => '</div>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__( 'Скрипты и счетчики', 'kedr-theme' ),
                'id'            => 'kedr-flexible',
                'description'   => esc_html__( 'Добавленные виджеты загрузятся в последнюю очередь. Для скриптов и счетчиков.', 'kedr-theme' ),
                'before_widget' => '<div class="frame-%2$s frame-%2$s--flexible">',
                'after_widget'  => '</div>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__( 'Категория "В мире"', 'kedr-theme' ),
                'id'            => 'kedr-world',
                'description'   => esc_html__( 'Добавленные виджеты появятся в архиве категории "В мире".', 'kedr-theme' ),
                'before_widget' => '<div class="frame-%2$s frame-%2$s--bottom">',
                'after_widget'  => '</div>',
            )
        );
    }

    /**
     * Remove default widgets to prevent printing unready styles on production
     */
    public static function unregister_defaults() {
        unregister_widget( 'WP_Widget_Pages' );
        unregister_widget( 'WP_Widget_Calendar' );
        unregister_widget( 'WP_Widget_Archives' );
        unregister_widget( 'WP_Widget_Links' );
        unregister_widget( 'WP_Widget_Meta' );
        unregister_widget( 'WP_Widget_Search' );
        unregister_widget( 'WP_Widget_Categories' );
        unregister_widget( 'WP_Widget_Recent_Posts' );
        unregister_widget( 'WP_Widget_Recent_Comments' );
        unregister_widget( 'WP_Widget_RSS' );
        unregister_widget( 'WP_Widget_Media_Video' );
        unregister_widget( 'WP_Widget_Tag_Cloud' );
        unregister_widget( 'WP_Nav_Menu_Widget' );
        unregister_widget( 'WP_Widget_Custom_HTML' );
        unregister_widget( 'WP_Widget_Text' );
        unregister_widget( 'WP_Widget_Audio' );
        unregister_widget( 'WP_Widget_Media_Audio' );
        unregister_widget( 'WP_Widget_Media_Image' );
        unregister_widget( 'WP_Widget_Media_Gallery' );
        unregister_widget( 'WP_Widget_Block' );
    }

    /**
     * Include widgets classes
     */
    public static function include_widgets() {
        $include = get_template_directory() . '/widgets/';

        foreach ( glob( $include . '*.php' ) as $widget ) {
            include_once $include . basename( $widget );
        }
    }

    /**
     * Enqueue assets to wigets admin page screen only
     */
    public static function enqueue_assets( $hook ) {
        if ( $hook !== 'widgets.php' ) {
            return;
        }

        $version = wp_get_theme()->get( 'Version' );

        wp_enqueue_media();

        wp_enqueue_script(
            'kedr-theme-widgets',
            get_template_directory_uri() . '/includes/scripts/widgets-screen.js',
            array( 'jquery' ),
            $version,
            true
        );

        wp_enqueue_style(
            'kedr-theme-widgets',
            get_template_directory_uri() . '/includes/styles/widgets-screen.css',
            array(),
            $version
        );

        $options = array(
            'action'  => 'kedr_widgets',
            'nonce'   => wp_create_nonce( 'kedr-widgets-nonce' ),
            'warning' => esc_html__( 'Произошла неизвестная ошибка', 'kedr-theme' ),
        );

        wp_localize_script( 'kedr-theme-widgets', 'kedr_widgets', $options );
    }

    /**
     * Handle widgets AJAX requests
     */
    public static function handle_ajax() {
        check_ajax_referer( 'kedr-widgets-nonce', 'nonce' );

        if ( ! empty( $_REQUEST['linkset'] ) ) {
            return self::process_linkset( sanitize_text_field( wp_unslash( $_REQUEST['linkset'] ) ) );
        }
    }

    /**
     * Find post for linkset AJAX query
     */
    private static function process_linkset( $url ) {
        $post_id = url_to_postid( wp_make_link_relative( $url ) );

        if ( empty( $post_id ) ) {
            return wp_send_json_error( esc_html__( 'Запись не найдена', 'kedr-theme' ) );
        }

        $post = array(
            'title' => esc_html( get_the_title( $post_id ) ),
            'link'  => esc_url( get_permalink( $post_id ) ),
            'image' => esc_url( get_the_post_thumbnail_url( $post_id ) ),
            'post'  => absint( $post_id ),
        );

        wp_send_json_success( $post );
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Widgets::load_module();
