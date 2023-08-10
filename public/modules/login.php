<?php
/**
 * Login filters
 * Change login screen template
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Login {
    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_filter( 'login_headerurl', array( __CLASS__, 'change_url' ) );
        add_filter( 'login_headertext', array( __CLASS__, 'change_title' ) );
        add_filter( 'login_enqueue_scripts', array( __CLASS__, 'login_styles' ) );
    }

    /**
     * Prints custom styles with custom logo
     */
    public static function login_styles() {
        $version = wp_get_theme()->get( 'Version' );

        wp_enqueue_style(
            'kedr-theme-login',
            get_template_directory_uri() . '/includes/styles/login-screen.css',
            array(),
            $version
        );
    }

    /**
     * Change logo links to front page instead of wordpress.org
     */
    public static function change_url() {
        return home_url();
    }

    /**
     * Change logo title
     */
    public static function change_title() {
        return esc_html__( 'На главную', 'kedr-theme' );
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Login::load_module();
