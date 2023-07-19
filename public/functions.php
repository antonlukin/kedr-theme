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

        wp_enqueue_script( 'kedr-theme', get_template_directory_uri() . '/assets/scripts.min.js', array(), $version, true );
    }
);

/**
 * Insert styles
 */
add_action(
    'wp_print_styles',
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

        // Let WordPress manage cutsom background
        add_theme_support( 'custom-background', array( 'wp-head-callback' => '__return_false' ) );

        // Add custom post formats support
        add_theme_support( 'post-formats', array( 'gallery', 'video' ) );
    }
);

/**
 * Include theme helpers
 */
require get_template_directory() . '/includes/helpers/template-tags.php';
require get_template_directory() . '/includes/helpers/plugin-filters.php';

/**
 * Include theme core modules
 */
require get_template_directory() . '/includes/modules/theme-filters.php';
require get_template_directory() . '/includes/modules/widgets-filters.php';
require get_template_directory() . '/includes/modules/blocks-filters.php';
require get_template_directory() . '/includes/modules/image-filters.php';
require get_template_directory() . '/includes/modules/menu-filters.php';
require get_template_directory() . '/includes/modules/special-filters.php';
require get_template_directory() . '/includes/modules/meta-filters.php';
require get_template_directory() . '/includes/modules/news-filters.php';
require get_template_directory() . '/includes/modules/embed-filters.php';
