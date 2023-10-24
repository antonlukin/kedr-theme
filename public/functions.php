<?php
/**
 * Important functions and definitions
 *
 * Setups the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @package kedir-theme
 * @since 2.0
 */

/**
 * We have to install this value for image sizes
 */
if ( ! isset( $content_width ) ) {
    $content_width = 736;
}

/**
 * Insert required js files
 */
add_action(
    'wp_enqueue_scripts',
    function () {
        $version = wp_get_theme()->get( 'Version' );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) {
            $version = gmdate( 'U' );
        }

        wp_enqueue_script( 'kedr-theme', get_template_directory_uri() . '/assets/scripts.min.js', array( 'wp-i18n' ), $version, true );
    }
);

/**
 * Insert styles
 */
add_action(
    'wp_enqueue_scripts',
    function () {
        $version = wp_get_theme()->get( 'Version' );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) {
            $version = gmdate( 'U' );
        }

        wp_enqueue_style( 'kedr-theme', get_template_directory_uri() . '/assets/styles.min.css', array(), $version );
    }
);

/**
 * Rewrite urls after switch theme just in case
 */
add_action(
    'after_switch_theme',
    function () {
        flush_rewrite_rules();
    }
);

/**
 * Add required theme support tags
 */
add_action(
    'after_setup_theme',
    function () {
        // Let WordPress generate page title
        add_theme_support( 'title-tag' );

        // Add links to feeds in header
        add_theme_support( 'automatic-feed-links' );

        // Add custom post formats support
        add_theme_support( 'post-formats', array( 'gallery', 'video' ) );

        // Add selective refresh support
        add_theme_support( 'customize-selective-refresh-widgets' );
    }
);

if ( ! function_exists( 'kedr_theme_info' ) ) :
    /**
     * Public template function to show post info
     */
    function kedr_theme_info( $option, $before = '', $after = '' ) {
        $output = null;
        $method = 'get_' . $option;

        if ( method_exists( 'Kedr_Modules_Postinfo', $method ) ) {
            $output = Kedr_Modules_Postinfo::$method();
        }

        if ( ! empty( $output ) ) {
            $output = $before . $output . $after;

            echo $output; // phpcs:ignore WordPress.Security.EscapeOutput
        }
    }
endif;

/**
 * Include theme helpers
 */
require_once get_template_directory() . '/helpers/coauthors-plus/index.php';
require_once get_template_directory() . '/helpers/leyka/index.php';

/**
 * Include theme core modules
 */
require_once get_template_directory() . '/modules/global.php';
require_once get_template_directory() . '/modules/translit.php';
require_once get_template_directory() . '/modules/widgets.php';
require_once get_template_directory() . '/modules/login.php';
require_once get_template_directory() . '/modules/blocks.php';
require_once get_template_directory() . '/modules/images.php';
require_once get_template_directory() . '/modules/postinfo.php';
require_once get_template_directory() . '/modules/menu.php';
require_once get_template_directory() . '/modules/projects.php';
require_once get_template_directory() . '/modules/sitemeta.php';
require_once get_template_directory() . '/modules/news.php';
require_once get_template_directory() . '/modules/content.php';
require_once get_template_directory() . '/modules/embeds.php';
require_once get_template_directory() . '/modules/loadmore.php';
require_once get_template_directory() . '/modules/regions.php';
require_once get_template_directory() . '/modules/snippet.php';
require_once get_template_directory() . '/modules/requests.php';
require_once get_template_directory() . '/modules/subcats.php';
require_once get_template_directory() . '/modules/comments.php';
