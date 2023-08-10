<?php
/**
 * Videos category filters
 *
 * @package kedr-theme
 * @since 2.0
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Kedr_Modules_Videos {
    /**
     * Unique slug using for videos category url
     *
     * @access  public
     * @var     string
     */
    public static $slug = 'videos';

    /**
     * Unique meta to videos options
     *
     * @access  public
     * @var     string
     */
    public static $term_meta = '_kedr-videos-options';

    /**
     * Use this method instead of constructor to avoid multiple hook setting
     */
    public static function load_module() {
        add_action( 'admin_init', array( __CLASS__, 'add_options_fields' ) );
        add_filter( 'archive_template', array( __CLASS__, 'include_archive' ) );
    }

    /**
     * Include custom archive template for videos
     */
    public static function include_archive( $template ) {
        if ( ! is_feed() && is_category( self::$slug ) ) {
            $new_template = locate_template( array( 'templates/archive-videos.php' ) );

            if ( ! empty( $new_template ) ) {
                return $new_template;
            }
        }

        return $template;
    }

    /**
     * Add adminside edit form fields
     */
    public static function add_options_fields() {
        add_action( 'category_edit_form_fields', array( __CLASS__, 'print_options_row' ), 9 );
        add_action( 'edited_category', array( __CLASS__, 'save_options_meta' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_options_assets' ) );
    }

    /**
     * Display custom special options row
     */
    public static function print_options_row( $term ) { // phpcs:ignore
        include_once get_template_directory() . '/includes/views/videos-options.php';
    }

    /**
     * Enqueue assets to term edit screen only
     */
    public static function enqueue_options_assets( $hook ) {
        $screen = get_current_screen();

        if ( $hook !== 'term.php' || $screen->taxonomy !== 'category' ) {
            return;
        }

        $version = wp_get_theme()->get( 'Version' );

        wp_enqueue_media();

        wp_enqueue_script(
            'kedr-theme-videos',
            get_template_directory_uri() . '/includes/scripts/videos-options.js',
            array( 'jquery' ),
            $version,
            true
        );
    }

    /**
     * Save term options
     */
    public static function save_options_meta( $term_id ) {
        if ( ! current_user_can( 'edit_term', $term_id ) ) {
            return;
        }

        if ( empty( $_REQUEST[ self::$term_meta ] ) ) {
            return delete_term_meta( $term_id, self::$term_meta );
        }

        $background = array_filter(
            array_map( 'sanitize_text_field', wp_unslash( $_REQUEST[ self::$term_meta ] ) )
        );

        return update_term_meta( $term_id, self::$term_meta, $background );
    }
}

/**
 * Load current module environment
 */
Kedr_Modules_Videos::load_module();
